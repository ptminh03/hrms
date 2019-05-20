<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Position;
use App\Models\LeaveAnnualLeft;
use Faker\Generator as Faker;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = factory(User::class, 100)->create()->each(function ($user) {
            $departments = Department::count();
            $positions = Position::count();
            factory(Employee::class)->create([
                'user_id'=> $user->id,
                'code' => generateCode($user->id),
                'department_id' => randomOrNull($departments),
                'position_id' => randomOrNull($positions)
            ]);
            LeaveAnnualLeft::create([
                'employee_id' => $user->id,
                'days_left' => 12
            ]);
        });
        User::find(1)->update(['email' => 'ptminh03@gmail.com']);
        Employee::find(1)->update(['name' => 'Phan Tấn Minh']);
        $department = Department::where('name', '=', 'HR')->first();
        Employee::find(1)->update(['department_id' => $department->id]);
    }
}

function generateCode($code) {
    $result = (string)$code;
    for ( ; strlen($result) < 4; ) {
        $result = "0".$result;
    }
    return "BK". $result;
}

function randomOrNull($id) {
    $random = rand(0, $id);
    if ($random == 0) {
        $random = NULL;
    }
    return $random;
}