@extends('layouts.app')

@section('content')
<div class="animate-fade-in-up">
    <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-3 mb-4">
        <div>
            <h1 class="h2 fw-bold text-dark mb-1 d-flex align-items-center gap-2">
                <span class="rounded-3 d-inline-flex align-items-center justify-content-center text-white"
                      style="width: 48px; height: 48px; background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%); box-shadow: 0 4px 14px rgba(99, 102, 241, 0.35);">
                    <i class="fas fa-users"></i>
                </span>
                Pacientes
            </h1>
            <p class="text-muted mb-0 small">Cadastro de pacientes, CPF e dados de contato.</p>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Dashboard
            </a>
            @if(auth()->user()->isAdmin())
                <a href="{{ route('patients.create') }}" class="btn btn-primary">
                    <i class="fas fa-user-plus me-2"></i>Novo paciente
                </a>
            @endif
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-xl-4">
            <div class="card border-0 h-100" style="border-left: 4px solid #6366f1 !important;">
                <div class="card-body py-3 d-flex align-items-center gap-3">
                    <div class="rounded-circle p-3" style="background: rgba(99, 102, 241, 0.12); color: #4f46e5;">
                        <i class="fas fa-users fa-lg"></i>
                    </div>
                    <div>
                        <div class="text-muted small text-uppercase fw-semibold">Total</div>
                        <div class="h4 mb-0 fw-bold text-dark">{{ $patients->count() }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-4">
            <div class="card border-0 h-100" style="border-left: 4px solid #0ea5e9 !important;">
                <div class="card-body py-3 d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-primary bg-opacity-10 p-3 text-primary">
                        <i class="fas fa-id-card fa-lg"></i>
                    </div>
                    <div>
                        <div class="text-muted small text-uppercase fw-semibold">Com cadastro completo</div>
                        <div class="h4 mb-0 fw-bold text-dark">{{ $patients->count() }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0 overflow-hidden">
        <div class="card-header bg-white border-bottom py-3">
            <span class="fw-semibold text-dark"><i class="fas fa-list me-2 text-primary"></i>Listagem</span>
        </div>
        @if($patients->isEmpty())
            <div class="text-center py-5 px-4">
                <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center mb-3" style="width: 72px; height: 72px;">
                    <i class="fas fa-users text-muted fa-2x"></i>
                </div>
                <h2 class="h5 fw-semibold text-dark">Nenhum paciente cadastrado</h2>
                <p class="text-muted small mb-4 mx-auto" style="max-width: 420px;">Adicione pacientes para associar consultas e histórico clínico no sistema.</p>
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('patients.create') }}" class="btn btn-primary">
                        <i class="fas fa-user-plus me-2"></i>Cadastrar paciente
                    </a>
                @endif
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4 text-uppercase small text-muted fw-semibold">Paciente</th>
                            <th class="text-uppercase small text-muted fw-semibold d-none d-md-table-cell">E-mail</th>
                            <th class="text-uppercase small text-muted fw-semibold">CPF</th>
                            <th class="text-uppercase small text-muted fw-semibold d-none d-lg-table-cell">Telefone</th>
                            <th class="text-end pe-4 text-uppercase small text-muted fw-semibold">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($patients as $patient)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-white"
                                             style="width: 44px; height: 44px; min-width: 44px; background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);">
                                            {{ strtoupper(mb_substr($patient->user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="fw-semibold text-dark">{{ $patient->user->name }}</div>
                                            <div class="small text-muted d-md-none">{{ $patient->user->email }}</div>
                                            <div class="small text-muted d-lg-none"><i class="fas fa-phone me-1"></i>{{ $patient->phone }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="d-none d-md-table-cell">
                                    <span class="small"><i class="fas fa-envelope text-muted me-1"></i>{{ $patient->user->email }}</span>
                                </td>
                                <td><code class="small bg-light px-2 py-1 rounded">{{ $patient->cpf }}</code></td>
                                <td class="d-none d-lg-table-cell">
                                    <span class="small"><i class="fas fa-phone text-muted me-1"></i>{{ $patient->phone }}</span>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="d-flex flex-wrap justify-content-end gap-1">
                                        <a href="{{ route('patients.show', $patient) }}" class="btn btn-sm btn-outline-primary" title="Ver">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('patients.edit', $patient) }}" class="btn btn-sm btn-outline-secondary" title="Editar">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                        <form action="{{ route('patients.destroy', $patient) }}" method="POST" class="d-inline"
                                              onsubmit="return confirm('Excluir este paciente e o usuário vinculado? Esta ação não pode ser desfeita.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Excluir">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
