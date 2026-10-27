<?php

namespace Database\Seeders;

use App\Models\Cita;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Crear usuarios iniciales
        $pacientes = User::factory(5)->create();
        $doctores = User::factory(3)->create();

        // Generar citas de prueba combinando estados
        foreach ($pacientes as $paciente) {
            Cita::factory()->create([
                'patient_id' => $paciente->id,
                'doctor_id' => $doctores->random()->id,
                'estado' => 'confirmada',
            ]);

            Cita::factory()->create([
                'patient_id' => $paciente->id,
                'doctor_id' => $doctores->random()->id,
                'estado' => 'pendiente',
            ]);
        }
    }
}