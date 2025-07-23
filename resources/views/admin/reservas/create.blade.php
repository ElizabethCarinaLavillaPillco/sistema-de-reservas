@extends('layouts.template')

@section('content')
<h1 class="mt-4">Crear Reserva</h1>

<form action="{{ route('admin.reservas.store') }}" method="POST">
    @csrf

    <!-- Tipo de Reserva -->
    <div class="mb-3">
        <label for="tipo_reserva">Tipo de Reserva:</label>
        <select name="tipo_reserva" id="tipo_reserva" class="form-control" required>
            <option value="">-- Seleccionar tipo --</option>
            <option value="Directo">Directo</option>
            <option value="Recomendacion">Recomendación</option>
            <option value="Publicidad">Publicidad</option>
            <option value="Agencia">Agencia</option>
        </select>
    </div>

    <!-- Titular -->
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

    <!-- Pasajeros -->
    <div class="mb-3">
        <label for="buscar_pasajero">Agregar Pasajeros:</label>
        <input type="text" id="buscar_pasajero" class="form-control" placeholder="Buscar pasajero por nombre">
        <div id="sugerencias_pasajeros" class="mt-2"></div>
        <ul id="pasajeros_seleccionados" class="list-group mt-2"></ul>
        <!-- Este input llevará los IDs seleccionados -->
        <input type="hidden" name="pasajeros_ids" id="pasajeros_ids">
    </div>

    <div class="mb-3">
        <label for="cantidad_pasajeros">Cantidad de Pasajeros:</label>
        <input type="number" name="cantidad_pasajeros" id="cantidad_pasajeros" class="form-control" readonly required>
    </div>

    <!-- Fechas y datos -->
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
        <input type="number" name="total" step="0.01" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="adelanto">Adelanto (S/.):</label>
        <input type="number" name="adelanto" step="0.01" class="form-control">
    </div>

    <button type="submit" class="btn btn-primary">Guardar Reserva</button>
    <a href="{{ route('admin.reservas.index') }}" class="btn btn-secondary">Cancelar</a>
</form>

<!-- Script búsqueda de pasajeros -->
<script>
    const input = document.getElementById('buscar_pasajero');
    const sugerencias = document.getElementById('sugerencias_pasajeros');
    const lista = document.getElementById('pasajeros_seleccionados');
    const inputHidden = document.getElementById('pasajeros_ids');
    const cantidadInput = document.getElementById('cantidad_pasajeros');

    let pasajerosSeleccionados = [];

    input.addEventListener('input', function () {
        fetch(`/api/pasajeros/buscar?q=${input.value}`)
            .then(res => res.json())
            .then(data => {
                sugerencias.innerHTML = '';
                data.forEach(p => {
                    const item = document.createElement('div');
                    item.textContent = `${p.nombre} ${p.apellido} (${p.documento})`;
                    item.classList.add('sugerencia-item');
                    item.addEventListener('click', () => agregarPasajero(p));
                    sugerencias.appendChild(item);
                });
            });
    });

    function agregarPasajero(pasajero) {
        if (!pasajerosSeleccionados.find(p => p.id === pasajero.id)) {
            pasajerosSeleccionados.push(pasajero);

            const li = document.createElement('li');
            li.classList.add('list-group-item', 'd-flex', 'justify-content-between', 'align-items-center');
            li.textContent = `${pasajero.nombre} ${pasajero.apellido}`;

            const btn = document.createElement('button');
            btn.textContent = 'Quitar';
            btn.classList.add('btn', 'btn-sm', 'btn-danger');
            btn.onclick = () => quitarPasajero(pasajero.id, li);

            li.appendChild(btn);
            lista.appendChild(li);
            actualizarHidden();
        }
    }

    function quitarPasajero(id, liElement) {
        pasajerosSeleccionados = pasajerosSeleccionados.filter(p => p.id !== id);
        liElement.remove();
        actualizarHidden();
    }

    function actualizarHidden() {
        const ids = pasajerosSeleccionados.map(p => p.id);
        inputHidden.value = ids.join(',');
        cantidadInput.value = ids.length;
    }
</script>

<style>
    .sugerencia-item {
        padding: 5px;
        background-color: #f8f9fa;
        border: 1px solid #ccc;
        margin-bottom: 4px;
        cursor: pointer;
    }

    .sugerencia-item:hover {
        background-color: #e2e6ea;
    }
</style>
@endsection
