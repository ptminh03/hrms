<?php

use Faker\Generator as Faker;
use App\Models\User;

$factory->define(User::class, function (Faker $faker) {
    return [
        'email' => $faker->unique()->email,
        'password' => bcrypt('123456')
    ];
});
