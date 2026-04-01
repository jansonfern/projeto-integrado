@extends('layouts.app')

@section('content')
<div class="animate-fade-in-up">
    <div class="d-flex flex-column flex-md-row align-items-start justify-content-between gap-3 mb-4">
        <div class="d-flex align-items-start gap-3">
            <div class="rounded-3 d-flex align-items-center justify-content-center text-white fs-3 fw-bold flex-shrink-0"
                 style="width: 72px; height: 72px; background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%); box-shadow: 0 8px 24px rgba(14, 165, 233, 0.35);">
                {{ strtoupper(mb_substr($doctor->user->name, 0, 1)) }}
            </div>
            <div>
                <h1 class="h3 fw-bold text-dark mb-1">{{ $doctor->user->name }}</h1>
                <p class="text-muted mb-2 small mb-0"><i class="fas fa-envelope me-1"></i>{{ $doctor->user->email }}</p>
                <div class="d-flex flex-wrap gap-2">
                    <span class="badge rounded-pill bg-primary bg-opacity-10 text-primary px-3 py-2">{{ $doctor->specialty }}</span>
                    <span class="badge rounded-pill bg-secondary bg-opacity-10 text-secondary px-3 py-2"><i class="fas fa-id-badge me-1"></i>{{ $doctor->crm }}</span>
                </div>
            </div>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('doctors.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-list me-2"></i>Lista
            </a>
            <a href="{{ route('doctors.edit', $doctor) }}" class="btn btn-primary">
                <i class="fas fa-pen me-2"></i>Editar
            </a>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #0ea5e9 !important;">
                <div class="card-body">
                    <div class="text-muted small text-uppercase fw-semibold mb-1">Consultas</div>
                    <div class="h2 fw-bold text-dark mb-0">{{ $doctor->appointments->count() }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #10b981 !important;">
                <div class="card-body">
                    <div class="text-muted small text-uppercase fw-semibold mb-1">Horários livres</div>
                    <div class="h2 fw-bold text-dark mb-0">{{ $doctor->schedules->where('is_available', true)->count() }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #6366f1 !important;">
                <div class="card-body">
                    <div class="text-muted small text-uppercase fw-semibold mb-1">Slots na agenda</div>
                    <div class="h2 fw-bold text-dark mb-0">{{ $doctor->schedules->count() }}</div>
                </div>
            </div>
        </div>
    </div>

    @if($doctor->appointments->isNotEmpty())
        <div class="card border-0 shadow-sm mt-4 overflow-hidden">
            <div class="card-header bg-white border-bottom py-3">
                <span class="fw-semibold"><i class="fas fa-calendar-check me-2 text-primary"></i>Últimas consultas</span>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Data</th>
                            <th>Horário</th>
                            <th>Paciente</th>
                            <th class="pe-4">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($doctor->appointments->sortByDesc('date')->take(8) as $appointment)
                            <tr>
                                <td class="ps-4">{{ \Carbon\Carbon::parse($appointment->date)->format('d/m/Y') }}</td>
                                <td><span class="badge bg-light text-dark">{{ $appointment->time }}</span></td>
                                <td class="fw-medium">{{ $appointment->patient->user->name }}</td>
                                <td class="pe-4">
                                    <span class="badge rounded-pill bg-{{ $appointment->status === 'confirmada' ? 'success' : ($appointment->status === 'cancelada' ? 'danger' : 'warning') }} bg-opacity-75">
                                        {{ ucfirst($appointment->status) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="alert alert-info border-0 mt-4 d-flex align-items-center gap-2">
            <i class="fas fa-info-circle fa-lg"></i>
            <span>Nenhuma consulta registrada para este médico ainda.</span>
        </div>
    @endif
</div>
@endsection
