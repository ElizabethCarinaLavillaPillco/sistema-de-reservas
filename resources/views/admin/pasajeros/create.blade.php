@extends('layouts.template')

@section('content')
<h1 class="mt-4">Registrar Nuevo Pasajero</h1>

<form action="{{ route('admin.pasajeros.store') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label for="reserva_id">Reserva Asociada:</label>
        <select name="reserva_id" class="form-control" required>
            <option value="">-- Seleccionar reserva --</option>
            @foreach ($reservas as $reserva)
                <option value="{{ $reserva->id }}">{{ $reserva->id }} - {{ $reserva->titular->nombre }} {{ $reserva->titular->apellido }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="documento">Documento:</label>
        <input type="text" name="documento" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="apellido">Apellido:</label>
        <input type="text" name="apellido" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="pais_nacimiento">País de Nacimiento:</label>
        <input type="text" name="pais_nacimiento" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="pais_residencia">País de Residencia:</label>
        <input type="text" name="pais_residencia" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="ciudad">Ciudad:</label>
        <input type="text" name="ciudad" class="form-control">
    </div>

    <div class="mb-3">
        <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
        <input type="date" name="fecha_nacimiento" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="tarifa">Tarifa:</label>
        <select name="tarifa" class="form-control" required>
            <option value="">-- Seleccionar tarifa --</option>
            <option value="Adulto">Adulto</option>
            <option value="Niño">Niño</option>
            <option value="Estudiante">Estudiante</option>
        </select>
    </div>

    <div class="mb-3">
        <label for="telefono">Teléfono:</label>
        <input type="text" name="telefono" class="form-control">
    </div>

    <button type="submit" class="btn btn-primary">Guardar Pasajero</button>
    <a href="{{ route('admin.pasajeros.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection
