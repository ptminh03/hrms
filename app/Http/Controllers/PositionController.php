<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Position;
use App\Models\Employee;
use DB;


class PositionController extends Controller
{
    public function index() {
        $positions = Position::paginate(15);
        return view('hrms.position.index', compact('positions'));
    }

    public function create() {
        return view('hrms.position.create');
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'bail|required|unique:positions',
        ],
        [
            'name.required' => 'Positions name must NOT be empty',
            'name.unique' => 'Positions name already exist'
        ]);

        $position = new Position;
        $position->name = $request->name;
        $position->save();
        
        return redirect()
            ->route('position.index')
            ->with('message', 'Create new position success')
            ->with('class', 'alert-success');
    }

    public function edit($id) {
        if( !$position = Position::find($id) ) {
            return back()
                ->with('message', 'Position ID not found')
                ->with('class', 'alert-danger');
        }
        
        return view('hrms.position.edit', compact('position'));
    }

    public function update(Request $request, $id) {
        $request->validate([
            'name' => 'bail|required|unique:positions'
        ],
        [
            'name.required' => 'Position name must NOT be empty',
            'name.unique' => 'Position name already exist'
        ]);

        if ( !$position = Position::find($id) ) {
            return back()
                ->with('message', 'Position ID not found')
                ->with('class', 'alert-danger');
        }
        $position->update(['name' => $request->name]);

        return redirect()
            ->route('position.index')
            ->with('message', 'Update position name success')
            ->with('class', 'alert-success');
    }

    public function destroy($id) {
        if ( !$position = Position::find($id) ) {
            return back()
                ->with('message', 'Position ID not found')
                ->with('class', 'alert-danger');
        }

        $employees = Employee::where('position_id', '=', $id)->get();
        $positionName = $position->name;
        
        DB::beginTransaction();
        try {
            $position->employeesWithTrashed()->update(['position_id' => NULL]);
            $position->delete();
            DB::commit();
            
            return back()
                ->with('message', 'Delete position '. $positionName . ' success')
                ->with('class', 'alert-success');
        } catch (Exception $e) {
            DB::rollBack();
            
            return back()
                ->with('message', 'Delete position was error, please try again later')
                ->with('class', 'alert-danger');
        }
    }
}
