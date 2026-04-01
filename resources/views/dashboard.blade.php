@extends('layouts.app')

@section('title', 'Painel Médico - Sistema de Gestão')

@section('content')
<div class="clean-container animate-fade-in-up">
    <!-- Header Profissional com Segurança -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-lg-8">
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3 secure-element">
                                    <i class="fas fa-heartbeat text-primary fs-4"></i>
                                </div>
                                <div>
                                    <h1 class="h2 mb-2 fw-bold">
                                        Painel de Controle Médico
                                    </h1>
                                    <p class="text-muted mb-0">
                                        <i class="fas fa-user-md me-2"></i>
                                        Bem-vindo(a), Dr(a). <strong class="text-primary">{{ e(Auth::user()->name) }}</strong>
                                        <span class="badge bg-primary bg-opacity-10 text-primary ms-2">{{ e(now()->format('d/m/Y H:i')) }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 text-lg-end">
                            <div class="d-flex gap-2 justify-content-lg-end">
                                <a href="{{ e(route('profile.edit')) }}" class="btn btn-outline-primary btn-sm secure-element">
                                    <i class="fas fa-user-cog me-2"></i>
                                    Meu Perfil
                                </a>
                                <form action="{{ e(route('logout')) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-danger btn-sm secure-element">
                                        <i class="fas fa-sign-out-alt me-2"></i>
                                        Sair
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Estatísticas Médicas com Validação -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Pacientes Ativos</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ e($patients_count ?? 0) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Consultas Hoje</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ e($appointments_today_count ?? 0) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-check fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Médicos</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ e($doctors_count ?? 0) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-md fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Agendamentos</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ e($schedules_count ?? 0) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Ações Rápidas Médicas com Segurança -->
    <div class="row g-4 mb-4">
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-medkit me-2"></i>
                        Ações Rápidas Médicas
                    </h6>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-3">Acessos diretos às funcionalidades principais do sistema médico</p>
                    <div class="row g-3">
                        @if(auth()->user()->role === 'admin')
                            <div class="col-md-6">
                                <a href="{{ e(route('patients.create')) }}" class="btn btn-primary w-100 mb-2 secure-element">
                                    <i class="fas fa-user-plus me-2"></i>
                                    Cadastrar Paciente
                                </a>
                            </div>
                            <div class="col-md-6">
                                <a href="{{ e(route('appointments.create')) }}" class="btn btn-success w-100 mb-2 secure-element">
                                    <i class="fas fa-calendar-plus me-2"></i>
                                    Agendar Consulta
                                </a>
                            </div>
                            <div class="col-md-6">
                                <a href="{{ e(route('doctors.create')) }}" class="btn btn-info w-100 mb-2 secure-element">
                                    <i class="fas fa-user-md me-2"></i>
                                    Adicionar Médico
                                </a>
                            </div>
                            <div class="col-md-6">
                                <a href="{{ e(route('schedules.index')) }}" class="btn btn-warning w-100 mb-2 secure-element">
                                    <i class="fas fa-clock me-2"></i>
                                    Gerenciar Agendas
                                </a>
                            </div>
                        @elseif(auth()->user()->role === 'medico')
                            <div class="col-md-6">
                                <a href="{{ e(route('appointments.create')) }}" class="btn btn-primary w-100 mb-2 secure-element">
                                    <i class="fas fa-stethoscope me-2"></i>
                                    Nova Consulta
                                </a>
                            </div>
                            <div class="col-md-6">
                                <a href="{{ e(route('my-schedules')) }}" class="btn btn-success w-100 mb-2 secure-element">
                                    <i class="fas fa-calendar-check me-2"></i>
                                    Minha Agenda
                                </a>
                            </div>
                            <div class="col-md-6">
                                <a href="#" class="btn btn-info w-100 mb-2 secure-element">
                                    <i class="fas fa-file-medical me-2"></i>
                                    Prontuários
                                </a>
                            </div>
                            <div class="col-md-6">
                                <a href="#" class="btn btn-warning w-100 mb-2 secure-element">
                                    <i class="fas fa-prescription me-2"></i>
                                    Receituário
                                </a>
                            </div>
                        @else
                            <div class="col-md-6">
                                <a href="{{ e(route('appointments.create')) }}" class="btn btn-primary w-100 mb-2 secure-element">
                                    <i class="fas fa-calendar-plus me-2"></i>
                                    Agendar Consulta
                                </a>
                            </div>
                            <div class="col-md-6">
                                <a href="#" class="btn btn-success w-100 mb-2 secure-element">
                                    <i class="fas fa-file-medical me-2"></i>
                                    Meu Prontuário
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-hospital me-2"></i>
                        Sistema Médico
                    </h6>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-3">Plataforma completa e moderna para gerenciamento de consultas médicas, pacientes e profissionais de saúde.</p>
                    
                    <div class="row mb-3">
                        <div class="col-sm-6 mb-2">
                            <small class="text-muted">Total de Pacientes</small>
                            <h5 class="mb-0">{{ e($patients_count ?? 0) }}</h5>
                        </div>
                        <div class="col-sm-6 mb-2">
                            <small class="text-muted">Total de Médicos</small>
                            <h5 class="mb-0">{{ e($doctors_count ?? 0) }}</h5>
                        </div>
                        <div class="col-sm-6 mb-2">
                            <small class="text-muted">Consultas Hoje</small>
                            <h5 class="mb-0">{{ e($appointments_today_count ?? 0) }}</h5>
                        </div>
                        <div class="col-sm-6 mb-2">
                            <small class="text-muted">Total de Agendamentos</small>
                            <h5 class="mb-0">{{ e($schedules_count ?? 0) }}</h5>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h6 class="mb-0">Status do Sistema</h6>
                            <small class="text-success">
                                <i class="fas fa-circle me-1"></i>
                                Online v2.0
                            </small>
                        </div>
                        <div class="text-end">
                            <small class="text-muted">Laravel 11 + Bootstrap 5</small>
                        </div>
                    </div>
                    
                    <div class="text-center">
                        <a href="#" class="btn btn-primary btn-sm secure-element">
                            <i class="fas fa-file-medical me-2"></i>
                            Gerar Relatórios Médicos
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Perfil do Usuário Médico com Proteção XSS -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-user-md me-2"></i>
                        Perfil do Profissional
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <p class="py-2">
                                <strong>Tipo de Acesso:</strong> 
                                <span class="badge bg-primary bg-opacity-10 text-primary">
                                    @if(auth()->user()->role === 'admin')
                                        Administrador do Sistema
                                    @elseif(auth()->user()->role === 'medico')
                                        Médico Responsável
                                    @else
                                        Paciente
                                    @endif
                                </span>
                            </p>
                            <p class="mb-0">
                                <i class="fas fa-shield-alt me-2"></i>
                                @if(auth()->user()->role === 'admin')
                                    Você tem controle total sobre todas as operações do sistema médico, incluindo gerenciamento de pacientes, médicos, agendas e relatórios clínicos.
                                @elseif(auth()->user()->role === 'medico')
                                    Você pode gerenciar suas consultas, acessar prontuários de pacientes e emitir documentos médicos.
                                @else
                                    Você pode agendar consultas, visualizar seu histórico médico e atualizar seus dados pessoais.
                                @endif
                            </p>
                        </div>
                        <div class="col-md-4 text-md-end">
                            <div class="bg-light rounded p-3 secure-element">
                                <h6 class="mb-2">{{ e(auth()->user()->name) }}</h6>
                                <p class="mb-1"><small class="text-muted">{{ e(auth()->user()->email) }}</small></p>
                                <p class="mb-0">
                                    <small class="text-muted">Cargo: </small>
                                    <strong>{{ e(ucfirst(auth()->user()->role)) }}</strong>
                                </p>
                                <p class="mb-0">
                                    <small class="text-muted">Status: </small>
                                    <span class="badge bg-success">Ativo</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Security: Anti-CSRF JavaScript -->
<script nonce="{{ $cspNonce ?? '' }}">
document.addEventListener('DOMContentLoaded', function() {
    // Proteção adicional contra CSRF em AJAX requests
    const originalFetch = window.fetch;
    window.fetch = function(url, options = {}) {
        if (options.method && ['POST', 'PUT', 'DELETE', 'PATCH'].includes(options.method.toUpperCase())) {
            const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            if (token) {
                options.headers = {
                    ...options.headers,
                    'X-CSRF-TOKEN': token
                };
            }
        }
        return originalFetch(url, options);
    };

    // Prevenir clickjacking
    if (window.top !== window.self) {
        window.top.location = window.self.location;
    }

    // Log de segurança (apenas em desenvolvimento)
    @if(app()->environment('local'))
    console.log('Security: Dashboard carregado com proteções XSS e CSRF');
    @endif
});
</script>
@endsection