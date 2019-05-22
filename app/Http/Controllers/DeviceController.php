<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DeviceType;
use App\Models\Device;
use App\Models\DeviceRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\DeviceAssign;
use App\Models\Employee;
use App\Models\News;
use Carbon\Carbon;
use DB;
use Mockery\Exception;

class DeviceController extends Controller
{
    public function index() {
        $request = request();
        $request->validate([
            'type' => 'exists:device_types,id',
        ],
        [
            'type.exists' => 'ID device type not found',
        ]);

        $info = [
            'total' => Device::count(),
            'available' => Device::where('status', '=', 0)->count(),
        ];
        if ( !empty($request->type) ) {
            $devices = Device::where('device_type_id', '=', $request->type)->orderBy('id', 'desc')->paginate(15);
        } else {
            $devices = Device::orderBy('id', 'desc')->paginate(15);
        }
        $deviceTypes = DeviceType::orderBy('id')->pluck('description', 'id')->prepend('all','');
        return view ('hrms.device.index', compact('devices', 'deviceTypes', 'request', 'info'));
    }

    public function create() {
        $deviceTypes = DeviceType::select('id', 'description')->get();
        return view ('hrms.device.create', compact('deviceTypes'));
    }

    public function store(Request $request) {
        $request = request();
        $request->validate([
            'device_type_id' => 'required|exists:device_types,id',
            'number' => 'required|min:1'
        ],
        [
            'device_type_id.required' => 'ID must NOT be empty',
            'device_type_id.exists' => 'Type not found',
            'number.required' => 'Number must NOT be empty',
            'number.min' => 'Please choose a number'
        ]);
        $countDevicesByType = Device::where('device_type_id', '=', $request->device_type_id)->max('code');
        $devices = [];
        for ($i = 1; $i <= $request->number; $i++) {
            $device = [
                'code' => $countDevicesByType + $i,
                'device_type_id' => $request->device_type_id
            ];
            $devices[] = $device;
        }
        Device::insert($devices);

        return redirect()
            ->route('device.index')
            ->with('message', 'Create device(s) success')
            ->with('class', 'alert-success');
    }

    public function destroy($id)
    {
        if ( !$device = Device::find($id) )
        {
            return back()
                ->with('message', 'ID device not found')
                ->with('class', 'alert-danger');
        }
        $device->delete();
        
        return back()
            ->with('message', 'Delete device success')
            ->with('class', 'alert-success');
    }

    public function status(Request $request)
    {
        $types = (new DeviceType)->withCount('devices');
        $countDevices = $types->paginate(15);
        $info = [
            'total' => $types->get()->count(),
            'available' => (new Device)->available()->count()
        ];
        return view('hrms.device.status', compact('countDevices', 'info'));
    }

    public function assignCreate($id)
    {
        if ( !$device = Device::where('status', '=', 0)->where('id', '=', $id)->first() )
        {
            return back()
                ->with('message', 'Device not found or not available')
                ->with('class', 'alert-danger');
        }

        if (request()->q)
        {
            $employees = Employee::whereNull('date_of_resignation')->whereRaw('LOWER(name) like \'%'. strtolower(request()->q). '%\'')->pluck('name', 'id');
        } else {
            $employees = Employee::pluck('name', 'id');
        }
        
        return view('hrms.device.assign', compact('device', 'employees')); 
    }

    public function assignStore(Request $request, $id)
    {
        if ( !$device = Device::where('status', '=', 0)->where('id', '=', $id)->first() )
        {
            return back()
                ->with('message', 'Device not found or not available')
                ->with('class', 'alert-danger');
        }

        if ( !$employee = Employee::whereNull('date_of_resignation')->where('id', '=', $request->employee_id)->first() )
        {
            return back()
                ->with('message', 'Employee not found or resignated')
                ->with('class', 'alert-danger');
        }
        
        $device->status = $request->employee_id;

        $deviceAssign = new DeviceAssign;
        $deviceAssign->employee_id = $request->employee_id;
        $deviceAssign->device_id = $id;
        $deviceAssign->process_assign = Auth::id();

        $news = new News;
        $news->type = 3;
        $news->status = 1;

        DB::beginTransaction();
        try {
            $device->save();
            $deviceAssign->save();
            $news->target_id = $deviceAssign->id;
            $news->save();
            DB::commit();

            return redirect()
                ->route('device.index')
                ->with('message', 'Assign device success')
                ->with('class', 'alert-success');
        } catch (Exception $e) {
            DB::rollBack();

            return back()
                ->with('message', 'Assign device failed, please try again later')
                ->with('class', 'alert-danger');
        }
    }

    public function assignUpdate($id)
    {
        if ( !$device = Device::where('status', '<>', 0)->where('id', '=', $id)->first() )
        {
            return back()
                ->with('message', 'Device not found or available')
                ->with('class', 'alert-danger');
        }

        if ( !$assign = DeviceAssign::where('device_id', '=', $id)->where('process_remove', '=', 0)->first() )
        {
            return back()
                ->with('message', 'ID device assign not found')
                ->with('class', 'alert-danger');
        }

        $assign->process_remove = Auth::id();
        $device->status = 0;

        $news = new News;
        $news->target_id = $assign->id;
        $news->type = 3;
        $news->status = 2;

        DB::beginTransaction();
        try {
            $assign->save();
            $device->save();
            $news->save();
            DB::commit();
            
            return back()
            ->with('message', 'Unassign device success')
            ->with('class', 'alert-success');


        } catch (Exception $e) {
            DB::rollBack();

            return back()
            ->with('message', 'Unassign device failed')
            ->with('class', 'alert-danger');

        }
    }
    
    public function myDevice()
    {
        $deviceAssigns = DeviceAssign::where(['employee_id' => Auth::id(), 'process_remove' => 0])->paginate(15);
        return view('hrms.device.my_device', compact('deviceAssigns'));  
    }
}
