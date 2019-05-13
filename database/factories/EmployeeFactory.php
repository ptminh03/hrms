<?php

use Faker\Generator as Faker;
use App\Models\Employee;
use App\Models\User;

$factory->define(Employee::class, function (Faker $faker) {
    return [
        'photo' => 'default.png',
        'name' => $faker->name,
        'gender' => ['Male', 'Female'][rand(0,1)],
        'date_of_join' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'date_of_birth' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'address' => $faker->address,
        'phone_number' => randomPhoneNumber(),
        'salary' => rand(5, 20)* 1000000,
        'account_number' => 'AGB0000000',
    ];
});

function randomPhoneNumber() {
    $result = "0";
    for ($i = 1; $i <= 9; $i++) {
        $result = $result. (string)rand(0, 9);
    }
    return $result;
}
