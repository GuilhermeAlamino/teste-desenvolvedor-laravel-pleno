<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use App\Department;
use App\User;

class DepartmentControllerTest extends TestCase
{
    use WithFaker;

    public function testIndex()
    {
        $existingUser = User::where('email', 'root@root.com')->first();

        $this->actingAs($existingUser);

        $response = $this->get('/dashboard/department');

        $response->assertViewIs('admin.department.index');
    }

    public function testShow()
    {
        $existingUser = User::where('email', 'root@root.com')->first();

        $department_id = Department::get()->first()['id'];

        $response = $this->actingAs($existingUser)->get('/dashboard/department/' . $department_id);

        $response->assertViewIs('admin.department.show');
    }

    public function testEdit()
    {
        $existingUser = User::where('email', 'root@root.com')->first();

        $department_id = Department::get()->first()['id'];

        $response = $this->actingAs($existingUser)->get('/dashboard/department/edit/' . $department_id);

        $response->assertViewIs('admin.department.update');
    }

    public function testStoreMethodWithValidData()
    {
        DB::beginTransaction();

        $existingUser = User::where('email', 'root@root.com')->first();

        $response = $this->actingAs($existingUser)
            ->get('/dashboard/department/create');

        $html = $response->getContent();
        preg_match('/<input type="hidden" name="_token" value="([^"]+)">/', $html, $matches);

        $csrfToken = $matches[1];

        $departmentData = [
            'name' => $this->faker->word,
            '_token' => $csrfToken,
        ];

        $response = $this->actingAs($existingUser)
            ->post('/dashboard/department', $departmentData);

        $this->assertDatabaseHas('tb_departments', [
            'name' => $departmentData['name'],
        ]);

        DB::rollBack();
    }

    public function testUpdateMethodWithValidData()
    {
        DB::beginTransaction();

        $departmentId = Department::inRandomOrder()->first()->id;

        $existingUser = User::where('email', 'root@root.com')->first();

        $response = $this->actingAs($existingUser)
            ->get("/dashboard/department/edit/{$departmentId}");

        $html = $response->getContent();
        preg_match('/<input type="hidden" name="_token" value="([^"]+)">/', $html, $matches);
        $csrfToken = $matches[1];


        $updatedDepartmentData = [
            'name' => 'Teste de Update ' . $this->faker->unique()->word,
            '_token' => $csrfToken,
        ];

        $response = $this->actingAs($existingUser)
            ->put("/dashboard/department/{$departmentId}", $updatedDepartmentData);

        $this->assertDatabaseHas('tb_departments', [
            'id' => $departmentId,
            'name' => $updatedDepartmentData['name'],
        ]);

        DB::rollBack();
    }

    public function testDeleteMethodWithValidData()
    {
        DB::beginTransaction();

        $department = Department::inRandomOrder()->first();

        $existingUser = User::where('email', 'root@root.com')->first();

        $response = $this->actingAs($existingUser)
            ->get("/dashboard/department/edit/{$department->id}");

        $html = $response->getContent();
        preg_match('/<input type="hidden" name="_token" value="([^"]+)">/', $html, $matches);

        $csrfToken = $matches[1];

        $deleteDepartmentData = [
            '_token' => $csrfToken,
        ];

        $response = $this->actingAs($existingUser)
            ->delete("/dashboard/department/delete/{$department->id}", $deleteDepartmentData);

        $this->assertDeleted($department);

        DB::rollBack();
    }
}
