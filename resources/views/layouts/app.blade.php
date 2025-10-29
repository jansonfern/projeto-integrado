<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Gestão Médica</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                <i class="fas fa-hospital"></i> Clínica Médica
            </a>
            
            @auth
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('dashboard') }}">
                                <i class="fas fa-tachometer-alt"></i> Dashboard
                            </a>
                        </li>
                        
                        <!-- DEBUG: Role atual: {{ auth()->user()->role }} -->
                        @if(auth()->user()->role === 'admin')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('patients.index') }}">
                                    <i class="fas fa-users"></i> Pacientes
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('doctors.index') }}">
                                    <i class="fas fa-user-md"></i> Médicos
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('schedules.index') }}">
                                    <i class="fas fa-calendar"></i> Agendas
                                </a>
                            </li>
                        @endif
                        
                        @if(auth()->user()->role === 'medico')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('my-schedules') }}">
                                    <i class="fas fa-calendar-check"></i> Minha Agenda
                                </a>
                            </li>
                        @endif
                        
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('appointments.index') }}">
                                <i class="fas fa-stethoscope"></i> 
                                @if(auth()->user()->role === 'paciente')
                                    Minhas Consultas
                                @else
                                    Consultas
                                @endif
                            </a>
                        </li>
                    </ul>
                    
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user"></i> {{ auth()->user()->name }}
                            </a>
                            <ul class="dropdown-menu">
                                <li><span class="dropdown-item-text text-muted">{{ ucfirst(auth()->user()->role) }}</span></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                        <i class="fas fa-user-cog"></i> Meus Dados
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="fas fa-sign-out-alt"></i> Sair
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            @endauth
        </div>
    </nav>

    <main class="py-4">
        @if(session('success'))
            <div class="container">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="container">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 