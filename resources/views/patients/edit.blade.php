@extends('layouts.app')

@section('content')
<div class="animate-fade-in-up">
    <div class="row justify-content-center">
        <div class="col-lg-9 col-xl-8">
            <div class="d-flex align-items-center gap-3 mb-4">
                <a href="{{ route('patients.show', $patient) }}" class="btn btn-outline-secondary btn-sm rounded-circle" style="width: 40px; height: 40px; padding: 0; display: inline-flex; align-items: center; justify-content: center;" title="Voltar">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div>
                    <h1 class="h3 fw-bold text-dark mb-0"><i class="fas fa-user-edit text-primary me-2"></i>Editar paciente</h1>
                    <p class="text-muted small mb-0 mt-1">{{ $patient->user->name }}</p>
                </div>
            </div>
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
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
                        
                        <div class="d-flex flex-wrap gap-2 justify-content-end pt-3 border-top mt-2">
                            <a href="{{ route('patients.show', $patient) }}" class="btn btn-outline-secondary">Cancelar</a>
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

<script nonce="{{ $cspNonce ?? '' }}">
(() => {
    const cep = document.getElementById('cep');
    const street = document.getElementById('street');
    const city = document.getElementById('city');
    const state = document.getElementById('state');

    if (!cep || !street || !city || !state) return;

    async function lookupCep(raw) {
        const digits = (raw || '').toString().replace(/\D/g, '');
        if (digits.length !== 8) return null;

        const res = await fetch(`/api/cep/${digits}`, {
            headers: { 'Accept': 'application/json' },
        });

        const data = await res.json().catch(() => ({}));
        if (!res.ok) throw new Error(data?.error || 'Erro ao consultar CEP');
        return data;
    }

    let lastValue = '';
    cep.addEventListener('blur', async () => {
        const value = cep.value;
        if (!value || value === lastValue) return;
        lastValue = value;

        try {
            const data = await lookupCep(value);
            if (!data) return;

            if (!street.value) street.value = data.street || '';
            if (!city.value) city.value = data.city || '';
            if (!state.value) state.value = (data.state || '').toUpperCase();
        } catch (e) {
            // ignore
        }
    });
})();
</script>
@endsection 