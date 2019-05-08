<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Employee;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;


class User extends Authenticatable
{
    protected $table = 'users';
    protected $fillable = ['email'];
    protected $hidden = ['password', 'remember_token'];
    protected $managerDepartment = ['CEO', 'VP', 'HR'];
    
    public function isManager()
    {
        $departmentId = Auth::user()->employee->department->description;
        if(in_array($departmentId, $this->managerDepartment ))
        {
            return true;
        }
        return false;
    }

    public function employee()
    {
        return $this->hasOne(Employee::class);
    }
}
