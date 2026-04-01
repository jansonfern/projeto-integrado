@extends('layouts.app')

@section('content')
<div class="animate-fade-in-up">
    <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-3 mb-4">
        <div>
            <h1 class="h2 fw-bold text-dark mb-1 d-flex align-items-center gap-2">
                <span class="rounded-3 d-inline-flex align-items-center justify-content-center text-white"
                      style="width: 48px; height: 48px; background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%); box-shadow: 0 4px 14px rgba(14, 165, 233, 0.35);">
                    <i class="fas fa-user-md"></i>
                </span>
                Médicos
            </h1>
            <p class="text-muted mb-0 small">Cadastro da equipe médica, CRM e especialidades.</p>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Dashboard
            </a>
            @if(auth()->user()->isAdmin())
                <a href="{{ route('doctors.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Novo médico
                </a>
            @endif
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-xl-4">
            <div class="card border-0 h-100" style="border-left: 4px solid #0ea5e9 !important;">
                <div class="card-body py-3 d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-primary bg-opacity-10 p-3 text-primary">
                        <i class="fas fa-user-md fa-lg"></i>
                    </div>
                    <div>
                        <div class="text-muted small text-uppercase fw-semibold">Total</div>
                        <div class="h4 mb-0 fw-bold text-dark">{{ $doctors->count() }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-4">
            <div class="card border-0 h-100" style="border-left: 4px solid #10b981 !important;">
                <div class="card-body py-3 d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-success bg-opacity-10 p-3 text-success">
                        <i class="fas fa-stethoscope fa-lg"></i>
                    </div>
                    <div>
                        <div class="text-muted small text-uppercase fw-semibold">Especialidades</div>
                        <div class="h4 mb-0 fw-bold text-dark">{{ $doctors->pluck('specialty')->unique()->count() }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0 overflow-hidden">
        <div class="card-header bg-white border-bottom py-3">
            <span class="fw-semibold text-dark"><i class="fas fa-list me-2 text-primary"></i>Listagem</span>
        </div>
        @if($doctors->isEmpty())
            <div class="text-center py-5 px-4">
                <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center mb-3" style="width: 72px; height: 72px;">
                    <i class="fas fa-user-md text-muted fa-2x"></i>
                </div>
                <h2 class="h5 fw-semibold text-dark">Nenhum médico cadastrado</h2>
                <p class="text-muted small mb-4 mx-auto" style="max-width: 420px;">Comece cadastrando o primeiro profissional para vincular agendas e consultas.</p>
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('doctors.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Cadastrar médico
                    </a>
                @endif
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4 text-uppercase small text-muted fw-semibold">Profissional</th>
                            <th class="text-uppercase small text-muted fw-semibold d-none d-lg-table-cell">Contato</th>
                            <th class="text-uppercase small text-muted fw-semibold">CRM</th>
                            <th class="text-uppercase small text-muted fw-semibold">Especialidade</th>
                            <th class="text-end pe-4 text-uppercase small text-muted fw-semibold">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($doctors as $doctor)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center fw-bold"
                                             style="width: 44px; height: 44px; min-width: 44px;">
                                            {{ strtoupper(mb_substr($doctor->user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="fw-semibold text-dark">{{ $doctor->user->name }}</div>
                                            <div class="small text-muted d-lg-none">{{ $doctor->user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="d-none d-lg-table-cell">
                                    <span class="small"><i class="fas fa-envelope text-muted me-1"></i>{{ $doctor->user->email }}</span>
                                </td>
                                <td><code class="small bg-light px-2 py-1 rounded">{{ $doctor->crm }}</code></td>
                                <td>
                                    <span class="badge rounded-pill bg-primary bg-opacity-10 text-primary px-3 py-2 fw-medium">
                                        {{ $doctor->specialty }}
                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="d-flex flex-wrap justify-content-end gap-1">
                                        <a href="{{ route('doctors.show', $doctor) }}" class="btn btn-sm btn-outline-primary" title="Ver">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('doctors.edit', $doctor) }}" class="btn btn-sm btn-outline-secondary" title="Editar">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                        <form action="{{ route('doctors.destroy', $doctor) }}" method="POST" class="d-inline"
                                              onsubmit="return confirm('Excluir este médico e o usuário vinculado? Esta ação não pode ser desfeita.');">
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
