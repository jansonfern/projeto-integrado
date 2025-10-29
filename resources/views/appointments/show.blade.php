@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Detalhes da Consulta</h4>
                    <div>
                        <a href="{{ route('appointments.index') }}" class="btn btn-secondary">Voltar</a>
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('appointments.edit', $appointment) }}" class="btn btn-primary">Editar</a>
                        @endif
                        @if($appointment->status === 'pendente' && auth()->user()->role === 'medico' && auth()->user()->doctor->id === $appointment->doctor_id)
                            <form action="{{ route('appointments.confirm', $appointment) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-success">Confirmar</button>
                            </form>
                        @endif
                        @if($appointment->status === 'confirmada')
                            <a href="{{ route('certificates.generate', $appointment) }}" class="btn btn-info">Gerar PDF</a>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Informações da Consulta</h5>
                            <p><strong>Data:</strong> {{ \Carbon\Carbon::parse($appointment->date)->format('d/m/Y') }}</p>
                            <p><strong>Horário:</strong> {{ $appointment->time }}</p>
                            <p><strong>Status:</strong> 
                                <span class="badge bg-{{ $appointment->status === 'confirmada' ? 'success' : ($appointment->status === 'cancelada' ? 'danger' : 'warning') }}">
                                    {{ ucfirst($appointment->status) }}
                                </span>
                            </p>
                            @if($appointment->notes)
                                <p><strong>Observações:</strong> {{ $appointment->notes }}</p>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <h5>Paciente</h5>
                            <p><strong>Nome:</strong> {{ $appointment->patient->user->name }}</p>
                            <p><strong>CPF:</strong> {{ $appointment->patient->cpf }}</p>
                            <p><strong>Telefone:</strong> {{ $appointment->patient->phone }}</p>
                            
                            <h5 class="mt-3">Médico</h5>
                            <p><strong>Nome:</strong> {{ $appointment->doctor->user->name }}</p>
                            <p><strong>CRM:</strong> {{ $appointment->doctor->crm }}</p>
                            <p><strong>Especialidade:</strong> {{ $appointment->doctor->specialty }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 