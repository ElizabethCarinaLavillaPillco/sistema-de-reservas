@extends('layouts.template')

@section('content')
<h1 class="mt-4">Crear Reserva</h1>

<form action="{{ route('admin.reservas.store') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label for="titular_id">Titular:</label>
        <select name="titular_id" class="form-control" required>
            <option value="">-- Seleccionar titular --</option>
            @foreach ($titulares as $titular)
                <option value="{{ $titular->id }}">
                    {{ $titular->nombre }} {{ $titular->apellido }} ({{ $titular->documento }})
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="cantidad_pasajeros">Cantidad de Pasajeros:</label>
        <input type="number" name="cantidad_pasajeros" class="form-control" min="1" required>
    </div>

    <div class="mb-3">
        <label for="fecha_llegada">Fecha de Llegada:</label>
        <input type="date" name="fecha_llegada" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="fecha_salida">Fecha de Salida:</label>
        <input type="date" name="fecha_salida" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="cantidad_tours">Cantidad de Tours:</label>
        <input type="number" name="cantidad_tours" class="form-control" min="0" required>
    </div>

    <div class="mb-3">
        <label for="total">Total (S/.):</label>
        <input type="number" step="0.01" name="total" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="adelanto">Adelanto (S/.):</label>
        <input type="number" step="0.01" name="adelanto" class="form-control">
    </div>

    <button type="submit" class="btn btn-primary">Guardar Reserva</button>
    <a href="{{ route('admin.reservas.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection
