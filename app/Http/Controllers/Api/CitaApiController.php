<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cita;
use App\Mail\NuevaCitaNotificacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CitaApiController extends Controller
{
    public function index(Request $request)
    {
        // Carga ansiosa para evitar N+1
        $query = Cita::with(['patient', 'doctor']);

        if ($request->has('estado')) {
            $query->where('estado', $request->input('estado'));
        }

        return response()->json($query->get(), 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'doctor_id' => 'required|exists:users,id',
            'especialidad' => 'required|string|max:255',
            'fecha_hora' => 'required|date',
            'motivo' => 'required|string',
        ]);

        // Se asigna el usuario autenticado como paciente
        $cita = Cita::create([
            'patient_id' => $request->user()->id,
            'doctor_id' => $validated['doctor_id'],
            'especialidad' => $validated['especialidad'],
            'fecha_hora' => $validated['fecha_hora'],
            'motivo' => $validated['motivo'],
            'estado' => 'pendiente',
        ]);

        // Notificación al médico
        Mail::to($cita->doctor->email)->send(new NuevaCitaNotificacion($cita));

        return response()->json([
            'message' => 'Cita creada exitosamente',
            'cita' => $cita->load(['patient', 'doctor'])
        ], 201);
    }
}