@extends('layouts.app')

@section('content')
@php
    $roleLabel = match ($user->role) {
        'admin' => 'Administrador',
        'medico' => 'Médico',
        'paciente' => 'Paciente',
        default => ucfirst($user->role),
    };
    $roleBadgeClass = match ($user->role) {
        'admin' => 'bg-dark bg-opacity-10 text-dark',
        'medico' => 'bg-primary bg-opacity-10 text-primary',
        'paciente' => '',
        default => 'bg-secondary bg-opacity-10 text-secondary',
    };
@endphp

<div class="animate-fade-in-up">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-xl-7">
            <div class="d-flex align-items-start gap-3 mb-4 flex-wrap">
                <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-sm rounded-circle flex-shrink-0" style="width: 40px; height: 40px; padding: 0; display: inline-flex; align-items: center; justify-content: center;" title="Voltar ao dashboard">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div class="d-flex align-items-start gap-3 flex-grow-1 min-w-0">
                    <div class="rounded-3 d-flex align-items-center justify-content-center text-white fs-4 fw-bold flex-shrink-0"
                         style="width: 64px; height: 64px; background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%); box-shadow: 0 6px 20px rgba(14, 165, 233, 0.35);">
                        {{ strtoupper(mb_substr($user->name, 0, 1)) }}
                    </div>
                    <div class="min-w-0">
                        <h1 class="h3 fw-bold text-dark mb-1">Meus dados</h1>
                        <p class="text-muted small mb-2 text-truncate">{{ $user->email }}</p>
                        @if($user->role === 'paciente')
                            <span class="badge rounded-pill px-3 py-2 fw-medium" style="background: rgba(99, 102, 241, 0.12); color: #4f46e5;">
                                <i class="fas fa-user me-1"></i>{{ $roleLabel }}
                            </span>
                        @else
                            <span class="badge rounded-pill px-3 py-2 fw-medium {{ $roleBadgeClass }}">
                                <i class="fas fa-user-shield me-1"></i>{{ $roleLabel }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            @if($user->role === 'medico' && $crm)
                <div class="card border-0 shadow-sm mb-4" style="border-left: 4px solid #0ea5e9 !important;">
                    <div class="card-body p-4">
                        <h2 class="h6 text-uppercase text-muted fw-bold mb-3">
                            <i class="fas fa-id-badge me-2 text-primary"></i>Registro profissional
                        </h2>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label text-muted small mb-1">CRM</label>
                                <input type="text" class="form-control bg-light" value="{{ $crm }}" readonly disabled>
                                <div class="form-text">O CRM não pode ser alterado aqui. Contate o administrador se precisar corrigir.</div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if($user->role === 'paciente')
                @if($cpf || $birthDate)
                    <div class="card border-0 shadow-sm mb-4" style="border-left: 4px solid #6366f1 !important;">
                        <div class="card-body p-4">
                            <h2 class="h6 text-uppercase text-muted fw-bold mb-3">
                                <i class="fas fa-fingerprint me-2 text-primary"></i>Dados cadastrais fixos
                            </h2>
                            <div class="row g-3">
                                @if($cpf)
                                    <div class="col-md-6">
                                        <label class="form-label text-muted small mb-1">CPF</label>
                                        <input type="text" class="form-control bg-light" value="{{ $cpf }}" readonly disabled>
                                        <div class="form-text">Alteração de CPF só via administrador.</div>
                                    </div>
                                @endif
                                @if($birthDate)
                                    <div class="col-md-6">
                                        <label class="form-label text-muted small mb-1">Data de nascimento</label>
                                        <input type="text" class="form-control bg-light" value="{{ $birthDate->format('d/m/Y') }}" readonly disabled>
                                        <div class="form-text">Data de nascimento não pode ser alterada aqui.</div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            @endif

            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h2 class="h6 text-uppercase text-muted fw-bold mb-3 border-bottom pb-2">
                        <i class="fas fa-edit me-2 text-primary"></i>Atualizar informações
                    </h2>

                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label for="name" class="form-label fw-medium">Nome completo <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required autocomplete="name">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label fw-medium">E-mail <span class="text-danger">*</span></label>
                                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required autocomplete="email">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <h3 class="h6 text-muted fw-bold mb-3">
                            <i class="fas fa-key me-2"></i>Alterar senha <span class="fw-normal small">(opcional)</span>
                        </h3>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label for="password" class="form-label fw-medium">Nova senha</label>
                                <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" autocomplete="new-password" placeholder="Mínimo 8 caracteres" minlength="8">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Deixe em branco para manter a senha atual.</div>
                            </div>
                            <div class="col-md-6">
                                <label for="password_confirmation" class="form-label fw-medium">Confirmar nova senha</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" autocomplete="new-password" placeholder="Repita a nova senha">
                            </div>
                        </div>

                        @if(in_array($user->role, ['paciente', 'medico'], true))
                            <h3 class="h6 text-muted fw-bold mb-3">
                                <i class="fas fa-phone me-2"></i>Contato
                            </h3>
                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <label for="phone" class="form-label fw-medium">Telefone</label>
                                    <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $phone) }}" placeholder="(00) 00000-0000" autocomplete="tel">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Atualiza o telefone do seu cadastro {{ $user->role === 'paciente' ? 'de paciente' : 'profissional' }}.</div>
                                </div>
                            </div>
                        @else
                            <div class="alert alert-light border mb-4 small text-muted mb-0">
                                <i class="fas fa-info-circle me-2 text-primary"></i>
                                Conta de administrador: apenas nome, e-mail e senha são gerenciados aqui.
                            </div>
                        @endif

                        <div class="d-flex flex-wrap gap-2 justify-content-end pt-3 border-top">
                            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Salvar alterações
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
