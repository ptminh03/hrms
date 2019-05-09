<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Employee;
use App\Models\Leave;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;


class News extends Model
{
    protected $table = 'news';
    
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function leave() {
        return $this->belongsTo(Leave::class);
    }
}
