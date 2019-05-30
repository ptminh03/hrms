<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\LeaveType;
use App\Models\Leave;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\LeaveDetail;
use App\Models\LeaveAnnualLeft;
use DB;
use Exception;
use App\Models\News;

class LeaveController extends Controller
{
    public function create()
    {
        $leaves = LeaveType::get();
        $info = [
            'days_left' => LeaveAnnualLeft::where('employee_id', Auth::id())->first()->days_left
        ];
        return view('hrms.leave.create', compact('leaves', 'info'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'leave_type_id' => 'required|exists:leave_types,id',
            'date' => 'required'
        ],
        [
            'leave_type_id.required' => 'Leave type must NOT be empty',
            'leave_type_id.exists' => 'Leave type invalid',
            'date.required' => 'Please choose day leave'
        ]);

        $quantity = 0;
        $leaveDetails = [];
        foreach ($request->date as $key => $value) {
            if ( $detail = LeaveDetail::where('date_leave', '=', date_format(date_create($key),"Y/m/d") )
                    ->whereRaw('(session_id + ? <> ?)', [$value, 1])->orderBy('id', 'desc')->first() )
            {   
                if ( Leave::where('id', '=', $detail->leave_id)->where('status', '<', 2)->first() )
                {
                    return back()
                        ->with('message', 'Create leave request failed because date leave are in conflict with previous request')
                        ->with('class', 'alert-danger');
                }
            }

            if ($value == 2) {
                $quantity += 1;
            } else {
                $quantity += 0.5;
            }
            $leaveDetail = [
              'date_leave' => date_format(date_create($key),"Y/m/d"),
              'session_id' => $value
            ];
            $leaveDetails[] = $leaveDetail;
        }

        $leave = new Leave();
        $leave->leave_type_id = $request->leave_type_id;
        $leave->reason = $request->reason;
        $leave->employee_id = Auth::user()->id;
        $leave->quantity = $quantity;

        if ($leave->leave_type->description == 'Annual') {
            $annual = LeaveAnnualLeft::where('employee_id', '=', Auth::user()->id)->firstOrFail();
            if ($annual->days_left < $quantity) {
                return back()
                    ->with('message', 'Your annual leave days left not enough')
                    ->with('class', 'alert-danger');
            }
            $annual->days_left -= $quantity;
        }

        DB::beginTransaction();
        try {
            $leave->save();
            foreach ( $leaveDetails as $key => $leaveDetail ) {
                $leaveDetails[$key] = array_add($leaveDetail, 'leave_id', $leave->id);
            }

            LeaveDetail::insert($leaveDetails);
            if ($leave->leave_type->description == 'Annual') {
                $annual->save();
            }
            DB::commit();
            
            return redirect()
            ->route('leave.myLeave')
            ->with('message', 'Create leave request success')
            ->with('class', 'alert-success');
        } catch (Exception $e) {
            DB::rollBack();
            
            return back()
                ->with('message', 'Something was error, please try again later')
                ->with('class', 'alert-danger');
        }
    }

    public function show($id)
    {
        $leaveDetails = LeaveDetail::where('leave_id', $id)->get();
        $leaves = Leave::where('id', $id)->first();
        return view('hrms.leave.show', compact('leaves', 'leaveDetails'));
    }

    public function myLeave()
    {
        $leaves = Leave::where('employee_id', Auth::user()->id)->orderBy('created_at', 'desc')->paginate(10);
        $info = [
            'days_left' => LeaveAnnualLeft::where('employee_id', Auth::id())->first()->days_left
        ];
        return view('hrms.leave.my_leave', compact('leaves', 'info'));
    }

    public function requestPending()
    {
        $leaves = Leave::where('status', 0)->with('employee')->whereHas('employee', function($query) {
            if ( request()->q )
            {
                $query->whereNull('date_of_resignation')
                    ->whereRaw('LOWER(name) like \'%'. strtolower( request()->q ). '%\'');
            } else {
                $query->whereNull('date_of_resignation');
            }
        });
        $info = [
            'total' => $leaves->count()
        ];
        
        $leaves = $leaves->paginate(15);
        return view('hrms.leave.request_pending', compact('leaves', 'info'));
    }

    public function requestHistory()
    {
        $leaves = Leave::where('status', '<>', 0)->with('employee')->whereHas('employee', function($query) {
            if ( request()->q )
            {
                $query->whereRaw('LOWER(name) like \'%'. strtolower( request()->q ). '%\'');
            }
        });
        
        $leaves = $leaves->orderBy('id', 'desc')->paginate(15);
        return view('hrms.leave.request_history', compact('leaves'));
    }

    public function update($id)
    {
        $leaveTypeAnnual = (new LeaveType)->getLeaveTypeAnnual();
        $request = request();
        $request->validate([
            'status' => 'required|in:1,2'
        ],
        [
            'status.required' => 'Status must NOT be empty',
            'status.in' => 'Status invalid',
        ]);

        $leave = Leave::findOrFail($id);
        $leave->status = $request->status;
        $leave->process_by = Auth::id();

        $news = new News;
        $news->type = 2;
        
        if ( $request->status == Leave::STATUS_YES ) {
            DB::beginTransaction();
            try {
                $leave->save();
                $news->target_id = $leave->id;
                $news->save();
                DB::commit();

                return back()
                    ->with('message', 'Approve leave request success')
                    ->with('class', 'alert-success');
            } catch (Exception $e) {
                DB::rollBack();

                return back()
                    ->with('message', 'Approve leave request failed, please try again later')
                    ->with('class', 'alert-danger');
            }
        } else {
            $leaveAnnualLeft = LeaveAnnualLeft::findOrFail($leave->employee_id);
            $leaveAnnualLeft->days_left += $leave->quantity;
            
            DB::beginTransaction();
            try {
                $leave->save();
                $leaveAnnualLeft->save();
                $news->target_id = $leave->id;
                $news->save();
                DB::commit();

                return redirect()
                    ->route('leave.request.pending')
                    ->with('message', 'Deny leave request success')
                    ->with('class', 'alert-success');
            } catch(Exception $e) {
                DB::rollBack();

                return back()
                    ->with('message', 'Deny leave request failed, please try again later')
                    ->with('class', 'alert-danger');
            }
        }
    }
}
