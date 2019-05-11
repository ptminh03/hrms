<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Device;

class DeviceType extends Model
{
    protected $table = 'device_types';
    
    public function devices()
    {
        return $this->hasMany(Device::class);
    }
}
