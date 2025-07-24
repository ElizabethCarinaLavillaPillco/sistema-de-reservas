@extends('layouts.template')

@section('content')
<h1 class="mt-4">Crear Reserva</h1>

<form action="{{ route('admin.reservas.store') }}" method="POST">
    @csrf

    <!-- TIPO DE RESERVA -->
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

    <!-- PROVEEDOR (solo si tipo = Agencia) -->
    <div class="mb-3" id="proveedor_container" style="display:none">
        <label for="proveedor_id">Proveedor:</label>
        <select name="proveedor_id" class="form-control">
            <option value="">-- Seleccionar proveedor --</option>
            @foreach ($proveedores as $proveedor)
                <option value="{{ $proveedor->id }}">{{ $proveedor->nombre }}</option>
            @endforeach
        </select>
    </div>

    <!-- TITULAR -->
    <div class="mb-3">
        <label for="titular_id">Titular:</label>
        <select name="titular_id" id="titular_id" class="form-control" required>
            <option value="">-- Seleccionar titular (pasajero) --</option>
            @foreach ($pasajeros as $pasajero)
                <option value="{{ $pasajero->id }}">
                    {{ $pasajero->nombre }} {{ $pasajero->apellido }} ({{ $pasajero->documento }})
                </option>
            @endforeach
        </select>
    </div>

    <!-- PASAJEROS -->
    <div class="mb-3">
        <label for="buscar_pasajero">Agregar Pasajeros:</label>
        <input type="text" id="buscar_pasajero" class="form-control" placeholder="Buscar pasajero por nombre">
        <div id="sugerencias_pasajeros"></div>
        <ul id="pasajeros_seleccionados"></ul>
    </div>
    <input type="hidden" name="pasajeros[]" id="pasajeros_ids">

    <div class="mb-3">
        <label for="cantidad_pasajeros">Cantidad de Pasajeros:</label>
        <input type="number" name="cantidad_pasajeros" id="cantidad_pasajeros" class="form-control" readonly required>
    </div>

    <!-- FECHAS -->
    <div class="mb-3">
        <label for="fecha_llegada">Fecha de Llegada:</label>
        <input type="date" name="fecha_llegada" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="fecha_salida">Fecha de Salida:</label>
        <input type="date" name="fecha_salida" class="form-control" required>
    </div>

    <!-- TOTAL Y ADELANTO -->
    <div class="mb-3">
        <label for="total">Total (S/.):</label>
        <input type="number" step="0.01" name="total" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="adelanto">Adelanto (S/.):</label>
        <input type="number" step="0.01" name="adelanto" class="form-control">
    </div>

    <!-- TOURS -->
    <div class="mb-3">
        <label>Tours Contratados:</label>
        <div id="tours_container"></div>
        <button type="button" class="btn btn-sm btn-secondary mt-2" onclick="agregarTour()">+ Agregar Tour</button>
    </div>

    <input type="hidden" name="cantidad_tours" id="cantidad_tours" value="0">

    <button type="submit" class="btn btn-primary">Guardar Reserva</button>
    <a href="{{ route('admin.reservas.index') }}" class="btn btn-secondary">Cancelar</a>
</form>

<script>
    const tipoReservaSelect = document.getElementById('tipo_reserva');
    const proveedorContainer = document.getElementById('proveedor_container');

    tipoReservaSelect.addEventListener('change', function () {
        proveedorContainer.style.display = this.value === 'Agencia' ? 'block' : 'none';
    });

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
                    item.textContent = `${p.nombre} ${p.apellido}`;
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
            li.textContent = `${pasajero.nombre} ${pasajero.apellido}`;
            lista.appendChild(li);
            actualizarPasajeros();
        }
    }

    function actualizarPasajeros() {
        const ids = pasajerosSeleccionados.map(p => p.id);
        inputHidden.value = ids;
        cantidadInput.value = ids.length;
    }

    let tourIndex = 0;
    const toursContainer = document.getElementById('tours_container');
    const cantidadToursInput = document.getElementById('cantidad_tours');

    function agregarTour() {
        const div = document.createElement('div');
        div.classList.add('border', 'p-2', 'mb-2');
        div.innerHTML = `
            <div class="mb-2">
                <label>Tour:</label>
                <select name="tours[${tourIndex}][tour_id]" class="form-control">
                    @foreach ($tours as $tour)
                        <option value="{{ $tour->id }}">{{ $tour->tipo }} - {{ $tour->descripcion }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-2">
                <label>Fecha:</label>
                <input type="date" name="tours[${tourIndex}][fecha]" class="form-control">
            </div>
            <div class="mb-2">
                <label>Empresa:</label>
                <input type="text" name="tours[${tourIndex}][empresa]" class="form-control">
            </div>
            <div class="mb-2">
                <label>Precio Unitario:</label>
                <input type="number" name="tours[${tourIndex}][precio_unitario]" step="0.01" class="form-control">
            </div>
            <div class="mb-2">
                <label>Cantidad:</label>
                <input type="number" name="tours[${tourIndex}][cantidad]" min="1" class="form-control">
            </div>
            <div class="mb-2">
                <label>Observaciones:</label>
                <input type="text" name="tours[${tourIndex}][observaciones]" class="form-control">
            </div>
        `;
        toursContainer.appendChild(div);
        tourIndex++;
        cantidadToursInput.value = tourIndex;
    }
</script>

<style>
    .sugerencia-item {
        padding: 4px;
        background-color: #f0f0f0;
        cursor: pointer;
        margin-bottom: 2px;
    }
    .sugerencia-item:hover {
        background-color: #ddd;
    }
</style>
@endsection
