@extends('layouts.app')

@section('content')
<div class="animate-fade-in-up">
    <div class="row justify-content-center">
        <div class="col-lg-9 col-xl-8">
            <div class="d-flex align-items-center gap-3 mb-4">
                <a href="{{ route('patients.index') }}" class="btn btn-outline-secondary btn-sm rounded-circle" style="width: 40px; height: 40px; padding: 0; display: inline-flex; align-items: center; justify-content: center;" title="Voltar">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div>
                    <h1 class="h3 fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                        <i class="fas fa-user-plus text-primary"></i>
                        Novo paciente
                    </h1>
                    <p class="text-muted small mb-0 mt-1">Cadastro completo com endereço. O CEP pode preencher rua, cidade e UF ao sair do campo.</p>
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

                    <form action="{{ route('patients.store') }}" method="POST">
                        @csrf

                        <h2 class="h6 text-uppercase text-muted fw-bold mb-3 border-bottom pb-2">
                            <i class="fas fa-user me-2 text-primary"></i>Dados pessoais e acesso
                        </h2>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-medium">Nome completo <span class="text-danger">*</span></label>
                                <input type="text" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" required>
                                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-medium">E-mail <span class="text-danger">*</span></label>
                                <input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" required>
                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-medium">Senha <span class="text-danger">*</span></label>
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required minlength="8">
                                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-medium">Confirmar senha <span class="text-danger">*</span></label>
                                <input type="password" name="password_confirmation" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-medium">CPF <span class="text-danger">*</span></label>
                                <input type="text" name="cpf" value="{{ old('cpf') }}" class="form-control @error('cpf') is-invalid @enderror" required placeholder="000.000.000-00">
                                @error('cpf')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-medium">Data de nascimento <span class="text-danger">*</span></label>
                                <input type="date" name="birth_date" value="{{ old('birth_date') }}" class="form-control @error('birth_date') is-invalid @enderror" required>
                                @error('birth_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-medium">Telefone <span class="text-danger">*</span></label>
                                <input type="text" name="phone" value="{{ old('phone') }}" class="form-control @error('phone') is-invalid @enderror" required placeholder="(00) 00000-0000">
                                @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <h2 class="h6 text-uppercase text-muted fw-bold mb-3 border-bottom pb-2">
                            <i class="fas fa-map-marker-alt me-2 text-primary"></i>Endereço
                        </h2>
                        <div class="row g-3 mb-4">
                            <div class="col-md-3">
                                <label class="form-label fw-medium">CEP</label>
                                <input type="text" id="cep" name="cep" value="{{ old('cep') }}" class="form-control @error('cep') is-invalid @enderror" placeholder="00000-000" maxlength="9">
                                @error('cep')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                <div class="form-text">Perda de foco busca o endereço automaticamente.</div>
                            </div>
                            <div class="col-md-9">
                                <label class="form-label fw-medium">Rua</label>
                                <input type="text" id="street" name="street" value="{{ old('street') }}" class="form-control @error('street') is-invalid @enderror">
                                @error('street')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-8">
                                <label class="form-label fw-medium">Cidade</label>
                                <input type="text" id="city" name="city" value="{{ old('city') }}" class="form-control @error('city') is-invalid @enderror">
                                @error('city')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-medium">UF</label>
                                <input type="text" id="state" name="state" value="{{ old('state') }}" class="form-control @error('state') is-invalid @enderror" maxlength="2" placeholder="SP">
                                @error('state')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="d-flex flex-wrap gap-2 justify-content-end pt-2 border-top">
                            <a href="{{ route('patients.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-check me-2"></i>Salvar paciente
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

        const res = await fetch('/api/cep/' + digits, {
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
            /* silencioso: usuário pode preencher manualmente */
        }
    });
})();
</script>
@endsection
