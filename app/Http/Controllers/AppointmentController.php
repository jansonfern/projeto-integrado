<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    private function authorizeAccess(Appointment $appointment): void
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            return;
        }

        if ($user->isMedico() && $user->doctor && $user->doctor->id === $appointment->doctor_id) {
            return;
        }

        if ($user->isPaciente() && $user->patient && $user->patient->id === $appointment->patient_id) {
            return;
        }

        abort(403);
    }

    public function index()
    {
        $user = Auth::user();
        
        if ($user->isAdmin()) {
            $appointments = Appointment::with(['patient.user', 'doctor.user'])->get();
        } elseif ($user->isMedico()) {
            $appointments = Appointment::with(['patient.user', 'doctor.user'])
                ->where('doctor_id', $user->doctor->id)
                ->get();
        } else {
            $appointments = Appointment::with(['patient.user', 'doctor.user'])
                ->where('patient_id', $user->patient->id)
                ->get();
        }
        
        return view('appointments.index', compact('appointments'));
    }

    public function create()
    {
        $user = Auth::user();
        
        // Verificar se o usuário é um paciente
        if (!$user->isPaciente()) {
            return redirect()->route('appointments.index')->withErrors(['error' => 'Apenas pacientes podem agendar consultas.']);
        }

        $doctors = Doctor::with('user')->get();
        return view('appointments.create', compact('doctors'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        
        // Verificar se o usuário é um paciente
        if (!$user->isPaciente()) {
            return back()->withErrors(['error' => 'Apenas pacientes podem agendar consultas.']);
        }

        $data = $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'date' => 'required|date|after:today',
            'time' => 'required|date_format:H:i',
        ]);

        $patient = $user->patient;
        
        if (!$patient) {
            return back()->withErrors(['error' => 'Perfil de paciente não encontrado.']);
        }
        
        // Verificar se o horário está disponível
        $schedule = Schedule::where('doctor_id', $data['doctor_id'])
            ->where('date', $data['date'])
            ->where('available_time', $data['time'])
            ->where('is_available', true)
            ->first();

        if (!$schedule) {
            return back()->withErrors(['time' => 'Horário não disponível.']);
        }

        // Verificar se não há consulta agendada no mesmo horário
        $existingAppointment = Appointment::where('doctor_id', $data['doctor_id'])
            ->where('date', $data['date'])
            ->where('time', $data['time'])
            ->where('status', '!=', 'cancelada')
            ->first();

        if ($existingAppointment) {
            return back()->withErrors(['time' => 'Horário já ocupado.']);
        }

        $appointment = Appointment::create([
            'patient_id' => $patient->id,
            'doctor_id' => $data['doctor_id'],
            'date' => $data['date'],
            'time' => $data['time'],
            'status' => 'pendente',
        ]);

        // Marcar horário como indisponível
        $schedule->update(['is_available' => false]);

        return redirect()->route('appointments.index')->with('success', 'Consulta agendada com sucesso!');
    }

    public function show(Appointment $appointment)
    {
        $this->authorizeAccess($appointment);
        $appointment->load(['patient.user', 'doctor.user']);
        return view('appointments.show', compact('appointment'));
    }

    public function edit(Appointment $appointment)
    {
        $this->authorizeAccess($appointment);
        $appointment->load(['patient.user', 'doctor.user']);
        $doctors = Doctor::with('user')->get();
        $patients = Patient::with('user')->get();
        return view('appointments.edit', compact('appointment', 'doctors', 'patients'));
    }

    public function update(Request $request, Appointment $appointment)
    {
        $this->authorizeAccess($appointment);

        $data = $request->validate([
            'status' => 'required|in:pendente,confirmada,cancelada',
            'notes' => 'nullable|string',
        ]);

        $appointment->update($data);

        return redirect()->route('appointments.show', $appointment)->with('success', 'Consulta atualizada com sucesso!');
    }

    public function confirm(Appointment $appointment)
    {
        if (!Auth::user()->isMedico() || Auth::user()->doctor->id !== $appointment->doctor_id) {
            abort(403);
        }

        $appointment->update(['status' => 'confirmada']);
        return back()->with('success', 'Consulta confirmada!');
    }

    public function cancel(Appointment $appointment)
    {
        $this->authorizeAccess($appointment);

        $appointment->update(['status' => 'cancelada']);

        // Liberar o horário na agenda
        $schedule = Schedule::where('doctor_id', $appointment->doctor_id)
            ->where('date', $appointment->date)
            ->where('available_time', $appointment->time)
            ->first();

        if ($schedule) {
            $schedule->update(['is_available' => true]);
        }

        return back()->with('success', 'Consulta cancelada!');
    }

    public function destroy(Appointment $appointment)
    {
        $this->authorizeAccess($appointment);

        $appointment->delete();
        return redirect()->route('appointments.index')->with('success', 'Consulta removida!');
    }

    public function availableSlots()
    {
        $user = Auth::user();
        
        if (!$user->isPaciente()) {
            return redirect()->route('appointments.index')->withErrors(['error' => 'Apenas pacientes podem agendar consultas.']);
        }

        // Buscar horários disponíveis para os próximos 7 dias
        $availableSlots = Schedule::with(['doctor.user'])
            ->where('is_available', true)
            ->where('date', '>=', now()->format('Y-m-d'))
            ->where('date', '<=', now()->addDays(7)->format('Y-m-d'))
            ->orderBy('date')
            ->orderBy('available_time')
            ->get()
            ->groupBy('date');

        return view('appointments.available', compact('availableSlots'));
    }

    public function quickBook(Request $request)
    {
        $user = Auth::user();
        
        if (!$user->isPaciente()) {
            return back()->withErrors(['error' => 'Apenas pacientes podem agendar consultas.']);
        }

        $data = $request->validate([
            'schedule_id' => 'required|exists:schedules,id',
        ]);

        $patient = $user->patient;
        
        if (!$patient) {
            return back()->withErrors(['error' => 'Perfil de paciente não encontrado.']);
        }

        $schedule = Schedule::find($data['schedule_id']);
        
        if (!$schedule || !$schedule->is_available) {
            return back()->withErrors(['error' => 'Horário não está mais disponível.']);
        }

        // Verificar se não há consulta agendada no mesmo horário
        $existingAppointment = Appointment::where('doctor_id', $schedule->doctor_id)
            ->where('date', $schedule->date)
            ->where('time', $schedule->available_time)
            ->where('status', '!=', 'cancelada')
            ->first();

        if ($existingAppointment) {
            return back()->withErrors(['error' => 'Horário já ocupado.']);
        }

        $appointment = Appointment::create([
            'patient_id' => $patient->id,
            'doctor_id' => $schedule->doctor_id,
            'date' => $schedule->date,
            'time' => $schedule->available_time,
            'status' => 'pendente',
        ]);

        // Marcar horário como indisponível
        $schedule->update(['is_available' => false]);

        return redirect()->route('appointments.index')->with('success', 'Consulta agendada com sucesso!');
    }
} 