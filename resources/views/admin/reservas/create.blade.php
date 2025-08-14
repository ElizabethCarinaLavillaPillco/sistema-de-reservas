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

                <!-- SELECCIONAR UN TOUR -->
                <div class="input-group mb-2">
                    <select id="select-tour" class="form-control">
                        <option value="">Seleccione tour</option>
                        @foreach($tours as $tour)
                            <option value="{{ $tour->id }}" data-nombre="{{ $tour->nombreTour }}">
                                {{ $tour->nombreTour }}
                            </option>
                        @endforeach
                    </select>
                    <input type="hidden" id="id_tour">
                    <input type="hidden" id="nombreTour">
                </div>

                <!-- CAMPOS GENERALES DEL TOUR -->
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

                <!-- CAMPOS ESPECIALES MACHUPICCHU -->
                <div id="machupicchu-details" class="col-12 mt-3" style="display:none; border-top:1px solid #ccc; padding-top:10px;">
                    <h5>Detalles Machupicchu</h5>

                    <!-- Entrada -->
                    <div class="form-group">
                        <label>¿Hay entrada?</label>
                        <select name="hay_entrada" id="hay_entrada" class="form-control">
                            <option value="">-- Seleccione --</option>
                            <option value="1">Sí</option>
                            <option value="0">No</option>
                        </select>
                    </div>

                    <!-- Circuitos y rutas -->
                    <div id="entrada-fields" style="display:none;">
                        <div class="form-group">
                            <label>Seleccione Circuito:</label>
                            <select name="tipo_entrada" id="tipo_entrada" class="form-control">
                                <option value="">-- Seleccione --</option>
                                <option value="circuito1">Circuito 1</option>
                                <option value="circuito2">Circuito 2</option>
                                <option value="circuito3">Circuito 3</option>
                            </select>
                        </div>

                        <!-- Rutas según circuito -->
                        <div class="form-group" id="ruta1-field" style="display:none;">
                            <label>Seleccione ruta de recorrido:</label>
                                <select id="ruta1" class="form-control">
                                    <option value="">-- Seleccione --</option>
                                    <option value="ruta1a">Ruta 1-A: Ruta Montaña Machupicchu</option>
                                    <option value="ruta1b">Ruta 1-B: Ruta terraza superior</option>
                                    <option value="ruta1c">Ruta 1-C: Ruta Portada Intipunku</option>
                                    <option value="ruta1d">Ruta 1-D: Ruta Puente Inka</option>
                                </select>
                            </div>

                        <div class="form-group" id="ruta2-field" style="display:none;">
                            <label>Seleccione ruta de recorrido:</label>
                                <select id="ruta2" class="form-control">
                                    <option value="">-- Seleccione --</option>
                                    <option value="ruta2a">Ruta 2-A: Ruta clásico diseñada</option>
                                    <option value="ruta2b">Ruta 2-B: Ruta terraza inferior</option>
                                </select>
                            </div>

                        <div class="form-group" id="ruta3-field" style="display:none;">
                        <label>Seleccione ruta de recorrido:</label>
                            <select id="ruta3" class="form-control">
                                <option value="">-- Seleccione --</option>
                                <option value="ruta3a">Ruta 3-A: Ruta Montaña Waynapicchu</option>
                                <option value="ruta3b">Ruta 3-B: Ruta realeza diseñada</option>
                                <option value="ruta3c">Ruta 3-C: Ruta Gran Caverna </option>
                                <option value="ruta3d">Ruta 3-D: Ruta Huchuypicchu</option>
                            </select>   
                        </div>

                        <!-- horario -->
                        <div class="col-md-4 mb-2">
                            <label>Horario Entrada:</label>
                            <input type="time" id="horario_entrada" class="form-control">
                        </div>
                    </div>

                    <!-- Comentario entrada -->
                    <div class="form-group" id="comentario-entrada-field" style="display:none;">
                        <label>Observacion acerca de la entrada</label>
                        <input type="text" name="comentario_entrada" class="form-control" placeholder="Ej: Tramitar en pueblo">
                    </div>

                    <hr>

                    <!-- Tren -->
                    <div class="form-group">
                        <label>Tipo de Tren</label>
                        <select name="tipo_tren" id="tipo_tren" class="form-control">
                            <option value="">-- Seleccione --</option>
                            <option value="Turístico">Tren Turístico</option>
                            <option value="Local">Tren Local</option>
                        </select>
                    </div>

                    <!-- Turístico -->
                    <div id="tren-turistico-fields" style="display:none;">
                        <div class="form-group">
                            <label>Empresa de Tren</label>
                            <select name="empresa_tren" class="form-control">
                                <option value="">-- Seleccione --</option>
                                <option value="Inca Rail">Inca Rail</option>
                                <option value="Peru Rail">Peru Rail</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Código de Tren</label>
                            <input type="text" name="codigo_tren" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Horario Ida</label>
                            <input type="time" name="horario_ida" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Horario Retorno</label>
                            <input type="time" name="horario_retorno" class="form-control">
                        </div>
                        

                    </div>
                    

                    <!-- Local -->
                    <div id="tren-local-fields" style="display:none;">
                        <div class="form-group">
                            <label>¿Tiene Ticket?</label>
                            <select name="tiene_ticket" id="tiene_ticket" class="form-control">
                                <option value="">-- Seleccione --</option>
                                <option value="1">Sí</option>
                                <option value="0">No</option>
                            </select>
                        </div>

                        <div id="ticket-fields" style="display:none;">
                            <div class="form-group">
                                <label>Horario Ida</label>
                                <input type="time" name="horario_ida" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Horario Retorno</label>
                                <input type="time" name="horario_retorno" class="form-control">
                            </div>
                        </div>

                        <div id="comentario-ticket-field" style="display:none;">
                            <label>Comentario Ticket</label>
                            <input type="text" name="comentario_ticket" class="form-control" placeholder="Ej: Hacer cola">
                        </div>
                    </div>

                    <!-- fechas tren -->
                    <div id="tren-fechas-fields" style="display:none;">
                        <div class="form-group">
                            <label>Fecha Tren Ida</label>
                            <input type="date" name="fecha_tren_ida" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Fecha Tren Retorno</label>
                            <input type="date" name="fecha_tren_retorno" class="form-control">
                        </div>
                    </div>

                    <hr>

                    <!-- Hospedaje -->
                        <div class="hospedaje-fields" style="display:none;">
                            <label>Hospedaje</label>
                            <input type="text" name="hospedaje" class="form-control">
                        </div>


                    <!-- By Car fechas -->
                    <div id="bycar-fields" style="display:none;">
                        <div class="form-group">
                            <label>Fecha Ida</label>
                            <input type="date" name="fecha_ida" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Fecha Retorno</label>
                            <input type="date" name="fecha_retorno" class="form-control">
                        </div>
                        <!-- Hospedaje -->
                        <div class="form-group">
                            <label>Hospedaje</label>
                            <input type="text" name="hospedaje" class="form-control">
                        </div>
                    </div>

                </div>

                <div class="col-12 text-end">
                    <button type="button" class="btn btn-success" onclick="agregarTour()">Agregar Tour</button>
                    <input type="hidden" id="tour_edit_index" value="">
                    <button type="button" class="btn btn-sm btn-warning"  id="btnActualizarTour" onclick="actualizarTour()" style="display:none;">Actualizar tour</button>

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
                        <option value="Hostal">Hotel</option>
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
                    <button type="button" class="btn btn-success" onclick="agregarEstadia()">Agregar Estadia</button>
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

    function setEditMode(on) {
        const addBtn = document.getElementById('btnAgregarTour');
        const updBtn = document.getElementById('btnActualizarTour');
        if (addBtn) addBtn.style.display = on ? 'none' : 'inline-block';
        if (updBtn) updBtn.style.display = on ? 'inline-block' : 'none';
    }


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
    const especiales = [
        'Machupicchu Full Day',
        'Machupicchu Conexión',
        'Machupicchu 2D/1N',
        'Machupicchu By car'
    ];

    document.getElementById('select-tour').addEventListener('change', function() {
        const option = this.options[this.selectedIndex];
        const id = option.value;
        const nombre = (option.dataset.nombre || '').trim();

        document.getElementById('id_tour').value = id;
        document.getElementById('nombreTour').value = nombre;

        // Normalizamos el texto para comparar (minúsculas y sin espacios extra)
        const nombreNormalizado = nombre.toLowerCase();

        const especialesNormalizados = especiales.map(e => e.toLowerCase().trim());

        if (especialesNormalizados.includes(nombreNormalizado)) {
            document.getElementById('machupicchu-details').style.display = 'block';

            // Si es By Car, mostrar fechas ida/retorno
            if (nombreNormalizado === 'machupicchu by car') {
                document.getElementById('bycar-fields').style.display = 'block';
            } else {
                document.getElementById('bycar-fields').style.display = 'none';
            }
        } else {
            document.getElementById('machupicchu-details').style.display = 'none';
            document.getElementById('bycar-fields').style.display = 'none';
        }
    });


     // Entrada
    document.getElementById('hay_entrada').addEventListener('change', function() {
        if (this.value == '1') {
            document.getElementById('entrada-fields').style.display = 'block';
            document.getElementById('comentario-entrada-field').style.display = 'none';
        } else if (this.value == '0') {
            document.getElementById('entrada-fields').style.display = 'none';
            document.getElementById('hospedaje-fields').style.display = 'block';
            document.getElementById('comentario-entrada-field').style.display = 'block';
        } else {
            document.getElementById('entrada-fields').style.display = 'none';
            document.getElementById('comentario-entrada-field').style.display = 'none';
        }
    });

    // Tipo Entrada -> rutas
    document.getElementById('tipo_entrada').addEventListener('change', function() {
        document.getElementById('ruta1-field').style.display = (this.value === 'circuito1') ? 'block' : 'none';
        document.getElementById('ruta2-field').style.display = (this.value === 'circuito2') ? 'block' : 'none';
        document.getElementById('ruta3-field').style.display = (this.value === 'circuito3') ? 'block' : 'none';
    });

    // Tren
    document.getElementById('tipo_tren').addEventListener('change', function() {
        if (this.value === 'Turístico') {
            document.getElementById('tren-turistico-fields').style.display = 'block';
            document.getElementById('tren-fechas-fields').style.display = 'block';
            document.getElementById('tren-local-fields').style.display = 'none';
        } else if (this.value === 'Local') {
            document.getElementById('tren-turistico-fields').style.display = 'none';
            document.getElementById('tren-local-fields').style.display = 'block';
            document.getElementById('tren-fechas-fields').style.display = 'block';
        } else {
            document.getElementById('tren-turistico-fields').style.display = 'none';
            document.getElementById('tren-local-fields').style.display = 'none';
            ocument.getElementById('tren-fechas-fields').style.display = 'none';
        }
    });

    // Tiene ticket
    document.getElementById('tiene_ticket').addEventListener('change', function() {
        if (this.value == '1') {
            document.getElementById('ticket-fields').style.display = 'block';
            document.getElementById('tren-fechas-fields').style.display = 'block';
            document.getElementById('comentario-ticket-field').style.display = 'none';
        } else if (this.value == '0') {
            document.getElementById('ticket-fields').style.display = 'none';
            document.getElementById('tren-fechas-fields').style.display = 'block';
            document.getElementById('comentario-ticket-field').style.display = 'block';
        } else {
            document.getElementById('tren-fechas-fields').style.display = 'none';
            document.getElementById('ticket-fields').style.display = 'none';
            document.getElementById('comentario-ticket-field').style.display = 'none';
        }
    });

    let tourIndex = 0;

    const listaToursAgregados = document.getElementById('listaToursAgregados');
    const cantidadToursInput = document.getElementById('cantidad_tours');

    function safeValue(id) {
        return document.getElementById(id)?.value || '';
    }

    function agregarTour(editMode = false, customIndex = null) {
        const indexToUse = editMode && customIndex !== null ? customIndex : tourIndex;

        const id = safeValue('id_tour');
        const nombre = safeValue('nombreTour');
        const fecha = safeValue('fecha_tour');
        const empresa = safeValue('empresa_tour');
        const precio = safeValue('precio_unitario_tour');
        const cantidad = safeValue('cantidad_tour');
        const observaciones = safeValue('observaciones_tour');

        if (!id) {
            alert("Selecciona un tour válido.");
            return;
        }

        let extras = '';
        let extrasPreview = '';
        if (especiales.includes(nombre)) {
            extras += `
                <input type="hidden" name="tours[${indexToUse}][tipo_entrada]" value="${safeValue('tipo_entrada')}">
                <input type="hidden" name="tours[${indexToUse}][ruta1]" value="${safeValue('ruta1')}">
                <input type="hidden" name="tours[${indexToUse}][ruta2]" value="${safeValue('ruta2')}">
                <input type="hidden" name="tours[${indexToUse}][ruta3]" value="${safeValue('ruta3')}">
                <input type="hidden" name="tours[${indexToUse}][horario_entrada]" value="${safeValue('horario_entrada')}">

                <input type="hidden" name="tours[${indexToUse}][tipo_tren]" value="${safeValue('tipo_tren')}">
                <input type="hidden" name="tours[${indexToUse}][empresa_tren]" value="${safeValue('empresa_tren')}">
                <input type="hidden" name="tours[${indexToUse}][codigo_tren]" value="${safeValue('codigo_tren')}">
                <input type="hidden" name="tours[${indexToUse}][horario_ida]" value="${safeValue('horario_ida')}">
                <input type="hidden" name="tours[${indexToUse}][horario_retorno]" value="${safeValue('horario_retorno')}">
                <input type="hidden" name="tours[${indexToUse}][fecha_tren_ida]" value="${safeValue('fecha_tren_ida')}">
                <input type="hidden" name="tours[${indexToUse}][fecha_tren_retorno]" value="${safeValue('fecha_tren_retorno')}">

                <input type="hidden" name="tours[${indexToUse}][hay_entrada]" value="${safeValue('hay_entrada')}">
                <input type="hidden" name="tours[${indexToUse}][comentario_entrada]" value="${safeValue('comentario_entrada')}">
                <input type="hidden" name="tours[${indexToUse}][tiene_ticket]" value="${safeValue('tiene_ticket')}">
                <input type="hidden" name="tours[${indexToUse}][comentario_ticket]" value="${safeValue('comentario_ticket')}">

                <input type="hidden" name="tours[${indexToUse}][fecha_ida]" value="${safeValue('fecha_ida')}">
                <input type="hidden" name="tours[${indexToUse}][fecha_retorno]" value="${safeValue('fecha_retorno')}">
                <input type="hidden" name="tours[${indexToUse}][hospedaje]" value="${safeValue('hospedaje')}">
            `;

            // preview visible
            extrasPreview = `
                
                    <strong>Detalles Machupicchu:</strong><br>
                    Entrada: ${safeValue('tipo_entrada') || '-'}<br>
                    Horario entrada: ${safeValue('horario_entrada') || '-'}<br>
                    Tren: ${safeValue('tipo_tren') || '-'} (${safeValue('empresa_tren') || '-'})<br>
            `;

        }

        const li = document.createElement('li');
        li.classList.add('list-group-item');
        li.dataset.index = indexToUse;
        li.innerHTML = `
            <div><strong>Tour:</strong> ${nombre}</div>
            <div><strong>Fecha:</strong> ${fecha || '-'}</div>
            <div><strong>Empresa:</strong> ${empresa || '-'}</div>
            <div><strong>Precio:</strong> S/. ${precio || '0.00'}</div>
            <div><strong>Cantidad:</strong> ${cantidad}</div>
            <div><strong>Observaciones:</strong> ${observaciones || '-'}</div>
            ${extrasPreview}

            <input type="hidden" name="tours[${indexToUse}][tour_id]" value="${id}">
            <input type="hidden" name="tours[${indexToUse}][nombreTour]" value="${nombre}">
            <input type="hidden" name="tours[${indexToUse}][fecha]" value="${fecha}">
            <input type="hidden" name="tours[${indexToUse}][empresa]" value="${empresa}">
            <input type="hidden" name="tours[${indexToUse}][precio_unitario]" value="${precio}">
            <input type="hidden" name="tours[${indexToUse}][cantidad]" value="${cantidad}">
            <input type="hidden" name="tours[${indexToUse}][observaciones]" value="${observaciones}">
            ${extras}

            <div class="mt-2">
                <button type="button" class="btn btn-sm btn-warning" onclick="editarTour(${indexToUse})">Editar</button>
                <button type="button" class="btn btn-sm btn-danger" onclick="this.closest('li').remove(); actualizarCantidadTours();">Eliminar</button>
            </div>
        `;


        if (editMode) {
            const oldLi = document.querySelector(`li[data-index="${indexToUse}"]`);
            if (oldLi) oldLi.replaceWith(li);
        } else {
            listaToursAgregados.appendChild(li);
            tourIndex++;
        }

        actualizarCantidadTours();
        limpiarCamposTour();
    }

    function editarTour(index) {
        const li = document.querySelector(`li[data-index="${index}"]`);
        if (!li) return;

        document.getElementById('id_tour').value = li.querySelector(`input[name="tours[${index}][tour_id]"]`).value;
        document.getElementById('nombreTour').value = li.querySelector(`input[name="tours[${index}][nombreTour]"]`).value;
        document.getElementById('fecha_tour').value = li.querySelector(`input[name="tours[${index}][fecha]"]`).value;
        document.getElementById('empresa_tour').value = li.querySelector(`input[name="tours[${index}][empresa]"]`).value;
        document.getElementById('precio_unitario_tour').value = li.querySelector(`input[name="tours[${index}][precio_unitario]"]`).value;
        document.getElementById('cantidad_tour').value = li.querySelector(`input[name="tours[${index}][cantidad]"]`).value;
        document.getElementById('observaciones_tour').value = li.querySelector(`input[name="tours[${index}][observaciones]"]`).value;

        // Campos especiales Machupicchu (si existen)
        const specialFields = [
            'tipo_entrada', 'ruta1', 'ruta2', 'ruta3', 'horario_entrada',
            'tipo_tren', 'empresa_tren', 'codigo_tren', 'horario_ida', 'horario_retorno',
            'fecha_tren_ida', 'fecha_tren_retorno',
            'hay_entrada', 'comentario_entrada', 'tiene_ticket', 'comentario_ticket',
            'fecha_ida', 'fecha_retorno', 'hospedaje'
        ];
        specialFields.forEach(field => {
            const el = document.getElementById(field);
            if (el) el.value = li.querySelector(`input[name="tours[${index}][${field}]"]`)?.value || '';
        });

        document.getElementById('tour_edit_index').value = index;
        //document.getElementById('btnAgregarTour').style.display = 'none';
        document.getElementById('btnActualizarTour').style.display = 'inline-block';

        document.getElementById('tour_edit_index').value = index;
        setEditMode(true);   // mostrar "Actualizar", ocultar "Agregar"

    }

    function actualizarTour() {
        const index = document.getElementById('tour_edit_index').value;
        if (index === '') return;
        agregarTour(true, parseInt(index, 10)); // reusa el índice
        document.getElementById('tour_edit_index').value = '';
        setEditMode(false);  // volver a mostrar "Agregar"
    }

    function limpiarCamposTour() {
        const ids = [
            'select-tour', 'id_tour', 'nombreTour', 'fecha_tour', 'empresa_tour',
            'precio_unitario_tour', 'cantidad_tour', 'observaciones_tour',
            'tipo_entrada', 'ruta1', 'ruta2', 'ruta3', 'horario_entrada',
            'tipo_tren', 'empresa_tren', 'codigo_tren', 'horario_ida', 'horario_retorno',
            'fecha_tren_ida', 'fecha_tren_retorno', 'hay_entrada', 'comentario_entrada',
            'tiene_ticket', 'comentario_ticket', 'fecha_ida', 'fecha_retorno', 'hospedaje'
        ];
        ids.forEach(id => {
            const el = document.getElementById(id);
            if (el) el.value = '';
        });
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
