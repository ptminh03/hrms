<?php

use Illuminate\Database\Seeder;
use App\Models\DeviceType;

class DeviceTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        (new DeviceType)->insert([
            [
                'description' => 'Macbook Air',
                'prefix' => 'MA'
            ],
            [
                'description' => 'Screen Sonic',
                'prefix' => 'SS'
            ],
            [
                'description' => 'Locker Key',
                'prefix' => 'LK'
            ]
        ]);
    }
}
