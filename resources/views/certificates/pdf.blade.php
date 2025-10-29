<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificado de Consulta</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f8f9fa;
        }
        .certificate {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            border-bottom: 3px solid #007bff;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .title {
            color: #007bff;
            font-size: 28px;
            font-weight: bold;
            margin: 0;
        }
        .subtitle {
            color: #6c757d;
            font-size: 16px;
            margin: 5px 0 0 0;
        }
        .content {
            margin: 30px 0;
        }
        .section {
            margin: 20px 0;
        }
        .section-title {
            font-size: 18px;
            font-weight: bold;
            color: #495057;
            margin-bottom: 10px;
        }
        .info-row {
            display: flex;
            margin: 8px 0;
        }
        .label {
            font-weight: bold;
            width: 150px;
            color: #6c757d;
        }
        .value {
            flex: 1;
            color: #212529;
        }
        .footer {
            text-align: center;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #dee2e6;
            color: #6c757d;
        }
        .signature {
            margin-top: 30px;
            text-align: center;
        }
        .signature-line {
            width: 200px;
            border-top: 1px solid #000;
            margin: 10px auto;
        }
        @media print {
            body {
                background-color: white;
            }
            .certificate {
                box-shadow: none;
                border: 1px solid #dee2e6;
            }
        }
    </style>
</head>
<body>
    <div class="certificate">
        <div class="header">
            <h1 class="title">CERTIFICADO DE CONSULTA MÉDICA</h1>
            <p class="subtitle">Sistema de Gestão Médica</p>
        </div>
        
        <div class="content">
            <div class="section">
                <div class="section-title">Informações da Consulta</div>
                <div class="info-row">
                    <span class="label">Data:</span>
                    <span class="value">{{ \Carbon\Carbon::parse($appointment->date)->format('d/m/Y') }}</span>
                </div>
                <div class="info-row">
                    <span class="label">Horário:</span>
                    <span class="value">{{ \Carbon\Carbon::parse($appointment->time, 'UTC')->setTimezone('America/Sao_Paulo')->format('H:i') }}</span>
                </div>
                <div class="info-row">
                    <span class="label">Status:</span>
                    <span class="value">{{ ucfirst($appointment->status) }}</span>
                </div>
                @if($appointment->notes)
                <div class="info-row">
                    <span class="label">Observações:</span>
                    <span class="value">{{ $appointment->notes }}</span>
                </div>
                @endif
            </div>
            
            <div class="section">
                <div class="section-title">Dados do Paciente</div>
                <div class="info-row">
                    <span class="label">Nome:</span>
                    <span class="value">{{ $appointment->patient->user->name }}</span>
                </div>
                <div class="info-row">
                    <span class="label">CPF:</span>
                    <span class="value">{{ $appointment->patient->cpf }}</span>
                </div>
                <div class="info-row">
                    <span class="label">Data de Nascimento:</span>
                    <span class="value">{{ \Carbon\Carbon::parse($appointment->patient->birth_date)->format('d/m/Y') }}</span>
                </div>
                <div class="info-row">
                    <span class="label">Telefone:</span>
                    <span class="value">{{ $appointment->patient->phone }}</span>
                </div>
            </div>
            
            <div class="section">
                <div class="section-title">Dados do Médico</div>
                <div class="info-row">
                    <span class="label">Nome:</span>
                    <span class="value">{{ $appointment->doctor->user->name }}</span>
                </div>
                <div class="info-row">
                    <span class="label">CRM:</span>
                    <span class="value">{{ $appointment->doctor->crm }}</span>
                </div>
                <div class="info-row">
                    <span class="label">Especialidade:</span>
                    <span class="value">{{ $appointment->doctor->specialty }}</span>
                </div>
            </div>
        </div>
        
        <div class="signature">
            <div class="signature-line"></div>
            <p>{{ $appointment->doctor->user->name }}</p>
            <p>CRM: {{ $appointment->doctor->crm }}</p>
        </div>
        
        <div class="footer">
            <p>Este documento foi gerado automaticamente pelo Sistema de Gestão Médica</p>
            <p>Data de emissão: {{ now()->setTimezone('America/Sao_Paulo')->format('d/m/Y H:i:s') }}</p>
        </div>
    </div>
    
    <script>
        // Auto-print quando a página carregar
        window.onload = function() {
            if (window.location.search.includes('print=1')) {
                window.print();
            }
        };
    </script>
</body>
</html> 