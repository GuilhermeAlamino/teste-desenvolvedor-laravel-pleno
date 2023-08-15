<?php

use Illuminate\Database\Seeder;
use App\Employee;
use App\Department;
use Faker\Factory as Faker;

class EmployeeSeeder extends Seeder
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
            $department = Department::inRandomOrder()->first();

            Employee::create([
                'firstName' => $faker->firstName,
                'lastName' => $faker->lastName,
                'email' => $faker->unique()->safeEmail,
                'phone' => $faker->phoneNumber,
                'department_id' => $department->id, // Atribuir o id do departamento aleatório
            ]);
        }
    }
}
