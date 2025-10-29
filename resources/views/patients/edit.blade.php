@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Editar Paciente</h4>
                    <a href="{{ route('patients.show', $patient) }}" class="btn btn-secondary">Voltar</a>
                </div>
                <div class="card-body">
                    <form action="{{ route('patients.update', $patient) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nome</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name', $patient->user->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           id="email" name="email" value="{{ old('email', $patient->user->email) }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="cpf" class="form-label">CPF</label>
                                    <input type="text" class="form-control @error('cpf') is-invalid @enderror" 
                                           id="cpf" name="cpf" value="{{ old('cpf', $patient->cpf) }}" required>
                                    @error('cpf')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="birth_date" class="form-label">Data de Nascimento</label>
                                    <input type="date" class="form-control @error('birth_date') is-invalid @enderror" 
                                           id="birth_date" name="birth_date" value="{{ old('birth_date', $patient->birth_date) }}" required>
                                    @error('birth_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Telefone</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                           id="phone" name="phone" value="{{ old('phone', $patient->phone) }}" required>
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="cep" class="form-label">CEP</label>
                                    <input type="text" class="form-control @error('cep') is-invalid @enderror" 
                                           id="cep" name="cep" value="{{ old('cep', $patient->cep) }}" required>
                                    @error('cep')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="street" class="form-label">Rua</label>
                                    <input type="text" class="form-control @error('street') is-invalid @enderror" 
                                           id="street" name="street" value="{{ old('street', $patient->street) }}" required>
                                    @error('street')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label for="city" class="form-label">Cidade</label>
                                    <input type="text" class="form-control @error('city') is-invalid @enderror" 
                                           id="city" name="city" value="{{ old('city', $patient->city) }}" required>
                                    @error('city')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label for="state" class="form-label">Estado</label>
                                    <input type="text" class="form-control @error('state') is-invalid @enderror" 
                                           id="state" name="state" value="{{ old('state', $patient->state) }}" required>
                                    @error('state')
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
                        
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">Atualizar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 