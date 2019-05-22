<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Device;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
class DeviceAssign extends Model
{
    use SoftDeletes;

    public function assign()
    {
        return $this->belongsTo(Employee::class, 'process_assign', 'id');
    }

    public function device()
    {
        return $this->belongsTo(Device::class, 'device_id', 'id');
    }

    public function deviceWithTrashed()
    {
        return $this->belongsTo(Device::class, 'device_id', 'id')->withTrashed();
    }
}
