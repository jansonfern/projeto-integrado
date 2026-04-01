<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            $schedules = Schedule::with('doctor.user')->get();
        } else {
            $schedules = Schedule::with('doctor.user')
                ->where('doctor_id', $user->doctor->id)
                ->get();
        }

        return view('schedules.index', compact('schedules'));
    }

    public function create()
    {
        $doctors = Doctor::with('user')->get();

        return view('schedules.create', compact('doctors'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'date' => 'required|date|after:today',
            'available_time' => 'required|date_format:H:i',
        ]);

        // Verificar se já existe um horário cadastrado
        $existingSchedule = Schedule::where('doctor_id', $data['doctor_id'])
            ->where('date', $data['date'])
            ->where('available_time', $data['available_time'])
            ->first();

        if ($existingSchedule) {
            return back()->withErrors(['available_time' => 'Horário já cadastrado para esta data.']);
        }

        Schedule::create([
            'doctor_id' => $data['doctor_id'],
            'date' => $data['date'],
            'available_time' => $data['available_time'],
            'is_available' => true,
        ]);

        return redirect()->route('schedules.index')->with('success', 'Horário cadastrado com sucesso!');
    }

    public function edit(Schedule $schedule)
    {
        $doctors = Doctor::with('user')->get();

        return view('schedules.edit', compact('schedule', 'doctors'));
    }

    public function update(Request $request, Schedule $schedule)
    {
        $data = $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'date' => 'required|date',
            'available_time' => 'required|date_format:H:i',
            'is_available' => 'boolean',
        ]);

        $schedule->update($data);

        return redirect()->route('schedules.index')->with('success', 'Horário atualizado com sucesso!');
    }

    public function destroy(Schedule $schedule)
    {
        $schedule->delete();

        return redirect()->route('schedules.index')->with('success', 'Horário removido com sucesso!');
    }

    public function getAvailableTimes(Request $request)
    {
        $data = $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'date' => 'required|date',
        ]);

        $availableTimes = Schedule::where('doctor_id', $data['doctor_id'])
            ->where('date', $data['date'])
            ->where('is_available', true)
            ->pluck('available_time')
            ->map(function ($time) {
                return date('H:i', strtotime($time));
            });

        return response()->json($availableTimes);
    }
}
