@extends('layouts.template')

@section('content')
<h1 class="mt-4">Crear Reserva</h1>

<form action="{{ route('admin.reservas.store') }}" method="POST">
    @csrf

    {{-- ERRORES --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

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
                <option value="{{ $proveedor->id }}">{{ $proveedor->nombreAgencia ?? $proveedor->nombre }}</option>
            @endforeach
        </select>
    </div>

    <!-- TITULAR (BUSCADOR: es un pasajero) -->
    <div class="mb-3">
        <label for="busquedaTitular">Titular (buscar pasajero):</label>
        <input list="listaTitulares" id="busquedaTitular" class="form-control" placeholder="Escribe nombre del pasajero (seleccionar)">
        <datalist id="listaTitulares">
            @foreach($pasajeros as $p)
                <option value="{{ $p->nombre }} {{ $p->apellido }} ({{ $p->documento }})" data-id="{{ $p->id }}"></option>
            @endforeach
        </datalist>
        <div class="mt-2">
            <button type="button" id="btnSeleccionarTitular" class="btn btn-sm btn-secondary">Seleccionar titular</button>
            <button type="button" id="btnLimpiarTitular" class="btn btn-sm btn-outline-secondary">Limpiar</button>
        </div>

        {{-- campo hidden que envía el id del titular al backend --}}
        <input type="hidden" name="titular_id" id="titular_id_hidden" value="">
        <div id="titularSeleccionado" class="mt-2"></div>
    </div>

    <!-- PASAJEROS (MÚLTIPLES) -->
    <div class="mb-3">
        <label for="busquedaPasajero">Buscar pasajeros (agregar varios):</label>
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

    <!-- FECHAS / HORAS / VUELOS (LLEGADA Y SALIDA EN UNA FILA) -->
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="fecha_llegada">Fecha de Llegada:</label>
            <input type="date" name="fecha_llegada" id="fecha_llegada" class="form-control">
        </div>
        <div class="col-md-4">
            <label for="hora_llegada">Hora de Llegada:</label>
            <input type="time" name="hora_llegada" id="hora_llegada" class="form-control">
        </div>
        <div class="col-md-4">
            <label for="nro_vuelo_llegada">N° Vuelo Llegada:</label>
            <input type="text" name="nro_vuelo_llegada" id="nro_vuelo_llegada" class="form-control">
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-4">
            <label for="fecha_salida">Fecha de Salida:</label>
            <input type="date" name="fecha_salida" id="fecha_salida" class="form-control">
        </div>
        <div class="col-md-4">
            <label for="hora_salida">Hora de Salida:</label>
            <input type="time" name="hora_salida" id="hora_salida" class="form-control">
        </div>
        <div class="col-md-4">
            <label for="nro_vuelo_salida">N° Vuelo Salida:</label>
            <input type="text" name="nro_vuelo_salida" id="nro_vuelo_salida" class="form-control">
        </div>
    </div>

    <!-- TOTAL Y ADELANTO -->
    <div class="mb-3">
        <label for="total">Total (S/.):</label>
        <input type="number" step="0.01" name="total" id="total" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="adelanto">Adelanto (S/.):</label>
        <input type="number" step="0.01" name="adelanto" id="adelanto" class="form-control">
    </div>

    <!-- TOURS (BUSCADOR + CAMPOS ADICIONALES) -->
    <div class="mb-3">
        <label>Tours Contratados:</label>

        <div class="border p-3 mb-2">
            <div class="row">
                <div class="col-md-6 mb-2">
                    <label for="busquedaTours">Buscar tours:</label>
                    <input list="listaTours" id="busquedaTours" class="form-control" placeholder="Escribe el nombre del tour:">
                    <input type="hidden" id="id_tour" value="">
                    <datalist id="listaTours">
                        @foreach ($tours as $tour)
                            <option value="{{ $tour->nombreTour }}" data-id="{{ $tour->id }}"></option>
                        @endforeach
                    </datalist>
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

    <!-- ESTADÍAS (MÚLTIPLES) -->
    <div class="mb-3">
        <label>Estadías:</label>
        <div class="border p-3 mb-2">
            <div class="row">
                <div class="col-md-4 mb-2">
                    <label>Tipo Estadia</label>
                    <select id="tipo_estadia_input" class="form-control">
                        <option value="Hostal">Hostal</option>
                        <option value="Hospedaje">Hospedaje</option>
                        <option value="Airbnb">Airbnb</option>
                    </select>
                </div>
                <div class="col-md-4 mb-2">
                    <label>Nombre Estadia</label>
                    <input type="text" id="nombre_estadia_input" class="form-control">
                </div>
                <div class="col-md-4 mb-2">
                    <label>Ubicación</label>
                    <input type="text" id="ubicacion_estadia_input" class="form-control">
                </div>
                <div class="col-md-4 mb-2">
                    <label>Fecha</label>
                    <input type="date" id="fecha_estadia_input" class="form-control">
                </div>
                <div class="col-md-4 mb-2">
                    <label>Habitación</label>
                    <input type="text" id="habitacion_estadia_input" class="form-control">
                </div>

                <div class="col-12 text-end">
                    <button type="button" class="btn btn-sm btn-secondary mt-2" onclick="agregarEstadia()">Agregar Estadia</button>
                </div>
            </div>
        </div>

        <ul id="listaEstadiasAgregadas" class="list-group mb-3"></ul>
    </div>

    <input type="hidden" name="cantidad_estadias" id="cantidad_estadias" value="0">

    <button type="submit" class="btn btn-primary">Guardar Reserva</button>
    <a href="{{ route('admin.reservas.index') }}" class="btn btn-secondary">Cancelar</a>
</form>

{{-- SCRIPTS --}}
<script>
    // Mostrar/ocultar proveedor si tipo = Agencia
    const tipoReservaSelect = document.getElementById('tipo_reserva');
    const proveedorContainer = document.getElementById('proveedor_container');
    tipoReservaSelect.addEventListener('change', function () {
        proveedorContainer.style.display = this.value === 'Agencia' ? 'block' : 'none';
    });

    /* ---------------- TITULAR (BUSCADOR) ---------------- */
    const inputBusquedaTitular = document.getElementById('busquedaTitular');
    const listaTitulares = document.querySelectorAll('#listaTitulares option');
    const titularIdHidden = document.getElementById('titular_id_hidden');
    const btnSeleccionarTitular = document.getElementById('btnSeleccionarTitular');
    const btnLimpiarTitular = document.getElementById('btnLimpiarTitular');
    const titularSeleccionadoDiv = document.getElementById('titularSeleccionado');

    btnSeleccionarTitular.addEventListener('click', function () {
        const val = inputBusquedaTitular.value.trim();
        if (!val) {
            alert('Escribe o selecciona un titular válido.');
            return;
        }
        // buscar opción que coincida exactamente
        let foundId = null;
        listaTitulares.forEach(opt => {
            if (opt.value === val) foundId = opt.dataset.id;
        });

        if (!foundId) {
            alert('Selecciona un titular válido de la lista.');
            return;
        }

        titularIdHidden.value = foundId;
        titularSeleccionadoDiv.innerHTML = `<div class="alert alert-success p-1">Titular seleccionado: <strong>${val}</strong></div>`;
    });

    btnLimpiarTitular.addEventListener('click', function () {
        inputBusquedaTitular.value = '';
        titularIdHidden.value = '';
        titularSeleccionadoDiv.innerHTML = '';
    });

    /* ---------------- PASAJEROS (MÚLTIPLES) ---------------- */
    const listaPasajerosAgregados = document.getElementById('listaPasajerosAgregados');
    const inputBusqueda = document.getElementById('busquedaPasajero');
    const cantidadPasajerosInput = document.getElementById('cantidad_pasajeros');
    const pasajerosYaAgregados = new Set();

    function agregarPasajero() {
        const nombreCompleto = inputBusqueda.value.trim();
        if (!nombreCompleto) return;

        const options = document.querySelectorAll('#listaPasajeros option');
        let pasajeroId = null;
        options.forEach(opt => { if (opt.value === nombreCompleto) pasajeroId = opt.dataset.id; });

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
            <div>
                <input type="hidden" name="pasajeros[]" value="${pasajeroId}">
                <button type="button" class="btn btn-sm btn-danger" onclick="eliminarPasajero(this, '${pasajeroId}')">Eliminar</button>
            </div>
        `;
        listaPasajerosAgregados.appendChild(li);

        actualizarCantidadPasajeros();
        inputBusqueda.value = '';
    }

    function eliminarPasajero(btn, id) {
        pasajerosYaAgregados.delete(id);
        btn.closest('li').remove();
        actualizarCantidadPasajeros();
    }

    function actualizarCantidadPasajeros() {
        cantidadPasajerosInput.value = pasajerosYaAgregados.size;
    }

    /* ---------------- TOURS (MÚLTIPLES) ---------------- */
    let tourIndex = 0;
    const listaToursAgregados = document.getElementById('listaToursAgregados');
    const cantidadToursInput = document.getElementById('cantidad_tours');

    // detectar selección en el input de tours y guardar su id en id_tour
    document.getElementById('busquedaTours').addEventListener('input', function () {
        const valor = this.value.trim();
        const options = document.querySelectorAll('#listaTours option');
        let tourId = '';
        options.forEach(opt => { if (opt.value === valor) tourId = opt.dataset.id; });
        document.getElementById('id_tour').value = tourId || '';
    });

    function agregarTour() {
        const nombre = document.getElementById('busquedaTours').value.trim();
        const fecha = document.getElementById('fecha_tour').value;
        const empresa = document.getElementById('empresa_tour').value.trim();
        const precio = document.getElementById('precio_unitario_tour').value;
        const cantidad = document.getElementById('cantidad_tour').value;
        const observaciones = document.getElementById('observaciones_tour').value.trim();
        const tourId = document.getElementById('id_tour').value;

        if (!tourId || !nombre) {
            alert("Selecciona un tour válido de la lista.");
            return;
        }
        if (precio && Number(precio) < 0) {
            alert("El precio no puede ser negativo.");
            return;
        }
        if (cantidad && Number(cantidad) <= 0) {
            alert("La cantidad debe ser mayor a 0.");
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

            <input type="hidden" name="tours[${tourIndex}][tour_id]" value="${tourId}">
            <input type="hidden" name="tours[${tourIndex}][nombre_tour]" value="${nombre}">
            <input type="hidden" name="tours[${tourIndex}][fecha]" value="${fecha}">
            <input type="hidden" name="tours[${tourIndex}][empresa]" value="${empresa}">
            <input type="hidden" name="tours[${tourIndex}][precio_unitario]" value="${precio}">
            <input type="hidden" name="tours[${tourIndex}][cantidad]" value="${cantidad}">
            <input type="hidden" name="tours[${tourIndex}][observaciones]" value="${observaciones}">
            <div class="mt-2">
                <button type="button" class="btn btn-sm btn-danger" onclick="eliminarTour(this)">Eliminar</button>
            </div>
        `;
        listaToursAgregados.appendChild(li);
        tourIndex++;
        actualizarCantidadTours();

        // limpiar campos
        document.getElementById('busquedaTours').value = '';
        document.getElementById('id_tour').value = '';
        document.getElementById('fecha_tour').value = '';
        document.getElementById('empresa_tour').value = '';
        document.getElementById('precio_unitario_tour').value = '';
        document.getElementById('cantidad_tour').value = 1;
        document.getElementById('observaciones_tour').value = '';
    }

    function eliminarTour(btn) {
        btn.closest('li').remove();
        actualizarCantidadTours();
    }

    function actualizarCantidadTours() {
        cantidadToursInput.value = listaToursAgregados.children.length;
    }

    /* ---------------- ESTADÍAS (MÚLTIPLES) ---------------- */
    let estadiaIndex = 0;
    const listaEstadiasAgregadas = document.getElementById('listaEstadiasAgregadas');
    const cantidadEstadiasInput = document.getElementById('cantidad_estadias');

    function agregarEstadia() {
        const tipo = document.getElementById('tipo_estadia_input').value;
        const nombre = document.getElementById('nombre_estadia_input').value.trim();
        const ubicacion = document.getElementById('ubicacion_estadia_input').value.trim();
        const fecha = document.getElementById('fecha_estadia_input').value;
        const habitacion = document.getElementById('habitacion_estadia_input').value.trim();

        if (!nombre) {
            if (!confirm('Estás agregando una estadía sin nombre. ¿Continuar?')) return;
        }

        const li = document.createElement('li');
        li.classList.add('list-group-item');
        li.innerHTML = `
            <div><strong>Tipo:</strong> ${tipo}</div>
            <div><strong>Nombre:</strong> ${nombre || '-'}</div>
            <div><strong>Ubicación:</strong> ${ubicacion || '-'}</div>
            <div><strong>Fecha:</strong> ${fecha || '-'}</div>
            <div><strong>Habitación:</strong> ${habitacion || '-'}</div>

            <input type="hidden" name="estadias[${estadiaIndex}][tipo_estadia]" value="${tipo}">
            <input type="hidden" name="estadias[${estadiaIndex}][nombre_estadia]" value="${nombre}">
            <input type="hidden" name="estadias[${estadiaIndex}][ubicacion]" value="${ubicacion}">
            <input type="hidden" name="estadias[${estadiaIndex}][fecha]" value="${fecha}">
            <input type="hidden" name="estadias[${estadiaIndex}][habitacion]" value="${habitacion}">

            <div class="mt-2">
                <button type="button" class="btn btn-sm btn-danger" onclick="eliminarEstadia(this)">Eliminar</button>
            </div>
        `;
        listaEstadiasAgregadas.appendChild(li);
        estadiaIndex++;
        actualizarCantidadEstadias();

        // limpiar inputs
        document.getElementById('nombre_estadia_input').value = '';
        document.getElementById('ubicacion_estadia_input').value = '';
        document.getElementById('fecha_estadia_input').value = '';
        document.getElementById('habitacion_estadia_input').value = '';
    }

    function eliminarEstadia(btn) {
        btn.closest('li').remove();
        actualizarCantidadEstadias();
    }

    function actualizarCantidadEstadias() {
        cantidadEstadiasInput.value = listaEstadiasAgregadas.children.length;
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
