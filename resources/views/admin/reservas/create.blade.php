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
        <strong><label>Pasajeros seleccionados:</label></strong>
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
    <div class="row mb-2">
        <div class="col-md-4">
            <label for="total">Total ($):</label>
            <input type="number" step="0.01" name="total" id="total" class="form-control" required>
        </div>
        <div class="col-md-4">
            <label for="adelanto">Adelanto ($):</label>
            <input type="number" step="0.01" name="adelanto" id="adelanto" class="form-control">
        </div>
        <div class="col-md-4">
            <label for="saldo">Saldo ($):</label>
            <input type="number" step="0.01" name="saldo" id="saldo" class="form-control">
        </div>
    </div>

    <!-- TOURS (BUSCADOR + CAMPOS ADICIONALES) -->
    <div class="mb-3">
        <strong><label>Tours Contratados:</label></strong>

        <div class="border p-3 mb-2">
            <div class="row">

                <div class="row mb-3">
                    <!-- SELECCIONAR UN TOUR -->
                    <div class="col-md-4">
                        <label>Seleccione tour:</label>
                        <select id="select-tour" class="form-control">
                            <option value="">Seleccione</option>
                            @foreach($tours as $tour)
                                <option value="{{ $tour->id }}" data-nombre="{{ $tour->nombreTour }}">
                                    {{ $tour->nombreTour }}
                                </option>
                            @endforeach
                        </select>
                        <input type="hidden" id="id_tour">
                        <input type="hidden" id="nombreTour">
                    </div>

                    <!-- FECHA DE VISITA -->
                    <div class="col-md-4">
                        <label>Fecha de visita:</label>
                        <input type="date" id="fecha_tour" class="form-control">
                    </div>

                    <!-- TIPO DE SERIVICIO -->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Servicio:</label>
                            <select name="tipo_tour" id="tipo_tour" class="form-control">
                                <option value="Grupal">Grupal</option>
                                <option value="Privado">Privado</option>
                            </select>
                        </div>
                    </div>
                </div>


                <div class="row mb-2">
                    <!-- LUGAR DE RECOJO -->
                    <div class="col md">
                        <label>Lugar Recojo:</label>
                        <input type="text" id="lugar_recojo" class="form-control">
                    </div>

                    <!-- HORA DE RECOJO -->
                    <div class="col md">
                        <label>Hora de Recojo:</label>
                        <input type="text" id="hora_recojo" class="form-control">
                    </div>
                </div>


                <div class="row mb-3">
                    <!-- IDIOMA DEL TOUR -->
                    <div class="col-md-4">
                        <label>Idioma:</label>
                        <input type="text" id="idioma" class="form-control">
                    </div>

                    <!-- PRECIO POR PERSONA -->
                    <div class="col-md-4">
                        <label>Precio Unitario:</label>
                        <input type="number" id="precio_unitario_tour" step="0.01" class="form-control">
                    </div>

                    <!-- CANTIDAD DE PERSONAS QUE IRAN AL TOUR -->
                    <div class="col-md-4">
                        <label>Cantidad:</label>
                        <input type="number" id="cantidad_tour" min="1" value="1" class="form-control">
                    </div>
                </div>


                <div class="row mb-2">
                    <!-- EMPRESA QUE BRINDA EL TOUR -->
                    <div class="col md">
                        <div class="form-group" id="empresa_tour_field" style="display:none;">
                            <label>Empresa:</label>
                            <input type="text" id="empresa_tour" class="form-control">
                        </div>
                    </div>

                    <!-- OBSERVACIONES -->
                    <div class="col md">
                        <div class="form-group" id="observaciones_tour_field" style="display:none;">
                            <label>Observaciones:</label>
                            <input type="text" id="observaciones_tour" class="form-control">
                        </div>
                    </div>
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
                    </div>

                        <!-- horarios -->
                    <div id="tren-horarios-fields" style="display:none;">
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
                            <div class="row mb-2">
                                <div class="col mb">
                                    <div class="form-group">
                                        <label>Horario Ida</label>
                                        <input type="time" name="horario_ida" class="form-control">
                                    </div>
                                </div>
                                <div class="col mb">
                                    <div class="form-group">
                                        <label>Horario Retorno</label>
                                        <input type="time" name="horario_retorno" class="form-control">
                                    </div>
                                </div>
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

                {{-- === Boleto turístico (Valle Sagrado, City Tour, etc.) === --}}
                <div id="boleto-turistico-details" class="col-12 mt-3"
                    style="display:none; border-top:1px solid #ccc; padding-top:10px;">
                    <h5>Detalles Boleto Turístico</h5>

                    {{-- Tipo de boleto --}}
                    <div class="mb-2">
                        <label>Tipo de Boleto:</label>
                        <select class="form-control" id="tipo_boleto">
                            <option value="">-- Seleccionar --</option>
                            <option value="Integral">Integral</option>
                            <option value="Parcial">Parcial</option>
                        </select>
                    </div>

                    {{-- ¿Se debe comprar? --}}
                    <div class="mb-2">
                        <label>¿Se debe comprar?</label>
                        <select class="form-control" id="requiere_compra">
                            <option value="">-- Seleccionar --</option>
                            <option value="0">Ya tiene</option>
                            <option value="1">Tiene que comprar</option>
                        </select>
                    </div>

                    {{-- Tipo de compra (solo si requiere_compra = 1 ) --}}
                    <div id="tipo-compra-field" class="mb-2" style="display:none;">
                        <label>Tipo de Compra:</label>
                        <select class="form-control" id="tipo_compra">
                            <option value="">-- Seleccionar --</option>
                            <option value="Personal">Compra personal</option>
                            <option value="Guia">Compra por el guía</option>
                        </select>
                    </div>
                </div>


                <!-- Botones para agregar/actualizar tour -->
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
        <strong><label>Estadías:</label></strong>
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



    /* ---------------- CALCULAR SALDO SOLO FRONTEND ---------------- */
    document.addEventListener('DOMContentLoaded', function() {
        const totalInput = document.getElementById('total');
        const adelantoInput = document.getElementById('adelanto');
        const saldoInput = document.getElementById('saldo');
        
        function calcularSaldo() {
            const total = parseFloat(totalInput.value) || 0;
            const adelanto = parseFloat(adelantoInput.value) || 0;
            saldoInput.value = (total - adelanto).toFixed(2);
        }
        
        totalInput.addEventListener('input', calcularSaldo);
        adelantoInput.addEventListener('input', calcularSaldo);
        
        // Calcular inicialmente si hay valores
        calcularSaldo();
    });
    

    // Variables globales
    let nombreNormalizado = "";
    let tourSeleccionadoNormalizado = '';




