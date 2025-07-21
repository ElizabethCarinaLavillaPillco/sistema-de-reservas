@extends('layouts.template')

@section('content')
<h1 class="mt-4">Editar Reserva</h1>

<form action="{{ route('admin.reservas.update', $reserva->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label for="titular_id">Titular:</label>
        <select name="titular_id" class="form-control" required>
            @foreach ($titulares as $titular)
                <option value="{{ $titular->id }}" {{ $titular->id == $reserva->titular_id ? 'selected' : '' }}>
                    {{ $titular->nombre }} {{ $titular->apellido }} ({{ $titular->documento }})
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="cantidad_pasajeros">Cantidad de Pasajeros:</label>
        <input type="number" name="cantidad_pasajeros" class="form-control" min="1" value="{{ $reserva->cantidad_pasajeros }}" required>
    </div>

    <div class="mb-3">
        <label for="fecha_llegada">Fecha de Llegada:</label>
        <input type="date" name="fecha_llegada" class="form-control" value="{{ $reserva->fecha_llegada }}" required>
    </div>

    <div class="mb-3">
        <label for="fecha_salida">Fecha de Salida:</label>
        <input type="date" name="fecha_salida" class="form-control" value="{{ $reserva->fecha_salida }}" required>
    </div>

    <div class="mb-3">
        <label for="cantidad_tours">Cantidad de Tours:</label>
        <input type="number" name="cantidad_tours" class="form-control" min="0" value="{{ $reserva->cantidad_tours }}" required>
    </div>

    <div class="mb-3">
        <label for="total">Total (S/.):</label>
        <input type="number" step="0.01" name="total" class="form-control" value="{{ $reserva->total }}" required>
    </div>

    <div class="mb-3">
        <label for="adelanto">Adelanto (S/.):</label>
        <input type="number" step="0.01" name="adelanto" class="form-control" value="{{ $reserva->adelanto }}">
    </div>

    <button type="submit" class="btn btn-success">Actualizar Reserva</button>
    <a href="{{ route('admin.reservas.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection
