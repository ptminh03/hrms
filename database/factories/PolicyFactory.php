<?php

use Faker\Generator as Faker;
use App\Models\Policy;

$factory->define(Policy::class, function (Faker $faker) {
    return [
        'employee_id' => 1
    ];
});
