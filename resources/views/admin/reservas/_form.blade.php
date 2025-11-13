{{-- FORMULARIO RESERVA (create & edit) --}}
@if($mode === 'create')
    <form action="{{ route('admin.reservas.store') }}" method="POST">
@else
    <form action="{{ route('admin.reservas.update', $reserva->id) }}" method="POST">
        @method('PUT')
@endif
@csrf

{{-- ============= SECCIÓN: INFORMACIÓN BÁSICA ============= --}}
<div class="form-section">
    <div class="section-header">
        <i class="fas fa-info-circle"></i>
        <h3>Información Básica</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <!-- TIPO DE RESERVA -->
            <div class="col-md-6 mb-3">
                <label for="tipo_reserva" class="form-label required">Tipo de Reserva</label>
                <select name="tipo_reserva" id="tipo_reserva" class="form-select" required>
                    <option value="">-- Seleccionar tipo --</option>
                    @foreach(['Directo','Recomendacion','Publicidad','Agencia'] as $tipo)
                        <option value="{{ $tipo }}" {{ old('tipo_reserva', $reserva->tipo_reserva ?? '') == $tipo ? 'selected' : '' }}>
                            {{ $tipo }}
                        </option>
                    @endforeach
                </select>
            </div>

            @php $tipoActual = old('tipo_reserva', $reserva->tipo_reserva ?? ''); @endphp

            <!-- PROVEEDOR -->
            <div class="col-md-6 mb-3" id="proveedor_container" style="{{ $tipoActual === 'Agencia' ? '' : 'display:none' }}">
                <label for="proveedor_id" class="form-label">Proveedor</label>
                <select name="proveedor_id" id="proveedor_id" class="form-select">
                    <option value="">-- Seleccionar proveedor --</option>
                    @foreach($proveedores as $proveedor)
                        <option value="{{ $proveedor->id }}" {{ (string)old('proveedor_id', $reserva->proveedor_id ?? '') === (string)$proveedor->id ? 'selected' : '' }}>
                            {{ $proveedor->nombreAgencia ?? $proveedor->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>

{{-- ============= SECCIÓN: TITULAR Y PASAJEROS ============= --}}
<div class="form-section">
    <div class="section-header">
        <i class="fas fa-users"></i>
        <h3>Titular y Pasajeros</h3>
    </div>
    <div class="section-body">
        <!-- TITULAR -->
        <div class="subsection">
            <h4 class="subsection-title">Titular de la Reserva</h4>
            <div class="row align-items-end">
                <div class="col-md-8 mb-3">
                    <label for="busquedaTitular" class="form-label">Buscar Titular</label>
                    <input list="listaTitulares" id="busquedaTitular" class="form-control" placeholder="Escribe nombre del pasajero...">
                    <datalist id="listaTitulares">
                        @foreach($pasajeros as $p)
                            <option value="{{ $p->nombre }} {{ $p->apellido }} ({{ $p->documento }})" data-id="{{ $p->id }}"></option>
                        @endforeach
                    </datalist>
                    <input type="hidden" name="titular_id" id="titular_id_hidden" value="{{ old('titular_id', $reserva->titular_id ?? '') }}">
                </div>
                <div class="col-md-4 mb-3">
                    <button type="button" id="btnSeleccionarTitular" class="btn btn-reserva w-100">
                        <i class="fas fa-check"></i> Seleccionar
                    </button>
                </div>
            </div>

            <div id="titularSeleccionado">
                @if(old('titular_id', $reserva->titular_id ?? false))
                    @php $titSel = $pasajeros->firstWhere('id', old('titular_id', $reserva->titular_id ?? null)); @endphp
                    @if($titSel)
                        <div class="selected-item">
                            <i class="fas fa-user-check"></i>
                            <strong>{{ $titSel->nombre }} {{ $titSel->apellido }}</strong>
                            <span class="text-muted">({{ $titSel->documento }})</span>
                            <button type="button" id="btnLimpiarTitular" class="btn-remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    @endif
                @endif
            </div>
        </div>

        <!-- PASAJEROS -->
        <div class="subsection mt-4">
            <h4 class="subsection-title">Pasajeros Adicionales</h4>
            <div class="row align-items-end">
                <div class="col-md-8 mb-3">
                    <label for="busquedaPasajero" class="form-label">Buscar Pasajeros</label>
                    <input list="listaPasajeros" id="busquedaPasajero" class="form-control" placeholder="Escribe el nombre del pasajero...">
                    <datalist id="listaPasajeros">
                        @foreach($pasajeros as $pasajero)
                            <option value="{{ $pasajero->nombre }} {{ $pasajero->apellido }} ({{ $pasajero->documento }})" data-id="{{ $pasajero->id }}"></option>
                        @endforeach
                    </datalist>
                </div>
                <div class="col-md-4 mb-3">
                    <button type="button" onclick="agregarPasajero()" class="btn btn-agregar w-100">
                        <i class="fas fa-plus"></i> Agregar
                    </button>
                </div>
            </div>

            <div id="pasajerosSeleccionados">
                <ul id="listaPasajerosAgregados" class="selected-list">
                    @php
                        $pasajerosOld = old('pasajeros', $mode === 'edit' ? ($reserva->pasajeros->pluck('id')->toArray() ?? []) : []);
                    @endphp
                    @foreach($pasajerosOld as $pid)
                        @php $p = $pasajeros->firstWhere('id', $pid); @endphp
                        @if($p)
                            <li class="selected-item" data-id="{{ $p->id }}">
                                <i class="fas fa-user"></i>
                                <span>{{ $p->nombre }} {{ $p->apellido }} ({{ $p->documento }})</span>
                                <input type="hidden" name="pasajeros[]" value="{{ $p->id }}">
                                <button type="button" class="btn-remove" onclick="eliminarPasajero(this, '{{ $p->id }}')">
                                    <i class="fas fa-times"></i>
                                </button>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>

        <input type="hidden" name="cantidad_pasajeros" id="cantidad_pasajeros" value="{{ count($pasajerosOld) }}">
    </div>
</div>

{{-- ============= SECCIÓN: FECHAS Y VUELOS ============= --}}
<div class="form-section">
    <div class="section-header">
        <i class="fas fa-plane"></i>
        <h3>Fechas y Vuelos</h3>
    </div>
    <div class="section-body">
        <div class="subsection">
            <h4 class="subsection-title">Llegada</h4>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="fecha_llegada" class="form-label">Fecha</label>
                    <input type="date" name="fecha_llegada" id="fecha_llegada" class="form-control" 
                        value="{{ old('fecha_llegada', $reserva->fecha_llegada ? $reserva->fecha_llegada->format('Y-m-d') : '') }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="hora_llegada" class="form-label">Hora</label>
                    <input type="time" name="hora_llegada" id="hora_llegada" class="form-control" value="{{ old('hora_llegada', $reserva->hora_llegada ?? '') }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="nro_vuelo_llegada" class="form-label">N° Vuelo</label>
                    <input type="text" name="nro_vuelo_llegada" id="nro_vuelo_llegada" class="form-control" value="{{ old('nro_vuelo_llegada', $reserva->nro_vuelo_llegada ?? '') }}">
                </div>
            </div>
        </div>

        <div class="subsection mt-3">
            <h4 class="subsection-title">Salida</h4>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="fecha_salida" class="form-label">Fecha</label>
                    <input type="date" name="fecha_salida" id="fecha_salida" class="form-control" 
                        value="{{ old('fecha_salida', $reserva->fecha_salida ? $reserva->fecha_salida->format('Y-m-d') : '') }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="hora_salida" class="form-label">Hora</label>
                    <input type="time" name="hora_salida" id="hora_salida" class="form-control" value="{{ old('hora_salida', $reserva->hora_salida ?? '') }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="nro_vuelo_salida" class="form-label">N° Vuelo</label>
                    <input type="text" name="nro_vuelo_salida" id="nro_vuelo_salida" class="form-control" value="{{ old('nro_vuelo_salida', $reserva->nro_vuelo_salida ?? '') }}">
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ============= SECCIÓN: PAGOS ============= --}}
<div class="form-section">
    <div class="section-header">
        <i class="fas fa-dollar-sign"></i>
        <h3>Información de Pago</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="total" class="form-label">Total ($)</label>
                <input type="number" step="0.01" name="total" id="total" class="form-control" value="{{ old('total', $reserva->total ?? '') }}">
            </div>
            <div class="col-md-4 mb-3">
                <label for="adelanto" class="form-label">Adelanto ($)</label>
                <input type="number" step="0.01" name="adelanto" id="adelanto" class="form-control" value="{{ old('adelanto', $reserva->adelanto ?? '') }}">
            </div>
            <div class="col-md-4 mb-3">
                <label for="saldo" class="form-label">Saldo ($)</label>
                <input type="number" step="0.01" id="saldo" class="form-control saldo-display" readonly>
            </div>
        </div>
    </div>
</div>

