<?php

namespace Tests\Feature;

use App\Mail\NuevaCitaNotificacion;
use App\Models\Cita;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CitaTest extends TestCase
{
    use RefreshDatabase;

    public function test_muestra_citas_confirmadas(): void
    {
        Cita::factory()->count(3)->create(['estado' => 'confirmada']);
        Cita::factory()->count(2)->create(['estado' => 'pendiente']);
        Cita::factory()->count(2)->create(['estado' => 'cancelada']);

        $response = $this->getJson('/api/citas?estado=confirmada');

        $response->assertStatus(200);
        $response->assertJsonCount(3);
        
        $citas = $response->json();
        foreach ($citas as $cita) {
            $this->assertEquals('confirmada', $cita['estado']);
        }
    }

    /**
     * Prueba 2: Acción Autenticada, Persistencia y Envío de Correo
     * Paciente autenticado agenda cita, se persiste en BD y notifica al médico por email.
     */
    public function test_agendar_cita_y_envio_correo(): void
    {
        Mail::fake();

        $paciente = User::factory()->create();
        $doctor = User::factory()->create();

        Sanctum::actingAs($paciente);

        $payload = [
            'doctor_id' => $doctor->id,
            'especialidad' => 'Cardiología',
            'fecha_hora' => '2026-12-01 10:00:00',
            'motivo' => 'Control de arritmia cardíaca',
        ];

        $response = $this->postJson('/api/citas', $payload);

        $response->assertStatus(201);

        $this->assertDatabaseHas('citas', [
            'patient_id' => $paciente->id,
            'doctor_id' => $doctor->id,
            'especialidad' => 'Cardiología',
            'motivo' => 'Control de arritmia cardíaca',
        ]);

        Mail::assertSent(NuevaCitaNotificacion::class, function ($mail) use ($doctor) {
            return $mail->hasTo($doctor->email);
        });
    }

    /**
     * Prueba 3: Diagnóstico y Prevención del Problema N+1
     * Comprueba que la carga ansiosa (eager loading) limite las consultas SQL.
     */
    public function test_detecta_problema_n_mas_1(): void
    {
        Cita::factory()->count(10)->create();

        DB::enableQueryLog();

        $response = $this->getJson('/api/citas');

        $response->assertStatus(200);

        $queries = DB::getQueryLog();


        $this->assertLessThanOrEqual(3, count($queries), 'Se detectó un problema de consulta N+1 al cargar las relaciones.');
    }
}