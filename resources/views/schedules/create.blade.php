@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Adicionar Horário</h4>
                    <a href="{{ route('schedules.index') }}" class="btn btn-secondary">Voltar</a>
                </div>
                <div class="card-body">
                    <form action="{{ route('schedules.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="doctor_id" class="form-label">Médico</label>
                            <select class="form-control @error('doctor_id') is-invalid @enderror" id="doctor_id" name="doctor_id" required>
                                <option value="">Selecione um médico</option>
                                @foreach($doctors as $doctor)
                                    <option value="{{ $doctor->id }}" {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                                        {{ $doctor->user->name }} - {{ $doctor->specialty }}
                                    </option>
                                @endforeach
                            </select>
                            @error('doctor_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="date" class="form-label">Data</label>
                                    <input type="date" class="form-control @error('date') is-invalid @enderror" 
                                           id="date" name="date" value="{{ old('date') }}" required>
                                    @error('date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="available_time" class="form-label">Horário</label>
                                    <input type="time" class="form-control @error('available_time') is-invalid @enderror" 
                                           id="available_time" name="available_time" value="{{ old('available_time') }}" required>
                                    @error('available_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Cadastrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 