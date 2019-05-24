<?php

use Illuminate\Database\Seeder;
use App\Models\Attendance;
use Carbon\Carbon;
use App\Models\Employee;

class AttendanceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $list = [];
        $day = new Carbon('first day of March 2019');
        $employees = Employee::pluck('id')->toArray();
        for ($i = 0; $i <= 30; $i++)
        {
            foreach( $employees as $key => $value ) {

                $start = Carbon::createFromTime(7,59,59);
                $start->addSeconds(rand(0,60));
                $end = Carbon::createFromTime(17,30,00);

                $attendance = new Attendance;
                $attendance->employee_id = $value;
                $attendance->year = $day->year;
                $attendance->month = $day->month;
                $attendance->day = $day->day;
                $attendance->start_at = $start->toTimeString();
                $attendance->end_at = $end->toTimeString();
                $attendance->save();
            }
            $day->addDay();
        }
    }
}
