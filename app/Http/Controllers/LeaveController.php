<?php

  namespace App\Http\Controllers;

  use App\EmployeeLeaves;
  use App\LeaveDraft;
  use App\Models\Employee;
  use App\Models\Holiday;
  use App\Models\HolidayFilenames;
  use App\Models\LeaveType;
  use App\Models\Team;
  use App\User;
  use App\Models\Leave;
  use Illuminate\Contracts\Mail\Mailer;

  use Illuminate\Http\Request;
  use App\Http\Requests;
  use Illuminate\Support\Facades\Input;
  use Maatwebsite\Excel\Facades\Excel;
  use Illuminate\Support\Facades\Auth;
  use App\Models\LeaveDetail;

  class LeaveController extends Controller
  {
    public function create()
    {
      $leaves = LeaveType::get();
      return view('hrms.leave.create', compact('leaves'));
    }

    public function store(Request $request)
    {
      $leave = new Leave();
      $leave->leave_type_id = $request->leave_type;
      $leave->reason = $request->reason;
      $quantity = 0;
      foreach ($request->date as $key => $value){
        if ($value == 2) {
          $quantity += 1;
        } else {
          $quantity += 0.5;
        }
      }
      $leave->quantity = $quantity;
      $leave->employee_id = Auth::user()->id;
      $leave->save();

      foreach ($request->date as $key => $value) {
        $leave_detail = new LeaveDetail();
        $leave_detail->leave_id = $leave->id;
        $leave_detail->date_leave = date_format(date_create($key),"Y/m/d");
        $leave_detail->session_id = $value;
        $leave_detail->save();
      }
      return redirect()
        ->route('leave.my-leave')
        ->with('message', 'Create leave request success')
        ->with('class', 'alert-success');
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
  }

