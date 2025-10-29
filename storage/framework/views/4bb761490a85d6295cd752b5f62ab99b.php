<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Documentação - Sistema de Gestão Médica</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 13px; color: #222; }
        h1, h2, h3 { color: #007bff; }
        h1 { font-size: 2em; margin-bottom: 0; }
        h2 { font-size: 1.3em; margin-top: 1.5em; }
        h3 { font-size: 1.1em; margin-top: 1.2em; }
        .section { margin-bottom: 1.5em; }
        .use-case, .entity, .relationship { background: #f8f9fa; border-left: 4px solid #007bff; padding: 10px 15px; margin: 10px 0; }
        .diagram { background: #fff; border: 1px solid #ccc; padding: 10px; margin: 15px 0; font-family: monospace; font-size: 11px; }
        ul, ol { margin: 0 0 0 20px; }
        .page-break { page-break-before: always; }
    </style>
</head>
<body>
    <h1>Sistema de Gestão Médica</h1>
    <p><strong>Documentação Completa</strong></p>
    <p>Desenvolvimento Web II - Prof. Luiz Efigênio<br>Data: <?php echo e(date('d/m/Y')); ?></p>

    <div class="section">
        <h2>1. Descrição do Projeto</h2>
        <p>O Sistema de Gestão Médica é uma aplicação web desenvolvida em Laravel para gerenciar pacientes, médicos, consultas, agendas, atestados, eventos e inscrições, com controle de acesso por perfil e integração com API de CEP.</p>
        <h3>Tecnologias Utilizadas</h3>
        <ul>
            <li>Laravel 12, PHP 8.2</li>
            <li>Blade, Tailwind CSS, Bootstrap 5</li>
            <li>SQLite</li>
            <li>DomPDF (emissão de PDF)</li>
            <li>ViaCEP (API de CEP)</li>
        </ul>
    </div>

    <div class="section page-break">
        <h2>2. Casos de Uso</h2>
        <div class="use-case">
            <strong>CU01 - Cadastro de Paciente</strong><br>
            <b>Atores:</b> Administrador, Paciente (autocadastro)<br>
            <b>Descrição:</b> Permite o cadastro de novos pacientes, valida CPF, integra com API de CEP, login automático.<br>
        </div>
        <div class="use-case">
            <strong>CU02 - Cadastro de Médico</strong><br>
            <b>Atores:</b> Administrador<br>
            <b>Descrição:</b> Admin cadastra médicos, define e-mail, CRM, especialidade, senha.<br>
        </div>
        <div class="use-case">
            <strong>CU03 - Agendamento de Consulta</strong><br>
            <b>Atores:</b> Paciente<br>
            <b>Descrição:</b> Paciente agenda consulta, sistema valida disponibilidade, bloqueia horário.<br>
        </div>
        <div class="use-case">
            <strong>CU04 - Gestão de Agenda</strong><br>
            <b>Atores:</b> Admin, Médico<br>
            <b>Descrição:</b> Cadastro de horários disponíveis, sem duplicidade.<br>
        </div>
        <div class="use-case">
            <strong>CU05 - Emissão de Atestado</strong><br>
            <b>Atores:</b> Médico<br>
            <b>Descrição:</b> Médico gera PDF de atestado para consulta confirmada.<br>
        </div>
        <div class="use-case">
            <strong>CU06 - Dashboard com Estatísticas</strong><br>
            <b>Atores:</b> Todos<br>
            <b>Descrição:</b> Exibe gráficos e estatísticas filtrados por perfil.<br>
        </div>
        <div class="use-case">
            <strong>CU07 - Edição de Perfil</strong><br>
            <b>Atores:</b> Todos<br>
            <b>Descrição:</b> Usuário edita dados pessoais, com restrições por perfil.<br>
        </div>
    </div>

    <div class="section page-break">
        <h2>3. Diagrama de Casos de Uso</h2>
        <div class="diagram">
            ┌─────────────┐    ┌─────────────┐    ┌─────────────┐<br>
            │ADMINISTRADOR│    │   MÉDICO    │    │   PACIENTE  │<br>
            └─────┬───────┘    └─────┬───────┘    └─────┬───────┘<br>
                  │                  │                  │<br>
                  │                  │                  │<br>
                  │                  │                  │<br>
                  │                  │                  │<br>
                  │                  │                  │<br>
            ◇ Cadastrar Médico       │                  │<br>
            ◇ Gerenciar Agenda       ◇ Ver Agenda       ◇ Agendar Consulta<br>
            ◇ Cadastrar Paciente     ◇ Confirmar Consulta◇ Ver Minhas Consultas<br>
            ◇ Ver Dashboard          ◇ Emitir Atestado   ◇ Editar Perfil<br>
            ◇ Editar Perfil          ◇ Editar Perfil     <br>
        </div>
    </div>

    <div class="section page-break">
        <h2>4. Modelagem de Dados</h2>
        <h3>Entidades</h3>
        <div class="entity"><b>users</b>: id, name, email, password, role, created_at, updated_at</div>
        <div class="entity"><b>patients</b>: id, user_id, cpf, birth_date, phone, cep, street, city, state, created_at, updated_at</div>
        <div class="entity"><b>doctors</b>: id, user_id, crm, specialty, created_at, updated_at</div>
        <div class="entity"><b>appointments</b>: id, patient_id, doctor_id, date, time, status, notes, created_at, updated_at</div>
        <div class="entity"><b>schedules</b>: id, doctor_id, date, available_time, is_available, created_at, updated_at</div>
        <div class="entity"><b>certificates</b>: id, appointment_id, pdf_path, created_at, updated_at</div>
        <div class="entity"><b>events</b>: id, title, description, date, organizer_id, created_at, updated_at</div>
        <div class="entity"><b>addresses</b>: id, event_id, cep, street, city, state, created_at, updated_at</div>
        <div class="entity"><b>registrations</b>: id, user_id, event_id, status, created_at, updated_at</div>
        <h3>Relacionamentos</h3>
        <div class="relationship"><b>1:1</b>: users→patients, users→doctors, events→addresses</div>
        <div class="relationship"><b>1:N</b>: doctor→appointments, patient→appointments, doctor→schedules, event→registrations, appointment→certificate</div>
    </div>

    <div class="section page-break">
        <h2>5. Diagrama Entidade-Relacionamento (ER)</h2>
        <div class="diagram">
users 1---1 patients<br>
users 1---1 doctors<br>
doctors 1---N appointments N---1 patients<br>
doctors 1---N schedules<br>
appointments 1---1 certificates<br>
events 1---1 addresses<br>
events 1---N registrations N---1 users<br>
        </div>
    </div>

    <div class="section page-break">
        <h2>6. Funcionalidades Adicionais</h2>
        <ul>
            <li>Emissão de PDF de atestados (DomPDF)</li>
            <li>Dashboard com gráficos</li>
            <li>Integração com API de CEP (ViaCEP)</li>
            <li>Validações avançadas de formulário</li>
            <li>Controle de acesso por perfil (RBAC)</li>
        </ul>
    </div>

    <div class="section page-break">
        <h2>7. Observações Finais</h2>
        <ul>
            <li>O sistema está pronto para deploy e uso real em clínicas.</li>
            <li>O código segue boas práticas de Laravel e organização de projeto.</li>
            <li>Todos os requisitos do trabalho foram atendidos.</li>
        </ul>
        <p style="margin-top:2em;">Desenvolvido por: <b>Seu Nome</b></p>
    </div>
</body>
</html> <?php /**PATH C:\xampp\htdocs\webll\resources\views/documentation/pdf.blade.php ENDPATH**/ ?>