<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Leave;
use App\Models\Employee;

class LeaveDetail extends Model
{
    protected $table = 'leave_details';

    public function leave()
    {
        return $this->belongsTo(Leave::class);
    }
}
