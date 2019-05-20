<?php

namespace App\Http\Controllers;

use App\Jobs\ExportData;
use App\Models\Employee;
use App\Models\EmployeeUpload;
use App\Models\Role;
use App\Models\UserRole;
use App\Promotion;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Department;
use App\Models\Position;
use Illuminate\Support\Facades\Auth;
use App\Models\LeaveAnnualLeft;
use DB;
use Exception;

class EmployeeController extends Controller
{
    public function index()
    {
        $request = request();
        request()->validate([
            'type' => 'in:all,resignated'
        ],
        [
            'type.in' => 'Type invalid'
        ]);

        $employees = new Employee;
        if ( $request->type == '' ) {
            $employees = $employees->whereNull('date_of_resignation');
        } else if ( $request->type == 'resignated' ) {
            $employees = $employees->whereNotNull('date_of_resignation');
        }
        if ( !empty($request->q) ) {
            $employees = $employees->whereRaw('LOWER(name) like \'%'. strtolower($request->q). '%\'');
        }
        $employees = $employees->orderBy('id', 'desc')->paginate(15);

        $info = [
            'current' => Employee::whereNull('date_of_resignation')->count(),
            'resigned' => Employee::whereNotNull('date_of_resignation')->count()
        ];

        return view('hrms.employee.index', compact('employees', 'request', 'info'));
    }

