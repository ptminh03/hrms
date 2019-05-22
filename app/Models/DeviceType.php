<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Device;

class DeviceType extends Model
{
    use SoftDeletes;
    
    protected $table = 'device_types';
    
    public function devices()
    {
        return $this->hasMany(Device::class);
    }
}
