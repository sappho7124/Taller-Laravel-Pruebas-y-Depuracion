<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nueva Cita</title>
</head>
<body>
    <h2>Estimado(a) Dr(a). {{ $cita->doctor->name }}</h2>
    <p>Se ha registrado una nueva cita médica con la siguiente información:</p>
    <ul>
        <li><strong>Paciente:</strong> {{ $cita->patient->name }}</li>
        <li><strong>Especialidad:</strong> {{ $cita->especialidad }}</li>
        <li><strong>Fecha y Hora:</strong> {{ $cita->fecha_hora }}</li>
        <li><strong>Motivo:</strong> {{ $cita->motivo }}</li>
    </ul>
</body>
</html>