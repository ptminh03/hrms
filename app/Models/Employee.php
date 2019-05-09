<?php

namespace App\Models;

use App\Models\User;
use App\Models\Department;
use App\Models\Position;
use App\Models\News;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = 'employees';
    protected $fillable = ['photo', 'code', 'name', 'gender', 'date_of_birth', 'date_of_join', 'department_id', 'position_id', 'address'];

    // public function userrole()
    // {
    //     return $this->hasOne('App\Models\UserRole', 'user_id', 'id');
    // }

    // public function employeeLeaves()
    // {
    //     return $this->hasMany('App\EmployeeLeaves', 'user_id', 'user_id');
    // }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function news() {
        return $this->hasMany(News::class);
    }
}
