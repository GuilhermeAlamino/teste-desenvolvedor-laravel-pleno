<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Task;
use App\Employee;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1, 10) as $index) {
            $employee = Employee::inRandomOrder()->first();

            Task::create([
                'title' => $faker->sentence,
                'description' => $faker->paragraph,
                'assignee_id' => $employee->id, // Atribuir o id do funcionário aleatório
                'due_date' => $faker->dateTimeThisMonth, // Data aleatória deste mês para a data de vencimento
            ]);
        }
    }
}
