<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class CertificateController extends Controller
{
    public function generate(Appointment $appointment)
    {
        $user = Auth::user();

        $canAccess =
            ($user && $user->isAdmin()) ||
            ($user && $user->isMedico() && $user->doctor && $user->doctor->id === $appointment->doctor_id) ||
            ($user && $user->isPaciente() && $user->patient && $user->patient->id === $appointment->patient_id);

        if (!$canAccess) {
            abort(403);
        }

        if ($appointment->status !== 'confirmada') {
            abort(403, 'Consulta não confirmada.');
        }
        
        // Carregar os relacionamentos necessários
        $appointment->load(['patient.user', 'doctor.user']);
        
        // Gerar o PDF
        $pdf = Pdf::loadView('certificates.pdf', ['appointment' => $appointment]);
        
        // Configurar para download automático
        $filename = 'certificado_consulta_' . $appointment->id . '_' . date('Y-m-d') . '.pdf';
        
        return $pdf->download($filename);
    }
} 