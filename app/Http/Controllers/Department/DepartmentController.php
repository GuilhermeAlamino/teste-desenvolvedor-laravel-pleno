<?php

namespace App\Http\Controllers\Department;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Department;

class DepartmentController extends Controller
{
    public function index()
    {
        $auth =  Auth::user();

        $departments = Department::paginate(5);

        $data = [
            "title" => 'Department',
            "auth" => $auth,
            "departments" => $departments
        ];

        return view('admin.department.index', $data);
    }

    public function show($id)
    {
        $auth =  Auth::user();

        $departments = Department::where('id', $id)->first();

        $data = [
            "title" => 'Department Show',
            "auth" => $auth,
            "departments" => $departments
        ];

        return view('admin.department.show', $data);
    }

    public function edit($id)
    {
        $auth =  Auth::user();

        $departments = Department::where('id', $id)->first();

        $data = [
            "title" => 'Department Update',
            "auth" => $auth,
            "departments" => $departments
        ];

        return view('admin.department.update', $data);
    }

    public function create()
    {
        $auth =  Auth::user();

        $departments = Department::get();

        $data = [
            "title" => 'Department Store',
            "auth" => $auth,
            "departments" => $departments
        ];

        return view('admin.department.store', $data);
    }

    public function store(Request $request)
    {
        try {
            $customMessages = [
                'name.required' => 'O campo nome é obrigatório.'
            ];

            $validator = Validator::make($request->all(), [
                'name' => 'required',
            ], $customMessages);


            if ($validator->fails()) {

                return redirect()->back()->withErrors($validator->errors())->withInput();
            }

            $department = Department::create($request->only('name'));

            return redirect()->back()->with('success', 'Criado com sucesso');
        } catch (\Exception $e) {

            return redirect()->back()->withErrors(['message' => $e->getMessage()])->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $department = Department::find($id);

            if (!$department) {
                return redirect()->back()->withErrors(['message' => 'Registro não encontrado'])->withInput();
            }

            $customMessages = [
                'name.required' => 'O campo nome é obrigatório.'
            ];

            $validator = Validator::make($request->all(), [
                'name' => 'required',
            ], $customMessages);


            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }

            $department->update($request->only('name'));

            return redirect()->back()->with('success', 'Atualizado com sucesso');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['message' => $e->getMessage()])->withInput();
        }
    }

    public function delete(Request $request, $id)
    {
        try {
            $department = Department::find($id);

            if (!$department) return redirect()->back()->withErrors(['message' => 'Registro não encontrado.'])->withInput();

            $department->delete();

            return redirect()->back()->with('success', 'Deletado com sucesso');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['message' => $e->getMessage()])->withInput();
        }
    }
}
