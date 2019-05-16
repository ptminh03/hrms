<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DeviceType;
use App\Models\Device;
use DB;

class DeviceController extends Controller
{
    public function index() {
        $request = request();
        $info = [
            'total' => Device::count(),
            'available' => Device::where('status', '=', 0)->count(),
        ];
        $devices = Device::orderBy('id', 'desc')->paginate(15);
        return view ('hrms.device.index', compact('devices', 'request', 'info'));
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
}
