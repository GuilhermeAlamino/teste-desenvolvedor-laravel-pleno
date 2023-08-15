<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Employee;

$factory->define(Task::class, function (Faker $faker) {
    $employeeId = Employee::inRandomOrder()->first()->id; // Obter um departamento aleatório

    return [
        'title' => $faker->sentence,
        'description' => $faker->paragraph,
        'assignee_id' => $employeeId, // Atribuir o id do funcionário aleatório
        'due_date' => $faker->dateTimeThisMonth, // Data aleatória deste mês para a data de vencimento
    ];
});
