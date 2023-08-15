<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Employee;
use App\Department;

$factory->define(Employee::class, function (Faker $faker) {
    $departmentId = Department::inRandomOrder()->first()->id; // Obter um departamento aleatório

    return [
        'firstName' => $faker->firstName,
        'lastName' => $faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'phone' => $faker->phoneNumber,
        'department_id' => $departmentId, // Atribuir o id do departamento aleatório
    ];
});
