<?php

namespace App\Models;

use App\Models\User;
use App\Models\Department;
use App\Models\Position;
use App\Models\News;
use App\Models\Leave;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use SoftDeletes;
    
    const PHOTO_DEFAULT = 'default.png';
    protected $table = 'employees';
    protected $fillable = ['photo', 'code', 'name', 'gender', 'date_of_birth', 'date_of_join', 'department_id', 'position_id', 'address'];

    public function generateCode($id) {
        $result = (string)$id;
        for ( ; strlen($result) < 4; ) {
            $result = "0".$result;
        }
        return "BK". $result;
    }

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

    public function leaves()
    {
        return $this->hasMany(Leave::class);
    }
}
