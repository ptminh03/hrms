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
                'name' => 'CEO'
            ],
            [
                'name' => 'VP'
            ],
            [
                'name' => 'HR'
            ],
            [
                'name' => 'iOS'
            ],
            [
                'name' => 'Android'
            ],
            [
                'name' => 'PHP'
            ]
        ]);
    }
}
