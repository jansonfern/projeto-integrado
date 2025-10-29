<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sistema Médico</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Dashboard - Sistema de Consultas Médicas</h1>
            <div class="flex items-center space-x-4">
                <span class="text-gray-600">Olá, {{ Auth::user()->name }}!</span>
                <a href="{{ route('profile.edit') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">Meus Dados</a>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">
                        Sair
                    </button>
                </form>
            </div>
        </div>
        
        <!-- Estatísticas Gerais (totais separados para médico) -->
        @if(auth()->user()->role === 'medico')
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-700">Consultas Realizadas</h3>
                <p class="text-3xl font-bold text-green-600">{{ $confirmedAppointments }}</p>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-700">Pendentes</h3>
                <p class="text-3xl font-bold text-yellow-600">{{ $pendingAppointments }}</p>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-700">Canceladas</h3>
                <p class="text-3xl font-bold text-red-600">{{ $cancelledAppointments }}</p>
            </div>
        </div>
        @endif

        <!-- Links de Navegação -->
        <div class="bg-white rounded-lg shadow p-6 mb-8">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Navegação</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('patients.index') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded text-center">
                        Gerenciar Pacientes
                    </a>
                    <a href="{{ route('doctors.index') }}" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded text-center">
                        Gerenciar Médicos
                    </a>
                @endif
                
                @if(auth()->user()->role === 'medico')
                    <a href="{{ route('my-schedules') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded text-center">
                        Minha Agenda
                    </a>
                @endif
                
                @if(auth()->user()->role === 'paciente')
                    <a href="{{ route('appointments.index') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded text-center">
                        Minhas Consultas
                    </a>
                    <a href="{{ route('appointments.available') }}" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded text-center">
                        Agendar Nova Consulta
                    </a>
                @endif
                
                @if(auth()->user()->role === 'admin' || auth()->user()->role === 'medico')
                    <a href="{{ route('appointments.index') }}" class="bg-purple-500 hover:bg-purple-600 text-white font-bold py-2 px-4 rounded text-center">
                        Ver Todas as Consultas
                    </a>
                @endif
            </div>
        </div>

        <!-- Consultas por Especialidade -->
        @if((auth()->user()->role === 'admin' || auth()->user()->role === 'medico') && $specialtyLabels->count() > 0)
        <div class="bg-white rounded-lg shadow p-6 mb-8">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Consultas por Especialidade</h2>
            <div class="space-y-2">
                @foreach($specialtyLabels as $index => $specialty)
                <div class="flex justify-between items-center">
                    <span class="font-medium">{{ $specialty }}</span>
                    <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded">{{ $specialtyValues[$index] }}</span>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Consultas do Paciente -->
        {{-- Bloco removido conforme solicitado --}}

        <!-- Consultas por Mês (todas) -->
        @if(auth()->user()->role === 'medico' && isset($monthLabels) && $monthLabels->count() > 0)
        <div class="bg-white rounded-lg shadow p-6 mb-8">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Consultas por Mês (todas)</h2>
            <div class="space-y-2">
                @foreach($monthLabels as $index => $month)
                <div class="flex justify-between items-center">
                    <span class="font-medium">{{ $month }}</span>
                    <span class="bg-green-100 text-green-800 px-2 py-1 rounded">{{ $monthValues[$index] }}</span>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Consultas Confirmadas por Mês -->
        @if(auth()->user()->role === 'medico' && isset($confirmedMonthLabels) && $confirmedMonthLabels->count() > 0)
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Consultas Confirmadas por Mês</h2>
            <div class="space-y-2">
                @foreach($confirmedMonthLabels as $index => $month)
                <div class="flex justify-between items-center">
                    <span class="font-medium">{{ $month }}</span>
                    <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded">{{ $confirmedMonthValues[$index] }}</span>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Gráficos por mês para médico -->
        @if(auth()->user()->role === 'medico')
        <div class="bg-white rounded-lg shadow p-6 mb-8">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Consultas Realizadas por Mês</h2>
            <div class="space-y-2">
                @foreach($months as $index => $month)
                <div class="flex justify-between items-center">
                    <span class="font-medium">{{ $month }}</span>
                    <span class="bg-green-100 text-green-800 px-2 py-1 rounded">{{ $confirmedPerMonth[$index] }}</span>
                </div>
                @endforeach
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6 mb-8">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Consultas Pendentes por Mês</h2>
            <div class="space-y-2">
                @foreach($months as $index => $month)
                <div class="flex justify-between items-center">
                    <span class="font-medium">{{ $month }}</span>
                    <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded">{{ $pendingPerMonth[$index] }}</span>
                </div>
                @endforeach
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Consultas Canceladas por Mês</h2>
            <div class="space-y-2">
                @foreach($months as $index => $month)
                <div class="flex justify-between items-center">
                    <span class="font-medium">{{ $month }}</span>
                    <span class="bg-red-100 text-red-800 px-2 py-1 rounded">{{ $cancelledPerMonth[$index] }}</span>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</body>
</html> 