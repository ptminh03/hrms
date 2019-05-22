<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\DeviceType;
use App\Models\Employee;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Device extends Model
{
    use SoftDeletes;

    protected $table = 'devices';

    public function deviceType()
    {
        return $this->belongsTo(DeviceType::class)->withTrashed();
    }

    public function available()
    {
        return $this->where('status', '=', 0)->selectRaw('device_type_id, count(`device_type_id`) as count')->groupBy('device_type_id')->having('count', '>', 0)->get();
    }

    public function generateCode()
    {
        $code = (string) $this->code;
        for ( ; strlen($code) < 4; $code = "0". $code );
        return $this->deviceType->prefix. "-". $code;
    }

    public function employee()
    {
        if ( $this->status == 0 )
        {
            return new Employee;
        }
        return $this->hasOne(Employee::class, 'id', 'status');
    }
}
