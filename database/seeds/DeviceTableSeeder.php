<?php

use Illuminate\Database\Seeder;
use App\Models\Device;

class DeviceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $device = new Device;
        for ($i = 1; $i <= 20; $i++) {
            $device->insert([
                [
                    'device_type_id' => 1,
                    'code' => $i
                ],
                [
                    'device_type_id' => 2,
                    'code' => $i
                ],
                [
                    'device_type_id' => 3,
                    'code' => $i
                ]
            ]);
        }
    }
}
