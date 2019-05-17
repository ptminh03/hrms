<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Employee;

class Department extends Model
{
    use SoftDeletes;

    protected $table = 'departments';
    protected $fillable = ['name'];

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    public function employeesWithTrashed()
    {
        return $this->hasMany(Employee::class)->withTrashed();
    }
}
