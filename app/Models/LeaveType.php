<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Leave;

class LeaveType extends Model
{
    protected $table = 'leave_types';

    public function leaves()
    {
        return $this->hasMany(Leave::class);
    }
}
