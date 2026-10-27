<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens; // <--- 1. IMPORTAR ESTO

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable; // <--- 2. AGREGAR HasApiTokens AQUÍ

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relaciones del taller
    public function citasComoPaciente()
    {
        return $this->hasMany(Cita::class, 'patient_id');
    }

    public function citasComoDoctor()
    {
        return $this->hasMany(Cita::class, 'doctor_id');
    }
}