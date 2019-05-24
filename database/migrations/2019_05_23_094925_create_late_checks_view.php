<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLateChecksView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE VIEW late_checks AS
        SELECT id, employee_id, year, month, day, start_at, end_at FROM lates
        WHERE day < 5 
        AND ( TIME_TO_SEC(start_at)  < TIME_TO_SEC('8:00:00') OR  TIME_TO_SEC(end_at) < TIME_TO_SEC('17:30:00') )");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW late_checks");
    }
}
