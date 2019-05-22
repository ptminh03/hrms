<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Employee;
use App\Models\Leave;
use App\Models\DeviceAssign;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;


class News extends Model
{
    protected $table = 'news';
    
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'target_id', 'id');
    }

    public function leave()
    {
        return $this->belongsTo(Leave::class);
    }

    public function leaveStatus()
    {
        if ( $this->type != 2)
        {
            return 0;
        }

        if ( !$leave = Leave::find($this->target_id) )
        {
            return 0;
        }

        return $leave->status;
    }

    public function showTitle()
    {
        if( strlen($this->title) > 60 )
        {
            return substr($this->title, 0, 57). '...';
        }
        return $this->title;
    }

    public function deviceAssign()
    {
        return $this->belongsTo(DeviceAssign::class, 'target_id', 'id');
    }
}
