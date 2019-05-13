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
            'description' => 'bail|required|unique:departments',
        ],
        [
            'description.required' => 'Description must NOT be empty',
            'description.unique' => 'Description already exist'
        ]);
       
        $department = new Department;
        $department->description = $request->description;
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
            'description' => 'bail|required|unique:departments'
        ],
        [
            'description.required' => 'Description must NOT be empty',
            'description.unique' => 'Description already exist'
        ]);

        $department = Department::findOrFail($id);
        $department->update(['description' => $request->description]);
        return redirect()
            ->route('department.index')
            ->with('message', 'Update department success')
            ->with('class', 'alert-success');
    }

    public function destroy($id) {
        $department = Department::findOrFail($id);
        $employees = Employee::where('department_id', '=', $id)->get();
        $description = $department->description;
        
        DB::beginTransaction();
        try {
            $department->employees()->update(['department_id' => NULL]);
            $department->delete();
            DB::commit();
            
            return back()
                ->with('message', 'Delete department '. $description . ' success')
                ->with('class', 'alert-success');
        } catch (Exception $e) {
            DB::rollBack();
            
            return back()
                ->with('message', 'Something was error, please try again later')
                ->with('class', 'alert-danger');
        }
    }
}
