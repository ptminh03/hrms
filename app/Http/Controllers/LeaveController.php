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
		
		DB::beginTransaction();
		try {
			$leave->save();
			foreach ($request->date as $key => $value) {
				$leave_detail = new LeaveDetail();
				$leave_detail->leave_id = $leave->id;
				$leave_detail->date_leave = date_format(date_create($key),"Y/m/d");
				$leave_detail->session_id = $value;
				$leave_detail->save();
			}
			$annual->save();
			DB::commit();

			return redirect()
				->route('leave.myLeave')
				->with('message', 'Create leave request success')
				->with('class', 'alert-success');
		} catch (Exception $e) {
			DB::rollBack();
			dd($e);

			return back()
				->with('message', 'Something was error, please try again later')
				->with('class', 'alert-danger');
		}
		
	}

	public function show($id)
	{
		$leaveDetails = LeaveDetail::where('leave_id', $id)->get();
		return view('hrms.leave.show', compact('leaveDetails'));
	}

	public function myLeave()
	{
		$leaves = Leave::where('employee_id', Auth::user()->id)->orderBy('created_at', 'desc')->paginate(10);
		return view('hrms.leave.my_leave', compact('leaves'));
	}

	public function requestPending()
	{
		$request = request();
		$leaves = Leave::where('status', '=', 0)->orderBy('id', 'desc')->paginate(15);
		$info = [
			'total' => Leave::where('status', '=', 0)->count()
		];

		return view('hrms.leave.request_pending', compact('leaves', 'request', 'info'));
	}

	public function update($id)
	{
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
		$leave->save();

		if ( $request->status == 1 ) {
			$message = 'Approve leave request success';
		} else {
			$message = 'Deny leave request success';
		}

		return back()
			->with('message', $message)
			->with('class', 'alert-success');
	}
}
