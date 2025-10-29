@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Editar Consulta</h4>
                    <a href="{{ route('appointments.show', $appointment) }}" class="btn btn-secondary">Voltar</a>
                </div>
                <div class="card-body">
                    <form action="{{ route('appointments.update', $appointment) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Paciente</label>
                                    <div class="form-control bg-light">{{ $appointment->patient->user->name }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Médico</label>
                                    <div class="form-control bg-light">{{ $appointment->doctor->user->name }} - {{ $appointment->doctor->specialty }}</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Data</label>
                                    <div class="form-control bg-light">{{ \Carbon\Carbon::parse($appointment->date)->format('d/m/Y') }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Horário</label>
                                    <div class="form-control bg-light">{{ \Carbon\Carbon::parse($appointment->time)->format('H:i') }}</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                                        <option value="pendente" {{ old('status', $appointment->status) === 'pendente' ? 'selected' : '' }}>Pendente</option>
                                        <option value="confirmada" {{ old('status', $appointment->status) === 'confirmada' ? 'selected' : '' }}>Confirmada</option>
                                        <option value="cancelada" {{ old('status', $appointment->status) === 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="notes" class="form-label">Observações</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" 
                                      id="notes" name="notes" rows="3">{{ old('notes', $appointment->notes) }}</textarea>
                            @error('notes')
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