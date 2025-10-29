<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DoctorController extends Controller
{
    public function index()
    {
        $doctors = Doctor::with('user')->get();
        return view('doctors.index', compact('doctors'));
    }

    public function create()
    {
        return view('doctors.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'crm' => 'required|string|max:20|unique:doctors',
            'specialty' => 'required|string|max:255',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'medico',
        ]);

        Doctor::create([
            'user_id' => $user->id,
            'crm' => $data['crm'],
            'specialty' => $data['specialty'],
        ]);

        return redirect()->route('doctors.index')->with('success', 'Médico cadastrado com sucesso!');
    }

    public function show(Doctor $doctor)
    {
        $doctor->load(['user', 'appointments.patient.user', 'schedules']);
        return view('doctors.show', compact('doctor'));
    }

    public function edit(Doctor $doctor)
    {
        return view('doctors.edit', compact('doctor'));
    }

    public function update(Request $request, Doctor $doctor)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $doctor->user_id,
            'crm' => 'required|string|max:20|unique:doctors,crm,' . $doctor->id,
            'specialty' => 'required|string|max:255',
            'password' => 'nullable|string|min:8',
        ]);

        $userData = [
            'name' => $data['name'],
            'email' => $data['email'],
        ];

        if (!empty($data['password'])) {
            $userData['password'] = Hash::make($data['password']);
        }

        $doctor->user->update($userData);

        $doctor->update([
            'crm' => $data['crm'],
            'specialty' => $data['specialty'],
        ]);

        return redirect()->route('doctors.index')->with('success', 'Médico atualizado com sucesso!');
    }

    public function destroy(Doctor $doctor)
    {
        $doctor->user->delete();
        return redirect()->route('doctors.index')->with('success', 'Médico removido com sucesso!');
    }
} 