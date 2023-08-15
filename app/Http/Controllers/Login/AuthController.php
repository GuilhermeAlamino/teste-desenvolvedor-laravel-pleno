<?php

namespace App\Http\Controllers\Login;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Notifications\notifyUser;
use App\Http\Controllers\Controller;
use App\User;

class AuthController extends Controller
{
    public function viewLogin()
    {
        return view('admin.auth.login');
    }

    public function index()
    {
        $auth =  Auth::user();

        $users =  User::paginate(5);

        $data = [
            "title" => 'User',
            "auth" => $auth,
            "users" => $users,
        ];

        return view('admin.user.index', $data);
    }

    public function show($id)
    {
        $auth =  Auth::user();

        $users =  User::where('id', $id)->first();

        $data = [
            "title" => 'User',
            "auth" => $auth,
            "users" => $users,
        ];

        return view('admin.user.show', $data);
    }

    public function edit($id)
    {
        $auth =  Auth::user();

        $users =  User::where('id', $id)->first();

        $data = [
            "title" => 'User Show',
            "auth" => $auth,
            "users" => $users,
        ];

        return view('admin.user.update', $data);
    }

    public function create()
    {
        $auth =  Auth::user();

        $data = [
            "title" => 'User Store',
            "auth" => $auth
        ];

        return view('admin.user.store', $data);
    }

    public function login(Request $request)
    {

        try {
            $credentials = $request->only('email', 'password');


            $customMessages = [
                'email.required' => 'O campo email é obrigatório.',
                'password.required' => 'O campo senha é obrigatório.'
            ];

            $validator = Validator::make($credentials, [
                'email' => 'required',
                'password' => 'required',
            ], $customMessages);


            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }

            if (Auth::attempt($credentials)) {
                return redirect()->intended('dashboard');
            } else {
                return redirect()->back()->withErrors(['message' => 'Por favor, verifique seu email ou senha.'])->withInput();
            }
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['message' => $e->getMessage()])->withInput();
        }
    }


    public function store(Request $request)
    {
        try {

            $credentials = $request->only('name', 'email', 'password');

            $customMessages = [
                'name.required' => 'O campo nome é obrigatório.',
                'email.required' => 'O campo email é obrigatório.',
                'password.required' => 'O campo senha é obrigatório.',
            ];

            $validator = Validator::make($credentials, [
                'name' => 'required',
                'email' => 'required',
                'password' => 'required',
            ], $customMessages);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }

            $credentialsFilteredNull = array_filter($credentials, function ($value) {
                return $value !== null;
            });

            if (isset($credentialsFilteredNull['password'])) {
                $credentialsFilteredNull['password'] = Hash::make($credentialsFilteredNull['password']);
            }

            $user = User::create($credentialsFilteredNull);
            $user->remember_token = Str::random(60);
            $user->save();

            return redirect()->back()->with('success', 'Criado com sucesso.');
        } catch (\Exception $e) {

            return redirect()->back()->withErrors(['message' => $e->getMessage()])->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $users = User::find($id);

            if (!$users) {
                return redirect()->back()->withErrors(['message' => 'Registro não encontrado.'])->withInput();
            }

            $credentials = $request->only('name', 'email', 'password');

            $customMessages = [
                'name.required' => 'O campo nome é obrigatório.',
                'email.required' => 'O campo email é obrigatório.',
            ];

            $validator = Validator::make($credentials, [
                'name' => 'required',
                'email' => 'required',
            ], $customMessages);


            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }

            $credentialsFilteredNull = array_filter($credentials, function ($value) {
                return $value !== null;
            });

            if (isset($credentialsFilteredNull['password'])) {
                $credentialsFilteredNull['password'] = Hash::make($credentialsFilteredNull['password']);
            }

            $users->update($credentialsFilteredNull);

            return redirect()->back()->with('success', 'Atualizado com sucesso');
        } catch (\Exception $e) {

            return redirect()->back()->withErrors(['message' => $e->getMessage()])->withInput();
        }
    }

    public function logout(Request $request)
    {
        try {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect('/login');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['message' => $e->getMessage()])->withInput();
        }
    }

    public function delete(Request $request, $id)
    {
        try {
            $user = User::find($id);

            if (!$user) return redirect()->back()->withErrors(['message' => 'Registro não encontrado.'])->withInput();

            $user->delete();

            return redirect()->back()->with('success', 'Deletado com sucesso');
        } catch (\Exception $e) {

            return redirect()->back()->withErrors(['message' => $e->getMessage()])->withInput();
        }
    }

    public function confirmEmail($token)
    {
        $user = User::where('remember_token', $token)->first();

        if (!$user) return redirect()->back()->withErrors(['message' => 'Registro não encontrado.'])->withInput();

        $user->email_verified_at = now();
        $user->save();

        return redirect()->back()->with('success_verify', 'E-mail confirmado com sucesso');
    }

    public function verify($id)
    {
        $user = User::where('id', $id)->first();

        if (!$user) return redirect()->back()->withErrors(['message' => 'Usúario não encontrado.'])->withInput();

        $user->remember_token = Str::random(60);
        $user->save();
        $user->notify(new notifyUser($user->remember_token));

        return redirect()->back()->with('success_verify', 'Verificação enviada com sucesso');
    }
}
