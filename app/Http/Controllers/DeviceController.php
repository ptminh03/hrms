<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DeviceType;
use DB;

class DeviceController extends Controller
{
    public function showAdd()
    {
        // $devices = Device::select('device_type_id', DB::raw('count(*) as count'))->groupBy('device_type_id')->get();
        $deviceTypes = DeviceType::withCount('devices')->get();
        return view('hrms.device.show_add', compact('deviceTypes'));
    }
}
