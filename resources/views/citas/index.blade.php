@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Citas Médicas Agendadas</h2>
    <a href="{{ route('citas.create') }}" class="btn btn-success">+ Agendar Nueva Cita</a>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <table class="table table-striped table-hover mb-0">
            <thead class="table-primary">
                <tr>
                    <th>ID</th>
                    <th>Paciente</th>
                    <th>Médico</th>
                    <th>Especialidad</th>
                    <th>Fecha y Hora</th>
                    <th>Estado</th>
                    <th>Motivo</th>
                </tr>
            </thead>
            <tbody>
                @forelse($citas as $cita)
                    <tr>
                        <td>{{ $cita->id }}</td>
                        <td>{{ $cita->patient->name }}</td>
                        <td>{{ $cita->doctor->name }}</td>
                        <td>{{ $cita->especialidad }}</td>
                        <td>{{ $cita->fecha_hora->format('d/m/Y H:i') }}</td>
                        <td>
                            @if($cita->estado === 'confirmada')
                                <span class="badge bg-success">Confirmada</span>
                            @elseif($cita->estado === 'cancelada')
                                <span class="badge bg-danger">Cancelada</span>
                            @else
                                <span class="badge bg-warning text-dark">Pendiente</span>
                            @endif
                        </td>
                        <td>{{ $cita->motivo }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">No hay citas médicas registradas en el sistema.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection