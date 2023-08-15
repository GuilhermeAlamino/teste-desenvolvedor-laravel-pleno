<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Department;

$factory->define(Department::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->word,
    ];
});