/* ---------------- TOURS (MÚLTIPLES) ---------------- */
    const especiales = [
        'Machupicchu Full Day',
        'Machupicchu Conexión',
        'Machupicchu 2D/1N',
        'Machupicchu By car'
    ];
    const toursBoleto = [
        'valle sagrado',
        'city tour',
        'valle sur',
        'maras moray',
        'valle sagrado vip'
    ];

    // BOTONES
    function setEditMode(on) {
        const addBtn = document.getElementById('btnAgregarTour');
        const updBtn = document.getElementById('btnActualizarTour');
        if (addBtn) addBtn.style.display = on ? 'none' : 'inline-block';
        if (updBtn) updBtn.style.display = on ? 'inline-block' : 'none';
    }

    // SELECCION DE TOURS
    document.getElementById('select-tour').addEventListener('change', function() {
        limpiarCampos();
        const option = this.options[this.selectedIndex];
        const id = option.value;
        const nombre = (option.dataset.nombre || '').trim();
        tourSeleccionadoNormalizado = nombre.toLowerCase().trim();


        document.getElementById('id_tour').value = id;
        document.getElementById('nombreTour').value = nombre;
        document.getElementById('empresa_tour_field').style.display = 'block';
        document.getElementById('observaciones_tour_field').style.display = 'block';


        const nombreNormalizado = nombre.toLowerCase().trim();
        

        // === Machupicchu ===
        const especialesNormalizados = especiales.map(e => e.toLowerCase().trim());

        if (especialesNormalizados.includes(nombreNormalizado)) {
            document.getElementById('machupicchu-details').style.display = 'block';

            // Si es By Car
            if (nombreNormalizado  === 'machupicchu by car') {
                document.getElementById('bycar-fields').style.display = 'block';
                document.getElementById('empresa_tour_field').style.display = 'none';
                document.getElementById('observaciones_tour_field').style.display = 'none';
            } else {
                document.getElementById('bycar-fields').style.display = 'none';
                document.getElementById('empresa_tour_field').style.display = 'none';
                document.getElementById('observaciones_tour_field').style.display = 'none';
            }
        } else {
            document.getElementById('machupicchu-details').style.display = 'none';
            document.getElementById('bycar-fields').style.display = 'none';
        }

        // === Boleto turístico ===
        const nombreBoleto = nombreNormalizado;
        if (toursBoleto.includes(nombreBoleto)) {
            document.getElementById('boleto-turistico-details').style.display = 'block';
        } else {
            document.getElementById('boleto-turistico-details').style.display = 'none';
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

    // Tipo tren
    document.getElementById('tipo_tren').addEventListener('change', function() {
        if (this.value === 'Turístico') {
            document.getElementById('tren-turistico-fields').style.display = 'block';
            document.getElementById('tren-horarios-fields').style.display = 'block';
            document.getElementById('tren-local-fields').style.display = 'none';

            if (tourSeleccionadoNormalizado  === 'machupicchu full day') {
                document.getElementById('tren-fechas-fields').style.display = 'none';
            } else {
                document.getElementById('tren-fechas-fields').style.display = 'block';
            }

        } else if (this.value === 'Local') {
            document.getElementById('tren-turistico-fields').style.display = 'none';
            document.getElementById('tren-local-fields').style.display = 'block';

            // En Local siempre hay horarios
            document.getElementById('tren-horarios-fields').style.display = 'block';

            if (tourSeleccionadoNormalizado  === 'machupicchu full day') {
                document.getElementById('tren-fechas-fields').style.display = 'none';
            } else {
                document.getElementById('tren-fechas-fields').style.display = 'block';
            }

        } else {
            document.getElementById('tren-turistico-fields').style.display = 'none';
            document.getElementById('tren-local-fields').style.display = 'none';
            document.getElementById('tren-fechas-fields').style.display = 'none';
            document.getElementById('tren-horarios-fields').style.display = 'none';
        }
    });

    // Tiene ticket
    document.getElementById('tiene_ticket').addEventListener('change', function() {
        const tipoTren = document.getElementById('tipo_tren').value;

        if (this.value == '1') { // Tiene ticket
            document.getElementById('comentario-ticket-field').style.display = 'none';

        } else if (this.value == '0') { // No tiene ticket
            document.getElementById('ticket-fields').style.display = 'none';

            if (tourSeleccionadoNormalizado  !== 'machupicchu full day') {
                document.getElementById('tren-fechas-fields').style.display = 'block';
            } else {
                document.getElementById('tren-fechas-fields').style.display = 'none';
            }

            // Si es Local, igual mostrar horarios + comentario
            if (tipoTren === 'Local') {
                document.getElementById('tren-horarios-fields').style.display = 'block';
            } else {
                document.getElementById('tren-horarios-fields').style.display = 'block'; // Turístico también
            }

            document.getElementById('comentario-ticket-field').style.display = 'block';

        } else { // Sin selección
            document.getElementById('tren-fechas-fields').style.display = 'none';
            document.getElementById('tren-horarios-fields').style.display = 'none';
            document.getElementById('ticket-fields').style.display = 'none';
            document.getElementById('comentario-ticket-field').style.display = 'none';
        }
    });



    // ---------------- BOLETO TURÍSTICO ----------------
    document.getElementById('requiere_compra').addEventListener('change', function () {
        if (this.value == '1') {
            document.getElementById('tipo-compra-field').style.display = 'block';
        } else {
            document.getElementById('tipo-compra-field').style.display = 'none';
        }
    });




    //limpieza
    function limpiarCampos() {
        // Ocultar todos los contenedores que usas
        const bloques = [
            'machupicchu-details', 'boleto-turistico-details','bycar-fields',
            'entrada-fields', 'comentario-entrada-field',
            'ruta1-field', 'ruta2-field', 'ruta3-field',
            'tren-turistico-fields', 'tren-local-fields', 'tren-fechas-fields', 'tren-horarios-fields',
            'ticket-fields', 'comentario-ticket-field',
            'empresa_tour_field', 'observaciones_tour_field'
        ];

        bloques.forEach(id => {
            const el = document.getElementById(id);
            if (el) {
                el.style.display = 'none';
                // Limpiar valores de inputs y selects dentro del bloque
                el.querySelectorAll('input, select, textarea').forEach(input => {
                    if (input.type === 'checkbox' || input.type === 'radio') {
                        input.checked = false;
                    } else {
                        input.value = '';
                    }
                });
            }
        });
    }

    // --- Agregar tours y definir variables ---
    let tourIndex = 0;
    const listaToursAgregados = document.getElementById('listaToursAgregados');
    const cantidadToursInput = document.getElementById('cantidad_tours');

    function safeValue(id) {
        return document.getElementById(id)?.value || '';
    }

    // -------------AGREGAR TOUR----------------
    function agregarTour(editMode = false, customIndex = null) {
        const indexToUse = editMode && customIndex !== null ? customIndex : tourIndex;

        const id = safeValue('id_tour');
        const nombre = safeValue('nombreTour');
        const fecha = safeValue('fecha_tour');
        const empresa = safeValue('empresa_tour');
        const precio = safeValue('precio_unitario_tour');
        const cantidad = safeValue('cantidad_tour');
        const observaciones = safeValue('observaciones_tour');
        const nombreBoleto = nombre.toLowerCase().trim();


        if (!id) {
            alert("Selecciona un tour válido.");
            return;
        }

        // Normalizo para poder comparar con arrays de tours especiales
        const nombreNormalizado = nombre.toLowerCase().trim();

        let extras = '';
        let extrasPreview = '';

        // ---- MACHUPICCHU ----
        const especialesNormalizados = especiales.map(e => e.toLowerCase().trim());
        if (especialesNormalizados.includes(nombreNormalizado)) {
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
                    <strong>Entrada: </strong>${safeValue('tipo_entrada') || '-'}<br>
                    <strong>Horario entrada: </strong>${safeValue('horario_entrada') || '-'}<br>
                    <strong>Tren: </strong>${safeValue('tipo_tren') || '-'} (${safeValue('empresa_tren') || '-'})<br>
            `;

        }

        if (toursBoleto.includes(nombreBoleto)) {
            extras += `
                <input type="hidden" name="tours[${indexToUse}][detalles_boleto][tipo_boleto]" value="${safeValue('tipo_boleto')}">
                <input type="hidden" name="tours[${indexToUse}][detalles_boleto][requiere_compra]" value="${safeValue('requiere_compra')}">
                <input type="hidden" name="tours[${indexToUse}][detalles_boleto][tipo_compra]" value="${safeValue('tipo_compra')}">
            `;

            extrasPreview = `
                    <strong>Boleto turistico: </strong> ${safeValue('tipo_boleto') || '-'}<br>
                    <strong>Requiere compra? </strong> ${safeValue('requiere_compra') || '-'}<br>
                    <strong>Tipo de Compra: </strong> ${safeValue('tipo_compra') || '-'}<br>
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

    // -------------EDITAR TOUR----------------
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

        // Campos especiales
        const specialFields = [
            'tipo_entrada', 'ruta1', 'ruta2', 'ruta3', 'horario_entrada',
            'tipo_tren', 'empresa_tren', 'codigo_tren', 'horario_ida', 'horario_retorno',
            'fecha_tren_ida', 'fecha_tren_retorno',
            'hay_entrada', 'comentario_entrada', 'tiene_ticket', 'comentario_ticket',
            'fecha_ida', 'fecha_retorno', 'hospedaje'
        ];
        const boletoFields = ['tipo_boleto', 'requiere_compra', 'tipo_compra'];

        specialFields.forEach(field => {
            const el = document.getElementById(field);
            if (el) el.value = li.querySelector(`input[name="tours[${index}][${field}]"]`)?.value || '';
        });

        boletoFields.forEach(field => {
            const el = document.getElementById(field);
            if (el) {
                const hiddenInput = li.querySelector(`input[name="tours[${index}][detalles_boleto][${field}]"]`);
                el.value = hiddenInput ? hiddenInput.value : '';
            }
        });


        document.getElementById('tour_edit_index').value = index;
        document.getElementById('btnActualizarTour').style.display = 'inline-block';

        document.getElementById('tour_edit_index').value = index;
        setEditMode(true); 

    }

    // -------------ACTUALIZAR TOUR----------------
    function actualizarTour() {
        const index = document.getElementById('tour_edit_index').value;
        if (index === '') return;
        agregarTour(true, parseInt(index, 10)); // reusa el índice
        document.getElementById('tour_edit_index').value = '';
        setEditMode(false);  // volver a mostrar "Agregar"
    }

    // -------------LIMPIAR TOUR----------------
    function limpiarCamposTour() {
        const ids = [
            'select-tour', 'id_tour', 'nombreTour', 'fecha_tour', 'empresa_tour',
            'precio_unitario_tour', 'cantidad_tour', 'observaciones_tour',
            'tipo_entrada', 'ruta1', 'ruta2', 'ruta3', 'horario_entrada',
            'tipo_tren', 'empresa_tren', 'codigo_tren', 'horario_ida', 'horario_retorno',
            'fecha_tren_ida', 'fecha_tren_retorno', 'hay_entrada', 'comentario_entrada',
            'tiene_ticket', 'comentario_ticket', 'fecha_ida', 'fecha_retorno', 'hospedaje',
            'tipo_boleto', 'requiere_compra', 'tipo_compra'
        ];
        ids.forEach(id => {
            const el = document.getElementById(id);
            if (el) el.value = '';
        });
    }

    // -------------ACTUALIZAR CANT TOUR----------------
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
