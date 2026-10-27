<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\User;
use App\Mail\NuevaCitaNotificacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CitaController extends Controller
{
    public function index()
    {
        // Se utiliza with() para prevenir N+1
        $citas = Cita::with(['patient', 'doctor'])->latest()->get();
        return view('citas.index', compact('citas'));
    }

    public function create()
    {
        $usuarios = User::all();
        return view('citas.create', compact('usuarios'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:users,id',
            'doctor_id' => 'required|exists:users,id',
            'especialidad' => 'required|string|max:255',
            'fecha_hora' => 'required|date',
            'motivo' => 'required|string',
        ]);

        $cita = Cita::create($validated);

        // Envío de correo al médico asignado
        Mail::to($cita->doctor->email)->send(new NuevaCitaNotificacion($cita));

        return redirect()->route('citas.index')->with('success', 'Cita médica agendada exitosamente.');
    }
}