{{-- ============= SECCIÓN: TOURS ============= --}}
<div class="form-section">
    <div class="section-header">
        <i class="fas fa-map-marked-alt"></i>
        <h3>Tours Contratados</h3>
    </div>
    <div class="section-body">
        <div id="form-tours" class="edit-card">
            <div class="row">
                <!-- BÁSICO DEL TOUR -->
                <div class="col-md-4 mb-3">
                    <label class="form-label">Tour</label>
                    <select id="select-tour" class="form-select">
                        <option value="">-- Seleccione --</option>
                        @foreach($tours as $tour)
                            <option value="{{ $tour->id }}" data-nombre="{{ $tour->nombreTour }}">{{ $tour->nombreTour }}</option>
                        @endforeach
                    </select>
                    <input type="hidden" id="id_tour">
                    <input type="hidden" id="nombreTour">
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Fecha de Visita</label>
                    <input type="date" id="fecha" class="form-control" name="fecha">
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Servicio</label>
                    <select name="tipo_tour" id="tipo_tour" class="form-select">
                        <option value="Grupal">Grupal</option>
                        <option value="Privado">Privado</option>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Lugar Recojo</label>
                    <input type="text" id="lugar_recojo" class="form-control" name="lugar_recojo">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Hora de Recojo</label>
                    <input type="time" id="hora_recojo" class="form-control" name="hora_recojo">
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Idioma</label>
                    <input type="text" id="idioma" class="form-control" name="idioma">
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Precio Unitario</label>
                    <input type="number" id="precio_unitario" step="0.01" class="form-control" name="precio_unitario">
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Cantidad</label>
                    <input type="number" id="cantidad" min="1" value="1" class="form-control" name="cantidad">
                </div>

                <div class="col-md-6 mb-3" id="empresa_tour_field" style="display:none;">
                    <label class="form-label">Empresa</label>
                    <input type="text" id="empresa" class="form-control" name="empresa">
                </div>

                <div class="col-md-6 mb-3" id="observaciones_tour_field" style="display:none;">
                    <label class="form-label">Observaciones</label>
                    <input type="text" id="observaciones" class="form-control" name="observaciones">
                </div>

                {{-- DETALLES MACHUPICCHU --}}
                <div id="machupicchu-details" class="col-12 mt-3 conditional-section" style="display:none;">
                    <div class="conditional-header">
                        <i class="fas fa-mountain"></i>
                        <h5>Detalles Machupicchu</h5>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">¿Hay entrada?</label>
                            <select name="hay_entrada" id="hay_entrada" class="form-select">
                                <option value="">-- Seleccione --</option>
                                <option value="1">Sí</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                    </div>

                    <div id="entrada-fields" style="display:none;">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Circuito</label>
                                <select name="tipo_entrada" id="tipo_entrada" class="form-select">
                                    <option value="">-- Seleccione --</option>
                                    <option value="circuito1">Circuito 1</option>
                                    <option value="circuito2">Circuito 2</option>
                                    <option value="circuito3">Circuito 3</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3" id="ruta1-field" style="display:none;">
                                <label class="form-label">Ruta</label>
                                <select id="ruta1" class="form-select" name="ruta1">
                                    <option value="">-- Seleccione --</option>
                                    <option value="ruta1a">Ruta 1-A: Montaña Machupicchu</option>
                                    <option value="ruta1b">Ruta 1-B: Terraza superior</option>
                                    <option value="ruta1c">Ruta 1-C: Portada Intipunku</option>
                                    <option value="ruta1d">Ruta 1-D: Puente Inka</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3" id="ruta2-field" style="display:none;">
                                <label class="form-label">Ruta</label>
                                <select id="ruta2" class="form-select" name="ruta2">
                                    <option value="">-- Seleccione --</option>
                                    <option value="ruta2a">Ruta 2-A: Clásico diseñada</option>
                                    <option value="ruta2b">Ruta 2-B: Terraza inferior</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3" id="ruta3-field" style="display:none;">
                                <label class="form-label">Ruta</label>
                                <select id="ruta3" class="form-select" name="ruta3">
                                    <option value="">-- Seleccione --</option>
                                    <option value="ruta3a">Ruta 3-A: Montaña Waynapicchu</option>
                                    <option value="ruta3b">Ruta 3-B: Realeza diseñada</option>
                                    <option value="ruta3c">Ruta 3-C: Gran Caverna</option>
                                    <option value="ruta3d">Ruta 3-D: Huchuypicchu</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Horario Entrada</label>
                                <input type="time" id="horario_entrada" class="form-control" name="horario_entrada">
                            </div>
                        </div>
                    </div>

                    <div id="comentario-entrada-field" class="mb-3" style="display:none;">
                        <label class="form-label">Observación entrada</label>
                        <input type="text" name="comentario_entrada" id="comentario_entrada" class="form-control" placeholder="Ej: Tramitar en pueblo">
                    </div>

                    <hr class="my-4">

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tipo de Tren</label>
                            <select name="tipo_tren" id="tipo_tren" class="form-select">
                                <option value="">-- Seleccione --</option>
                                <option value="Turístico">Tren Turístico</option>
                                <option value="Local">Tren Local</option>
                            </select>
                        </div>
                    </div>

                    <div id="tren-turistico-fields" style="display:none;">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Empresa de Tren</label>
                                <select name="empresa_tren" class="form-select" id="empresa_tren">
                                    <option value="">-- Seleccione --</option>
                                    <option value="Inca Rail">Inca Rail</option>
                                    <option value="Peru Rail">Peru Rail</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Código de Tren</label>
                                <input type="text" name="codigo_tren" class="form-control" id="codigo_tren" placeholder="Ej: 1234AB">
                            </div>
                        </div>
                    </div>

                    <div id="tren-horarios-fields" style="display:none;">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Horario Ida</label>
                                <input type="time" name="horario_ida" class="form-control" id="horario_ida_tren">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Horario Retorno</label>
                                <input type="time" name="horario_retorno" class="form-control" id="horario_retorno_tren">
                            </div>
                        </div>
                    </div>

                    <div id="tren-local-fields" style="display:none;">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">¿Tiene Ticket?</label>
                                <select name="tiene_ticket" id="tiene_ticket" class="form-select">
                                    <option value="">-- Seleccione --</option>
                                    <option value="1">Sí</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                        </div>

                        <div id="ticket-fields" style="display:none;">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Horario Ida</label>
                                    <input type="time" name="horario_ida_ticket" class="form-control" id="horario_ida_ticket">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Horario Retorno</label>
                                    <input type="time" name="horario_retorno_ticket" class="form-control" id="horario_retorno_ticket">
                                </div>
                            </div>
                        </div>

                        <div id="comentario-ticket-field" class="mb-3" style="display:none;">
                            <label class="form-label">Comentario Ticket</label>
                            <input type="text" name="comentario_ticket" class="form-control" placeholder="Ej: Hacer cola" id="comentario_ticket">
                        </div>
                    </div>

                    <div id="tren-fechas-fields" style="display:none;">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Fecha Tren Ida</label>
                                <input type="date" name="fecha_tren_ida" class="form-control" id="fecha_tren_ida">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Fecha Tren Retorno</label>
                                <input type="date" name="fecha_tren_retorno" class="form-control" id="fecha_tren_retorno">
                            </div>
                        </div>
                    </div>

                    <div class="hospedaje-fields mb-3" style="display:none;">
                        <label class="form-label">Hospedaje</label>
                        <input type="text" name="hospedaje" class="form-control" id="hospedaje" placeholder="Ej: Hotel Inka">
                    </div>

                    <hr class="my-4">

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Transporte de ida</label>
                            <select name="transp_ida" id="transp_ida" class="form-select">
                                <option value="">-- Seleccione --</option>
                                <option value="busLucy">Bus Lucy</option>
                                <option value="Bimodal">Bimodal</option>
                                <option value="BimodalDoor">Bimodal Door</option>
                                <option value="Privado">Transporte Privado</option>
                                <option value="otro">Otro</option>
                                <option value="porCuentaPropia">Por cuenta propia</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3" id="horario_recojo_ida-field" style="display:none;">
                            <label class="form-label">Horario de recojo</label>
                            <input type="time" name="horario_recojo_ida" class="form-control" id="horario_recojo_ida">
                        </div>

                        <div class="col-md-12 mb-3" id="comentario_trans_ida-field" style="display:none;">
                            <label class="form-label">Observación</label>
                            <input type="text" name="comentario_trans_ida" class="form-control" id="comentario_trans_ida">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Transporte de retorno</label>
                            <select name="transp_ret" id="transp_ret" class="form-select">
                                <option value="">-- Seleccione --</option>
                                <option value="busLucy">Bus Lucy</option>
                                <option value="Bimodal">Bimodal</option>
                                <option value="BimodalDoor">Bimodal Door</option>
                                <option value="Privado">Transporte Privado</option>
                                <option value="otro">Otro</option>
                                <option value="porCuentaPropia">Por cuenta propia</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3" id="horario_recojo_ret-field" style="display:none;">
                            <label class="form-label">Horario de recojo</label>
                            <input type="time" name="horario_recojo_ret" class="form-control" id="horario_recojo_ret">
                        </div>

                        <div class="col-md-12 mb-3" id="comentario_trans_ret-field" style="display:none;">
                            <label class="form-label">Observación</label>
                            <input type="text" name="comentario_trans_ret" class="form-control" id="comentario_trans_ret">
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">¿Consetur o irá a pie?</label>
                            <select name="tipo_servicio" id="tipo_servicio" class="form-select">
                                <option value="">-- Seleccione --</option>
                                <option value="Comprar">Comprar</option>
                                <option value="Caminando">Caminando</option>
                                <option value="Tiene">Tiene</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3" id="tipo_consetur-field" style="display:none;">
                            <label class="form-label">Tipo de Consetur</label>
                            <select name="tipo_consetur" class="form-select" id="tipo_consetur">
                                <option value="">-- Seleccione --</option>
                                <option value="ambos">Ida y Retorno</option>
                                <option value="ida">Ida</option>
                                <option value="ret">Retorno</option>
                            </select>
                        </div>

                        <div class="col-md-12 mb-3" id="comentario_consetur-field" style="display:none;">
                            <label class="form-label">Observación consetur</label>
                            <input type="text" name="comentario_consetur" class="form-control" placeholder="Ej: Tramitar en pueblo" id="comentario_consetur">
                        </div>
                    </div>

                    <div id="bycar-fields" style="display:none;">
                        <hr class="my-4">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Hospedaje</label>
                                <input type="text" name="hospedaje" class="form-control" id="hospedaje_bycar" placeholder="Ej: Hotel Inka">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- DETALLES BOLETO TURÍSTICO --}}
                <div id="boleto-turistico-details" class="col-12 mt-3 conditional-section" style="display:none;">
                    <div class="conditional-header">
                        <i class="fas fa-ticket-alt"></i>
                        <h5>Detalles Boleto Turístico</h5>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tipo de Boleto</label>
                            <select class="form-select" id="tipo_boleto" name="tipo_boleto">
                                <option value="">-- Seleccionar --</option>
                                <option value="Integral">Boleto Integral</option>
                                <option value="Parcial">Boleto Parcial</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3" id="requiere_compra-field" style="display:none;">
                            <label class="form-label">¿Se debe comprar?</label>
                            <select class="form-select" id="requiere_compra" name="requiere_compra">
                                <option value="">-- Seleccionar --</option>
                                <option value="0">Ya tiene</option>
                                <option value="1">Tiene que comprar</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3" id="tipo_compra-field" style="display:none;">
                            <label class="form-label">Tipo de Compra</label>
                            <select class="form-select" id="tipo_compra" name="tipo_compra">
                                <option value="">-- Seleccionar --</option>
                                <option value="Personal">Compra personal</option>
                                <option value="Guia">Compra por el guía</option>
                            </select>
                        </div>
                    </div>

                    <div id="lugares-priv-fields" style="display:none;">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">¿Incluye entrada a <strong id="nombrePropiedadPrivada"></strong>?</label>
                                <select class="form-select" id="incluye_entrada_propiedad_priv" name="incluye_entrada_propiedad_priv">
                                    <option value="">-- Seleccionar --</option>
                                    <option value="1">Sí</option>
                                    <option value="0">No</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3" id="quien-compra-field" style="display:none;">
                                <label class="form-label">¿Quién compra la entrada?</label>
                                <select class="form-select" name="quien_compra_propiedad_priv" id="quien_compra_propiedad_priv">
                                    <option value="">-- Seleccionar --</option>
                                    <option value="guia">Guía</option>
                                    <option value="pasajero">Pasajero</option>
                                </select>
                            </div>

                            <div class="col-md-12 mb-3" id="comentario-entrada-priv-field" style="display:none;">
                                <label class="form-label">Comentario</label>
                                <input type="text" name="comentario_entrada_propiedad_priv" class="form-control" id="comentario_entrada_propiedad_priv" placeholder="Ej: Tramitar en pueblo">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 text-end mt-4">
                    <button type="button" class="btn btn-actualizar" id="btn-agregar-tour" onclick="agregarTour()">
                        <i class="fas fa-plus-circle"></i> Agregar Tour
                    </button>
                </div>
            </div>
        </div>

        <ul id="listaToursAgregados" class="selected-list mt-3">
            @if($mode === 'edit')
                @foreach($reserva->toursReservas as $i => $tour)
                    <li class="tour-item">
                        <div class="tour-item-header">
                            <i class="fas fa-map-marker-alt"></i>
                            <strong>{{ $tour->tour->nombreTour }}</strong>
                            <span class="badge badge-info">{{ $tour->tipo_tour ?? 'Grupal' }}</span>
                        </div>
                        <div class="tour-item-body">
                            <div class="tour-detail"><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($tour->fecha)->format('d/m/Y') }}</div>
                            <div class="tour-detail"><strong>Recojo:</strong> {{ $tour->lugar_recojo ?? '-' }} a las {{ $tour->hora_recojo ? \Carbon\Carbon::parse($tour->hora_recojo)->format('H:i') : '-' }}</div>
                            <div class="tour-detail"><strong>Idioma:</strong> {{ $tour->idioma ?? '-' }}</div>
                            <div class="tour-detail"><strong>Precio:</strong> S/. {{ number_format($tour->precio_unitario ?? 0, 2) }} x {{ $tour->cantidad ?? 1 }}</div>
                        </div>

                        {{-- Inputs ocultos --}}
                        <input type="hidden" name="tours[{{ $i }}][id]" value="{{ $tour->id }}">
                        <input type="hidden" name="tours[{{ $i }}][tour_id]" value="{{ $tour->tour_id }}">
                        <input type="hidden" name="tours[{{ $i }}][nombreTour]" value="{{ $tour->tour->nombreTour }}">
                        <input type="hidden" name="tours[{{ $i }}][fecha]" value="{{ $tour->fecha }}">
                        <input type="hidden" name="tours[{{ $i }}][tipo_tour]" value="{{ $tour->tipo_tour }}">
                        <input type="hidden" name="tours[{{ $i }}][lugar_recojo]" value="{{ $tour->lugar_recojo }}">
                        <input type="hidden" name="tours[{{ $i }}][hora_recojo]" value="{{ $tour->hora_recojo }}">
                        <input type="hidden" name="tours[{{ $i }}][idioma]" value="{{ $tour->idioma }}">
                        <input type="hidden" name="tours[{{ $i }}][empresa]" value="{{ $tour->empresa }}">
                        <input type="hidden" name="tours[{{ $i }}][precio_unitario]" value="{{ $tour->precio_unitario }}">
                        <input type="hidden" name="tours[{{ $i }}][cantidad]" value="{{ $tour->cantidad }}">
                        <input type="hidden" name="tours[{{ $i }}][observaciones]" value="{{ $tour->observaciones }}">

                        @if($tour->detalleMachupicchu)
                            <input type="hidden" name="tours[{{ $i }}][detalles_machu][tipo_entrada]" value="{{ $tour->detalleMachupicchu->tipo_entrada }}">
                            <input type="hidden" name="tours[{{ $i }}][detalles_machu][ruta1]" value="{{ $tour->detalleMachupicchu->ruta1 }}">
                            <input type="hidden" name="tours[{{ $i }}][detalles_machu][ruta2]" value="{{ $tour->detalleMachupicchu->ruta2 }}">
                            <input type="hidden" name="tours[{{ $i }}][detalles_machu][ruta3]" value="{{ $tour->detalleMachupicchu->ruta3 }}">
                            <input type="hidden" name="tours[{{ $i }}][detalles_machu][horario_entrada]" value="{{ $tour->detalleMachupicchu->horario_entrada }}">
                            <input type="hidden" name="tours[{{ $i }}][detalles_machu][tipo_tren]" value="{{ $tour->detalleMachupicchu->tipo_tren }}">
                            <input type="hidden" name="tours[{{ $i }}][detalles_machu][empresa_tren]" value="{{ $tour->detalleMachupicchu->empresa_tren }}">
                            <input type="hidden" name="tours[{{ $i }}][detalles_machu][codigo_tren]" value="{{ $tour->detalleMachupicchu->codigo_tren }}">
                            <input type="hidden" name="tours[{{ $i }}][detalles_machu][horario_ida]" value="{{ $tour->detalleMachupicchu->horario_ida }}">
                            <input type="hidden" name="tours[{{ $i }}][detalles_machu][horario_retorno]" value="{{ $tour->detalleMachupicchu->horario_retorno }}">
                            <input type="hidden" name="tours[{{ $i }}][detalles_machu][fecha_tren_ida]" value="{{ $tour->detalleMachupicchu->fecha_tren_ida }}">
                            <input type="hidden" name="tours[{{ $i }}][detalles_machu][fecha_tren_retorno]" value="{{ $tour->detalleMachupicchu->fecha_tren_retorno }}">
                            <input type="hidden" name="tours[{{ $i }}][detalles_machu][hay_entrada]" value="{{ $tour->detalleMachupicchu->hay_entrada }}">
                            <input type="hidden" name="tours[{{ $i }}][detalles_machu][comentario_entrada]" value="{{ $tour->detalleMachupicchu->comentario_entrada }}">
                            <input type="hidden" name="tours[{{ $i }}][detalles_machu][tiene_ticket]" value="{{ $tour->detalleMachupicchu->tiene_ticket }}">
                            <input type="hidden" name="tours[{{ $i }}][detalles_machu][comentario_ticket]" value="{{ $tour->detalleMachupicchu->comentario_ticket }}">
                            <input type="hidden" name="tours[{{ $i }}][detalles_machu][fecha_ida]" value="{{ $tour->detalleMachupicchu->fecha_ida }}">
                            <input type="hidden" name="tours[{{ $i }}][detalles_machu][fecha_retorno]" value="{{ $tour->detalleMachupicchu->fecha_retorno }}">
                            <input type="hidden" name="tours[{{ $i }}][detalles_machu][hospedaje]" value="{{ $tour->detalleMachupicchu->hospedaje }}">
                            <input type="hidden" name="tours[{{ $i }}][detalles_machu][transp_ida]" value="{{ $tour->detalleMachupicchu->transp_ida }}">
                            <input type="hidden" name="tours[{{ $i }}][detalles_machu][horario_recojo_ida]" value="{{ $tour->detalleMachupicchu->horario_recojo_ida }}">
                            <input type="hidden" name="tours[{{ $i }}][detalles_machu][comentario_trans_ida]" value="{{ $tour->detalleMachupicchu->comentario_trans_ida }}">
                            <input type="hidden" name="tours[{{ $i }}][detalles_machu][transp_ret]" value="{{ $tour->detalleMachupicchu->transp_ret }}">
                            <input type="hidden" name="tours[{{ $i }}][detalles_machu][horario_recojo_ret]" value="{{ $tour->detalleMachupicchu->horario_recojo_ret }}">
                            <input type="hidden" name="tours[{{ $i }}][detalles_machu][comentario_trans_ret]" value="{{ $tour->detalleMachupicchu->comentario_trans_ret }}">
                            <input type="hidden" name="tours[{{ $i }}][detalles_machu][tipo_servicio]" value="{{ $tour->detalleMachupicchu->tipo_servicio }}">
                            <input type="hidden" name="tours[{{ $i }}][detalles_machu][tipo_consetur]" value="{{ $tour->detalleMachupicchu->tipo_consetur }}">
                            <input type="hidden" name="tours[{{ $i }}][detalles_machu][comentario_consetur]" value="{{ $tour->detalleMachupicchu->comentario_consetur }}">
                        @endif

                        @if($tour->detalleBoletoTuristico)
                            <input type="hidden" name="tours[{{ $i }}][detalles_boleto][tipo_boleto]" value="{{ $tour->detalleBoletoTuristico->tipo_boleto }}">
                            <input type="hidden" name="tours[{{ $i }}][detalles_boleto][requiere_compra]" value="{{ $tour->detalleBoletoTuristico->requiere_compra }}">
                            <input type="hidden" name="tours[{{ $i }}][detalles_boleto][tipo_compra]" value="{{ $tour->detalleBoletoTuristico->tipo_compra }}">
                            <input type="hidden" name="tours[{{ $i }}][detalles_boleto][incluye_entrada_propiedad_priv]" value="{{ $tour->detalleBoletoTuristico->incluye_entrada_propiedad_priv }}">
                            <input type="hidden" name="tours[{{ $i }}][detalles_boleto][quien_compra_propiedad_priv]" value="{{ $tour->detalleBoletoTuristico->quien_compra_propiedad_priv }}">
                            <input type="hidden" name="tours[{{ $i }}][detalles_boleto][comentario_entrada_propiedad_priv]" value="{{ $tour->detalleBoletoTuristico->comentario_entrada_propiedad_priv }}">
                        @endif

                        <div class="tour-item-actions">
                            <button type="button" class="btn btn-sm btn-edit" onclick="editarTour(this)">
                                <i class="fas fa-edit"></i> Editar
                            </button>
                            <button type="button" class="btn btn-sm btn-delete" onclick="eliminarTour(this)">
                                <i class="fas fa-trash"></i> Eliminar
                            </button>
                        </div>
                    </li>
                @endforeach
            @endif
        </ul>
    </div>
