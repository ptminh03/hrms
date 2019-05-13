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
                'description' => 'Senior'
            ],
            [
                'description' => 'Junior'
            ],
            [
                'description' => 'Technical Leader'
            ],
            [
                'description' => 'Fresher'
            ],
            [
                'description' => 'Intern'
            ]
        ]);
    }
}
