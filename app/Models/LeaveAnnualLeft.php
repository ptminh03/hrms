<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Employee;

class LeaveAnnualLeft extends Model
{
    const DEFAULT_DAYS_LEFT = 12;
    protected $table = 'leave_annual_lefts';

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