</div>

<input type="hidden" name="cantidad_tours" id="cantidad_tours" value="{{ $mode === 'edit' ? $reserva->toursReservas->count() : 0 }}">

{{-- ============= SECCIÓN: ESTADÍAS ============= --}}
<div class="form-section">
    <div class="section-header">
        <i class="fas fa-hotel"></i>
        <h3>Estadías</h3>
    </div>
    <div class="section-body">
        <div id="form-estadia" class="edit-card">
            <div class="row">
                <div class="col-md-3 mb-3">
                    <label class="form-label">Tipo</label>
                    <select id="tipo_estadia_input" class="form-select" name="tipo_estadia_input">
                        <option value="Hostal">Hotel</option>
                        <option value="Hospedaje">Hospedaje</option>
                        <option value="Airbnb">Airbnb</option>
                    </select>
                </div>

                <div class="col-md-3 mb-3">
                    <label class="form-label">Nombre</label>
                    <input type="text" id="nombre_estadia_input" class="form-control" name="nombre_estadia_input">
                </div>

                <div class="col-md-3 mb-3">
                    <label class="form-label">Ubicación</label>
                    <input type="text" id="ubicacion_estadia_input" class="form-control" name="ubicacion_estadia_input">
                </div>

                <div class="col-md-3 mb-3">
                    <label class="form-label">Fecha</label>
                    <input type="date" id="fecha_estadia_input" class="form-control" name="fecha_estadia_input">
                </div>

                <div class="col-md-9 mb-3">
                    <label class="form-label">Habitación</label>
                    <input type="text" id="habitacion_estadia_input" class="form-control" name="habitacion_estadia_input">
                </div>

                <div class="col-md-3 mb-3 d-flex align-items-end">
                    <button type="button" class="btn btn-actualizar w-100" id="btn-agregar-estadia" onclick="agregarEstadia()">
                        <i class="fas fa-plus-circle"></i> Agregar
                    </button>
                </div>
            </div>
        </div>

        <ul id="listaEstadiasAgregadas" class="selected-list mt-3">
            @if($mode === 'edit')
                @foreach($reserva->estadias as $i => $estadia)
                    <li class="estadia-item">
                        <div class="estadia-info">
                            <i class="fas fa-bed"></i>
                            <div>
                                <strong>{{ $estadia->nombre_estadia }}</strong>
                                <div class="estadia-details">
                                    <span class="badge badge-secondary">{{ $estadia->tipo_estadia }}</span>
                                    <span>{{ $estadia->ubicacion }}</span>
                                    <span>{{ \Carbon\Carbon::parse($estadia->fecha)->format('d/m/Y') }}</span>
                                    <span>Hab: {{ $estadia->habitacion }}</span>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="estadias[{{ $i }}][tipo_estadia]" value="{{ $estadia->tipo_estadia }}">
                        <input type="hidden" name="estadias[{{ $i }}][nombre_estadia]" value="{{ $estadia->nombre_estadia }}">
                        <input type="hidden" name="estadias[{{ $i }}][ubicacion]" value="{{ $estadia->ubicacion }}">
                        <input type="hidden" name="estadias[{{ $i }}][fecha]" value="{{ $estadia->fecha }}">
                        <input type="hidden" name="estadias[{{ $i }}][habitacion]" value="{{ $estadia->habitacion }}">

                        <div class="estadia-actions">
                            <button type="button" class="btn btn-sm btn-edit" onclick="editarEstadia(this)">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-delete" onclick="eliminarEstadia(this)">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </li>
                @endforeach
            @endif
        </ul>
    </div>
