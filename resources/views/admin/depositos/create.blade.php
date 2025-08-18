@extends('layouts.template')

@section('content')
<div class="container">
    <h1>Registrar Depósito</h1>

    <form action="{{ route('admin.depositos.store') }}" method="POST">
        @csrf

        {{-- Buscar Reserva --}}
        <div class="mb-3">
            <label for="busquedaReserva">Reserva (busque por nombre o código):</label>
            <input list="listaReservas" id="busquedaReserva" class="form-control" placeholder="Ej. José Ram..." >
            <datalist id="listaReservas">
                @foreach($reservas as $r)
                    <option value="{{ $r->id }} - {{ $r->titular->nombre }} {{ $r->titular->apellido }}">
                @endforeach
            </datalist>

            <!-- Este input guarda el id real de la reserva -->
            <input type="hidden" name="reserva_id" id="reserva_id_hidden">
        </div>

        {{-- Nombre del depositante --}}
        <div class="mb-3">
            <label for="nombre_depositante" class="form-label">Nombre del Depositante</label>
            <input type="text" name="nombre_depositante" id="nombre_depositante" class="form-control" required>
        </div>

        {{-- Monto --}}
        <div class="mb-3">
            <label for="monto" class="form-label">Monto</label>
            <input type="number" step="0.01" name="monto" id="monto" class="form-control" required>
        </div>

        {{-- Fecha --}}
        <div class="mb-3">
            <label for="fecha" class="form-label">Fecha</label>
            <input type="date" name="fecha" id="fecha" class="form-control" required>
        </div>

        {{-- Tipo de depósito --}}
        <div class="mb-3">
            <label for="tipo_deposito" class="form-label">Tipo de Depósito</label>
            <select name="tipo_deposito" id="tipo_deposito" class="form-control" required>
                <option value="">Seleccione...</option>
                <option value="Deposito WU">Depósito WU</option>
                <option value="Transferencia BCP">Transferencia BCP</option>
                <option value="Transferencia Interbank">Transferencia Interbank</option>
                <option value="Yape">Yape</option>
                <option value="Plin">Plin</option>
                <option value="Otro">Otro</option>
            </select>
        </div>

        {{-- Observaciones --}}
        <div class="mb-3">
            <label for="observaciones" class="form-label">Observaciones</label>
            <textarea name="observaciones" id="observaciones" class="form-control"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="{{ route('admin.depositos.index') }}" class="btn btn-secondary">Cancelar</a>

    </form>
</div>

{{-- Script para búsqueda AJAX --}}
<script>

    document.getElementById('busquedaReserva').addEventListener('input', function(){
        const val = this.value;
        const opt = Array.from(document.querySelectorAll('#listaReservas option'))
                        .find(o => o.value === val);
        document.getElementById('reserva_id_hidden').value = opt ? opt.value.split(' - ')[0] : '';
    });
</script>
@endsection
