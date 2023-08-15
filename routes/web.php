<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', 'Login\AuthController@viewLogin');

Route::get('/confirm-email/{token}', 'Login\AuthController@confirmEmail');

Route::post('/login', 'Login\AuthController@login');

Route::group(['middleware' => 'auth.dashboard'], function () {

    Route::post('/logout', 'Login\AuthController@logout');

    // Rotas prefixo Dashboard
    Route::prefix('dashboard')->group(function () {
        // Rota Dashboard Verificar User
        Route::post('/user/verify/{id}', 'Login\AuthController@verify');

        // Rotas Dashboard Index
        Route::get('/', 'Dashboard\DashboardController@index');

        // Rotas Dashboard User
        Route::get('/user', 'Login\AuthController@index');

        Route::get('/user/create', 'Login\AuthController@create');

        Route::get('/user/{id}', 'Login\AuthController@show');

        Route::get('/user/edit/{id}', 'Login\AuthController@edit');

        Route::post('/user', 'Login\AuthController@store');

        Route::put('/user/{id}', 'Login\AuthController@update');

        Route::post('/user/store', 'Login\AuthController@store');

        Route::delete('/user/delete/{id}', 'Login\AuthController@delete');

        // Rotas Dashboard Departamentos
        Route::get('/department', 'Department\DepartmentController@index');

        Route::get('/department/create', 'Department\DepartmentController@create');

        Route::get('/department/{id}', 'Department\DepartmentController@show');

        Route::get('/department/edit/{id}', 'Department\DepartmentController@edit');

        Route::post('/department', 'Department\DepartmentController@store');

        Route::put('/department/{id}', 'Department\DepartmentController@update');

        Route::delete('/department/delete/{id}', 'Department\DepartmentController@delete');

        // Rotas Dashboard Funcionarios
        Route::get('/employee', 'Employee\EmployeeController@index');

        Route::get('/employee/create', 'Employee\EmployeeController@create');

        Route::get('/employee/{id}', 'Employee\EmployeeController@show');

        Route::get('/employee/edit/{id}', 'Employee\EmployeeController@edit');

        Route::post('/employee', 'Employee\EmployeeController@store');

        Route::put('/employee/{id}', 'Employee\EmployeeController@update');

        Route::delete('/employee/delete/{id}', 'Employee\EmployeeController@delete');

        // Rotas Dashboard Tarefas
        Route::get('/task', 'Task\TaskController@index');

        Route::get('/task/create', 'Task\TaskController@create');

        Route::get('/task/{id}', 'Task\TaskController@show');

        Route::get('/task/edit/{id}', 'Task\TaskController@edit');

        Route::post('/task', 'Task\TaskController@store');

        Route::put('/task/{id}', 'Task\TaskController@update');

        Route::delete('/task/delete/{id}', 'Task\TaskController@delete');
    });
});
