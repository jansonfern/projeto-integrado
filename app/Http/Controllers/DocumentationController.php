<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use Barryvdh\DomPDF\Facade\Pdf;

class DocumentationController extends Controller
{
    public function generatePDF()
    {
        $data = [
            'generatedAt' => now()->setTimezone('America/Sao_Paulo'),
            'totals' => [
                'patients' => Patient::count(),
                'doctors' => Doctor::count(),
                'appointments' => Appointment::count(),
                'appointments_pending' => Appointment::where('status', 'pendente')->count(),
                'appointments_confirmed' => Appointment::where('status', 'confirmada')->count(),
                'appointments_cancelled' => Appointment::where('status', 'cancelada')->count(),
            ],
        ];

        $pdf = Pdf::loadView('documentation.pdf', $data);

        return $pdf->download('relatorio_sistema_medico_'.$data['generatedAt']->format('Y-m-d_H-i-s').'.pdf');
    }
}
