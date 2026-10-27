<?php

namespace Database\Factories;

use App\Models\Cita;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CitaFactory extends Factory
{
    protected $model = Cita::class;

    public function definition(): array
    {
        return [
            'patient_id' => User::factory(),
            'doctor_id' => User::factory(),
            'especialidad' => fake()->randomElement(['Cardiología', 'Pediatría', 'Medicina General', 'Dermatología']),
            'fecha_hora' => fake()->dateTimeBetween('+1 days', '+1 month'),
            'estado' => 'pendiente',
            'motivo' => fake()->sentence(),
        ];
    }
}