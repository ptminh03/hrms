<?php

use Illuminate\Database\Seeder;
use App\Models\LeaveAnnualLeft;

class LeaveAnnualLeftTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $leaveAnnualLeft = (new LeaveAnnualLeft);
        for($i = 1; $i <= 10; $i++) {
            $leaveAnnualLeft->create([
                'employee_id' => $i,
                'days_left' => 12
            ]);
        }
    }
}
