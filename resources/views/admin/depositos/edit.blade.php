<!-- resources/views/depositos/edit.blade.php -->
@extends('layouts.template')

@section('content')
<div class="container">
    <h2>Editar Depósito</h2>

    <form action="{{ route('admin.depositos.update', $depositos->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nombre_depositante" class="form-label">Nombre del Depositante</label>
            <input type="text" name="nombre_depositante" class="form-control" value="{{ old('nombre_depositante', $depositos->nombre_depositante) }}" required>
        </div>

        <div class="mb-3">
            <label for="reserva_id" class="form-label">ID de Reserva</label>
            <input type="text" id="buscarReserva" class="form-control" placeholder="Buscar ID de reserva (Ej: R001)">
            <select name="reserva_id" id="reserva_id" class="form-control mt-2" required>
                <option value="{{ $depositos->reserva_id }}" selected>{{ $depositos->reserva_id }}</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="monto" class="form-label">Monto</label>
            <input type="number" step="0.01" name="monto" class="form-control" value="{{ old('monto', $depositos->monto) }}" required>
        </div>

        <div class="mb-3">
            <label for="fecha" class="form-label">Fecha</label>
            <input type="date" name="fecha" class="form-control" value="{{ old('fecha', $depositos->fecha) }}" required>
        </div>

        <div class="mb-3">
            <label for="tipo_deposito" class="form-label">Tipo de Depósito</label>
            <select name="tipo_deposito" class="form-control" required>
                @foreach(['Deposito WU', 'Transferencia BCP', 'Transferencia Interbank', 'Yape', 'Plin', 'Otro'] as $tipo)
                    <option value="{{ $tipo }}" {{ old('tipo_deposito', $deposito->tipo_deposito) == $tipo ? 'selected' : '' }}>{{ $tipo }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="observaciones" class="form-label">Observaciones</label>
            <textarea name="observaciones" class="form-control">{{ old('observaciones', $depositos->observaciones) }}</textarea>
        </div>

        <button type="submit" class="btn btn-success">Actualizar</button>
        <a href="{{ route('admin.depositos.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<script>
document.getElementById('buscarReserva').addEventListener('keyup', function() {
    let query = this.value;
    if (query.length >= 1) {
        fetch(`/buscar-reserva?query=${query}`)
            .then(response => response.json())
            .then(data => {
                let select = document.getElementById('reserva_id');
                select.innerHTML = '';
                data.forEach(reserva => {
                    let option = document.createElement('option');
                    option.value = reserva.id;
                    option.text = reserva.codigo_reserva;
                    select.appendChild(option);
                });
            });
    }
});
</script>
@endsection
