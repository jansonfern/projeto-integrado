<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório do Sistema</title>
    <style nonce="{{ $cspNonce ?? '' }}">
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #ffffff;
            color: #212529;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 30px;
            border: 1px solid #dee2e6;
            border-radius: 10px;
        }
        .header {
            text-align: center;
            border-bottom: 3px solid #007bff;
            padding-bottom: 16px;
            margin-bottom: 24px;
        }
        .title {
            margin: 0;
            color: #007bff;
            font-size: 24px;
            font-weight: bold;
        }
        .subtitle {
            margin: 6px 0 0 0;
            color: #6c757d;
            font-size: 14px;
        }
        .section-title {
            margin: 18px 0 10px 0;
            font-size: 16px;
            font-weight: bold;
            color: #495057;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }
        th, td {
            text-align: left;
            padding: 10px;
            border-bottom: 1px solid #dee2e6;
        }
        th {
            background: #f8f9fa;
            color: #495057;
        }
        .footer {
            margin-top: 24px;
            padding-top: 12px;
            border-top: 1px solid #dee2e6;
            font-size: 12px;
            color: #6c757d;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 class="title">RELATÓRIO DO SISTEMA DE GESTÃO MÉDICA</h1>
            <p class="subtitle">Gerado em: {{ $generatedAt->format('d/m/Y H:i:s') }} (America/Sao_Paulo)</p>
        </div>

        <div class="section-title">Resumo</div>
        <table>
            <thead>
                <tr>
                    <th>Métrica</th>
                    <th>Valor</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Total de pacientes</td>
                    <td>{{ $totals['patients'] }}</td>
                </tr>
                <tr>
                    <td>Total de médicos</td>
                    <td>{{ $totals['doctors'] }}</td>
                </tr>
                <tr>
                    <td>Total de consultas</td>
                    <td>{{ $totals['appointments'] }}</td>
                </tr>
                <tr>
                    <td>Consultas pendentes</td>
                    <td>{{ $totals['appointments_pending'] }}</td>
                </tr>
                <tr>
                    <td>Consultas confirmadas</td>
                    <td>{{ $totals['appointments_confirmed'] }}</td>
                </tr>
                <tr>
                    <td>Consultas canceladas</td>
                    <td>{{ $totals['appointments_cancelled'] }}</td>
                </tr>
            </tbody>
        </table>

        <div class="footer">
            Documento gerado automaticamente pelo Sistema de Gestão Médica.
        </div>
    </div>
</body>
</html>

