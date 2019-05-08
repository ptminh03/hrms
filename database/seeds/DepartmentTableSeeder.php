<?php

use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        (new Department)->insert([
            [
                'description' => 'CEO'
            ],
            [
                'description' => 'VP'
            ],
            [
                'description' => 'HR'
            ],
            [
                'description' => 'iOS'
            ],
            [
                'description' => 'Android'
            ],
            [
                'description' => 'PHP'
            ]
        ]);
    }
}
