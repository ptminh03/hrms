<?php

use Illuminate\Database\Seeder;
use App\Models\Position;

class PositionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        (new Position)->insert([
            [
                'name' => 'Senior'
            ],
            [
                'name' => 'Junior'
            ],
            [
                'name' => 'Technical Leader'
            ],
            [
                'name' => 'Fresher'
            ],
            [
                'name' => 'Intern'
            ]
        ]);
    }
}
