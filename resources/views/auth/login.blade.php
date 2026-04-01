@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-md-8 col-lg-5">
        <div class="card shadow-sm">
            <div class="card-body p-4 p-md-5">
                <h1 class="h4 text-center mb-2">Sistema de Consultas Medicas</h1>
                <p class="text-center text-muted mb-4">Faca login para acessar o sistema</p>

                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                @error('email')
                    <div class="alert alert-danger" role="alert">
                        {{ $message }}
                    </div>
                @enderror

                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="mb-3">
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
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label">Senha</label>
                        <input
                            id="password"
                            name="password"
                            type="password"
                            class="form-control"
                            required
                        >
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Entrar</button>
                </form>

                <div class="text-center mt-3">
                    <a href="{{ route('password.request') }}">Esqueci minha senha</a>
                </div>

                <div class="text-center mt-4">
                    <a href="{{ route('register') }}">Nao tem uma conta? Cadastre-se</a>
                </div>

                <hr class="my-4">

                <div>
                    <h2 class="h6 mb-3">Credenciais de teste</h2>
                    <div class="small text-muted">
                        <div><strong>Admin:</strong> admin@clinica.com / password</div>
                        <div><strong>Medico:</strong> joao.silva@clinica.com / password</div>
                        <div><strong>Paciente:</strong> carlos@email.com / password</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection