@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Detalhes do Paciente</h4>
                    <div>
                        <a href="{{ route('patients.index') }}" class="btn btn-secondary">Voltar</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Informações Pessoais</h5>
                            <p><strong>Nome:</strong> {{ $patient->user->name }}</p>
                            <p><strong>Email:</strong> {{ $patient->user->email }}</p>
                            <p><strong>CPF:</strong> {{ $patient->cpf }}</p>
                            <p><strong>Data de Nascimento:</strong> {{ \Carbon\Carbon::parse($patient->birth_date)->format('d/m/Y') }}</p>
                            <p><strong>Telefone:</strong> {{ $patient->phone }}</p>
                        </div>
                        <div class="col-md-6">
                            <h5>Endereço</h5>
                            <p><strong>CEP:</strong> {{ $patient->cep }}</p>
                            <p><strong>Rua:</strong> {{ $patient->street }}</p>
                            <p><strong>Cidade:</strong> {{ $patient->city }}</p>
                            <p><strong>Estado:</strong> {{ $patient->state }}</p>
                        </div>
                    </div>
                    
                    @if($patient->appointments->count() > 0)
                        <div class="mt-4">
                            <h5>Histórico de Consultas</h5>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Data</th>
                                            <th>Horário</th>
                                            <th>Médico</th>
                                            <th>Especialidade</th>
                                            <th>Status</th>
                                            <th>Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($patient->appointments as $appointment)
                                            <tr>
                                                <td>{{ \Carbon\Carbon::parse($appointment->date)->format('d/m/Y') }}</td>
                                                <td>{{ $appointment->time }}</td>
                                                <td>{{ $appointment->doctor->user->name }}</td>
                                                <td>{{ $appointment->doctor->specialty }}</td>
                                                <td>
                                                    <span class="badge bg-{{ $appointment->status === 'confirmada' ? 'success' : ($appointment->status === 'cancelada' ? 'danger' : 'warning') }}">
                                                        {{ ucfirst($appointment->status) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="{{ route('appointments.show', $appointment) }}" class="btn btn-sm btn-info">Ver</a>
                                                    @if($appointment->status === 'confirmada')
                                                        <a href="{{ route('certificates.generate', $appointment) }}" class="btn btn-sm btn-success">PDF</a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @else
                        <div class="mt-4">
                            <div class="alert alert-info">
                                Este paciente ainda não possui consultas agendadas.
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 