<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors([
            'email' => 'As credenciais fornecidas não correspondem aos nossos registros.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'cpf' => 'required|string|size:14|unique:patients',
            'birth_date' => 'required|date',
            'phone' => 'required|string|max:20',
            'cep' => ['nullable', 'string', 'regex:/^(\d{8}|\d{5}-\d{3})$/'],
            'street' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|size:2',
        ]);

        $user = \App\Models\User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => \Illuminate\Support\Facades\Hash::make($data['password']),
            'role' => 'paciente',
        ]);

        \App\Models\Patient::create([
            'user_id' => $user->id,
            'cpf' => $data['cpf'],
            'birth_date' => $data['birth_date'],
            'phone' => $data['phone'],
            'cep' => $data['cep'] ?? null,
            'street' => $data['street'] ?? null,
            'city' => $data['city'] ?? null,
            'state' => $data['state'] ?? null,
        ]);

        \Illuminate\Support\Facades\Auth::login($user);

        return redirect()->route('dashboard')->with('success', 'Cadastro realizado com sucesso!');
    }
}
