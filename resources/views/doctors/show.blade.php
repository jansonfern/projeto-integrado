@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Detalhes do Médico</h4>
                    <div>
                        <a href="{{ route('doctors.index') }}" class="btn btn-secondary">Voltar</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Informações Pessoais</h5>
                            <p><strong>Nome:</strong> {{ $doctor->user->name }}</p>
                            <p><strong>Email:</strong> {{ $doctor->user->email }}</p>
                            <p><strong>CRM:</strong> {{ $doctor->crm }}</p>
                            <p><strong>Especialidade:</strong> {{ $doctor->specialty }}</p>
                        </div>
                        <div class="col-md-6">
                            <h5>Estatísticas</h5>
                            <p><strong>Total de Consultas:</strong> {{ $doctor->appointments->count() }}</p>
                            <p><strong>Horários Disponíveis:</strong> {{ $doctor->schedules->where('is_available', true)->count() }}</p>
                        </div>
                    </div>
                    
                    @if($doctor->appointments->count() > 0)
                        <div class="mt-4">
                            <h5>Últimas Consultas</h5>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Data</th>
                                            <th>Horário</th>
                                            <th>Paciente</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($doctor->appointments->take(5) as $appointment)
                                            <tr>
                                                <td>{{ \Carbon\Carbon::parse($appointment->date)->format('d/m/Y') }}</td>
                                                <td>{{ $appointment->time }}</td>
                                                <td>{{ $appointment->patient->user->name }}</td>
                                                <td>
                                                    <span class="badge bg-{{ $appointment->status === 'confirmada' ? 'success' : ($appointment->status === 'cancelada' ? 'danger' : 'warning') }}">
                                                        {{ ucfirst($appointment->status) }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 