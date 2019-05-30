<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(DepartmentTableSeeder::class);
        $this->call(PositionTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(LeaveTypeTableSeeder::class);
        $this->call(PolicyTableSeeder::class);
        $this->call(NewsTableSeeder::class);
        $this->call(DeviceTypeTableSeeder::class);
        $this->call(DeviceTableSeeder::class);
    }
}
