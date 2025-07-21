@extends('layouts.template')

@section('content')
<h1 class="mt-4">Editar Pasajero</h1>

<form action="{{ route('admin.pasajeros.update', $pasajero->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label for="reserva_id">Reserva:</label>
        <select name="reserva_id" class="form-control" required>
            @foreach ($reservas as $reserva)
                <option value="{{ $reserva->id }}" {{ $reserva->id == $pasajero->reserva_id ? 'selected' : '' }}>
                    {{ $reserva->id }} - {{ $reserva->titular->nombre }} {{ $reserva->titular->apellido }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="documento">Documento:</label>
        <input type="text" name="documento" class="form-control" value="{{ $pasajero->documento }}" required>
    </div>

    <div class="mb-3">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" class="form-control" value="{{ $pasajero->nombre }}" required>
    </div>

    <div class="mb-3">
        <label for="apellido">Apellido:</label>
        <input type="text" name="apellido" class="form-control" value="{{ $pasajero->apellido }}" required>
    </div>

    <div class="mb-3">
        <label for="pais_nacimiento">País de nacimiento:</label>
        <input type="text" name="pais_nacimiento" class="form-control" value="{{ $pasajero->pais_nacimiento }}" required>
    </div>

    <div class="mb-3">
        <label for="pais_residencia">País de residencia:</label>
        <input type="text" name="pais_residencia" class="form-control" value="{{ $pasajero->pais_residencia }}" required>
    </div>

    <div class="mb-3">
        <label for="ciudad">Ciudad:</label>
        <input type="text" name="ciudad" class="form-control" value="{{ $pasajero->ciudad }}">
    </div>

    <div class="mb-3">
        <label for="fecha_nacimiento">Fecha de nacimiento:</label>
        <input type="date" name="fecha_nacimiento" class="form-control" value="{{ $pasajero->fecha_nacimiento }}" required>
    </div>

    <div class="mb-3">
        <label for="tarifa">Tarifa:</label>
        <select name="tarifa" class="form-control" required>
            <option value="Adulto" {{ $pasajero->tarifa == 'Adulto' ? 'selected' : '' }}>Adulto</option>
            <option value="Niño" {{ $pasajero->tarifa == 'Niño' ? 'selected' : '' }}>Niño</option>
            <option value="Estudiante" {{ $pasajero->tarifa == 'Estudiante' ? 'selected' : '' }}>Estudiante</option>
        </select>
    </div>

    <div class="mb-3">
        <label for="telefono">Teléfono:</label>
        <input type="text" name="telefono" class="form-control" value="{{ $pasajero->telefono }}">
    </div>

    <button type="submit" class="btn btn-primary">Actualizar</button>
    <a href="{{ route('admin.pasajeros.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection
