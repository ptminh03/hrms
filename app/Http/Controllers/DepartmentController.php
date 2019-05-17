<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\Employee;
use PhpParser\Node\Expr\Error;
use Illuminate\Database\QueryException;
use DB;
use Mockery\Exception;

class DepartmentController extends Controller
{
    public function index() {
        $departments = Department::paginate(15);
        return view('hrms.department.index', compact('departments'));
    }

    public function create() {
        return view('hrms.department.create');
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'bail|required|unique:departments',
        ],
        [
            'name.required' => 'Department name must NOT be empty',
            'name.unique' => 'Department name already exist'
        ]);
       
        $department = new Department;
        $department->name = $request->name;
        $department->save();

        return redirect()
            ->route('department.index')
            ->with('message', 'Create new department success')
            ->with('class', 'alert-success');
    }

    public function edit($id) {
        $department = Department::findOrFail($id);
        return view('hrms.department.edit', compact('department'));
    }

    public function update(Request $request, $id) {
        $request->validate([
            'name' => 'bail|required|unique:departments'
        ],
        [
            'name.required' => 'Department name must NOT be empty',
            'name.unique' => 'Department name already exist'
        ]);

        $department = Department::findOrFail($id);
        $department->update(['name' => $request->name]);

        return redirect()
            ->route('department.index')
            ->with('message', 'Update department name success')
            ->with('class', 'alert-success');
    }

    public function destroy($id) {
        $department = Department::findOrFail($id);
        $employees = Employee::where('department_id', '=', $id)->get();
        $departmentName = $department->name;
        
        DB::beginTransaction();
        try {
            $department->employeesWithTrashed()->update(['department_id' => NULL]);
            $department->delete();
            DB::commit();
            
            return back()
                ->with('message', 'Delete department '. $departmentName . ' success')
                ->with('class', 'alert-success');
        } catch (Exception $e) {
            DB::rollBack();
            
            return back()
                ->with('message', 'Delete department was error, please try again later')
                ->with('class', 'alert-danger');
        }
    }
}
