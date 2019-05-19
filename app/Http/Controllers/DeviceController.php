<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DeviceType;
use App\Models\Device;
use App\Models\DeviceRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\DeviceAssign;
use DB;

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
                ->with('message', 'ID devicenot found')
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

    public function test() {
        $device = Device::where('status', '=', 0)->get();
        return response()->json($device);
    }
}
