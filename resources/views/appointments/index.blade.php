@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('dashboard') }}" class="btn btn-secondary">
            ← Voltar ao Dashboard
        </a>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Consultas</h4>
                    @if(auth()->user()->role === 'paciente')
                        <a href="{{ route('appointments.available') }}" class="btn btn-success">
                            <i class="fas fa-calendar-check"></i> Ver Horários Disponíveis
                        </a>
                    @endif
                </div>

                <div class="card-body">
                    @if($appointments->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Paciente</th>
                                        <th>Médico</th>
                                        <th>Data</th>
                                        <th>Hora</th>
                                        <th>Status</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($appointments as $appointment)
                                    <tr>
                                        <td>{{ $appointment->patient->user->name }}</td>
                                        <td>
                                            {{ $appointment->doctor->user->name }}
                                            <br><small class="text-muted">{{ $appointment->doctor->specialty }}</small>
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($appointment->date)->format('d/m/Y') }}</td>
                                        <td>{{ $appointment->time }}</td>
                                        <td>
                                            @if($appointment->status === 'pendente')
                                                <span class="badge bg-warning">Pendente</span>
                                            @elseif($appointment->status === 'confirmada')
                                                <span class="badge bg-success">Confirmada</span>
                                            @else
                                                <span class="badge bg-danger">Cancelada</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('appointments.show', $appointment) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i> Ver
                                            </a>
                                            
                                            @if($appointment->status === 'pendente')
                                                @if(auth()->user()->role === 'medico' && auth()->user()->doctor->id === $appointment->doctor_id)
                                                    <form action="{{ route('appointments.confirm', $appointment) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-success">
                                                            <i class="fas fa-check"></i> Confirmar
                                                        </button>
                                                    </form>
                                                @endif
                                            @endif
                                            
                                            @if($appointment->status !== 'cancelada')
                                                <form action="{{ route('appointments.cancel', $appointment) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza?')">
                                                        <i class="fas fa-times"></i> Cancelar
                                                    </button>
                                                </form>
                                            @endif
                                            
                                            @if($appointment->status === 'confirmada')
                                                <a href="{{ route('certificates.generate', $appointment) }}" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-file-pdf"></i> PDF
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info">
                            Nenhuma consulta encontrada.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 