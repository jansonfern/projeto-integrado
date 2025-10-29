@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Agendar Consulta</h4>
                    <a href="{{ route('appointments.index') }}" class="btn btn-secondary">Voltar</a>
                </div>
                <div class="card-body">
                    <form action="{{ route('appointments.store') }}" method="POST">
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
                                    <label for="time" class="form-label">Horário</label>
                                    <input type="time" class="form-control @error('time') is-invalid @enderror" 
                                           id="time" name="time" value="{{ old('time') }}" required>
                                    @error('time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="notes" class="form-label">Observações (opcional)</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" 
                                      id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Agendar Consulta</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Script para carregar horários disponíveis quando selecionar médico e data
document.getElementById('doctor_id').addEventListener('change', loadAvailableTimes);
document.getElementById('date').addEventListener('change', loadAvailableTimes);

function loadAvailableTimes() {
    const doctorId = document.getElementById('doctor_id').value;
    const date = document.getElementById('date').value;
    const timeSelect = document.getElementById('time');
    
    if (doctorId && date) {
        fetch(`/api/schedules/available-times?doctor_id=${doctorId}&date=${date}`)
            .then(response => response.json())
            .then(times => {
                timeSelect.innerHTML = '<option value="">Selecione um horário</option>';
                times.forEach(time => {
                    const option = document.createElement('option');
                    option.value = time;
                    option.textContent = time;
                    timeSelect.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Erro ao carregar horários:', error);
            });
    }
}
</script>
@endsection 