<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DeviceType;
use App\Models\Device;
use DB;

class DeviceController extends Controller
{
    public function index() {
        // $deviceTypes = DeviceType::withCount('devices')->get();
        $devices = Device::orderBy('id', 'desc')->paginate(15);
        return view ('hrms.device.index', compact('devices'));
    }
}
