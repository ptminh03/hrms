<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\DeviceType;

class Device extends Model
{
    protected $table = 'devices';

    public function deviceType()
    {
        return $this->belongsTo(DeviceType::class);
    }
}
