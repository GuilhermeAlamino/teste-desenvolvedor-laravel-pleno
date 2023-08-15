<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use App\Employee;
use App\User;
use App\Department;

class EmployeeControllerTest extends TestCase
{
    use WithFaker;

    public function testIndex()
    {
        $existingUser = User::where('email', 'root@root.com')->first();

        $this->actingAs($existingUser);

        $response = $this->get('/dashboard/employee');

        $response->assertViewIs('admin.employee.index');
    }

    public function testShow()
    {
        $existingUser = User::where('email', 'root@root.com')->first();

        $employee_id = Employee::get()->first()['id'];

        $response = $this->actingAs($existingUser)->get('/dashboard/employee/' . $employee_id);

        $response->assertViewIs('admin.employee.show');
    }

    public function testEdit()
    {
        $existingUser = User::where('email', 'root@root.com')->first();

        $employee_id = Employee::get()->first()['id'];

        $response = $this->actingAs($existingUser)->get('/dashboard/employee/edit/' . $employee_id);

        $response->assertViewIs('admin.employee.update');
    }

    public function testStoreMethodWithValidData()
    {
        DB::beginTransaction();

        $existingUser = User::where('email', 'root@root.com')->first();

        $employeeId = Department::inRandomOrder()->first()->id;

        $response = $this->actingAs($existingUser)
            ->get('/dashboard/employee/create');

        $html = $response->getContent();
        preg_match('/<input type="hidden" name="_token" value="([^"]+)">/', $html, $matches);

        $csrfToken = $matches[1];

        $employeeData = [
            'firstName' => $this->faker->firstName,
            'lastName' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->phoneNumber,
            'department_id' => $employeeId,
            '_token' => $csrfToken,
        ];


        $response = $this->actingAs($existingUser)
            ->post('/dashboard/employee', $employeeData);

        $this->assertDatabaseHas('tb_employees', [
            'firstName' => $employeeData['firstName'],
            'lastName' => $employeeData['lastName'],
            'email' => $employeeData['email'],
            'phone' => $employeeData['phone'],
            'department_id' => $employeeData['department_id'],
        ]);

        DB::rollBack();
    }

    public function testUpdateMethodWithValidData()
    {
        DB::beginTransaction();

        $existingUser = User::where('email', 'root@root.com')->first();

        $employeeId = Employee::inRandomOrder()->first()->id;

        $departmentId = Department::inRandomOrder()->first()->id;

        $response = $this->actingAs($existingUser)
            ->get("/dashboard/employee/edit/{$employeeId}");

        $html = $response->getContent();
        preg_match('/<input type="hidden" name="_token" value="([^"]+)">/', $html, $matches);
        $csrfToken = $matches[1];

        $updatedEmployeeData = [
            'firstName' => 'Teste de Update ' . $this->faker->firstName,
            'lastName' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->phoneNumber,
            'department_id' => $departmentId,
            '_token' => $csrfToken,
        ];

        $response = $this->actingAs($existingUser)
            ->put("/dashboard/employee/{$employeeId}", $updatedEmployeeData);

        $this->assertDatabaseHas('tb_employees', [
            'id' => $employeeId,
            'firstName' => $updatedEmployeeData['firstName'],
            'lastName' => $updatedEmployeeData['lastName'],
            'email' => $updatedEmployeeData['email'],
            'phone' => $updatedEmployeeData['phone'],
            'department_id' => $updatedEmployeeData['department_id'],
        ]);

        DB::rollBack();
    }

    public function testDeleteMethodWithValidData()
    {
        DB::beginTransaction();

        $employee = Employee::inRandomOrder()->first();

        $existingUser = User::where('email', 'root@root.com')->first();

        $response = $this->actingAs($existingUser)
            ->get("/dashboard/employee/edit/{$employee->id}");

        $html = $response->getContent();
        preg_match('/<input type="hidden" name="_token" value="([^"]+)">/', $html, $matches);

        $csrfToken = $matches[1];

        $deleteEmployeeData = [
            '_token' => $csrfToken,
        ];

        $response = $this->actingAs($existingUser)
            ->delete("/dashboard/employee/delete/{$employee->id}", $deleteEmployeeData);

        $this->assertDeleted($employee);

        DB::rollBack();
    }
}
