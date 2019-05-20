<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Employee;
use App\Models\Leave;
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
            return new Leave;
        }

        if ( !$leave = Leave::find($this->target_id) )
        {
            return new Leave;
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
}