</div>

<input type="hidden" name="cantidad_estadias" id="cantidad_estadias" value="{{ $mode === 'edit' ? $reserva->estadias->count() : 0 }}">

{{-- BOTONES FINALES --}}
<div class="form-actions">
    <button type="submit" class="btn btn-reserva btn-lg">
        <i class="fas fa-save"></i>
        {{ $mode === 'create' ? 'Crear Reserva' : 'Actualizar Reserva' }}
    </button>
    <a href="{{ route('admin.reservas.index') }}" class="btn btn-secondary btn-lg">
        <i class="fas fa-times"></i> Cancelar
    </a>
</div>

{{-- ============= SCRIPTS ============= --}}
<script>
    // ===== CONFIGURACIÓN =====
    const tipoReservaSelect = document.getElementById('tipo_reserva');
    const proveedorContainer = document.getElementById('proveedor_container');

    tipoReservaSelect.addEventListener('change', function() {
        proveedorContainer.style.display = this.value === 'Agencia' ? 'block' : 'none';
    });

    // ===== TITULAR =====
    const inputBusquedaTitular = document.getElementById('busquedaTitular');
    const listaTitulares = document.querySelectorAll('#listaTitulares option');
    const titularIdHidden = document.getElementById('titular_id_hidden');
    const btnSeleccionarTitular = document.getElementById('btnSeleccionarTitular');
    const titularSeleccionadoDiv = document.getElementById('titularSeleccionado');

    btnSeleccionarTitular.addEventListener('click', function() {
        const val = inputBusquedaTitular.value.trim();
        if (!val) {
            alert('Escribe o selecciona un titular válido.');
            return;
        }

        let foundId = null;
        listaTitulares.forEach(opt => {
            if (opt.value === val) foundId = opt.dataset.id;
        });

        if (!foundId) {
            alert('Selecciona un titular válido de la lista.');
            return;
        }

        titularIdHidden.value = foundId;
        titularSeleccionadoDiv.innerHTML = `
            <div class="selected-item">
                <i class="fas fa-user-check"></i>
                <strong>${val}</strong>
                <button type="button" id="btnLimpiarTitular" class="btn-remove">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        `;

        document.getElementById('btnLimpiarTitular').addEventListener('click', function() {
            inputBusquedaTitular.value = '';
            titularIdHidden.value = '';
            titularSeleccionadoDiv.innerHTML = '';
        });
    });

    // ===== PASAJEROS =====
    const listaPasajerosAgregados = document.getElementById('listaPasajerosAgregados');
    const inputBusqueda = document.getElementById('busquedaPasajero');
    const cantidadPasajerosInput = document.getElementById('cantidad_pasajeros');
    const pasajerosYaAgregados = new Set();

    function agregarPasajero() {
        const nombreCompleto = inputBusqueda.value.trim();
        if (!nombreCompleto) return;

        const options = document.querySelectorAll('#listaPasajeros option');
        let pasajeroId = null;
        options.forEach(opt => {
            if (opt.value === nombreCompleto) pasajeroId = opt.dataset.id;
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
        li.classList.add('selected-item');
        li.innerHTML = `
            <i class="fas fa-user"></i>
            <span>${nombreCompleto}</span>
            <input type="hidden" name="pasajeros[]" value="${pasajeroId}">
            <button type="button" class="btn-remove" onclick="eliminarPasajero(this, '${pasajeroId}')">
                <i class="fas fa-times"></i>
            </button>
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

    // ===== CALCULAR SALDO =====
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
        calcularSaldo();
    });

    // ===== TOURS =====
    let tourSeleccionadoNormalizado = '';
    let estadiaIndex = {{ $mode === 'edit' ? $reserva->estadias->count() : 0 }};
    let editandoEstadia = null;
    let tourIndex = {{ $mode === 'edit' ? $reserva->toursReservas->count() : 0 }};
    let editandoTour = null;
    let indexUsado;

    const especiales = ['Machupicchu Full Day', 'Machupicchu Conexión', 'Machupicchu 2D/1N', 'Machupicchu By car'];
    const toursBoleto = ['valle sagrado', 'city tour', 'valle sur', 'maras moray', 'valle sagrado vip'];
    const lugaresPrivados = {
        'city tour': 'qoricancha',
        'valle sagrado': 'salineras',
        'valle sagrado vip': 'salineras',
        'maras moray': 'salineras',
        'valle sur': 'andahuaylillas'
    };

    document.getElementById('select-tour').addEventListener('change', function() {
        limpiarCampos();
        const option = this.options[this.selectedIndex];
        const id = option.value;
        const nombre = (option.dataset.nombre || '').trim();
        const nombreNormalizado = nombre.toLowerCase().trim();

        tourSeleccionadoNormalizado = nombre.toLowerCase().trim();

        document.getElementById('id_tour').value = id;
        document.getElementById('nombreTour').value = nombre;
        document.getElementById('empresa_tour_field').style.display = 'block';
        document.getElementById('observaciones_tour_field').style.display = 'block';

        const especialesNormalizados = especiales.map(e => e.toLowerCase().trim());
        if (especialesNormalizados.includes(nombreNormalizado)) {
            document.getElementById('machupicchu-details').style.display = 'block';

            if (nombreNormalizado === 'machupicchu by car') {
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

        const nombreBoleto = nombreNormalizado;
        const esBoletoTuristico = toursBoleto.includes(nombreBoleto);
        const boletoDetails = document.getElementById('boleto-turistico-details');
        const bloquePrivado = document.getElementById('lugares-priv-fields');

        boletoDetails.style.display = esBoletoTuristico ? 'block' : 'none';

        if (esBoletoTuristico) {
            const lugarPrivado = lugaresPrivados[nombreBoleto] || null;

            if (lugarPrivado) {
                bloquePrivado.style.display = 'block';
                document.getElementById('nombrePropiedadPrivada').innerText = lugarPrivado;
            } else {
                bloquePrivado.style.display = 'none';
                document.getElementById('incluye_entrada_propiedad_priv').value = '';
                document.getElementById('quien-compra-field').style.display = 'none';
                document.getElementById('comentario-entrada-priv-field').style.display = 'none';
            }
        } else {
            bloquePrivado.style.display = 'none';
        }
    });

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

    document.getElementById('tipo_entrada').addEventListener('change', function() {
        document.getElementById('ruta1-field').style.display = (this.value === 'circuito1') ? 'block' : 'none';
        document.getElementById('ruta2-field').style.display = (this.value === 'circuito2') ? 'block' : 'none';
        document.getElementById('ruta3-field').style.display = (this.value === 'circuito3') ? 'block' : 'none';
    });

    document.getElementById('tipo_tren').addEventListener('change', function() {
        if (this.value === 'Turístico') {
            document.getElementById('tren-turistico-fields').style.display = 'block';
            document.getElementById('tren-horarios-fields').style.display = 'block';
            document.getElementById('tren-local-fields').style.display = 'none';

            if (tourSeleccionadoNormalizado === 'machupicchu full day') {
                document.getElementById('tren-fechas-fields').style.display = 'none';
            } else {
                document.getElementById('tren-fechas-fields').style.display = 'block';
            }
        } else if (this.value === 'Local') {
            document.getElementById('tren-turistico-fields').style.display = 'none';
            document.getElementById('tren-local-fields').style.display = 'block';
            document.getElementById('tren-horarios-fields').style.display = 'block';

            if (tourSeleccionadoNormalizado === 'machupicchu full day') {
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

    document.getElementById('tiene_ticket').addEventListener('change', function() {
        const tipoTren = document.getElementById('tipo_tren').value;

        if (this.value == '1') {
            document.getElementById('comentario-ticket-field').style.display = 'none';
        } else if (this.value == '0') {
            document.getElementById('ticket-fields').style.display = 'none';

            if (tourSeleccionadoNormalizado !== 'machupicchu full day') {
                document.getElementById('tren-fechas-fields').style.display = 'block';
            } else {
                document.getElementById('tren-fechas-fields').style.display = 'none';
            }

            if (tipoTren === 'Local') {
                document.getElementById('tren-horarios-fields').style.display = 'block';
            } else {
                document.getElementById('tren-horarios-fields').style.display = 'block';
            }

            document.getElementById('comentario-ticket-field').style.display = 'block';
        } else {
            document.getElementById('tren-fechas-fields').style.display = 'none';
            document.getElementById('tren-horarios-fields').style.display = 'none';
            document.getElementById('ticket-fields').style.display = 'none';
            document.getElementById('comentario-ticket-field').style.display = 'none';
        }
    });

    document.getElementById('tipo_servicio').addEventListener('change', function() {
        if (this.value === 'Comprar' || this.value === 'Tiene') {
            document.getElementById('tipo_consetur-field').style.display = 'block';
            document.getElementById('comentario_consetur-field').style.display = 'block';
        } else if (this.value === 'Caminando') {
            document.getElementById('tipo_consetur-field').style.display = 'none';
            document.getElementById('comentario_consetur-field').style.display = 'none';
        }
    });

    document.getElementById('transp_ida').addEventListener('change', () => {
        document.getElementById('horario_recojo_ida-field').style.display = 'block';
        document.getElementById('comentario_trans_ida-field').style.display = 'block';
    });

    document.getElementById('transp_ret').addEventListener('change', () => {
        document.getElementById('horario_recojo_ret-field').style.display = 'block';
        document.getElementById('comentario_trans_ret-field').style.display = 'block';
    });

    document.getElementById('tipo_boleto').addEventListener('change', () => {
        document.getElementById('requiere_compra-field').style.display = 'block';
    });

    document.getElementById('requiere_compra').addEventListener('change', function() {
        document.getElementById('tipo_compra-field').style.display = (this.value == '1') ? 'block' : 'none';
    });

    document.getElementById('incluye_entrada_propiedad_priv').addEventListener('change', function() {
        const showCompra = (this.value == '1');
        document.getElementById('quien-compra-field').style.display = showCompra ? 'block' : 'none';
        document.getElementById('comentario-entrada-priv-field').style.display = 'block';
    });

    function limpiarCampos() {
        const bloques = [
            'machupicchu-details', 'boleto-turistico-details', 'bycar-fields',
            'entrada-fields', 'comentario-entrada-field',
            'ruta1-field', 'ruta2-field', 'ruta3-field',
            'tren-turistico-fields', 'tren-local-fields', 'tren-fechas-fields', 'tren-horarios-fields',
            'ticket-fields', 'comentario-ticket-field',
            'empresa_tour_field', 'observaciones_tour_field',
            'tipo_consetur-field', 'comentario_consetur-field',
            'tipo_compra-field', 'requiere_compra-field',
            'quien-compra-field', 'comentario-entrada-priv-field',
            'hospedaje-fields',
            'horario_recojo_ida-field', 'comentario_trans_ida-field',
            'horario_recojo_ret-field', 'comentario_trans_ret-field',
        ];

        bloques.forEach(id => {
            const el = document.getElementById(id);
            if (el) {
                el.style.display = 'none';
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

    // ===== AGREGAR/EDITAR TOUR =====
    const listaToursAgregados = document.getElementById('listaToursAgregados');
    const cantidadToursInput = document.getElementById('cantidad_tours');

    function agregarTour() {
        const id = safeValue('id_tour');
        const nombre = safeValue('nombreTour');
        const fecha = safeValue('fecha');
        const tipo = safeValue('tipo_tour');
        const lugarRecojo = safeValue('lugar_recojo');
        const horaRecojo = safeValue('hora_recojo');
        const idioma = safeValue('idioma');
        const empresa = safeValue('empresa');
        const precio = safeValue('precio_unitario');
        const cantidad = safeValue('cantidad');
        const observaciones = safeValue('observaciones');
        const nombreBoleto = nombre.toLowerCase().trim();

        if (!id) {
            alert("Selecciona un tour válido.");
            return;
        }

        let idTourReserva = '';
        if (editandoTour) {
            idTourReserva = editandoTour.querySelector('input[name*="[id]"]')?.value || '';
            indexUsado = editandoTour.dataset.index;
        } else {
            indexUsado = tourIndex;
        }

        const nombreNormalizado = nombre.toLowerCase().trim();
        let extras = '';
        let extrasPreview = '';

        const especialesNormalizados = especiales.map(e => e.toLowerCase().trim());
        if (especialesNormalizados.includes(nombreNormalizado)) {
            extras += `
                <input type="hidden" name="tours[${indexUsado}][detalles_machu][hay_entrada]" value="${safeValue('hay_entrada')}">
                <input type="hidden" name="tours[${indexUsado}][detalles_machu][tipo_entrada]" value="${safeValue('tipo_entrada')}">
                <input type="hidden" name="tours[${indexUsado}][detalles_machu][ruta1]" value="${safeValue('ruta1')}">
                <input type="hidden" name="tours[${indexUsado}][detalles_machu][ruta2]" value="${safeValue('ruta2')}">
                <input type="hidden" name="tours[${indexUsado}][detalles_machu][ruta3]" value="${safeValue('ruta3')}">
                <input type="hidden" name="tours[${indexUsado}][detalles_machu][horario_entrada]" value="${safeValue('horario_entrada')}">
                <input type="hidden" name="tours[${indexUsado}][detalles_machu][comentario_entrada]" value="${safeValue('comentario_entrada')}">
                <input type="hidden" name="tours[${indexUsado}][detalles_machu][tipo_tren]" value="${safeValue('tipo_tren')}">
                <input type="hidden" name="tours[${indexUsado}][detalles_machu][empresa_tren]" value="${safeValue('empresa_tren')}">
                <input type="hidden" name="tours[${indexUsado}][detalles_machu][codigo_tren]" value="${safeValue('codigo_tren')}">
                <input type="hidden" name="tours[${indexUsado}][detalles_machu][horario_ida]" value="${safeValue('horario_ida_tren')}">
                <input type="hidden" name="tours[${indexUsado}][detalles_machu][horario_retorno]" value="${safeValue('horario_retorno_tren')}">
                <input type="hidden" name="tours[${indexUsado}][detalles_machu][fecha_tren_ida]" value="${safeValue('fecha_tren_ida')}">
                <input type="hidden" name="tours[${indexUsado}][detalles_machu][fecha_tren_retorno]" value="${safeValue('fecha_tren_retorno')}">
                <input type="hidden" name="tours[${indexUsado}][detalles_machu][tiene_ticket]" value="${safeValue('tiene_ticket')}">
                <input type="hidden" name="tours[${indexUsado}][detalles_machu][comentario_ticket]" value="${safeValue('comentario_ticket')}">
                <input type="hidden" name="tours[${indexUsado}][detalles_machu][fecha_ida]" value="${safeValue('fecha_ida')}">
                <input type="hidden" name="tours[${indexUsado}][detalles_machu][fecha_retorno]" value="${safeValue('fecha_retorno')}">
                <input type="hidden" name="tours[${indexUsado}][detalles_machu][hospedaje]" value="${safeValue('hospedaje')}">
                <input type="hidden" name="tours[${indexUsado}][detalles_machu][tipo_servicio]" value="${safeValue('tipo_servicio')}">
                <input type="hidden" name="tours[${indexUsado}][detalles_machu][tipo_consetur]" value="${safeValue('tipo_consetur')}">
                <input type="hidden" name="tours[${indexUsado}][detalles_machu][comentario_consetur]" value="${safeValue('comentario_consetur')}">
                <input type="hidden" name="tours[${indexUsado}][detalles_machu][transp_ida]" value="${safeValue('transp_ida')}">
                <input type="hidden" name="tours[${indexUsado}][detalles_machu][horario_recojo_ida]" value="${safeValue('horario_recojo_ida')}">
                <input type="hidden" name="tours[${indexUsado}][detalles_machu][comentario_trans_ida]" value="${safeValue('comentario_trans_ida')}">
                <input type="hidden" name="tours[${indexUsado}][detalles_machu][transp_ret]" value="${safeValue('transp_ret')}">
                <input type="hidden" name="tours[${indexUsado}][detalles_machu][horario_recojo_ret]" value="${safeValue('horario_recojo_ret')}">
                <input type="hidden" name="tours[${indexUsado}][detalles_machu][comentario_trans_ret]" value="${safeValue('comentario_trans_ret')}">
            `;
            extrasPreview = `<div class="tour-extras"><i class="fas fa-mountain"></i> Incluye detalles de Machupicchu</div>`;
        }

        if (toursBoleto.includes(nombreBoleto)) {
            extras += `
                <input type="hidden" name="tours[${indexUsado}][detalles_boleto][tipo_boleto]" value="${safeValue('tipo_boleto')}">
                <input type="hidden" name="tours[${indexUsado}][detalles_boleto][requiere_compra]" value="${safeValue('requiere_compra')}">
                <input type="hidden" name="tours[${indexUsado}][detalles_boleto][tipo_compra]" value="${safeValue('tipo_compra')}">
                <input type="hidden" name="tours[${indexUsado}][detalles_boleto][incluye_entrada_propiedad_priv]" value="${safeValue('incluye_entrada_propiedad_priv')}">
                <input type="hidden" name="tours[${indexUsado}][detalles_boleto][quien_compra_propiedad_priv]" value="${safeValue('quien_compra_propiedad_priv')}">
                <input type="hidden" name="tours[${indexUsado}][detalles_boleto][comentario_entrada_propiedad_priv]" value="${safeValue('comentario_entrada_propiedad_priv')}">
            `;
            extrasPreview += `<div class="tour-extras"><i class="fas fa-ticket-alt"></i> Incluye Boleto Turístico</div>`;
        }

        if (editandoTour) {
            editandoTour.innerHTML = `
                <div class="tour-item-header">
                    <i class="fas fa-map-marker-alt"></i>
                    <strong>${nombre}</strong>
                    <span class="badge badge-info">${tipo || 'Grupal'}</span>
                </div>
                <div class="tour-item-body">
                    <div class="tour-detail"><strong>Fecha:</strong> ${fecha || '-'}</div>
                    <div class="tour-detail"><strong>Recojo:</strong> ${lugarRecojo || '-'} a las ${horaRecojo || '-'}</div>
                    <div class="tour-detail"><strong>Idioma:</strong> ${idioma || '-'}</div>
                    <div class="tour-detail"><strong>Precio:</strong> S/. ${precio || '0.00'} x ${cantidad}</div>
                    ${extrasPreview}
                </div>

                <input type="hidden" name="tours[${indexUsado}][id]" value="${idTourReserva}">
                <input type="hidden" name="tours[${indexUsado}][tour_id]" value="${id}">
                <input type="hidden" name="tours[${indexUsado}][nombreTour]" value="${nombre}">
                <input type="hidden" name="tours[${indexUsado}][fecha]" value="${fecha}">
                <input type="hidden" name="tours[${indexUsado}][tipo_tour]" value="${tipo}">
                <input type="hidden" name="tours[${indexUsado}][lugar_recojo]" value="${lugarRecojo}">
                <input type="hidden" name="tours[${indexUsado}][hora_recojo]" value="${horaRecojo}">
                <input type="hidden" name="tours[${indexUsado}][idioma]" value="${idioma}">
                <input type="hidden" name="tours[${indexUsado}][empresa]" value="${empresa}">
                <input type="hidden" name="tours[${indexUsado}][precio_unitario]" value="${precio}">
                <input type="hidden" name="tours[${indexUsado}][cantidad]" value="${cantidad}">
                <input type="hidden" name="tours[${indexUsado}][observaciones]" value="${observaciones}">
                ${extras}

                <div class="tour-item-actions">
                    <button type="button" class="btn btn-sm btn-edit" onclick="editarTour(this)">
                        <i class="fas fa-edit"></i> Editar
                    </button>
                    <button type="button" class="btn btn-sm btn-delete" onclick="eliminarTour(this)">
                        <i class="fas fa-trash"></i> Eliminar
                    </button>
                </div>
            `;

            editandoTour = null;
            document.getElementById('btn-agregar-tour').innerHTML = '<i class="fas fa-plus-circle"></i> Agregar Tour';
        } else {
            const li = document.createElement('li');
            li.classList.add('tour-item');
            li.dataset.index = indexUsado;

            li.innerHTML = `
                <div class="tour-item-header">
                    <i class="fas fa-map-marker-alt"></i>
                    <strong>${nombre}</strong>
                    <span class="badge badge-info">${tipo || 'Grupal'}</span>
                </div>
                <div class="tour-item-body">
                    <div class="tour-detail"><strong>Fecha:</strong> ${fecha || '-'}</div>
                    <div class="tour-detail"><strong>Recojo:</strong> ${lugarRecojo || '-'} a las ${horaRecojo || '-'}</div>
                    <div class="tour-detail"><strong>Idioma:</strong> ${idioma || '-'}</div>
                    <div class="tour-detail"><strong>Precio:</strong> S/. ${precio || '0.00'} x ${cantidad}</div>
                    ${extrasPreview}
                </div>

                <input type="hidden" name="tours[${indexUsado}][tour_id]" value="${id}">
                <input type="hidden" name="tours[${indexUsado}][nombreTour]" value="${nombre}">
                <input type="hidden" name="tours[${indexUsado}][fecha]" value="${fecha}">
                <input type="hidden" name="tours[${indexUsado}][tipo_tour]" value="${tipo}">
                <input type="hidden" name="tours[${indexUsado}][lugar_recojo]" value="${lugarRecojo}">
                <input type="hidden" name="tours[${indexUsado}][hora_recojo]" value="${horaRecojo}">
                <input type="hidden" name="tours[${indexUsado}][idioma]" value="${idioma}">
                <input type="hidden" name="tours[${indexUsado}][empresa]" value="${empresa}">
                <input type="hidden" name="tours[${indexUsado}][precio_unitario]" value="${precio}">
                <input type="hidden" name="tours[${indexUsado}][cantidad]" value="${cantidad}">
                <input type="hidden" name="tours[${indexUsado}][observaciones]" value="${observaciones}">
                ${extras}

                <div class="tour-item-actions">
                    <button type="button" class="btn btn-sm btn-edit" onclick="editarTour(this)">
                        <i class="fas fa-edit"></i> Editar
                    </button>
                    <button type="button" class="btn btn-sm btn-delete" onclick="eliminarTour(this)">
                        <i class="fas fa-trash"></i> Eliminar
                    </button>
                </div>
            `;

            listaToursAgregados.appendChild(li);
            tourIndex++;
        }

        actualizarCantidadTours();
        resetFieldsTour();
    }

    function eliminarTour(btn) {
        btn.closest('li').remove();
        actualizarCantidadTours();
    }

    function actualizarCantidadTours() {
        cantidadToursInput.value = listaToursAgregados.children.length;
    }

    function editarTour(btn) {
        const li = btn.closest('li');
        editandoTour = li;

        const id = li.querySelector('input[name*="[tour_id]"]').value;
        const fecha = li.querySelector('input[name*="[fecha]"]').value;
        const tipo = li.querySelector('input[name*="[tipo_tour]"]').value;
        const lugarRecojo = li.querySelector('input[name*="[lugar_recojo]"]').value;
        const horaRecojo = li.querySelector('input[name*="[hora_recojo]"]').value;
        const idioma = li.querySelector('input[name*="[idioma]"]').value;
        const empresa = li.querySelector('input[name*="[empresa]"]').value;
        const precio = li.querySelector('input[name*="[precio_unitario]"]').value;
        const cantidad = li.querySelector('input[name*="[cantidad]"]').value;
        const observaciones = li.querySelector('input[name*="[observaciones]"]').value;

        const selectTour = document.getElementById('select-tour');
        selectTour.value = id;
        selectTour.dispatchEvent(new Event('change'));

        document.getElementById('fecha').value = fecha.split(' ')[0] || '';
        document.getElementById('tipo_tour').value = tipo;
        document.getElementById('lugar_recojo').value = lugarRecojo;
        document.getElementById('hora_recojo').value = horaRecojo ? horaRecojo.substring(0, 5) : '';
        document.getElementById('idioma').value = idioma;
        document.getElementById('empresa').value = empresa;
        document.getElementById('precio_unitario').value = precio;
        document.getElementById('cantidad').value = cantidad;
        document.getElementById('observaciones').value = observaciones;

        const specialFields = [
            'hay_entrada', 'tipo_entrada', 'ruta1', 'ruta2', 'ruta3', 'horario_entrada', 'comentario_entrada',
            'tipo_tren', 'empresa_tren', 'codigo_tren', 'fecha_tren_ida', 'fecha_tren_retorno',
            'tiene_ticket', 'comentario_ticket',
            'fecha_ida', 'fecha_retorno', 'hospedaje',
            'tipo_servicio', 'tipo_consetur', 'comentario_consetur',
            'transp_ida', 'horario_recojo_ida', 'comentario_trans_ida', 'transp_ret', 'horario_recojo_ret', 'comentario_trans_ret'
        ];

        specialFields.forEach(field => {
            const el = document.getElementById(field === 'horario_ida' ? 'horario_ida_tren' : field === 'horario_retorno' ? 'horario_retorno_tren' : field);
            if (el) {
                const hiddenInput = li.querySelector(`input[name*="[detalles_machu][${field}]"]`);
                el.value = hiddenInput ? hiddenInput.value : '';
            }
        });

        const boletoFields = ['tipo_boleto', 'requiere_compra', 'tipo_compra', 'incluye_entrada_propiedad_priv', 'quien_compra_propiedad_priv', 'comentario_entrada_propiedad_priv'];

        boletoFields.forEach(field => {
            const el = document.getElementById(field);
            if (el) {
                const hiddenInput = li.querySelector(`input[name*="[detalles_boleto][${field}]"]`);
                el.value = hiddenInput ? hiddenInput.value : '';
            }
        });

        const btnAdd = document.getElementById('btn-agregar-tour');
        btnAdd.innerHTML = '<i class="fas fa-sync"></i> Actualizar Tour';
        btnAdd.classList.add("editing");
        document.getElementById('form-tours').classList.add("editing");

        document.getElementById('form-tours').scrollIntoView({ behavior: 'smooth', block: 'center' });
    }

    function resetFieldsTour() {
        document.getElementById('select-tour').value = '';
        document.getElementById('id_tour').value = '';
        document.getElementById('nombreTour').value = '';
        document.getElementById('fecha').value = '';
        document.getElementById('tipo_tour').value = '';
        document.getElementById('lugar_recojo').value = '';
        document.getElementById('hora_recojo').value = '';
        document.getElementById('empresa').value = '';
        document.getElementById('idioma').value = '';
        document.getElementById('precio_unitario').value = '';
        document.getElementById('cantidad').value = '';
        document.getElementById('observaciones').value = '';

        limpiarCampos();

        const btnAdd = document.getElementById('btn-agregar-tour');
        btnAdd.innerHTML = '<i class="fas fa-plus-circle"></i> Agregar Tour';
        btnAdd.classList.remove("editing");

        editandoTour = null;
        document.getElementById('form-tours').classList.remove("editing");
    }

    function safeValue(id) {
        return document.getElementById(id)?.value || '';
    }

    // ===== ESTADÍAS =====
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

        if (editandoEstadia) {
            editandoEstadia.innerHTML = `
                <div class="estadia-info">
                    <i class="fas fa-bed"></i>
                    <div>
                        <strong>${nombre || '-'}</strong>
                        <div class="estadia-details">
                            <span class="badge badge-secondary">${tipo}</span>
                            <span>${ubicacion || '-'}</span>
                            <span>${fecha || '-'}</span>
                            <span>Hab: ${habitacion || '-'}</span>
                        </div>
                    </div>
                </div>

                <input type="hidden" name="estadias[${estadiaIndex}][tipo_estadia]" value="${tipo}">
                <input type="hidden" name="estadias[${estadiaIndex}][nombre_estadia]" value="${nombre}">
                <input type="hidden" name="estadias[${estadiaIndex}][ubicacion]" value="${ubicacion}">
                <input type="hidden" name="estadias[${estadiaIndex}][fecha]" value="${fecha}">
                <input type="hidden" name="estadias[${estadiaIndex}][habitacion]" value="${habitacion}">

                <div class="estadia-actions">
                    <button type="button" class="btn btn-sm btn-edit" onclick="editarEstadia(this)">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button type="button" class="btn btn-sm btn-delete" onclick="eliminarEstadia(this)">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            `;

            editandoEstadia = null;
            const btnAdd = document.getElementById('btn-agregar-estadia');
            btnAdd.innerHTML = '<i class="fas fa-plus-circle"></i> Agregar';
            btnAdd.classList.remove("editing");
            document.getElementById('form-estadia').classList.remove("editing");
        } else {
            const li = document.createElement('li');
            li.classList.add('estadia-item');
            li.dataset.index = estadiaIndex;

            li.innerHTML = `
                <div class="estadia-info">
                    <i class="fas fa-bed"></i>
                    <div>
                        <strong>${nombre || '-'}</strong>
                        <div class="estadia-details">
                            <span class="badge badge-secondary">${tipo}</span>
                            <span>${ubicacion || '-'}</span>
                            <span>${fecha || '-'}</span>
                            <span>Hab: ${habitacion || '-'}</span>
                        </div>
                    </div>
                </div>

                <input type="hidden" name="estadias[${estadiaIndex}][tipo_estadia]" value="${tipo}">
                <input type="hidden" name="estadias[${estadiaIndex}][nombre_estadia]" value="${nombre}">
                <input type="hidden" name="estadias[${estadiaIndex}][ubicacion]" value="${ubicacion}">
                <input type="hidden" name="estadias[${estadiaIndex}][fecha]" value="${fecha}">
                <input type="hidden" name="estadias[${estadiaIndex}][habitacion]" value="${habitacion}">

                <div class="estadia-actions">
                    <button type="button" class="btn btn-sm btn-edit" onclick="editarEstadia(this)">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button type="button" class="btn btn-sm btn-delete" onclick="eliminarEstadia(this)">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            `;

            listaEstadiasAgregadas.appendChild(li);
            estadiaIndex++;
        }

        actualizarCantidadEstadias();
        limpiarCamposEstadia();
    }

    function eliminarEstadia(btn) {
        btn.closest('li').remove();
        actualizarCantidadEstadias();
    }

    function actualizarCantidadEstadias() {
        cantidadEstadiasInput.value = listaEstadiasAgregadas.children.length;
    }

    function editarEstadia(btn) {
        const li = btn.closest('li');
        editandoEstadia = li;

        const tipo = li.querySelector('input[name*="[tipo_estadia]"]').value;
        const nombre = li.querySelector('input[name*="[nombre_estadia]"]').value;
        const ubicacion = li.querySelector('input[name*="[ubicacion]"]').value;
        const fecha = li.querySelector('input[name*="[fecha]"]').value;
        const habitacion = li.querySelector('input[name*="[habitacion]"]').value;

        document.getElementById('tipo_estadia_input').value = tipo;
        document.getElementById('nombre_estadia_input').value = nombre;
        document.getElementById('ubicacion_estadia_input').value = ubicacion;
        document.getElementById('fecha_estadia_input').value = fecha;
        document.getElementById('habitacion_estadia_input').value = habitacion;

        const btnAdd = document.getElementById('btn-agregar-estadia');
        btnAdd.innerHTML = '<i class="fas fa-sync"></i> Actualizar';
        btnAdd.classList.add("editing");
        document.getElementById('form-estadia').classList.add("editing");

        document.getElementById('form-estadia').scrollIntoView({ behavior: 'smooth', block: 'center' });
    }

    function limpiarCamposEstadia() {
        document.getElementById('tipo_estadia_input').value = 'Hostal';
        document.getElementById('nombre_estadia_input').value = '';
        document.getElementById('ubicacion_estadia_input').value = '';
        document.getElementById('fecha_estadia_input').value = '';
        document.getElementById('habitacion_estadia_input').value = '';
    }
</script>

<style>
    /* ===== ESTILOS MEJORADOS ===== */
    .form-section {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }

    .section-header {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding-bottom: 1rem;
        margin-bottom: 1.5rem;
        border-bottom: 2px solid var(--primary);
    }

    .section-header i {
        color: var(--primary);
        font-size: 1.5rem;
    }

    .section-header h3 {
        margin: 0;
        font-size: 1.3rem;
        font-weight: 600;
        color: var(--dark);
    }

    .section-body {
        padding: 0;
    }

    .subsection {
        padding: 1rem;
        background: #f8f9fa;
        border-radius: 8px;
        margin-bottom: 1rem;
    }

    .subsection-title {
        font-size: 1rem;
        font-weight: 600;
        color: var(--primary-dark);
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .subsection-title::before {
        content: "";
        display: inline-block;
        width: 4px;
        height: 16px;
        background: var(--primary);
        border-radius: 2px;
    }

    .form-label {
        font-weight: 500;
        color: #495057;
        margin-bottom: 0.5rem;
    }

    .form-label.required::after {
        content: "*";
        color: var(--accent);
        margin-left: 4px;
    }

    /* ===== ITEMS SELECCIONADOS ===== */
    .selected-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .selected-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem 1rem;
        background: linear-gradient(135deg, rgba(20, 165, 181, 0.05) 0%, rgba(20, 165, 181, 0.02) 100%);
        border-left: 3px solid var(--primary);
        border-radius: 8px;
        margin-bottom: 0.5rem;
        transition: all 0.3s;
    }

    .selected-item:hover {
        background: linear-gradient(135deg, rgba(20, 165, 181, 0.1) 0%, rgba(20, 165, 181, 0.05) 100%);
        transform: translateX(4px);
    }

    .selected-item i {
        color: var(--primary);
        font-size: 1.1rem;
    }

    .selected-item strong {
        color: var(--dark);
        flex: 1;
    }

    .selected-item .text-muted {
        font-size: 0.9rem;
    }

    .btn-remove {
        background: transparent;
        border: none;
        color: var(--accent);
        cursor: pointer;
        padding: 0.25rem 0.5rem;
        border-radius: 4px;
        transition: all 0.3s;
    }

    .btn-remove:hover {
        background: rgba(220, 53, 69, 0.1);
        transform: scale(1.1);
    }

    /* ===== TARJETAS DE EDICIÓN ===== */
    .edit-card {
        background: #f8f9fa;
        border: 2px dashed #dee2e6;
        border-radius: 12px;
        padding: 1.5rem;
        transition: all 0.3s;
    }

    .edit-card.editing {
        background: #fff3cd;
        border-color: var(--warning);
        box-shadow: 0 4px 12px rgba(255, 193, 7, 0.2);
    }

    /* ===== SECCIONES CONDICIONALES ===== */
    .conditional-section {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 1.5rem;
        margin-top: 1rem;
    }

    .conditional-header {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid #dee2e6;
    }

    .conditional-header i {
        color: var(--primary-light);
        font-size: 1.2rem;
    }

    .conditional-header h5 {
        margin: 0;
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--dark);
    }

    /* ===== TOURS Y ESTADÍAS ===== */
    .tour-item, .estadia-item {
        background: white;
        border: 1px solid #e9ecef;
        border-radius: 12px;
        padding: 1rem;
        margin-bottom: 1rem;
        transition: all 0.3s;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }

    .tour-item:hover, .estadia-item:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        transform: translateY(-2px);
    }

    .tour-item-header {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 0.75rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid #e9ecef;
    }

    .tour-item-header i {
        color: var(--primary);
        font-size: 1.2rem;
    }

    .tour-item-header strong {
        flex: 1;
        font-size: 1.05rem;
        color: var(--dark);
    }

    .tour-item-body {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 0.5rem;
        margin-bottom: 0.75rem;
    }

    .tour-detail {
        font-size: 0.9rem;
        color: #6c757d;
    }

    .tour-detail strong {
        color: var(--dark);
    }

    .tour-extras {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem;
        background: rgba(20, 165, 181, 0.1);
        border-radius: 6px;
        font-size: 0.85rem;
        color: var(--primary-dark);
        margin-top: 0.5rem;
    }

    .tour-extras i {
        color: var(--primary);
    }

    .tour-item-actions {
        display: flex;
        gap: 0.5rem;
        justify-content: flex-end;
        padding-top: 0.75rem;
        border-top: 1px solid #e9ecef;
    }

    .estadia-info {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        flex: 1;
    }

    .estadia-info i {
        color: var(--primary);
        font-size: 1.5rem;
    }

    .estadia-info strong {
        display: block;
        font-size: 1.05rem;
        color: var(--dark);
        margin-bottom: 0.25rem;
    }

    .estadia-details {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
        font-size: 0.85rem;
        color: #6c757d;
    }

    .estadia-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .estadia-actions {
        display: flex;
        gap: 0.5rem;
    }

    /* ===== BOTONES ===== */
    .btn-sm.btn-edit {
        background: rgba(255, 193, 7, 0.1);
        color: var(--warning);
        border: 1px solid transparent;
    }

    .btn-sm.btn-edit:hover {
        background: var(--warning);
        color: white;
        border-color: var(--warning);
    }

    .btn-sm.btn-delete {
        background: rgba(220, 53, 69, 0.1);
        color: var(--accent);
        border: 1px solid transparent;
    }

    .btn-sm.btn-delete:hover {
        background: var(--accent);
        color: white;
        border-color: var(--accent);
    }

    /* ===== SALDO DESTACADO ===== */
    .saldo-display {
        background: linear-gradient(135deg, #e8f5e9 0%, #f1f8e9 100%) !important;
        font-weight: 600;
        font-size: 1.1rem;
        color: var(--success);
        border: 2px solid var(--success) !important;
    }

    /* ===== ACCIONES DEL FORMULARIO ===== */
    .form-actions {
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
        padding: 1.5rem;
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        margin-top: 2rem;
    }

    .btn-lg {
        padding: 0.75rem 2rem;
        font-size: 1rem;
        font-weight: 600;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .section-header h3 {
            font-size: 1.1rem;
        }
        
        .tour-item-body {
            grid-template-columns: 1fr;
        }
        
        .form-actions {
            flex-direction: column;
        }
        
        .form-actions .btn {
            width: 100%;
        }
        
        .estadia-item {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }
        
        .estadia-actions {
            width: 100%;
            justify-content: flex-end;
        }
    }

    /* ===== ANIMACIONES ===== */
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .form-section {
        animation: slideIn 0.4s ease;
    }

    .form-section:nth-child(1) { animation-delay: 0.1s; }
    .form-section:nth-child(2) { animation-delay: 0.2s; }
    .form-section:nth-child(3) { animation-delay: 0.3s; }
    .form-section:nth-child(4) { animation-delay: 0.4s; }
    .form-section:nth-child(5) { animation-delay: 0.5s; }
    .form-section:nth-child(6) { animation-delay: 0.6s; }
</style>