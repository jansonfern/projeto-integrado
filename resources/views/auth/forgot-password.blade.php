@extends('layouts.app')

@section('title', 'Recuperar senha')

@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-md-8 col-lg-5">
        <div class="card shadow-sm">
            <div class="card-body p-4 p-md-5">
                <h1 class="h4 text-center mb-2">Recuperar acesso</h1>
                <p class="text-center text-muted mb-4">Informe seu e-mail para receber o link de redefinicao.</p>

                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <form action="{{ route('password.email') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="email" class="form-label">E-mail</label>
                        <input
                            id="email"
                            name="email"
                            type="email"
                            value="{{ old('email') }}"
                            class="form-control @error('email') is-invalid @enderror"
                            required
                            autofocus
                        >
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Enviar link de redefinicao</button>
                </form>

                <div class="text-center mt-4">
                    <a href="{{ route('login') }}">Voltar para o login</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
