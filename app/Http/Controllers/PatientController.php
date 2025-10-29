<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PatientController extends Controller
{
    public function index()
    {
        $patients = Patient::with('user')->get();
        return view('patients.index', compact('patients'));
    }

    public function create()
    {
        return view('patients.create');
    }

    public function store(Request $request)
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

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'paciente',
        ]);

        Patient::create([
            'user_id' => $user->id,
            'cpf' => $data['cpf'],
            'birth_date' => $data['birth_date'],
            'phone' => $data['phone'],
            'cep' => $data['cep'] ?? null,
            'street' => $data['street'] ?? null,
            'city' => $data['city'] ?? null,
            'state' => $data['state'] ?? null,
        ]);

        return redirect()->route('patients.index')->with('success', 'Paciente cadastrado com sucesso!');
    }

    public function show(Patient $patient)
    {
        $patient->load(['user', 'appointments.doctor.user']);
        return view('patients.show', compact('patient'));
    }

    public function edit(Patient $patient)
    {
        return view('patients.edit', compact('patient'));
    }

    public function update(Request $request, Patient $patient)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $patient->user_id,
            'cpf' => 'required|string|size:14|unique:patients,cpf,' . $patient->id,
            'birth_date' => 'required|date',
            'phone' => 'required|string|max:20',
            'cep' => ['nullable', 'string', 'regex:/^(\d{8}|\d{5}-\d{3})$/'],
            'street' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|size:2',
            'password' => 'nullable|string|min:8',
        ]);

        $userData = [
            'name' => $data['name'],
            'email' => $data['email'],
        ];

        if (!empty($data['password'])) {
            $userData['password'] = Hash::make($data['password']);
        }

        $patient->user->update($userData);

        $patient->update([
            'cpf' => $data['cpf'],
            'birth_date' => $data['birth_date'],
            'phone' => $data['phone'],
            'cep' => $data['cep'] ?? null,
            'street' => $data['street'] ?? null,
            'city' => $data['city'] ?? null,
            'state' => $data['state'] ?? null,
        ]);

        return redirect()->route('patients.index')->with('success', 'Paciente atualizado com sucesso!');
    }

    public function destroy(Patient $patient)
    {
        $patient->user->delete();
        return redirect()->route('patients.index')->with('success', 'Paciente removido com sucesso!');
    }
}
