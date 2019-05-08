<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Employee;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;


class News extends Authenticatable
{
    protected $table = 'news';
    
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
