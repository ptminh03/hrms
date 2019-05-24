<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use DB;
use Carbon\Carbon;
use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        // Commands\Inspire::class,
        \App\Console\Commands\Wish::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $today = Carbon::now();
    
            DB::statement("INSERT INTO lates (employee_id, year, month, day, start_at, end_at)
            SELECT employee_id, year, month, day, start_at, end_at FROM attendances
            WHERE TIME_TO_SEC(start_at)  < TIME_TO_SEC('8:00:00') OR  TIME_TO_SEC(end_at) < TIME_TO_SEC('17:30:00')");

            Attendance::truncate();
            $employees = Employee::where('id', '<', 10)->pluck('id')->toArray();
            // $list = [];
            foreach( $employees as $key => $value ) {
                $attendance = new Attendance;
                $attendance->employee_id = $value;
                $attendance->year = $today->year;
                $attendance->month = $today->month;
                $attendance->day = $today->day;
                $attendance->start_at = '0:00:00';
                $attendance->end_at = '0:00:00';
                // $list[] = $attendance;
                $attendance->save();
            }
            \Log::info('12312321');
            // dd($list);
            // Attendance::insert($list);
            
        })->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}
