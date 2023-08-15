<?php

namespace App\Http\Controllers\Task;

use App\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Employee;

class TaskController extends Controller
{
    public function index()
    {
        $auth =  Auth::user();

        $tasks = Task::with('employee')->paginate(5);

        $data = [
            "title" => 'Task',
            "auth" => $auth,
            "tasks" => $tasks
        ];

        return view('admin.task.index', $data);
    }

    public function show($id)
    {
        $auth =  Auth::user();

        $tasks = Task::where('id', $id)->with('employee')->first();

        $data = [
            "title" => 'Task Show',
            "auth" => $auth,
            "tasks" => $tasks
        ];

        return view('admin.task.show', $data);
    }

    public function edit($id)
    {
        $auth =  Auth::user();

        $tasks = Task::where('id', $id)->with('employee')->first();

        $employees = Employee::get();

        $data = [
            "title" => 'Task Show',
            "auth" => $auth,
            "tasks" => $tasks,
            "employees" => $employees
        ];

        return view('admin.task.update', $data);
    }

    public function create()
    {
        $auth =  Auth::user();

        $employees = Employee::get();

        $data = [
            "title" => 'Task Store',
            "auth" => $auth,
            "employees" => $employees
        ];

        return view('admin.task.store', $data);
    }

    public function store(Request $request)
    {
        try {
            $customMessages = [
                'title.required' => 'O campo título é obrigatório.',
                'description.nullable' => 'O campo descrição deve ser null ou vazio.',
                'due_date.nullable' => 'O campo prazo deve ser null ou vazio.',
                'assignee_id.exists' => 'O funcionário selecionado não existe.'
            ];

            $validator = Validator::make($request->all(), [
                'title' => 'required',
                'description' => 'nullable',
                'due_date' => 'nullable',
                'assignee_id' => 'exists:tb_employees,id'
            ], $customMessages);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }

            $task = Task::create($request->only('title', 'description', 'due_date', 'assignee_id'));

            return redirect()->back()->with('success', 'Criado com sucesso');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['message' => $e->getMessage()])->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $task = Task::find($id);

            if (!$task) return redirect()->back()->withErrors(['message' => 'Registro não encontrado.'])->withInput();

            $customMessages = [
                'title.required' => 'O campo título é obrigatório.',
                'description.nullable' => 'O campo descrição deve ser null ou vazio.',
                'due_date.nullable' => 'O campo prazo deve ser null ou vazio.',
                'assignee_id.exists' => 'O funcionário selecionado não existe.'
            ];

            $validator = Validator::make($request->all(), [
                'title' => 'required',
                'description' => 'nullable',
                'due_date' => 'nullable',
                'assignee_id' => 'exists:tb_employees,id'
            ], $customMessages);

            if ($validator->fails()) {

                return redirect()->back()->withErrors($validator->errors())->withInput();
            }

            $task->update($request->only('title', 'description', 'due_date', 'assignee_id'));

            return redirect()->back()->with('success', 'Atualizado com sucesso');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['message' => $e->getMessage()])->withInput();
        }
    }

    public function delete(Request $request, $id)
    {
        try {
            $task = Task::find($id);

            if (!$task) return redirect()->back()->withErrors(['message' => 'Registro não encontrado.'])->withInput();

            $task->delete();

            return redirect()->back()->with('success', 'Deletado com sucesso');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['message' => $e->getMessage()])->withInput();
        }
    }
}
