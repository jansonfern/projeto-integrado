@extends('layouts.app')

@section('content')
<div class="animate-fade-in-up">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-xl-7">
            <div class="d-flex align-items-center gap-3 mb-4">
                <a href="{{ route('doctors.show', $doctor) }}" class="btn btn-outline-secondary btn-sm rounded-circle" style="width: 40px; height: 40px; padding: 0; display: inline-flex; align-items: center; justify-content: center;" title="Voltar">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div>
                    <h1 class="h3 fw-bold text-dark mb-0"><i class="fas fa-user-md text-primary me-2"></i>Editar médico</h1>
                    <p class="text-muted small mb-0 mt-1">{{ $doctor->user->name }}</p>
                </div>
            </div>
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <form action="{{ route('doctors.update', $doctor) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nome</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name', $doctor->user->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           id="email" name="email" value="{{ old('email', $doctor->user->email) }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="crm" class="form-label">CRM</label>
                                    <input type="text" class="form-control @error('crm') is-invalid @enderror" 
                                           id="crm" name="crm" value="{{ old('crm', $doctor->crm) }}" required>
                                    @error('crm')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="specialty" class="form-label">Especialidade</label>
                                    <input type="text" class="form-control @error('specialty') is-invalid @enderror" 
                                           id="specialty" name="specialty" value="{{ old('specialty', $doctor->specialty) }}" required>
                                    @error('specialty')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label">Nova Senha (deixe em branco para manter a atual)</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   id="password" name="password">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-flex flex-wrap gap-2 justify-content-end pt-3 border-top mt-2">
                            <a href="{{ route('doctors.show', $doctor) }}" class="btn btn-outline-secondary">Cancelar</a>
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