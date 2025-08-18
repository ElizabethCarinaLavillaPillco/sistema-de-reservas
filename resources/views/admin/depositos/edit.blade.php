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

    {{-- Buscar Reserva --}}
    <div class="mb-3">
        <label>Reserva (busque por nombre o código):</label>

        <input list="listaReservas"
            id="busquedaReserva"
            class="form-control"
            placeholder="Ej. José Ram..."
            value="{{ $depositos->reserva ? ($depositos->reserva->id . ' - ' . $depositos->reserva->titular->nombre .' '. $depositos->reserva->titular->apellido) : '' }}"
        >

        <datalist id="listaReservas">
            @foreach($reservas as $r)
                <option value="{{ $r->id }} - {{ $r->titular->nombre }} {{ $r->titular->apellido }}"></option>
            @endforeach
        </datalist>

        <input type="hidden"
            name="reserva_id"
            id="reserva_id_hidden"
            value="{{ $depositos->reserva_id }}">
    </div>



        <div class="mb-3">
            <label for="monto" class="form-label">Monto</label>
            <input type="number" step="0.01" name="monto" class="form-control" value="{{ old('monto', $depositos->monto) }}" required>
        </div>

        <div class="mb-3">
            <label for="fecha" class="form-label">Fecha</label>
            <input type="date"
                name="fecha"
                class="form-control"
                value="{{ old('fecha', optional($depositos->fecha)->format('Y-m-d')) }}"
                required>

        </div>

        <div class="mb-3">
            <label for="tipo_deposito" class="form-label">Tipo de Depósito</label>
            <select name="tipo_deposito" class="form-control" required>
                @foreach(['Deposito WU', 'Transferencia BCP', 'Transferencia Interbank', 'Yape', 'Plin', 'Otro'] as $tipo)
                    <option value="{{ $tipo }}" {{ old('tipo_deposito', $depositos->tipo_deposito) == $tipo ? 'selected' : '' }}>{{ $tipo }}</option>
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
    document.getElementById('busquedaReserva').addEventListener('input', function(){
        const val = this.value;
        const opt = Array.from(document.querySelectorAll('#listaReservas option'))
                        .find(o => o.value === val);
        document.getElementById('reserva_id_hidden').value = opt ? opt.value.split(' - ')[0] : '';
    });
</script>
@endsection
