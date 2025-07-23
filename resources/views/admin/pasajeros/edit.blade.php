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
                <option value="{{ $reserva->id }}" 
                    {{ old('reserva_id', $pasajero->reserva_id) == $reserva->id ? 'selected' : '' }}>
                    {{ $reserva->id }} - {{ $reserva->titular->nombre }} {{ $reserva->titular->apellido }}
                </option>
            @endforeach
        </select>
        @error('reserva_id')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="mb-3">
        <label for="documento">Documento:</label>
        <input type="text" name="documento" class="form-control" value="{{ old('documento', $pasajero->documento) }}" required>
        @error('documento')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="mb-3">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $pasajero->nombre) }}" required>
        @error('nombre')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="mb-3">
        <label for="apellido">Apellido:</label>
        <input type="text" name="apellido" class="form-control" value="{{ old('apellido', $pasajero->apellido) }}" required>
        @error('apellido')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="mb-3">
        <label for="pais_nacimiento">País de nacimiento:</label>
        <input type="text" name="pais_nacimiento" class="form-control" value="{{ old('pais_nacimiento', $pasajero->pais_nacimiento) }}" required>
        @error('pais_nacimiento')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="mb-3">
        <label for="pais_residencia">País de residencia:</label>
        <input type="text" name="pais_residencia" class="form-control" value="{{ old('pais_residencia', $pasajero->pais_residencia) }}" required>
        @error('pais_residencia')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="mb-3">
        <label for="ciudad">Ciudad:</label>
        <input type="text" name="ciudad" class="form-control" value="{{ old('ciudad', $pasajero->ciudad) }}">
        @error('ciudad')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="mb-3">
        <label for="fecha_nacimiento">Fecha de nacimiento:</label>
        <input type="date" name="fecha_nacimiento" class="form-control" value="{{ old('fecha_nacimiento', $pasajero->fecha_nacimiento) }}" required>
        @error('fecha_nacimiento')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="mb-3">
        <label for="tarifa">Tarifa:</label>
        <select name="tarifa" class="form-control" required>
            <option value="Adulto" {{ old('tarifa', $pasajero->tarifa) == 'Adulto' ? 'selected' : '' }}>Adulto</option>
            <option value="Niño" {{ old('tarifa', $pasajero->tarifa) == 'Niño' ? 'selected' : '' }}>Niño</option>
            <option value="Estudiante" {{ old('tarifa', $pasajero->tarifa) == 'Estudiante' ? 'selected' : '' }}>Estudiante</option>
        </select>
        @error('tarifa')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="mb-3">
        <label for="telefono">Teléfono:</label>
        <input type="text" name="telefono" class="form-control" value="{{ old('telefono', $pasajero->telefono) }}">
        @error('telefono')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary">Actualizar</button>
    <a href="{{ route('admin.pasajeros.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection
