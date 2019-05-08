<?php

use Faker\Generator as Faker;
use App\Models\Employee;
use App\Models\User;

$factory->define(Employee::class, function (Faker $faker) {
    return [
        'photo' => 'default.png',
        'name' => $faker->name,
        'gender' => rand(0, 1),
        'date_of_birth' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'date_of_join' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'address' => $faker->address,
        'salary' => rand(5, 20)* 1000000,
        'account_number' => 'AGB0000000',
        'date_of_resignation' => $faker->date($format = 'Y-m-d', $max = 'now')
    ];
});
