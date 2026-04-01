@extends('layouts.app')

@section('content')
<div class="animate-fade-in-up">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-xl-7">
            <div class="d-flex align-items-center gap-3 mb-4">
                <a href="{{ route('doctors.index') }}" class="btn btn-outline-secondary btn-sm rounded-circle" style="width: 40px; height: 40px; padding: 0; display: inline-flex; align-items: center; justify-content: center;" title="Voltar">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div>
                    <h1 class="h3 fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                        <i class="fas fa-user-md text-primary"></i>
                        Novo médico
                    </h1>
                    <p class="text-muted small mb-0 mt-1">Crie o usuário e o registro profissional (CRM e especialidade).</p>
                </div>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    @if ($errors->any())
                        <div class="alert alert-danger border-0 mb-4">
                            <div class="fw-semibold mb-2"><i class="fas fa-exclamation-circle me-2"></i>Corrija os campos abaixo</div>
                            <ul class="mb-0 small ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('doctors.store') }}" method="POST">
                        @csrf

                        <h2 class="h6 text-uppercase text-muted fw-bold mb-3 border-bottom pb-2">
                            <i class="fas fa-user me-2 text-primary"></i>Dados pessoais e acesso
                        </h2>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-medium">Nome completo <span class="text-danger">*</span></label>
                                <input type="text" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" required placeholder="Ex.: Dr. João Silva">
                                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-medium">E-mail <span class="text-danger">*</span></label>
                                <input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" required placeholder="nome@clinica.com">
                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-medium">Senha <span class="text-danger">*</span></label>
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required minlength="8" placeholder="Mínimo 8 caracteres">
                                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-medium">Confirmar senha <span class="text-danger">*</span></label>
                                <input type="password" name="password_confirmation" class="form-control" required placeholder="Repita a senha">
                            </div>
                        </div>

                        <h2 class="h6 text-uppercase text-muted fw-bold mb-3 border-bottom pb-2">
                            <i class="fas fa-stethoscope me-2 text-primary"></i>Registro profissional
                        </h2>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-medium">CRM <span class="text-danger">*</span></label>
                                <input type="text" name="crm" value="{{ old('crm') }}" class="form-control @error('crm') is-invalid @enderror" required placeholder="Ex.: 12345-SP">
                                @error('crm')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-medium">Especialidade <span class="text-danger">*</span></label>
                                <input type="text" name="specialty" value="{{ old('specialty') }}" class="form-control @error('specialty') is-invalid @enderror" required placeholder="Ex.: Clínica geral">
                                @error('specialty')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="d-flex flex-wrap gap-2 justify-content-end pt-2 border-top">
                            <a href="{{ route('doctors.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-check me-2"></i>Salvar médico
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
