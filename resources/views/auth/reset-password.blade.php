@extends('layouts.app')

@section('title', 'Redefinir senha')

@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-md-8 col-lg-5">
        <div class="card shadow-sm">
            <div class="card-body p-4 p-md-5">
                <h1 class="h4 text-center mb-2">Nova senha</h1>
                <p class="text-center text-muted mb-4">Defina uma senha forte para sua conta.</p>

                <form action="{{ route('password.update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail</label>
                        <input
                            id="email"
                            name="email"
                            type="email"
                            value="{{ old('email', $email) }}"
                            class="form-control @error('email') is-invalid @enderror"
                            required
                            autofocus
                        >
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Nova senha</label>
                        <input
                            id="password"
                            name="password"
                            type="password"
                            class="form-control @error('password') is-invalid @enderror"
                            required
                        >
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label">Confirmar senha</label>
                        <input
                            id="password_confirmation"
                            name="password_confirmation"
                            type="password"
                            class="form-control"
                            required
                        >
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Redefinir senha</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