    public function create()
    {
        $maxID = Employee::withTrashed()->max('id');
        $newCode = (new Employee)->generateCode($maxID + 1);
        $departments = Department::all();
        $positions = Position::all();
        return view('hrms.employee.create', compact(['departments', 'positions', 'newCode']));
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'bail|required|email|unique:users',
            'photo' => 'image',
            'code' => 'bail|required|unique:employees',
            'name' => 'required',
            'gender' => 'bail|required|in:Male,Female',
            'department_id' => 'exists:departments,id',
            'position_id' => 'exists:positions,id',
            'date_of_join' => 'bail|required|date',
            'date_of_birth' => 'date',
            'phone_number' => 'numeric',
            'salary' => 'bail|required|numeric|min:1000000'
        ]);
        if ($request->file('photo')) {
            $destinationPath  = public_path('photos');
            $file             = $request->file('photo');
            $fileExt          = $file->getClientOriginalExtension();
            // $allowedExtension = ['jpg', 'jpeg', 'png'];
            // if (!in_array($fileExt, $allowedExtension)) {
            //     return back()
            //         ->with('message', 'Employee photo has extension not allowed')
            //         ->with('class', 'alert-danger');
            // }
            $filename = str_random(12). '.'. $fileExt;
        } else {
            $filename = Employee::PHOTO_DEFAULT;
        }
        $file->move($destinationPath, $filename);

        $user           = new User;
        $user->email = $request->email;
        $user->password = bcrypt(User::PASSWORD_DEFAULT);
        
        $employee                  = new Employee;
        $employee->photo           = $filename;
        $employee->name            = $request->name;
        $employee->code            = $request->code;       
        $employee->gender          = $request->gender;
        $employee->date_of_join    = date_format(date_create($request->date_of_join), 'Y-m-d');
        if (!empty($request->date_of_birth)) {
            $employee->date_of_birth   = date_format(date_create($request->date_of_birth), 'Y-m-d');
        }
        if (!empty($request->address)) {
            $employee->address   = $request->address;
        }
        if (!empty($request->department_id)) {
            $employee->department_id   = $request->department_id;
        }
        if (!empty($request->position_id)) {
            $employee->position_id   = $request->position_id;
        }
        if (!empty($request->account_number)) {
            $employee->account_number   = $request->account_number;
        }
        $employee->salary          = $request->salary;
        
        $leaveAnnualLeft = new LeaveAnnualLeft;
        $leaveAnnualLeft->days_left = LeaveAnnualLeft::DEFAULT_DAYS_LEFT;

        DB::beginTransaction();
        try {
            $user->save();
            $employee->user_id = $user->id;
            $employee->save();
            $leaveAnnualLeft->employee_id = $employee->id;
            $leaveAnnualLeft->save();
            DB::commit();
            
            return back()
                ->with('message', 'Create new employee success')
                ->with('class', 'alert-success');
        } catch (Exception $e) {
            DB::rollBack();
            
            return back()
                ->with('message', 'Create new employee failed, please try again later')
                ->with('class', 'alert-danger');
        }
    }


    public function myProfile()
    {
        $employee = Employee::where('user_id', Auth::user()->id)->first();
        return view('hrms.employee.my_profile', compact('employee'));
    }
    
    
    public function myDepartment()
    {
        $departmentId = Auth::user()->employee->department_id;
        $department = Department::withCount('employees as count')->findOrFail($departmentId);
        $employees = Employee::where('department_id', $departmentId)->orderBy('id', 'desc')->paginate(15);
        return view('hrms.employee.my_department', compact('employees', 'department'));
    }

    public function department($id)
    {
        $request = request();
        request()->validate([
            'type' => 'in:all,resignated'
        ],
        [
            'type.in' => 'Type invalid'
        ]);

        $employees = Employee::where('department_id', '=', $id);
        if ( $request->type == '' ) {
            $employees = $employees->whereNull('date_of_resignation');
        } else if ( $request->type == 'resignated' ) {
            $employees = $employees->whereNotNull('date_of_resignation');
        }
        if ( !empty($request->q) ) {
            $employees = $employees->whereRaw('LOWER(name) like \'%'. strtolower($request->q). '%\'');
        }
        $employees = $employees->orderBy('id', 'desc')->paginate(15);

        $info = [
            'department' => Department::findOrFail($id)->name,
            'total' => Department::findOrFail($id)->employees()->whereNull('date_of_resignation')->count()
        ];

        return view('hrms.employee.department', compact('employees', 'request', 'info'));
    }

    public function show($id)
    {
        $employee = Employee::findOrFail($id);
        return view('hrms.employee.show', compact('employee'));
    }

    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        $user = User::findOrFail($employee->user_id);
        
        DB::beginTransaction();
        try {
            $employee->delete();
            $user->delete();
            DB::commit();

            return back()
                ->with('message', 'Delete employee success')
                ->with('class', 'alert-success');
        } catch (Exception $e) {
            DB::rollBack();

            return back()
                ->with('message', 'Something was error, please try again later')
                ->with('class', 'alert-danger');
        } 
    }

    public function edit($id)
    {
        $employee = Employee::findOrFail($id);
        $departments = Department::all();
        $positions = Position::all();

        return view('hrms.employee.edit', compact('employee', 'departments', 'positions'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'photo' => 'image',
            'name' => 'required',
            'gender' => 'bail|required|in:Male,Female',
            'department_id' => 'exists:departments,id',
            'position_id' => 'exists:positions,id',
            'date_of_join' => 'bail|required|date',
            'date_of_birth' => 'date',
            'phone_number' => 'numeric',
            'salary' => 'bail|required|numeric|min:1000000'
        ]);

        if ( !$employee = Employee::find($id) ) {
            return back()
                ->with('message', 'Employee ID not found')
                ->with('class', 'alert-danger');
        }

        if ($request->file('photo')) {
            $file             = $request->file('photo');
            $filename         = str_random(12);
            $fileExt          = $file->getClientOriginalExtension();
            $allowedExtension = ['jpg', 'jpeg', 'png'];
            $destinationPath  = public_path('photos');
            if (!in_array($fileExt, $allowedExtension)) {
                return back()
                    ->with('message', 'Employee photo has extension not allowed')
                    ->with('class', 'alert-danger');
            }
            $filename = $filename . '.' . $fileExt;
            $file->move($destinationPath, $filename);
            $employee->photo           = $filename;
        }
        $employee->name            = $request->name;
        $employee->code            = $request->code;       
        $employee->gender          = $request->gender;
        $employee->date_of_join    = date_format(date_create($request->date_of_join), 'Y-m-d');
        $employee->date_of_birth   = date_format(date_create($request->date_of_birth), 'Y-m-d');
        $employee->address         = $request->address;
        if ( empty($request->department_id) ) {
            $employee->department_id = null;
        } else {
            $employee->department_id   = $request->department_id;
        }

        if ( empty($request->position_id) ) {
            $employee->position_id = null;
        } else {
            $employee->position_id   = $request->position_id;
        }
        
        $employee->account_number   = $request->account_number;
        $employee->salary          = $request->salary;
        $employee->save();

        return back()
            ->with('message', 'Update employee success')
            ->with('class', 'alert-success');
    }
}
