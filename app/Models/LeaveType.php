<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Leave;

class LeaveType extends Model
{
    protected $table = 'leave_types';

    public function getLeaveTypeAnnual() {
        $leaveType = $this->where('description', '=', 'Annual')->first();
        return $leaveType->id;
    }

    public function leaves()
    {
        return $this->hasMany(Leave::class);
    }
}
