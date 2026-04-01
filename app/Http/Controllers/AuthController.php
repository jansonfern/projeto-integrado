<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password as PasswordRule;

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

            if ((bool) env('LOG_SECURITY', true)) {
                Log::info('Login realizado com sucesso', [
                    'user_id' => Auth::id(),
                    'email' => $request->input('email'),
                    'ip' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                ]);
            }

            return redirect()->intended(route('dashboard'));
        }

        if ((bool) env('LOG_FAILED_LOGIN', true)) {
            Log::warning('Tentativa de login falhou', [
                'email' => $request->input('email'),
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
        }

        return back()->withErrors([
            'email' => 'As credenciais fornecidas não correspondem aos nossos registros.',
        ])->onlyInput('email');
    }

    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withErrors(['email' => __($status)]);
    }

    public function showResetPasswordForm(Request $request, string $token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->query('email'),
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', PasswordRule::min(8)->letters()->numbers()],
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make((string) $request->input('password')),
                    'remember_token' => Str::random(60),
                ])->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
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
            'password' => ['required', 'confirmed', PasswordRule::min(8)->letters()->numbers()],
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
