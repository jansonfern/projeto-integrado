<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Appointment;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class CertificateController extends Controller
{
    public function generate(Appointment $appointment)
    {
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