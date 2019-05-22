<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Device;
class DeviceAssign extends Model
{
    public function device()
    {
        return $this->belongsTo(Device::class);
    }

    public function assign()
    {
        return $this->belongsTo(Employee::class, 'process_assign', 'id');
    }
}
