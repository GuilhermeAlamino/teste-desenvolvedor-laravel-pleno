<?php

namespace Tests\Feature;

use App\Employee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use App\Task;
use App\User;

class TaskControllerTest extends TestCase
{

    use WithFaker;

    public function testIndex()
    {
        $existingUser = User::where('email', 'root@root.com')->first();

        $this->actingAs($existingUser);

        $response = $this->get('/dashboard/task');

        $response->assertViewIs('admin.task.index');
    }

    public function testShow()
    {
        $existingUser = User::where('email', 'root@root.com')->first();

        $task_id = Task::get()->first()['id'];

        $response = $this->actingAs($existingUser)->get('/dashboard/task/' . $task_id);

        $response->assertViewIs('admin.task.show');
    }

    public function testEdit()
    {
        $existingUser = User::where('email', 'root@root.com')->first();

        $task_id = Task::get()->first()['id'];

        $response = $this->actingAs($existingUser)->get('/dashboard/task/edit/' . $task_id);

        $response->assertViewIs('admin.task.update');
    }

    public function testStoreMethodWithValidData()
    {
        DB::beginTransaction();

        $existingUser = User::where('email', 'root@root.com')->first();

        $employeeId = Employee::inRandomOrder()->first()->id;

        $response = $this->actingAs($existingUser)
            ->get('/dashboard/task/create');

        $html = $response->getContent();
        preg_match('/<input type="hidden" name="_token" value="([^"]+)">/', $html, $matches);

        $csrfToken = $matches[1];

        $taskData = [
            'title' => $this->faker->title,
            'description' => $this->faker->paragraph,
            'assignee_id' => $employeeId,
            'due_date' => $this->faker->dateTimeThisMonth,
            '_token' => $csrfToken,
        ];

        $response = $this->actingAs($existingUser)
            ->post('/dashboard/task', $taskData);

        $this->assertDatabaseHas('tb_tasks', [
            'title' => $taskData['title'],
            'description' => $taskData['description'],
            'assignee_id' => $taskData['assignee_id'],
            'due_date' => $taskData['due_date'],
        ]);

        DB::rollBack();
    }

    public function testUpdateMethodWithValidData()
    {
        DB::beginTransaction();

        $existingUser = User::where('email', 'root@root.com')->first();

        $employeeId = Employee::inRandomOrder()->first()->id;

        $taskId = Task::inRandomOrder()->first()->id;

        $response = $this->actingAs($existingUser)
            ->get("/dashboard/task/edit/{$taskId}");

        $html = $response->getContent();
        preg_match('/<input type="hidden" name="_token" value="([^"]+)">/', $html, $matches);
        $csrfToken = $matches[1];

        $updatedTaskData = [
            'title' => 'Teste de Update ' . $this->faker->title,
            'description' => $this->faker->paragraph,
            'assignee_id' => $employeeId,
            'due_date' => $this->faker->dateTimeThisMonth,
            '_token' => $csrfToken,
        ];

        $response = $this->actingAs($existingUser)
            ->put("/dashboard/task/{$employeeId}", $updatedTaskData);

        $this->assertDatabaseHas('tb_tasks', [
            'id' => $taskId,
            'title' => $updatedTaskData['title'],
            'description' => $updatedTaskData['description'],
            'assignee_id' => $updatedTaskData['assignee_id'],
            'due_date' => $updatedTaskData['due_date'],
        ]);

        DB::rollBack();
    }

    public function testDeleteMethodWithValidData()
    {
        DB::beginTransaction();

        $task = Task::inRandomOrder()->first();

        $existingUser = User::where('email', 'root@root.com')->first();

        $response = $this->actingAs($existingUser)
            ->get("/dashboard/task/edit/{$task->id}");

        $html = $response->getContent();
        preg_match('/<input type="hidden" name="_token" value="([^"]+)">/', $html, $matches);

        $csrfToken = $matches[1];

        $deleteTaskData = [
            '_token' => $csrfToken,
        ];

        $response = $this->actingAs($existingUser)
            ->delete("/dashboard/task/delete/{$task->id}", $deleteTaskData);

        $this->assertDeleted($task);

        DB::rollBack();
    }
}
