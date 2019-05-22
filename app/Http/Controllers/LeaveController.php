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
        return view('hrms.leave.create', compact('leaves'));
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
        foreach ($request->date as $key => $value){
            if ($value == 2) {
                $quantity += 1;
            } else {
                $quantity += 0.5;
            }
        }

        $leave = new Leave();
        $leave->leave_type_id = $request->leave_type_id;
        if ($leave->leave_type->description == 'Annual') {
            $annual = LeaveAnnualLeft::where('employee_id', '=', Auth::user()->id)->firstOrFail();
            if ($annual->days_left < $quantity) {
                return back()
                    ->with('message', 'Your annual leave days left not enough')
                    ->with('class', 'alert-danger');
            }
            $annual->days_left -= $quantity;
        }
        $leave->reason = $request->reason;
        $leave->quantity = $quantity;
        $leave->employee_id = Auth::user()->id;

        $leaveDetails = [];
        foreach ($request->date as $key => $value) {
            if ( $detail = LeaveDetail::where('date_leave', '=', date_format(date_create($key),"Y/m/d") )
                    ->whereRaw('(session_id = ? OR session_id = ?)', [2, $value])->first() )
            {
                if ( Leave::where('id', '=', $detail->leave_id)->where('status', '<', 2)->first() )
                {
                    return back()
                        ->with('message', 'Create leave request failed because date leave are in conflict with previous request')
                        ->with('class', 'alert-danger');
                }
            }

            $leaveDetail = [
              'date_leave' => date_format(date_create($key),"Y/m/d"),
              'session_id' => $value
            ];
            $leaveDetails[] = $leaveDetail;
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
        return view('hrms.leave.my_leave', compact('leaves'));
    }

    public function requestPending()
    {
        $request = request();
        $leaves = Leave::where('status', '=', 0)->/*where('employee_id', '<>', Auth::id())->*/orderBy('id', 'desc')->paginate(15);
        $info = [
            'total' => Leave::where('status', '=', 0)->count()
        ];

        return view('hrms.leave.request_pending', compact('leaves', 'request', 'info'));
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

                return back()
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
