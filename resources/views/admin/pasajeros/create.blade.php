@extends('layouts.template')

@section('content')
<h1 class="mt-4">Registrar Nuevo Pasajero</h1>

<form action="{{ route('admin.pasajeros.store') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label for="reserva_id">Reserva Asociada (opcional):</label>
        <select name="reserva_id" class="form-control">
            <option value="">-- Seleccionar reserva --</option>
            @foreach ($reservas as $reserva)
                <option value="{{ $reserva->id }}" {{ old('reserva_id') == $reserva->id ? 'selected' : '' }}>
                    {{ $reserva->id }}
                </option>
            @endforeach
        </select>
        @error('reserva_id')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>


    <div class="mb-3">
        <label for="documento">Documento:</label>
        <input type="text" name="documento" class="form-control" value="{{ old('documento') }}" required>
        @error('documento')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="mb-3">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" class="form-control" value="{{ old('nombre') }}" required>
        @error('nombre')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="mb-3">
        <label for="apellido">Apellido:</label>
        <input type="text" name="apellido" class="form-control" value="{{ old('apellido') }}" required>
        @error('apellido')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="mb-3">
        <label for="pais_nacimiento">País de Nacimiento:</label>
        <input type="text" name="pais_nacimiento" class="form-control" value="{{ old('pais_nacimiento') }}" required>
        @error('pais_nacimiento')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="mb-3">
        <label for="pais_residencia">País de Residencia:</label>
        <input type="text" name="pais_residencia" class="form-control" value="{{ old('pais_residencia') }}" required>
        @error('pais_residencia')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="mb-3">
        <label for="ciudad">Ciudad:</label>
        <input type="text" name="ciudad" class="form-control" value="{{ old('ciudad') }}">
        @error('ciudad')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="mb-3">
        <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
        <input type="date" name="fecha_nacimiento" class="form-control" value="{{ old('fecha_nacimiento') }}" required>
        @error('fecha_nacimiento')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="mb-3">
        <label for="tarifa">Tarifa:</label>
        <select name="tarifa" class="form-control" required>
            <option value="">-- Seleccionar tarifa --</option>
            <option value="Adulto" {{ old('tarifa') == 'Adulto' ? 'selected' : '' }}>Adulto</option>
            <option value="Niño" {{ old('tarifa') == 'Niño' ? 'selected' : '' }}>Niño</option>
            <option value="Estudiante" {{ old('tarifa') == 'Estudiante' ? 'selected' : '' }}>Estudiante</option>
        </select>
        @error('tarifa')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="mb-3">
        <label for="telefono">Teléfono:</label>
        <input type="text" name="telefono" class="form-control" value="{{ old('telefono') }}">
        @error('telefono')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary">Guardar Pasajero</button>
    <a href="{{ route('admin.pasajeros.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection
