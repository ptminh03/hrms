<?php

use Illuminate\Database\Seeder;
use App\Models\Employee;

class EmployeeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        factory(Employee::class)->create([
            'user_id'=> 1,
            'code' => 'CODE1',
            'department_id' => 1,
            'position_id' => 6
        ]);
        factory(Employee::class)->create([
            'user_id'=> 2,
            'code' => 'CODE2',
            'department_id' => 2,
            'position_id' => 6
        ]);
        for($i = 3; $i <= 10; $i++) {
            factory(Employee::class)->create([
                'user_id'=> $i,
                'code' => 'CODE'.strval($i),
                'department_id' => rand(3, 6),
                'position_id' => rand(1, 5)
            ]);
        }
    }
}
