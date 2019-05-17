<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Employee;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;


class User extends Authenticatable
{
    use SoftDeletes;
    
    const PASSWORD_DEFAULT = '123456';
    protected $table = 'users';
    protected $fillable = ['email'];
    protected $hidden = ['password', 'remember_token'];
    protected $managerDepartments = ['CEO', 'VP', 'HR'];
    
    public function isManager()
    {
        $department = Auth::user()->employee->department->name;
        if(in_array($department, $this->managerDepartments )) {
            return true;
        }
        return false;
    }

    public function employee()
    {
        return $this->hasOne(Employee::class);
    }
}
