<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Estatísticas gerais
        $totalAppointments = Appointment::count();
        $pendingAppointments = Appointment::where('status', 'pendente')->count();
        $confirmedAppointments = Appointment::where('status', 'confirmada')->count();
        $cancelledAppointments = Appointment::where('status', 'cancelada')->count();

        // Consultas por especialidade
        $appointmentsBySpecialty = Appointment::join('doctors', 'appointments.doctor_id', '=', 'doctors.id')
            ->selectRaw('doctors.specialty, COUNT(*) as count')
            ->groupBy('doctors.specialty')
            ->get();

        $specialtyLabels = $appointmentsBySpecialty->pluck('specialty');
        $specialtyValues = $appointmentsBySpecialty->pluck('count');

        // Consultas por mês
        $driver = DB::connection()->getDriverName();
        $year = (int) date('Y');

        if ($driver === 'sqlite') {
            $appointmentsByMonth = Appointment::query()
                ->selectRaw("CAST(strftime('%m', date) AS INTEGER) as month, COUNT(*) as count")
                ->whereRaw("strftime('%Y', date) = ?", [(string) $year])
                ->groupBy('month')
                ->orderBy('month')
                ->get();
        } else {
            $appointmentsByMonth = Appointment::query()
                ->selectRaw('MONTH(date) as month, COUNT(*) as count')
                ->whereYear('date', $year)
                ->groupBy('month')
                ->orderBy('month')
                ->get();
        }

        $monthLabels = $appointmentsByMonth->pluck('month')->map(function ($month) {
            return date('F', mktime(0, 0, 0, $month, 1));
        });
        $monthValues = $appointmentsByMonth->pluck('count');

        $user = auth()->user();
        $patientAppointments = collect();

        if ($user->role === 'paciente' && $user->patient) {
            $patientAppointments = \App\Models\Appointment::with(['doctor.user'])
                ->where('patient_id', $user->patient->id)
                ->orderByDesc('date')
                ->orderByDesc('time')
                ->get();
        }

        // Se for médico, filtrar estatísticas e consultas apenas dele
        if ($user->role === 'medico' && $user->doctor) {
            // Totais por status
            $totalConfirmed = Appointment::where('doctor_id', $user->doctor->id)->where('status', 'confirmada')->count();
            $totalPending = Appointment::where('doctor_id', $user->doctor->id)->where('status', 'pendente')->count();
            $totalCancelled = Appointment::where('doctor_id', $user->doctor->id)->where('status', 'cancelada')->count();

            // Gráficos por mês para cada status
            $months = collect(range(1, 12))->map(function ($m) {
                return date('F', mktime(0, 0, 0, $m, 1));
            });

            $confirmedPerMonth = collect();
            $pendingPerMonth = collect();
            $cancelledPerMonth = collect();
            foreach (range(1, 12) as $month) {
                $confirmedPerMonth->push(Appointment::where('doctor_id', $user->doctor->id)
                    ->where('status', 'confirmada')
                    ->whereYear('date', date('Y'))
                    ->whereMonth('date', $month)
                    ->count());
                $pendingPerMonth->push(Appointment::where('doctor_id', $user->doctor->id)
                    ->where('status', 'pendente')
                    ->whereYear('date', date('Y'))
                    ->whereMonth('date', $month)
                    ->count());
                $cancelledPerMonth->push(Appointment::where('doctor_id', $user->doctor->id)
                    ->where('status', 'cancelada')
                    ->whereYear('date', date('Y'))
                    ->whereMonth('date', $month)
                    ->count());
            }

            // Não mostrar consultas por especialidade para médico
            $specialtyLabels = collect();
            $specialtyValues = collect();

            // Atualizar variáveis de totais para não confundir na view
            $totalAppointments = $totalConfirmed + $totalPending + $totalCancelled;
            $pendingAppointments = $totalPending;
            $confirmedAppointments = $totalConfirmed;
            $cancelledAppointments = $totalCancelled;
        }

        // Garantir que as variáveis dos gráficos estejam sempre definidas
        if (! isset($months)) {
            $months = collect(range(1, 12))->map(function ($m) {
                return date('F', mktime(0, 0, 0, $m, 1));
            });
        }
        if (! isset($confirmedPerMonth)) {
            $confirmedPerMonth = collect(array_fill(0, 12, 0));
        }
        if (! isset($pendingPerMonth)) {
            $pendingPerMonth = collect(array_fill(0, 12, 0));
        }
        if (! isset($cancelledPerMonth)) {
            $cancelledPerMonth = collect(array_fill(0, 12, 0));
        }

        return view('dashboard', compact(
            'totalAppointments',
            'pendingAppointments',
            'confirmedAppointments',
            'cancelledAppointments',
            'specialtyLabels',
            'specialtyValues',
            'months',
            'confirmedPerMonth',
            'pendingPerMonth',
            'cancelledPerMonth',
            'patientAppointments'
        ));
    }
}
