@extends('layouts.app')

@section('content')
<div class="container max-w-lg mx-auto mt-8">
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-2xl font-semibold mb-4">Meus Dados</h2>
        
        <!-- Dados específicos do tipo de usuário -->
        @if($user->role === 'medico' && $crm)
            <div class="mb-3">
                <label for="crm" class="form-label">CRM</label>
                <input type="text" name="crm" id="crm" class="form-control" value="{{ $crm }}" readonly>
                <small class="form-text text-muted">CRM não pode ser alterado</small>
            </div>
        @endif
        
        @if($user->role === 'paciente')
            @if($cpf)
                <div class="mb-3">
                    <label for="cpf" class="form-label">CPF</label>
                    <input type="text" name="cpf" id="cpf" class="form-control" value="{{ $cpf }}" readonly>
                    <small class="form-text text-muted">CPF não pode ser alterado</small>
                </div>
            @endif
            
            @if($birthDate)
                <div class="mb-3">
                    <label for="birth_date" class="form-label">Data de Nascimento</label>
                    <input type="text" name="birth_date" id="birth_date" class="form-control" value="{{ $birthDate->format('d/m/Y') }}" readonly>
                    <small class="form-text text-muted">Data de nascimento não pode ser alterada</small>
                </div>
            @endif
        @endif
        
        <form action="{{ route('profile.update') }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name" class="form-label">Nome</label>
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">E-mail</label>
                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Nova Senha</label>
                <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror">
                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirmar Nova Senha</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Telefone</label>
                <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $phone) }}">
                @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
        </form>
    </div>
</div>
@endsection 