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
    public function create()
    {
        $maxID = Employee::max('id');
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
            'date_of_join' => 'bail|required|date',
            'date_of_birth' => 'date',
            'phone_number' => 'numeric',
            'salary' => 'bail|required|numeric|min:1000000'
        ]);
        $filename = public_path('photos/a.png');
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
        } else {
            $filename = Employee::PHOTO_DEFAULT;
        }

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

        try {
            DB::beginTransaction();
            $user->save();
            $employee->user_id = $user->id;
            $employee->save();
            $leaveAnnualLeft->employee_id = $employee->id;
            $leaveAnnualLeft->save();
            DB::commit();
            return back()->with('message', 'Create new employee success')->with('class', 'alert-success');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('message', 'Create new employee failed, please try again later')->with('class', 'alert-danger');
        }
    }

    public function showEdit($id)
    {
        //$emps = Employee::whereid($id)->with('userrole.role')->first();
        $emps = User::where('id', $id)->with('employee')->first();
        $departments = Department::all();
        $positions = Position::all();
        return view('hrms.employee.add', compact('emps', 'departments', 'positions'));
    }

    public function doEdit(Request $request, $id)
    {
        $filename = public_path('photos/a.png');
        if ($request->file('photo')) {
            $file             = $request->file('photo');
            $filename         = str_random(12);
            $fileExt          = $file->getClientOriginalExtension();
            $allowedExtension = ['jpg', 'jpeg', 'png'];
            $destinationPath  = public_path('photos');
            if (!in_array($fileExt, $allowedExtension)) {
                return redirect()->back()->with('message', 'Extension not allowed');
            }
            $filename = $filename . '.' . $fileExt;
            $file->move($destinationPath, $filename);

        }

        $photo             = $filename;
        $emp_name          = $request->emp_name;
        $emp_code          = $request->emp_code;
        $emp_status        = $request->status;
        $emp_role          = $request->role;
        $gender            = $request->gender;
        $dob               = date_format(date_create($request->date_of_birth), 'Y-m-d');
        $doj               = date_format(date_create($request->date_of_joining), 'Y-m-d');
        $mob_number        = $request->number;
        $qualification     = $request->qualification;
        $address           = $request->current_address;
        $permanent_address = $request->permanent_address;
        $formalities       = $request->formalities;
        $offer_acceptance  = $request->offer_acceptance;
        $prob_period       = $request->probation_period;
        $doc               = date_format(date_create($request->date_of_confirmation), 'Y-m-d');
        $department        = $request->department;
        $salary            = $request->salary;
        $account_number    = $request->account_number;
        $bank_name         = $request->bank_name;
        $account_name         = $request->account_name;
        $pf_status         = $request->pf_status;
        $dor               = date_format(date_create($request->date_of_resignation), 'Y-m-d');
        $notice_period     = $request->notice_period;
        $last_working_day  = date_format(date_create($request->last_working_day), 'Y-m-d');
        $full_final        = $request->full_final;

        //$edit = Employee::findOrFail($id);
        $edit = Employee::where('user_id', $id)->first();

        if (!empty($photo)) {
            $edit->photo = $photo;
        }
        if (!empty($emp_name)) {
            $edit->name = $emp_name;
        }
        if (!empty($emp_code)) {
            $edit->code = $emp_code;
        }
        if (isset($emp_status)) {
            $edit->status = $emp_status;
        }
        if (isset($emp_role)) {
            $userRole = UserRole::firstOrNew(['user_id' => $edit->user_id]);
            $userRole->role_id = $emp_role;
            $userRole->save();
        }
        if (isset($gender)) {
            $edit->gender = $gender;
        }
        if (!empty($dob)) {
            $edit->date_of_birth = $dob;
        }
        if (!empty($doj)) {
            $edit->date_of_joining = $doj;
        }
        if (!empty($mob_number)) {
            $edit->number = $mob_number;
        }
        if (!empty($qualification)) {
            $edit->qualification = $qualification;
        }
        if (!empty($emer_number)) {
            $edit->emergency_number = $emer_number;
        }
        if (!empty($pan_number)) {
            $edit->pan_number = $pan_number;
        }
        if (!empty($address)) {
            $edit->current_address = $address;
        }
        if (!empty($permanent_address)) {
            $edit->permanent_address = $permanent_address;
        }

        if (isset($formalities)) {
            $edit->formalities = $formalities;
        }
        if (isset($offer_acceptance)) {
            $edit->offer_acceptance = $offer_acceptance;
        }
        if (!empty($prob_period)) {
            $edit->probation_period = $prob_period;
        }
        if (!empty($doc)) {
            $edit->date_of_confirmation = $doc;
        }
        if (!empty($department)) {
            $edit->department = $department;
        }
        if (!empty($salary)) {
            $edit->salary = $salary;
        }
        if (!empty($account_number)) {
            $edit->account_number = $account_number;
        }
        if (!empty($bank_name)) {
            $edit->bank_name = $bank_name;
        }
        if (!empty($account_name)) {
            $edit->account_name = $account_name;
        }
        if (!empty($pf_account_number)) {
            $edit->pf_account_number = $pf_account_number;
        }
        if (!empty($un_number)) {
            $edit->un_number = $un_number;
        }
        if (isset($pf_status)) {
            $edit->pf_status = $pf_status;
        }
        if (!empty($dor)) {
            $edit->date_of_resignation = $dor;
        }
        if (!empty($notice_period)) {
            $edit->notice_period = $notice_period;
        }
        if (!empty($last_working_day)) {
            $edit->last_working_day = $last_working_day;
        }
        if (isset($full_final)) {
            $edit->full_final = $full_final;
        }

        $edit->save();
        return json_encode(['title' => 'Thông báo', 'message' => 'Cập nhật thông tin thành công', 'class' => 'modal-header-success']);
    }

    public function doDelete($id)
    {

        $emp = User::find($id);
        $emp->delete();

        \Session::flash('flash_message', 'Đã xóa thành công!');

        return redirect()->back();
    }

    public function importFile()
    {
        return view('hrms.employee.upload');
    }

    public function uploadFile(Request $request)
    {
        $files = Input::file('upload_file');

        /* try {*/
        foreach ($files as $file) {
            Excel::load($file, function ($reader) {
                $rows = $reader->get(['emp_name', 'emp_code', 'emp_status', 'role', 'gender', 'dob', 'doj', 'mob_number', 'qualification', 'emer_number', 'pan_number','address', 'permanent_address', 'formalities', 'offer_acceptance', 'prob_period', 'doc', 'department', 'salary', 'account_number', 'bank_name', 'account_name', 'pf_account_number', 'un_number', 'pf_status', 'dor', 'notice_period', 'last_working_day', 'full_final']);

                foreach ($rows as $row) {
                    \Log::info($row->role);
                    $user           = new User;
                    $user->name     = $row->emp_name;
                    $user->email    = str_replace(' ', '_', $row->emp_name) . '@sipi-ip.sg';
                    $user->password = bcrypt('123456');
                    $user->save();
                    $attachment         = new Employee();
                    $attachment->photo  = '/img/Emp.jpg';
                    $attachment->name   = $row->emp_name;
                    $attachment->code   = $row->emp_code;
                    $attachment->status = convertStatus($row->emp_status);

                    if (empty($row->gender)) {
                        $attachment->gender = 'Not Exist';
                    } else {
                        $attachment->gender = $row->gender;
                    }
                    if (empty($row->dob)) {
                        $attachment->date_of_birth = '0000-00-00';
                    } else {
                        $attachment->date_of_birth = date('Y-m-d', strtotime($row->dob));
                    }
                    if (empty($row->doj)) {
                        $attachment->date_of_joining = '0000-00-00';
                    } else {
                        $attachment->date_of_joining = date('Y-m-d', strtotime($row->doj));
                    }
                    if (empty($row->mob_number)) {
                        $attachment->number = '1234567890';
                    } else {
                        $attachment->number = $row->mob_number;
                    }
                    if (empty($row->qualification)) {
                        $attachment->qualification = 'Not Exist';
                    } else {
                        $attachment->qualification = $row->qualification;
                    }
                    if (empty($row->emer_number)) {
                        $attachment->emergency_number = '1234567890';
                    } else {
                        $attachment->emergency_number = $row->emer_number;
                    }
                    if (empty($row->pan_number)) {
                        $attachment->pan_number = 'Not Exist';
                    } else {
                        $attachment->pan_number = $row->pan_number;
                    }
                    if (empty($row->address)) {
                        $attachment->current_address = 'Not Exist';
                    } else {
                        $attachment->current_address = $row->address;
                    }
                    if (empty($row->permanent_address)) {
                        $attachment->permanent_address = 'Not Exist';
                    } else {
                        $attachment->permanent_address = $row->permanent_address;
                    }
                    if (empty($row->emp_formalities)) {
                        $attachment->formalities = '1';
                    } else {
                        $attachment->formalities = $row->emp_formalities;
                    }
                    if (empty($row->offer_acceptance)) {
                        $attachment->offer_acceptance = '1';
                    } else {
                        $attachment->offer_acceptance = $row->offer_acceptance;
                    }
                    if (empty($row->prob_period)) {
                        $attachment->probation_period = 'Not Exist';
                    } else {
                        $attachment->probation_period = $row->prob_period;
                    }
                    if (empty($row->doc)) {
                        $attachment->date_of_confirmation = '0000-00-00';
                    } else {
                        $attachment->date_of_confirmation = date('Y-m-d', strtotime($row->doc));
                    }
                    if (empty($row->department)) {
                        $attachment->department = 'Not Exist';
                    } else {
                        $attachment->department = $row->department;
                    }
                    if (empty($row->salary)) {
                        $attachment->salary = '00000';
                    } else {
                        $attachment->salary = $row->salary;
                    }
                    if (empty($row->account_number)) {
                        $attachment->account_number = 'Not Exist';
                    } else {
                        $attachment->account_number = $row->account_number;
                    }
                    if (empty($row->bank_name)) {
                        $attachment->bank_name = 'Not Exist';
                    } else {
                        $attachment->bank_name = $row->bank_name;
                    }
                    if (empty($row->account_name)) {
                        $attachment->account_name = 'Not Exist';
                    } else {
                        $attachment->account_name = $row->account_name;
                    }
                    if (empty($row->pf_account_number)) {
                        $attachment->pf_account_number = 'Not Exist';
                    } else {
                        $attachment->pf_account_number = $row->pf_account_number;
                    }
                    if (empty($row->un_number)) {
                        $attachment->un_number = 'Not Exist';
                    } else {
                        $attachment->un_number = $row->un_number;
                    }
                    if (empty($row->pf_status)) {
                        $attachment->pf_status = '1';
                    } else {
                        $attachment->pf_status = $row->pf_status;
                    }
                    if (empty($row->dor)) {
                        $attachment->date_of_resignation = '0000-00-00';
                    } else {
                        $attachment->date_of_resignation = date('Y-m-d', strtotime($row->dor));
                    }
                    if (empty($row->notice_period)) {
                        $attachment->notice_period = 'Not exist';
                    } else {
                        $attachment->notice_period = $row->notice_period;
                    }
                    if (empty($row->last_working_day)) {
                        $attachment->last_working_day = '0000-00-00';
                    } else {
                        $attachment->last_working_day = date('Y-m-d', strtotime($row->last_working_day));
                    }
                    if (empty($row->full_final)) {
                        $attachment->full_final = 'Not exist';
                    } else {
                        $attachment->full_final = $row->full_final;
                    }
                    $attachment->user_id = $user->id;
                    $attachment->save();

                    $userRole          = new UserRole();
                    $userRole->role_id = convertRole($row->role);
                    $userRole->user_id = $user->id;
                    $userRole->save();

                }

                return 1;
                //return redirect('upload_form');*/
            }
            );

        }
        /*catch (\Exception $e) {
           return $e->getMessage();*/

        \Session::flash('success', ' Thành công');

        return redirect()->back();
    }

    public function searchEmployee(Request $request)
    {
        $string = $request->string;
        $column = $request->column;
        if ($request->button == 'Search') {
            if ($string == '' && $column == '') {
                \Session::flash('success', ' Thành công');
                return redirect()->to('employee-manager');
            } elseif ($string != '' && $column == '') {
                \Session::flash('failed', ' Vui lòng lựa chọn Category.');
                return redirect()->to('employee-manager');
            }elseif ($column == 'email') {
                $emps = User::with('employee')->where($column,'like', "%$string%")->paginate(20);
            } else {
                $emps = User::whereHas('employee', function ($q) use ($column, $string) {
                    $q->whereRaw($column . " like '%" . $string . "%'");
                }
                )->with('employee')->paginate(20);
            }

            return view('hrms.employee.show_emp', compact('emps', 'column', 'string'));
        } else {
            if ($column == '') {
                $emps = User::with('employee')->get();
            } elseif ($column == 'email') {
                $emps = User::with('employee')->where($request->column, $request->string)->paginate(20);
            } else {
                $emps = User::whereHas('employee', function ($q) use ($column, $string) {
                    $q->whereRaw($column . " like '%" . $string . "%'");
                }
                )->with('employee')->get();
            }

            $fileName = 'Employee_Listing_' . rand(1, 1000) . '.csv';
            $filePath = storage_path('export/') . $fileName;
            $file     = new \SplFileObject($filePath, "a");
            // Add header to csv file.
            $headers = ['id', 'photo', 'code', 'name', 'status', 'gender', 'date_of_birth', 'date_of_joining', 'number', 'qualification', 'emergency_number', 'pan_number', 'current_address', 'permanent_address', 'formalities', 'offer_acceptance', 'probation_period', 'date_of_confirmation', 'department', 'salary', 'account_number', 'bank_name', 'account_name', 'pf_account_number', 'un_number', 'pf_status', 'date_of_resignation', 'notice_period', 'last_working_day', 'full_final', 'user_id', 'created_at', 'updated_at'];
            $file->fputcsv($headers);
            foreach ($emps as $emp) {
                $file->fputcsv([
                                   $emp->id,
                                   (
                                   $emp->employee->photo) ? $emp->employee->photo : 'Not available',
                                   $emp->employee->code,
                                   $emp->employee->name,
                                   $emp->employee->status,
                                   $emp->employee->gender,
                                   $emp->employee->date_of_birth,
                                   $emp->employee->date_of_joining,
                                   $emp->employee->number,
                                   $emp->employee->qualification,
                                   $emp->employee->current_address,
                                   $emp->employee->permanent_address,
                                   $emp->employee->formalities,
                                   $emp->employee->offer_acceptance,
                                   $emp->employee->probation_period,
                                   $emp->employee->date_of_confirmation,
                                   $emp->employee->department,
                                   $emp->employee->salary,
                                   $emp->employee->account_number,
                                   $emp->employee->bank_name,
                                   $emp->employee->account_name,
                                   $emp->employee->pf_status,
                                   $emp->employee->date_of_resignation,
                                   $emp->employee->notice_period,
                                   $emp->employee->last_working_day,
                                   $emp->employee->full_final
                               ]
                );
            }

            return response()->download(storage_path('export/') . $fileName);
        }
    }


    public function showDetails()
    {
        $emps = User::with('employee')->paginate(15);

        return view('hrms.employee.show_bank_detail', compact('emps'));
    }

    public function updateAccountDetail(Request $request)
    {
        try {
            $model                    = Employee::where('id', $request->employee_id)->first();
            $model->bank_name         = $request->bank_name;
            $model->account_number    = $request->account_number;
            $model->account_name      = $request->account_name;
            $model->save();

            return json_encode('success');
        } catch (\Exception $e) {
            \Log::info($e->getMessage() . ' on ' . $e->getLine() . ' in ' . $e->getFile());

            return json_encode('failed');
        }

    }

    public function doPromotion()
    {
        $emps  = User::get();
        $roles = Role::get();

        return view('hrms.promotion.add_promotion', compact('emps', 'roles'));
    }

    public function getPromotionData(Request $request)
    {
        $result = Employee::with('userrole.role')->where('id', $request->employee_id)->first();
        if ($result) {
            $result = ['salary' => $result->salary, 'designation' => $result->userrole->role->name];
        }

        return json_encode(['status' => 'success', 'data' => $result]);
    }

    public function processPromotion(Request $request)
    {

        $newDesignation  = Role::where('id', $request->new_designation)->first();
        $process         = Employee::where('id', $request->emp_id)->first();
        $process->salary = $request->new_salary;
        $process->save();

        \DB::table('user_roles')->where('user_id', $process->user_id)->update(['role_id' => $request->new_designation]);

        $promotion                    = new Promotion();
        $promotion->emp_id            = $request->emp_id;
        $promotion->old_designation   = $request->old_designation;
        $promotion->new_designation   = $newDesignation->name;
        $promotion->old_salary        = $request->old_salary;
        $promotion->new_salary        = $request->new_salary;
        $promotion->date_of_promotion = date_format(date_create($request->date_of_promotion), 'Y-m-d');
        $promotion->save();

        \Session::flash('flash_message', 'Employee successfully Promoted!');

        return redirect()->back();
    }

    public function showPromotion()
    {
        $promotions = Promotion::with('employee')->paginate(10);

        return view('hrms.promotion.show_promotion', compact('promotions'));
    }

    public function myProfile()
    {

        $employee = Employee::where('user_id', Auth::user()->id)->first();
        return view('hrms.employee.my_profile', compact('employee'));
    }
    
    public function index()
    {
        $employees = Employee::whereNull('date_of_resignation')->orderBy('id', 'desc')->paginate(15);
        return view('hrms.employee.index', compact('employees'));
    }
    
    public function myDepartment()
    {
        $departmentId = Auth::user()->employee->department_id;
        $employees = Employee::where('department_id', $departmentId)->orderBy('id', 'desc')->paginate(15);
        return view('hrms.employee.my_department', compact('employees'));
    }

    public function department($id)
    {
        $employees = Employee::where('department_id', $id)->orderBy('id', 'desc')->paginate(15);
        return view('hrms.employee.department', compact('employees'));
    }

    public function show($id)
    {
        $employee = Employee::findOrFail($id);
        return view('hrms.employee.show', compact('employee'));
    }
}
