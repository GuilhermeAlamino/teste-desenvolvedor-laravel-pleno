<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Department;
use App\Employee;
use App\Task;
use App\User;

class DashboardController extends Controller
{
    public function index()
    {
        $auth =  Auth::user();

        $department = Department::get()->count();
        $employee = Employee::get()->count();
        $task = Task::get()->count();

        $data = [
            "title" => 'Dashboard',
            "auth" => $auth,
            "department" => $department,
            "employee" => $employee,
            "task" => $task,
        ];

        return view('admin.dashboard', $data);
    }
}
