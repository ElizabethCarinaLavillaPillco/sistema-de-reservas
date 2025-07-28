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
    <label for="busquedaPasajero">Buscar pasajeros:</label>
    <input list="listaPasajeros" id="busquedaPasajero" class="form-control" placeholder="Escribe el nombre del pasajero">
    <datalist id="listaPasajeros">
        @foreach ($pasajeros as $pasajero)
            <option value="{{ $pasajero->nombre }} {{ $pasajero->apellido }} ({{ $pasajero->documento }})" data-id="{{ $pasajero->id }}"></option>
        @endforeach
    </datalist>

    <button type="button" onclick="agregarPasajero()" class="btn btn-sm btn-secondary mt-2">Agregar pasajero</button>
    </div>

    <div id="pasajerosSeleccionados" class="mb-3">
        <label>Pasajeros seleccionados:</label>
        <ul id="listaPasajerosAgregados" class="list-group"></ul>
    </div>

    <input type="hidden" name="cantidad_pasajeros" id="cantidad_pasajeros" value="0">


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

        <div class="border p-3 mb-3">
            <div class="row">
                <div class="col-md-6 mb-2">
                    <label>Nombre del tour:</label>
                    <input type="text" id="nombre_tour" class="form-control" placeholder="Ej. Machupicchu Full Day">
                </div>
                <div class="col-md-6 mb-2">
                    <label>Fecha:</label>
                    <input type="date" id="fecha_tour" class="form-control">
                </div>
                <div class="col-md-4 mb-2">
                    <label>Empresa:</label>
                    <input type="text" id="empresa_tour" class="form-control">
                </div>
                <div class="col-md-4 mb-2">
                    <label>Precio Unitario:</label>
                    <input type="number" id="precio_unitario_tour" step="0.01" class="form-control">
                </div>
                <div class="col-md-4 mb-2">
                    <label>Cantidad:</label>
                    <input type="number" id="cantidad_tour" min="1" value="1" class="form-control">
                </div>
                <div class="col-md-12 mb-2">
                    <label>Observaciones:</label>
                    <input type="text" id="observaciones_tour" class="form-control">
                </div>
                <div class="col-12 text-end">
                    <button type="button" class="btn btn-sm btn-secondary mt-2" onclick="agregarTour()">Agregar Tour</button>
                </div>
            </div>
        </div>

    <ul id="listaToursAgregados" class="list-group mb-3"></ul>
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

    const cantidadInput = document.getElementById('cantidad_pasajeros');
    let pasajerosSeleccionados = [];

    const listaPasajerosAgregados = document.getElementById('listaPasajerosAgregados');
    const inputBusqueda = document.getElementById('busquedaPasajero');
    const cantidadPasajerosInput = document.getElementById('cantidad_pasajeros');
    const pasajerosYaAgregados = new Set();

    function agregarPasajero() {
        const nombreCompleto = inputBusqueda.value.trim();
        if (!nombreCompleto) return;

        // Buscar el ID del pasajero según el texto
        const options = document.querySelectorAll('#listaPasajeros option');
        let pasajeroId = null;

        options.forEach(opt => {
            if (opt.value === nombreCompleto) {
                pasajeroId = opt.dataset.id;
            }
        });

        if (!pasajeroId) {
            alert("Selecciona un pasajero válido de la lista.");
            return;
        }

        if (pasajerosYaAgregados.has(pasajeroId)) {
            alert("Este pasajero ya fue agregado.");
            return;
        }

        pasajerosYaAgregados.add(pasajeroId);

        const li = document.createElement('li');
        li.classList.add('list-group-item', 'd-flex', 'justify-content-between', 'align-items-center');
        li.innerHTML = `
            ${nombreCompleto}
            <input type="hidden" name="pasajeros[]" value="${pasajeroId}">
            <button type="button" class="btn btn-sm btn-danger" onclick="eliminarPasajero(this, '${pasajeroId}')">Eliminar</button>
        `;
        listaPasajerosAgregados.appendChild(li);

        actualizarCantidadPasajeros();
        inputBusqueda.value = '';
    }


    function eliminarPasajero(btn, id) {
        pasajerosYaAgregados.delete(id);
        btn.parentElement.remove();
        actualizarCantidadPasajeros();
    }

    function actualizarCantidadPasajeros() {
        cantidadPasajerosInput.value = pasajerosYaAgregados.size;
    }

    let tourIndex = 0;
    const listaToursAgregados = document.getElementById('listaToursAgregados');
    const cantidadToursInput = document.getElementById('cantidad_tours');

    function agregarTour() {
        const nombre = document.getElementById('nombre_tour').value.trim();
        const fecha = document.getElementById('fecha_tour').value;
        const empresa = document.getElementById('empresa_tour').value.trim();
        const precio = document.getElementById('precio_unitario_tour').value;
        const cantidad = document.getElementById('cantidad_tour').value;
        const observaciones = document.getElementById('observaciones_tour').value.trim();

        if (!nombre) {
            alert("El nombre del tour es obligatorio.");
            return;
        }

        const li = document.createElement('li');
        li.classList.add('list-group-item');
        li.innerHTML = `
            <div><strong>Tour:</strong> ${nombre}</div>
            <div><strong>Fecha:</strong> ${fecha || '-'}</div>
            <div><strong>Empresa:</strong> ${empresa || '-'}</div>
            <div><strong>Precio Unitario:</strong> S/. ${precio || '0.00'}</div>
            <div><strong>Cantidad:</strong> ${cantidad || '1'}</div>
            <div><strong>Observaciones:</strong> ${observaciones || '-'}</div>
            <input type="hidden" name="tours[${tourIndex}][nombre_tour]" value="${nombre}">
            <input type="hidden" name="tours[${tourIndex}][fecha]" value="${fecha}">
            <input type="hidden" name="tours[${tourIndex}][empresa]" value="${empresa}">
            <input type="hidden" name="tours[${tourIndex}][precio_unitario]" value="${precio}">
            <input type="hidden" name="tours[${tourIndex}][cantidad]" value="${cantidad}">
            <input type="hidden" name="tours[${tourIndex}][observaciones]" value="${observaciones}">
            <button type="button" class="btn btn-sm btn-danger mt-2" onclick="eliminarTour(this)">Eliminar</button>
        `;
        listaToursAgregados.appendChild(li);
        tourIndex++;

        actualizarCantidadTours();

        // Limpiar inputs
        document.getElementById('nombre_tour').value = '';
        document.getElementById('fecha_tour').value = '';
        document.getElementById('empresa_tour').value = '';
        document.getElementById('precio_unitario_tour').value = '';
        document.getElementById('cantidad_tour').value = 1;
        document.getElementById('observaciones_tour').value = '';
    }

    function eliminarTour(btn) {
        btn.parentElement.remove();
        actualizarCantidadTours();
    }

    function actualizarCantidadTours() {
        cantidadToursInput.value = listaToursAgregados.children.length;
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
