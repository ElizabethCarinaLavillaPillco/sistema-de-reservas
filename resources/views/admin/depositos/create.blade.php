@extends('layouts.template')

@section('content')
<div class="container">
    <h1>Registrar Depósito</h1>

    <form action="{{ route('admin.depositos.store') }}" method="POST">
        @csrf

        {{-- Buscar Reserva --}}
        <div class="mb-3">
            <label for="reserva_search" class="form-label">Buscar Reserva</label>
            <input type="text" id="reserva_search" class="form-control" placeholder="Ej: R001" autocomplete="off">
            <input type="hidden" name="reserva_id" id="reserva_id">
            <div id="reserva_list" class="list-group mt-1"></div>
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
    </form>
</div>

{{-- Script para búsqueda AJAX --}}
<script>
    document.getElementById('reserva_search').addEventListener('keyup', function() {
        let query = this.value;
        let list = document.getElementById('reserva_list');

        if(query.length > 1) {
            fetch(`/reservas/search?q=${query}`)
                .then(res => res.json())
                .then(data => {
                    list.innerHTML = '';
                    data.forEach(reserva => {
                        let item = document.createElement('a');
                        item.classList.add('list-group-item', 'list-group-item-action');
                        item.textContent = `${reserva.codigo} - ${reserva.nombre_cliente}`;
                        item.href = '#';
                        item.onclick = function(e) {
                            e.preventDefault();
                            document.getElementById('reserva_search').value = `${reserva.codigo} - ${reserva.nombre_cliente}`;
                            document.getElementById('reserva_id').value = reserva.id;
                            list.innerHTML = '';
                        };
                        list.appendChild(item);
                    });
                });
        } else {
            list.innerHTML = '';
        }
    });
</script>
@endsection
