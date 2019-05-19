<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DeviceType;
use DB;

class DeviceTypeController extends Controller
{
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

    }

    public function store()
    {

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

}
