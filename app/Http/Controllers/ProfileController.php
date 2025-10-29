<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        $phone = null;
        $crm = null;
        $cpf = null;
        $birthDate = null;
        
        if ($user->role === 'paciente' && $user->patient) {
            $phone = $user->patient->phone;
            $cpf = $user->patient->cpf;
            $birthDate = $user->patient->birth_date;
        } elseif ($user->role === 'medico' && $user->doctor) {
            $phone = $user->doctor->phone ?? '';
            $crm = $user->doctor->crm;
        }
        
        return view('profile.edit', compact('user', 'phone', 'crm', 'cpf', 'birthDate'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->name = $data['name'];
        $user->email = $data['email'];
        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }
        $user->save();

        // Atualizar telefone
        if ($user->role === 'paciente' && $user->patient) {
            $user->patient->phone = $data['phone'];
            $user->patient->save();
        } elseif ($user->role === 'medico' && $user->doctor) {
            $user->doctor->phone = $data['phone'];
            $user->doctor->save();
        }

        return redirect()->route('profile.edit')->with('success', 'Dados atualizados com sucesso!');
    }
} 