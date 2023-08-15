<?php

namespace App\Http\Controllers\Employee;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Employee;
use App\Department;

class EmployeeController extends Controller
{
    public function index()
    {
        $auth =  Auth::user();

        $employees = Employee::with('department')->paginate(5);

        $data = [
            "title" => 'Employee',
            "auth" => $auth,
            "employees" => $employees
        ];

        return view('admin.employee.index', $data);
    }

    public function show($id)
    {
        $auth =  Auth::user();

        $employees = Employee::where('id', $id)->with('department')->first();

        $data = [
            "title" => 'Employee Show',
            "auth" => $auth,
            "employees" => $employees
        ];

        return view('admin.employee.show', $data);
    }

    public function edit($id)
    {
        $auth =  Auth::user();

        $employees = Employee::where('id', $id)->with('department')->first();

        $departments = Department::get();

        $data = [
            "title" => 'Employee Update',
            "auth" => $auth,
            "employees" => $employees,
            "departments" => $departments
        ];

        return view('admin.employee.update', $data);
    }

    public function create()
    {
        $auth =  Auth::user();

        $departments = Department::get();

        $data = [
            "title" => 'Employee Store',
            "auth" => $auth,
            "departments" => $departments
        ];

        return view('admin.employee.store', $data);
    }

    public function store(Request $request)
    {

        try {
            $customMessages = [
                'firstName.required' => 'O campo nome é obrigatório.',
                'lastName.required' => 'O campo sobrenome é obrigatório.',
                'email.required' => 'O campo e-mail é obrigatório.',
                'email.email' => 'Por favor, insira um endereço de e-mail válido.',
                'email.unique' => 'Este e-mail já está sendo usado por outro funcionário.',
                'department_id.exists' => 'O departamento selecionado não existe.'
            ];

            $validator = Validator::make($request->all(), [
                'firstName' => 'required',
                'lastName' => 'required',
                'email' => 'required|email|unique:tb_employees,email',
                'phone' => 'nullable',
                'department_id' => 'exists:tb_departments,id'
            ], $customMessages);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }

            $employee = Employee::create($request->only('firstName', 'lastName', 'email', 'phone', 'department_id'));

            return redirect()->back()->with('success', 'Criado com sucesso');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['message' => $e->getMessage()])->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $employee = Employee::find($id);

            if (!$employee) return redirect()->back()->withErrors(['message' => 'Registro não encontrado.'])->withInput();

            $customMessages = [
                'firstName.required' => 'O campo nome é obrigatório.',
                'lastName.required' => 'O campo sobrenome é obrigatório.',
                'email.required' => 'O campo e-mail é obrigatório.',
                'email.email' => 'Por favor, insira um endereço de e-mail válido.',
                'email.unique' => 'Este e-mail já está sendo usado por outro funcionário.',
                'department_id.exists' => 'O departamento selecionado não existe.'
            ];

            $validator = Validator::make($request->all(), [
                'firstName' => 'required',
                'lastName' => 'required',
                'email' => 'required|email|unique:tb_employees,email,' . $id,
                'phone' => 'nullable',
                'department_id' => 'exists:tb_departments,id'
            ], $customMessages);

            if ($validator->fails()) {

                return redirect()->back()->withErrors($validator->errors())->withInput();
            }

            $employee->update($request->only('firstName', 'lastName', 'email', 'phone', 'department_id'));

            return redirect()->back()->with('success', 'Atualizado com sucesso');
        } catch (\Exception $e) {

            return redirect()->back()->withErrors(['message' => $e->getMessage()])->withInput();
        }
    }

    public function delete(Request $request, $id)
    {
        try {
            $employee = Employee::find($id);

            if (!$employee) return redirect()->back()->withErrors(['message' => 'Registro não encontrado.'])->withInput();

            $employee->delete();

            return redirect()->back()->with('success', 'Deletado com sucesso');
        } catch (\Exception $e) {

            return redirect()->back()->withErrors(['message' => $e->getMessage()])->withInput();
        }
    }
}
