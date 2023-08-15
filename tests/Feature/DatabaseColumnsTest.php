<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Schema;
use Tests\TestCase;
use App\Department;
use App\Employee;
use App\Task;
use App\User;

class DatabaseColumnsTest extends TestCase
{
    public function testDepartmentsTableHasNameColumn()
    {
        $columns = Schema::getColumnListing((new Department())->getTable());

        $this->assertContains('name', $columns);
    }

    public function testTasksTableHasNameColumn()
    {
        $expectedColumns = ['title', 'description', 'assignee_id', 'due_date']; // Adicione os nomes das colunas esperadas

        $columns = Schema::getColumnListing((new Task())->getTable());

        foreach ($expectedColumns as $column) {
            $this->assertContains($column, $columns);
        }
    }

    public function testEmployeesTableHasNameColumn()
    {
        $expectedColumns = ['firstName', 'lastName', 'email', 'phone', 'department_id']; // Adicione os nomes das colunas esperadas

        $columns = Schema::getColumnListing((new Employee())->getTable());

        foreach ($expectedColumns as $column) {
            $this->assertContains($column, $columns);
        }
    }

    public function testUsersTableHasNameColumn()
    {
        $expectedColumns = ['name', 'email', 'email_verified_at', 'password', 'remember_token']; // Adicione os nomes das colunas esperadas

        $columns = Schema::getColumnListing((new User())->getTable());

        foreach ($expectedColumns as $column) {
            $this->assertContains($column, $columns);
        }
    }
}
