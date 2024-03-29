<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\LeaveType;
use App\Models\Employee;
use App\Models\LeaveDetail;
use App\Models\News;

class Leave extends Model
{
    protected $table = 'leaves';

    public const STATUS_YES = 1;
    public const STATUS_NO = 2;

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function leave_type()
    {
        return $this->belongsTo(LeaveType::class);
    }

    public function processor()
    {
        return $this->belongsTo(Employee::class, 'process_by', 'id');
    }

    public function details()
    {
        return $this->hasMany(LeaveDetail::class);
    }

    public function news() {
        return $this->hasOne(News::class);
    }
}
