@extends('layouts.app')

@section('content')
<div class="animate-fade-in-up">
    <div class="d-flex flex-column flex-md-row align-items-start justify-content-between gap-3 mb-4">
        <div class="d-flex align-items-start gap-3">
            <div class="rounded-3 d-flex align-items-center justify-content-center text-white fs-3 fw-bold flex-shrink-0"
                 style="width: 72px; height: 72px; background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%); box-shadow: 0 8px 24px rgba(99, 102, 241, 0.35);">
                {{ strtoupper(mb_substr($patient->user->name, 0, 1)) }}
            </div>
            <div>
                <h1 class="h3 fw-bold text-dark mb-1">{{ $patient->user->name }}</h1>
                <p class="text-muted small mb-2"><i class="fas fa-envelope me-1"></i>{{ $patient->user->email }}</p>
                <div class="d-flex flex-wrap gap-2">
                    <span class="badge rounded-pill bg-light text-dark border px-3 py-2"><i class="fas fa-id-card me-1"></i>{{ $patient->cpf }}</span>
                    <span class="badge rounded-pill bg-light text-dark border px-3 py-2"><i class="fas fa-phone me-1"></i>{{ $patient->phone }}</span>
                    <span class="badge rounded-pill bg-light text-dark border px-3 py-2">
                        <i class="fas fa-birthday-cake me-1"></i>{{ \Carbon\Carbon::parse($patient->birth_date)->format('d/m/Y') }}
                    </span>
                </div>
            </div>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('patients.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-list me-2"></i>Lista
            </a>
            <a href="{{ route('patients.edit', $patient) }}" class="btn btn-primary">
                <i class="fas fa-pen me-2"></i>Editar
            </a>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-bottom py-3 fw-semibold">
                    <i class="fas fa-map-marker-alt me-2 text-primary"></i>Endereço
                </div>
                <div class="card-body">
                    @if($patient->cep || $patient->street)
                        <dl class="row mb-0 small">
                            <dt class="col-sm-4 text-muted">CEP</dt>
                            <dd class="col-sm-8">{{ $patient->cep ?? '—' }}</dd>
                            <dt class="col-sm-4 text-muted">Logradouro</dt>
                            <dd class="col-sm-8">{{ $patient->street ?? '—' }}</dd>
                            <dt class="col-sm-4 text-muted">Cidade / UF</dt>
                            <dd class="col-sm-8">{{ trim(($patient->city ?? '').' / '.($patient->state ?? '')) ?: '—' }}</dd>
                        </dl>
                    @else
                        <p class="text-muted small mb-0">Endereço não informado.</p>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #6366f1 !important;">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="rounded-circle p-3" style="background: rgba(99, 102, 241, 0.12); color: #4f46e5;">
                        <i class="fas fa-stethoscope fa-lg"></i>
                    </div>
                    <div>
                        <div class="text-muted small text-uppercase fw-semibold">Consultas no sistema</div>
                        <div class="h2 fw-bold text-dark mb-0">{{ $patient->appointments->count() }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($patient->appointments->count() > 0)
        <div class="card border-0 shadow-sm mt-4 overflow-hidden">
            <div class="card-header bg-white border-bottom py-3">
                <span class="fw-semibold"><i class="fas fa-history me-2 text-primary"></i>Histórico de consultas</span>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Data</th>
                            <th>Horário</th>
                            <th>Médico</th>
                            <th>Especialidade</th>
                            <th>Status</th>
                            <th class="pe-4 text-end">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($patient->appointments->sortByDesc('date') as $appointment)
                            <tr>
                                <td class="ps-4">{{ \Carbon\Carbon::parse($appointment->date)->format('d/m/Y') }}</td>
                                <td><span class="badge bg-light text-dark">{{ $appointment->time }}</span></td>
                                <td class="fw-medium">{{ $appointment->doctor->user->name }}</td>
                                <td><span class="small text-muted">{{ $appointment->doctor->specialty }}</span></td>
                                <td>
                                    <span class="badge rounded-pill bg-{{ $appointment->status === 'confirmada' ? 'success' : ($appointment->status === 'cancelada' ? 'danger' : 'warning') }} bg-opacity-75">
                                        {{ ucfirst($appointment->status) }}
                                    </span>
                                </td>
                                <td class="pe-4 text-end">
                                    <a href="{{ route('appointments.show', $appointment) }}" class="btn btn-sm btn-outline-primary me-1">Ver</a>
                                    @if($appointment->status === 'confirmada')
                                        <a href="{{ route('certificates.generate', $appointment) }}" class="btn btn-sm btn-success">
                                            <i class="fas fa-file-pdf me-1"></i>PDF
                                        </a>
                                    @endif
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
            <span>Este paciente ainda não possui consultas agendadas.</span>
        </div>
    @endif
</div>
@endsection
