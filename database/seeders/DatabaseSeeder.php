<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Schedule;
use App\Models\Appointment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Criar usuário admin
        $admin = User::create([
            'name' => 'Administrador',
            'email' => 'admin@clinica.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Criar médicos
        $doctor1 = User::create([
            'name' => 'Dr. João Silva',
            'email' => 'joao.silva@clinica.com',
            'password' => Hash::make('password'),
            'role' => 'medico',
        ]);

        $doctor2 = User::create([
            'name' => 'Dra. Maria Santos',
            'email' => 'maria.santos@clinica.com',
            'password' => Hash::make('password'),
            'role' => 'medico',
        ]);

        Doctor::create([
            'user_id' => $doctor1->id,
            'crm' => '12345-SP',
            'specialty' => 'Cardiologia',
        ]);

        Doctor::create([
            'user_id' => $doctor2->id,
            'crm' => '67890-SP',
            'specialty' => 'Dermatologia',
        ]);

        // Criar pacientes
        $patient1 = User::create([
            'name' => 'Carlos Oliveira',
            'email' => 'carlos@email.com',
            'password' => Hash::make('password'),
            'role' => 'paciente',
        ]);

        $patient2 = User::create([
            'name' => 'Ana Costa',
            'email' => 'ana@email.com',
            'password' => Hash::make('password'),
            'role' => 'paciente',
        ]);

        Patient::create([
            'user_id' => $patient1->id,
            'cpf' => '123.456.789-00',
            'birth_date' => '1985-05-15',
            'phone' => '(11) 99999-1111',
            'cep' => '01234-567',
            'street' => 'Rua das Flores, 123',
            'city' => 'São Paulo',
            'state' => 'SP',
        ]);

        Patient::create([
            'user_id' => $patient2->id,
            'cpf' => '987.654.321-00',
            'birth_date' => '1990-08-20',
            'phone' => '(11) 88888-2222',
            'cep' => '04567-890',
            'street' => 'Av. Paulista, 456',
            'city' => 'São Paulo',
            'state' => 'SP',
        ]);

        // Criar horários disponíveis
        $doctors = Doctor::all();
        foreach ($doctors as $doctor) {
            for ($i = 1; $i <= 7; $i++) {
                $date = now()->addDays($i);
                Schedule::create([
                    'doctor_id' => $doctor->id,
                    'date' => $date->format('Y-m-d'),
                    'available_time' => '09:00',
                    'is_available' => true,
                ]);
                Schedule::create([
                    'doctor_id' => $doctor->id,
                    'date' => $date->format('Y-m-d'),
                    'available_time' => '10:00',
                    'is_available' => true,
                ]);
                Schedule::create([
                    'doctor_id' => $doctor->id,
                    'date' => $date->format('Y-m-d'),
                    'available_time' => '14:00',
                    'is_available' => true,
                ]);
            }
        }

        // Criar algumas consultas de exemplo
        $patients = Patient::all();
        $doctors = Doctor::all();
        
        if ($patients->count() > 0 && $doctors->count() > 0) {
            Appointment::create([
                'patient_id' => $patients->first()->id,
                'doctor_id' => $doctors->first()->id,
                'date' => now()->addDays(2),
                'time' => '09:00',
                'status' => 'pendente',
                'notes' => 'Primeira consulta',
            ]);

            Appointment::create([
                'patient_id' => $patients->last()->id,
                'doctor_id' => $doctors->last()->id,
                'date' => now()->addDays(3),
                'time' => '14:00',
                'status' => 'confirmada',
                'notes' => 'Consulta de rotina',
            ]);
        }
    }
}
