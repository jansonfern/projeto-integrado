@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-4">Cadastro de Paciente</h1>
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('register') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700">Nome</label>
            <input type="text" name="name" class="border rounded w-full py-2 px-3" required value="{{ old('name') }}">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">E-mail</label>
            <input type="email" name="email" class="border rounded w-full py-2 px-3" required value="{{ old('email') }}">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Senha</label>
            <input type="password" name="password" class="border rounded w-full py-2 px-3" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Confirme a Senha</label>
            <input type="password" name="password_confirmation" class="border rounded w-full py-2 px-3" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">CPF</label>
            <input type="text" name="cpf" class="border rounded w-full py-2 px-3" required value="{{ old('cpf') }}">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Data de Nascimento</label>
            <input type="date" name="birth_date" class="border rounded w-full py-2 px-3" required value="{{ old('birth_date') }}">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Telefone</label>
            <input type="text" name="phone" class="border rounded w-full py-2 px-3" required value="{{ old('phone') }}">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">CEP</label>
            <input type="text" id="cep" name="cep" class="border rounded w-full py-2 px-3" value="{{ old('cep') }}">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Rua</label>
            <input type="text" id="street" name="street" class="border rounded w-full py-2 px-3" value="{{ old('street') }}">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Cidade</label>
            <input type="text" id="city" name="city" class="border rounded w-full py-2 px-3" value="{{ old('city') }}">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Estado</label>
            <input type="text" id="state" name="state" class="border rounded w-full py-2 px-3" maxlength="2" value="{{ old('state') }}">
        </div>
        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">Cadastrar</button>
    </form>
    <div class="mt-4">
        <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800">Já tem uma conta? Entrar</a>
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
            // evita travar o usuário: só limpa preenchimento automático
        }
    });
})();
</script>
@endsection 