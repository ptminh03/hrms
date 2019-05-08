<?php

use Illuminate\Database\Seeder;
use App\Models\LeaveType;

class LeaveTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        (new LeaveType)->insert([
            [
                'description' => 'Non paid'
            ],
            [
                'description' => 'Annual'
            ]
        ]);
    }
}
