@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>
                        @if(auth()->user()->role === 'admin')
                            Gerenciar Agendas
                        @else
                            Minha Agenda
                        @endif
                    </h4>
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('schedules.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                            <i class="fas fa-plus"></i> Adicionar Horário
                        </a>
                    @endif
                </div>
                <div class="card-body">
                    @if($schedules->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Data</th>
                                        <th>Horário</th>
                                        <th>Médico</th>
                                        <th>Status</th>
                                        @if(auth()->user()->role === 'admin')
                                            <th>Ações</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($schedules as $schedule)
                                        <tr>
                                            <td>{{ \Carbon\Carbon::parse($schedule->date)->format('d/m/Y') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($schedule->available_time)->format('H:i') }}</td>
                                            <td>{{ $schedule->doctor->user->name }} - {{ $schedule->doctor->specialty }}</td>
                                            <td>
                                                @if($schedule->is_available)
                                                    <span class="badge bg-success" style="background-color: #22c55e; color: white;">Disponível</span>
                                                @else
                                                    <span class="badge bg-danger" style="background-color: #ef4444; color: white;">Ocupado</span>
                                                @endif
                                            </td>
                                            @if(auth()->user()->role === 'admin')
                                                <td>
                                                    <a href="{{ route('schedules.edit', $schedule) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded">
                                                        <i class="fas fa-edit"></i> Editar
                                                    </a>
                                                    <form action="{{ route('schedules.destroy', $schedule) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza?')">
                                                            <i class="fas fa-trash"></i> Excluir
                                                        </button>
                                                    </form>
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info">
                            @if(auth()->user()->role === 'admin')
                                Nenhum horário cadastrado ainda.
                            @else
                                Nenhum horário disponível na sua agenda.
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 