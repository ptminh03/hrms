<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DeviceType;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use Mockery\Exception;
use App\Models\Device;

class DeviceTypeController extends Controller
{
    use SoftDeletes;

    public function index()
    {
        $deviceTypes = DeviceType::withCount('devices')->paginate(15);
        $info = [
            'total' => DeviceType::count()
        ];

        return view('hrms.device-type.index', compact('deviceTypes', 'info'));
    }

    public function create()
    {
        return view('hrms.device-type.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'prefix' => 'bail|required|unique:device_types',
            'description' => 'bail|required|unique:device_types'
        ],
        [
            'prefix.required' => 'Prefix must NOT be empty',
            'prefix.unique' => 'Prefix already exist',
            'description.required' => 'Description must NOT be empty',
            'description.unique' => 'Description already exist'
        ]);

        $type = new DeviceType;
        $type->prefix = $request->prefix;
        $type->description = $request->description;
        $type->save();

        return redirect()
            ->route('device-type.index')
            ->with('message', 'Create new device type success')
            ->with('class', 'alert-success');

    }
    public function edit($id)
    {
        if ( !$deviceType = DeviceType::find($id) )
        {
            return back()
                ->with('message', 'ID device type not found')
                ->with('class', 'alert-danger');
        }

        return view('hrms.device-type.edit', compact('deviceType'));
    }

    public function update(Request $request, $id)
    {
        if ( !$deviceType = DeviceType::find($id) )
        {
            return back()
            ->with('message', 'ID device type not found')
            ->with('class', 'alert-danger');
        }

        if ( DeviceType::whereRaw('(id <> ?) AND (prefix = ? OR description = ?)', [$id, $request->prefix, $request->description])->first() )
        {
            return back()
                ->with('message', 'Prefix or description already exists')
                ->with('class', 'alert-danger');
        }
        

        $deviceType->prefix = $request->prefix;
        $deviceType->description = $request->description;
        $deviceType->save();

        return redirect()
            ->route('device-type.index')
            ->with('message', 'Edit device type success')
            ->with('class', 'alert-success');
    }

    public function destroy($id)
    {
        if ( !$deviceType = DeviceType::find($id) )
        {
            return back()
                ->with('message', 'ID device type not found')
                ->with('class', 'alert-danger');
        }

        if ( $devices = Device::where('device_type_id', $id)->where('status', '<>', 0)->first() )
        {
            return back()
                ->with('message', 'Please unassign all device with this type')
                ->with('class', 'alert-danger');
        }

        DB::beginTransaction();
        try {
            Device::where('device_type_id', $id)->delete();
            $deviceType->delete();
            DB::commit();

            return redirect()
            ->route('device-type.index')
            ->with('message', 'Delete device type success')
            ->with('class', 'alert-success');
        } catch (Exception $e) {
            DB::rollBack();

            return back()
                ->with('message', 'Delete device type failed')
                ->with('class', 'alert-danger');
        }
    }
}
