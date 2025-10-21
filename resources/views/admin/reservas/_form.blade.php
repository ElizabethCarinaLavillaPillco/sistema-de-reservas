@php
    $mode = isset($reserva->id) ? 'edit' : 'create';
    $action = $mode === 'create' 
        ? route('admin.reservas.store') 
        : route('admin.reservas.update', $reserva->id);
@endphp

<style>
    .campo-especial {
        background: #f8f9fa;
        border-left: 4px solid #0d6efd;
        padding: 15px;
        margin-bottom: 15px;
        border-radius: 8px;
        animation: slideIn 0.3s ease;
    }
    .seccion-titulo {
        font-weight: 600;
        color: #495057;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .badge-custom {
        font-size: 0.85rem;
        padding: 5px 10px;
    }
    .form-switch {
        padding-left: 2.5em;
    }
    .list-group-item {
        transition: all 0.3s ease;
    }

    .list-group-item:hover {
        background-color: #f8f9fa;
        transform: translateX(5px);
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .badge {
        font-weight: 500;
    }

    .btn-group .btn {
        transition: transform 0.2s ease;
    }

    .btn-group .btn:hover {
        transform: scale(1.1);
    }

    .card {
        border: 1px solid #dee2e6;
        transition: box-shadow 0.3s ease;
    }

    .card:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .form-select:focus,
    .form-control:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }

    .input-group-text {
        background-color: #e9ecef;
        border: 1px solid #ced4da;
    }

    .alert {
        border-left: 4px solid;
    }

    .alert-info {
        border-left-color: #0dcaf0;
    }

    .alert-warning {
        border-left-color: #ffc107;
    }

    .alert-success {
        border-left-color: #198754;
    }

    /* Mejoras visuales para campos especiales */
    .campo-especial.machu {
        background: linear-gradient(135deg, #fff5f5 0%, #ffe5e5 100%);
    }

    .campo-especial.boleto {
        background: linear-gradient(135deg, #f0fff4 0%, #d1f5dd 100%);
    }

    .seccion-titulo {
        padding-bottom: 10px;
        border-bottom: 2px solid #dee2e6;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .d-flex.gap-3 {
            flex-direction: column;
        }

        .btn-lg {
            width: 100%;
        }
    }
</style>

<form action="{{ $action }}" method="POST" id="form-reserva">
    @csrf
    @if($mode === 'edit')
        @method('PUT')
    @endif

    {{-- ========================================
        SECCIÓN 1: INFORMACIÓN BÁSICA
    ======================================== --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Información Básica</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="tipo_reserva" class="form-label">Tipo de Reserva *</label>
                    <select name="tipo_reserva" id="tipo_reserva" class="form-select" required>
                        <option value="">-- Seleccionar --</option>
                        @foreach(['Directo','Recomendacion','Publicidad','Agencia'] as $tipo)
                            <option value="{{ $tipo }}" 
                                {{ old('tipo_reserva', $reserva->tipo_reserva ?? '') == $tipo ? 'selected' : '' }}>
                                {{ $tipo }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4 mb-3" id="proveedor_container" style="display: none;">
                    <label for="proveedor_id" class="form-label">Proveedor</label>
                    <select name="proveedor_id" id="proveedor_id" class="form-select">
                        <option value="">-- Seleccionar --</option>
                        @foreach($proveedores as $proveedor)
                            <option value="{{ $proveedor->id }}"
                                {{ old('proveedor_id', $reserva->proveedor_id ?? '') == $proveedor->id ? 'selected' : '' }}>
                                {{ $proveedor->nombreAgencia }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <label for="estado" class="form-label">Estado de la Reserva</label>
                    <select name="estado" id="estado" class="form-select">
                        @foreach(['En espera','Activa','Finalizada','Cancelada'] as $estado)
                            <option value="{{ $estado }}"
                                {{ old('estado', $reserva->estado ?? 'En espera') == $estado ? 'selected' : '' }}>
                                {{ $estado }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>

    {{-- ========================================
        SECCIÓN 2: TITULAR Y PASAJEROS
    ======================================== --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0"><i class="fas fa-users me-2"></i>Titular y Pasajeros</h5>
        </div>
        <div class="card-body">
            
            {{-- TITULAR --}}
            <div class="mb-4">
                <label class="form-label fw-bold">Titular de la Reserva *</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
                    <input list="listaTitulares" 
                           id="busquedaTitular" 
                           class="form-control"
                           placeholder="Buscar pasajero..."
                           autocomplete="off">
                    <datalist id="listaTitulares">
                        @foreach($pasajeros as $p)
                            <option value="{{ $p->nombre }} {{ $p->apellido }} ({{ $p->documento }})" 
                                    data-id="{{ $p->id }}">
                        @endforeach
                    </datalist>
                    <button type="button" class="btn btn-primary" onclick="seleccionarTitular()">
                        <i class="fas fa-check"></i> Seleccionar
                    </button>
                </div>

                <input type="hidden" name="titular_id" id="titular_id" 
                       value="{{ old('titular_id', $reserva->titular_id ?? '') }}" required>

                <div id="titularSeleccionado" class="mt-2">
                    @if($mode === 'edit' && $reserva->titular)
                        <div class="alert alert-success p-2 mb-0">
                            <i class="fas fa-user-check me-2"></i>
                            <strong>{{ $reserva->titular->nombre_completo }}</strong> 
                            ({{ $reserva->titular->documento }})
                        </div>
                    @endif
                </div>
            </div>

            {{-- PASAJEROS --}}
            <div class="mb-3">
                <label class="form-label fw-bold">Pasajeros de la Reserva</label>
                <div class="input-group mb-3">
                    <span class="input-group-text"><i class="fas fa-users"></i></span>
                    <input list="listaPasajeros" 
                           id="busquedaPasajero" 
                           class="form-control"
                           placeholder="Buscar y agregar pasajeros..."
                           autocomplete="off">
                    <datalist id="listaPasajeros">
                        @foreach($pasajeros as $p)
                            <option value="{{ $p->nombre }} {{ $p->apellido }} ({{ $p->documento }})" 
                                    data-id="{{ $p->id }}">
                        @endforeach
                    </datalist>
                    <button type="button" class="btn btn-success" onclick="agregarPasajero()">
                        <i class="fas fa-user-plus"></i> Agregar
                    </button>
                </div>

                <div id="listaPasajerosAgregados" class="list-group">
                    @if($mode === 'edit')
                        @foreach($reserva->pasajeros as $pasajero)
                            <div class="list-group-item d-flex justify-content-between align-items-center" 
                                 data-id="{{ $pasajero->id }}">
                                <div>
                                    <i class="fas fa-user me-2 text-primary"></i>
                                    {{ $pasajero->nombre_completo }} ({{ $pasajero->documento }})
                                </div>
                                <div>
                                    <input type="hidden" name="pasajeros[]" value="{{ $pasajero->id }}">
                                    <button type="button" class="btn btn-sm btn-danger" 
                                            onclick="eliminarPasajero(this)">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

            <a href="{{ route('admin.pasajeros.create') }}" class="btn btn-outline-primary" target="_blank">
                <i class="fas fa-plus-circle me-1"></i> Registrar Nuevo Pasajero
            </a>
        </div>
    </div>

    {{-- ========================================
        SECCIÓN 3: VUELOS
    ======================================== --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0"><i class="fas fa-plane me-2"></i>Información de Vuelos</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12 mb-3">
                    <h6 class="text-muted"><i class="fas fa-plane-arrival me-2"></i>Llegada</h6>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="fecha_llegada" class="form-label">Fecha de Llegada</label>
                    <input type="date" name="fecha_llegada" id="fecha_llegada" class="form-control"
                           value="{{ old('fecha_llegada', $reserva->fecha_llegada?->format('Y-m-d') ?? '') }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="hora_llegada" class="form-label">Hora de Llegada</label>
                    <input type="time" name="hora_llegada" id="hora_llegada" class="form-control"
                           value="{{ old('hora_llegada', $reserva->hora_llegada ?? '') }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="nro_vuelo_llegada" class="form-label">N° de Vuelo</label>
                    <input type="text" name="nro_vuelo_llegada" id="nro_vuelo_llegada" class="form-control"
                           placeholder="Ej: LA2050"
                           value="{{ old('nro_vuelo_llegada', $reserva->nro_vuelo_llegada ?? '') }}">
                </div>

                <div class="col-12 mb-3 mt-2">
                    <h6 class="text-muted"><i class="fas fa-plane-departure me-2"></i>Salida</h6>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="fecha_salida" class="form-label">Fecha de Salida</label>
                    <input type="date" name="fecha_salida" id="fecha_salida" class="form-control"
                           value="{{ old('fecha_salida', $reserva->fecha_salida?->format('Y-m-d') ?? '') }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="hora_salida" class="form-label">Hora de Salida</label>
                    <input type="time" name="hora_salida" id="hora_salida" class="form-control"
                           value="{{ old('hora_salida', $reserva->hora_salida ?? '') }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="nro_vuelo_retorno" class="form-label">N° de Vuelo Retorno</label>
                    <input type="text" name="nro_vuelo_retorno" id="nro_vuelo_retorno" class="form-control"
                           placeholder="Ej: LA2051"
                           value="{{ old('nro_vuelo_retorno', $reserva->nro_vuelo_retorno ?? '') }}">
                </div>
            </div>
        </div>
    </div>

    {{-- ========================================
        SECCIÓN 4: FINANZAS
    ======================================== --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-warning text-dark">
            <h5 class="mb-0"><i class="fas fa-dollar-sign me-2"></i>Finanzas</h5>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="total" class="form-label">Total (USD) *</label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number" step="0.01" name="total" id="total" 
                               value="{{ old('total', $reserva->total ?? 0) }}"
                               class="form-control" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Adelanto (USD)</label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="text" id="adelanto_display" class="form-control" 
                               value="{{ $mode === 'edit' ? number_format($reserva->adelanto, 2) : '0.00' }}" readonly>
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Saldo Pendiente (USD)</label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="text" id="saldo_display" class="form-control" 
                               value="{{ $mode === 'edit' ? number_format($reserva->saldo, 2) : '0.00' }}" readonly>
                    </div>
                </div>
            </div>

            {{-- AGREGAR DEPÓSITOS --}}
            <button type="button" class="btn btn-success mb-3" data-bs-toggle="collapse" 
                    data-bs-target="#formDeposito">
                <i class="fas fa-plus-circle me-1"></i> Agregar Depósito
            </button>

            <div class="collapse" id="formDeposito">
                <div class="card card-body bg-light mb-3">
                    <div class="row">
                        <div class="col-md-3 mb-2">
                            <label class="form-label">Nombre Depositante</label>
                            <input type="text" id="deposito_nombre" class="form-control" placeholder="Juan Pérez">
                        </div>
                        <div class="col-md-2 mb-2">
                            <label class="form-label">Monto</label>
                            <input type="number" step="0.01" id="deposito_monto" class="form-control" placeholder="0.00">
                        </div>
                        <div class="col-md-2 mb-2">
                            <label class="form-label">Fecha</label>
                            <input type="date" id="deposito_fecha" class="form-control">
                        </div>
                        <div class="col-md-3 mb-2">
                            <label class="form-label">Tipo</label>
                            <select id="deposito_tipo" class="form-select">
                                <option value="">Seleccionar...</option>
                                <option value="Deposito WU">Depósito WU</option>
                                <option value="Transferencia BCP">Transferencia BCP</option>
                                <option value="Transferencia Interbank">Transferencia Interbank</option>
                                <option value="Yape">Yape</option>
                                <option value="Plin">Plin</option>
                                <option value="Otro">Otro</option>
                            </select>
                        </div>
                        <div class="col-md-2 mb-2 d-flex align-items-end">
                            <button type="button" class="btn btn-primary w-100" onclick="agregarDeposito()">
                                <i class="fas fa-check"></i> Agregar
                            </button>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Observaciones</label>
                            <textarea id="deposito_obs" class="form-control" rows="2"></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div id="listaDepositos" class="list-group">
                @if($mode === 'edit')
                    @foreach($reserva->depositos as $i => $deposito)
                        <div class="list-group-item">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <strong>{{ $deposito->nombre_depositante }}</strong> - 
                                    ${{ number_format($deposito->monto, 2) }} 
                                    <span class="badge bg-info">{{ $deposito->tipo_deposito }}</span>
                                    <br><small class="text-muted">{{ $deposito->fecha->format('d/m/Y') }}</small>
                                </div>
                                <button type="button" class="btn btn-sm btn-danger" onclick="eliminarDeposito(this)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                            <input type="hidden" name="depositos[{{ $i }}][nombre_depositante]" value="{{ $deposito->nombre_depositante }}">
                            <input type="hidden" name="depositos[{{ $i }}][monto]" value="{{ $deposito->monto }}">
                            <input type="hidden" name="depositos[{{ $i }}][fecha]" value="{{ $deposito->fecha->format('Y-m-d') }}">
                            <input type="hidden" name="depositos[{{ $i }}][tipo_deposito]" value="{{ $deposito->tipo_deposito }}">
                            <input type="hidden" name="depositos[{{ $i }}][observaciones]" value="{{ $deposito->observaciones }}">
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>

    {{-- ========================================
        SECCIÓN 5: TOURS
    ======================================== --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-danger text-white">
            <h5 class="mb-0"><i class="fas fa-map-marked-alt me-2"></i>Tours Contratados</h5>
        </div>
        <div class="card-body">
            
            <button type="button" class="btn btn-primary mb-3" data-bs-toggle="collapse" 
                    data-bs-target="#formTour">
                <i class="fas fa-plus-circle me-1"></i> Agregar Tour
            </button>

            <div class="collapse" id="formTour">
                <div class="card card-body bg-light mb-4" style="border: 2px dashed #dee2e6;">
                    <input type="hidden" id="tour_index_edit">
                    <input type="hidden" id="tour_id_edit">
                    
                    {{-- INFORMACIÓN BÁSICA DEL TOUR --}}
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Tour *</label>
                            <select id="tour_id" class="form-select form-select-lg">
                                <option value="">-- Seleccionar Tour --</option>
                                @foreach($tours as $tour)
                                    <option value="{{ $tour->id }}" 
                                            data-nombre="{{ $tour->nombreTour }}">
                                        {{ $tour->nombreTour }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold">Fecha</label>
                            <input type="date" id="tour_fecha" class="form-control">
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold">Estado</label>
                            <select id="tour_estado" class="form-select">
                                <option value="Programado">🟡 Programado</option>
                                <option value="Confirmado">🟢 Confirmado</option>
                                <option value="Cancelado">🔴 Cancelado</option>
                                <option value="Completado">✅ Completado</option>
                            </select>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">Tipo de Servicio</label>
                            <select id="tour_tipo" class="form-select">
                                <option value="Grupal">Grupal</option>
                                <option value="Privado">Privado</option>
                            </select>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Lugar de Recojo</label>
                            <input type="text" id="tour_lugar_recojo" class="form-control" placeholder="Hotel, dirección...">
                        </div>

                        <div class="col-md-2 mb-3">
                            <label class="form-label">Hora Recojo</label>
                            <input type="time" id="tour_hora_recojo" class="form-control">
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">Idioma</label>
                            <input type="text" id="tour_idioma" class="form-control" placeholder="Español, Inglés...">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Empresa Operadora</label>
                            <input type="text" id="tour_empresa" class="form-control" placeholder="Nombre de la empresa">
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">Precio Unitario</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" step="0.01" id="tour_precio" class="form-control" value="0">
                            </div>
                        </div>

                        <div class="col-md-2 mb-3">
                            <label class="form-label">Cantidad</label>
                            <input type="number" id="tour_cantidad" class="form-control" value="1" min="1">
                        </div>

                        <div class="col-md-3 mb-3 d-flex align-items-end">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="tour_incluye_entrada">
                                <label class="form-check-label" for="tour_incluye_entrada">
                                    Incluye Entrada
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="tour_incluye_tren">
                                <label class="form-check-label" for="tour_incluye_tren">
                                    Incluye Tren
                                </label>
                            </div>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="form-label">Observaciones</label>
                            <textarea id="tour_observaciones" class="form-control" rows="2" placeholder="Información adicional..."></textarea>
                        </div>
                    </div>

                    {{-- INTEGRANTES DEL TOUR --}}
                    <div class="border-top pt-3 mb-3">
                        <h6 class="fw-bold mb-3"><i class="fas fa-users me-2"></i>¿Quiénes van a este tour?</h6>
                        <div class="mb-3">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="tour_modo" 
                                       id="modo_todos" value="todos" checked>
                                <label class="form-check-label" for="modo_todos">
                                    <i class="fas fa-users-cog me-1"></i> Todos los pasajeros
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="tour_modo" 
                                       id="modo_personalizado" value="personalizado">
                                <label class="form-check-label" for="modo_personalizado">
                                    <i class="fas fa-user-check me-1"></i> Seleccionar manualmente
                                </label>
                            </div>
                        </div>

                        <div id="integrantes_personalizados" class="d-none">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                Selecciona los pasajeros que participarán en este tour
                            </div>
                            <div id="lista_integrantes_tour" class="row">
                                {{-- Se llena dinámicamente con JS --}}
                            </div>
                        </div>
                    </div>

                    {{-- ===================================================
                        🔴 DETALLES ESPECIALES: MACHUPICCHU
                    =================================================== --}}
                    <div id="detalles_machupicchu" class="d-none">
                        <div class="campo-especial machu">
                            <div class="seccion-titulo">
                                <i class="fas fa-mountain text-danger fs-5"></i>
                                <span class="text-danger fs-5">DETALLES MACHUPICCHU</span>
                            </div>

                            {{-- ENTRADA --}}
                            <div class="row mb-3">
                                <div class="col-12">
                                    <h6 class="fw-bold text-secondary mb-2">
                                        <i class="fas fa-ticket-alt me-2"></i>Entrada a Machupicchu
                                    </h6>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">¿Hay entrada?</label>
                                    <select id="machu_hay_entrada" class="form-select">
                                        <option value="">-- Seleccionar --</option>
                                        <option value="1">Sí, hay entrada</option>
                                        <option value="0">No hay entrada</option>
                                    </select>
                                </div>

                                <div class="col-md-12" id="machu_entrada_fields" style="display:none;">
                                    <div class="row">
                                        <div class="col-md-3 mb-2">
                                            <label class="form-label">Circuito</label>
                                            <select id="machu_tipo_entrada" class="form-select">
                                                <option value="">-- Seleccionar --</option>
                                                <option value="circuito1">Circuito 1</option>
                                                <option value="circuito2">Circuito 2</option>
                                                <option value="circuito3">Circuito 3</option>
                                            </select>
                                        </div>

                                        <div class="col-md-3 mb-2" id="machu_ruta1_field" style="display:none;">
                                            <label class="form-label">Ruta Circuito 1</label>
                                            <select id="machu_ruta1" class="form-select">
                                                <option value="">-- Seleccionar --</option>
                                                <option value="ruta1a">1-A: Montaña Machupicchu</option>
                                                <option value="ruta1b">1-B: Terraza Superior</option>
                                                <option value="ruta1c">1-C: Portada Intipunku</option>
                                                <option value="ruta1d">1-D: Puente Inka</option>
                                            </select>
                                        </div>

                                        <div class="col-md-3 mb-2" id="machu_ruta2_field" style="display:none;">
                                            <label class="form-label">Ruta Circuito 2</label>
                                            <select id="machu_ruta2" class="form-select">
                                                <option value="">-- Seleccionar --</option>
                                                <option value="ruta2a">2-A: Clásico Diseñado</option>
                                                <option value="ruta2b">2-B: Terraza Inferior</option>
                                            </select>
                                        </div>

                                        <div class="col-md-3 mb-2" id="machu_ruta3_field" style="display:none;">
                                            <label class="form-label">Ruta Circuito 3</label>
                                            <select id="machu_ruta3" class="form-select">
                                                <option value="">-- Seleccionar --</option>
                                                <option value="ruta3a">3-A: Montaña Waynapicchu</option>
                                                <option value="ruta3b">3-B: Realeza Diseñada</option>
                                                <option value="ruta3c">3-C: Gran Caverna</option>
                                                <option value="ruta3d">3-D: Huchuypicchu</option>
                                            </select>
                                        </div>

                                        <div class="col-md-3 mb-2">
                                            <label class="form-label">Horario de Entrada</label>
                                            <input type="time" id="machu_horario_entrada" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12" id="machu_comentario_entrada_field" style="display:none;">
                                    <label class="form-label">Observación sobre entrada</label>
                                    <input type="text" id="machu_comentario_entrada" class="form-control" 
                                           placeholder="Ej: Tramitar en pueblo">
                                </div>
                            </div>

                            {{-- TREN --}}
                            <div class="row mb-3">
                                <div class="col-12">
                                    <h6 class="fw-bold text-secondary mb-2">
                                        <i class="fas fa-train me-2"></i>Transporte en Tren
                                    </h6>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Tipo de Tren</label>
                                    <select id="machu_tipo_tren" class="form-select">
                                        <option value="">-- Seleccionar --</option>
                                        <option value="Turístico">Tren Turístico</option>
                                        <option value="Local">Tren Local</option>
                                    </select>
                                </div>

                                {{-- TREN TURÍSTICO --}}
                                <div class="col-md-12" id="machu_tren_turistico_fields" style="display:none;">
                                    <div class="row">
                                        <div class="col-md-3 mb-2">
                                            <label class="form-label">Empresa de Tren</label>
                                            <select id="machu_empresa_tren" class="form-select">
                                                <option value="">-- Seleccionar --</option>
                                                <option value="Inca Rail">Inca Rail</option>
                                                <option value="Peru Rail">Peru Rail</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            <label class="form-label">Código de Tren</label>
                                            <input type="text" id="machu_codigo_tren" class="form-control" 
                                                   placeholder="Ej: 1234AB">
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            <label class="form-label">Horario Ida</label>
                                            <input type="time" id="machu_horario_ida" class="form-control">
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            <label class="form-label">Horario Retorno</label>
                                            <input type="time" id="machu_horario_retorno" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                {{-- TREN LOCAL --}}
                                <div class="col-md-12" id="machu_tren_local_fields" style="display:none;">
                                    <div class="row">
                                        <div class="col-md-4 mb-2">
                                            <label class="form-label">¿Tiene Ticket?</label>
                                            <select id="machu_tiene_ticket" class="form-select">
                                                <option value="">-- Seleccionar --</option>
                                                <option value="1">Sí, tiene ticket</option>
                                                <option value="0">No tiene ticket</option>
                                            </select>
                                        </div>
                                        <div class="col-md-8 mb-2" id="machu_comentario_ticket_field" style="display:none;">
                                            <label class="form-label">Observación Ticket</label>
                                            <input type="text" id="machu_comentario_ticket" class="form-control" 
                                                   placeholder="Ej: Hacer cola temprano">
                                        </div>
                                    </div>
                                </div>

                                {{-- FECHAS TREN --}}
                                <div class="col-md-12" id="machu_tren_fechas_fields" style="display:none;">
                                    <div class="row">
                                        <div class="col-md-6 mb-2">
                                            <label class="form-label">Fecha Tren Ida</label>
                                            <input type="date" id="machu_fecha_tren_ida" class="form-control">
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label class="form-label">Fecha Tren Retorno</label>
                                            <input type="date" id="machu_fecha_tren_retorno" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- CONSETUR (BUS) --}}
                            <div class="row mb-3">
                                <div class="col-12">
                                    <h6 class="fw-bold text-secondary mb-2">
                                        <i class="fas fa-bus me-2"></i>Bus Consettur (Aguas Calientes - Machupicchu)
                                    </h6>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label class="form-label">¿Consetur o a pie?</label>
                                    <select id="machu_tipo_servicio" class="form-select">
                                        <option value="">-- Seleccionar --</option>
                                        <option value="Comprar">Comprar</option>
                                        <option value="Tiene">Ya tiene</option>
                                        <option value="Caminando">Irá caminando</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-2" id="machu_tipo_consetur_field" style="display:none;">
                                    <label class="form-label">Tipo de Consetur</label>
                                    <select id="machu_tipo_consetur" class="form-select">
                                        <option value="">-- Seleccionar --</option>
                                        <option value="ambos">Ida y Retorno</option>
                                        <option value="ida">Solo Ida</option>
                                        <option value="ret">Solo Retorno</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-2" id="machu_comentario_consetur_field" style="display:none;">
                                    <label class="form-label">Observación Consetur</label>
                                    <input type="text" id="machu_comentario_consetur" class="form-control" 
                                           placeholder="Ej: Comprar en pueblo">
                                </div>
                            </div>

                            {{-- TRANSPORTE CUSCO - OLLANTAYTAMBO --}}
                            <div class="row mb-3">
                                <div class="col-12">
                                    <h6 class="fw-bold text-secondary mb-2">
                                        <i class="fas fa-shuttle-van me-2"></i>Transporte Cusco - Ollantaytambo - Cusco
                                    </h6>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label class="form-label">Transporte de Ida</label>
                                    <select id="machu_transp_ida" class="form-select">
                                        <option value="">-- Seleccionar --</option>
                                        <option value="busLucy">Bus Lucy</option>
                                        <option value="Bimodal">Bimodal</option>
                                        <option value="BimodalDoor">Bimodal Door to Door</option>
                                        <option value="Privado">Transporte Privado</option>
                                        <option value="otro">Otro</option>
                                        <option value="porCuentaPropia">Por cuenta propia</option>
                                    </select>
                                </div>
                                <div class="col-md-3 mb-2" id="machu_horario_recojo_ida_field" style="display:none;">
                                    <label class="form-label">Horario de Recojo (Ida)</label>
                                    <input type="time" id="machu_horario_recojo_ida" class="form-control">
                                </div>
                                <div class="col-md-5 mb-2" id="machu_comentario_trans_ida_field" style="display:none;">
                                    <label class="form-label">Observación Transporte Ida</label>
                                    <input type="text" id="machu_comentario_trans_ida" class="form-control">
                                </div>

                                <div class="col-md-4 mb-2">
                                    <label class="form-label">Transporte de Retorno</label>
                                    <select id="machu_transp_ret" class="form-select">
                                        <option value="">-- Seleccionar --</option>
                                        <option value="busLucy">Bus Lucy</option>
                                        <option value="Bimodal">Bimodal</option>
                                        <option value="BimodalDoor">Bimodal Door to Door</option>
                                        <option value="Privado">Transporte Privado</option>
                                        <option value="otro">Otro</option>
                                        <option value="porCuentaPropia">Por cuenta propia</option>
                                    </select>
                                </div>
                                <div class="col-md-3 mb-2" id="machu_horario_recojo_ret_field" style="display:none;">
                                    <label class="form-label">Horario de Recojo (Ret)</label>
                                    <input type="time" id="machu_horario_recojo_ret" class="form-control">
                                </div>
                                <div class="col-md-5 mb-2" id="machu_comentario_trans_ret_field" style="display:none;">
                                    <label class="form-label">Observación Transporte Retorno</label>
                                    <input type="text" id="machu_comentario_trans_ret" class="form-control">
                                </div>
                            </div>

                            {{-- HOSPEDAJE (PARA 2D/1N Y BY CAR) --}}
                            <div class="row mb-3" id="machu_hospedaje_fields" style="display:none;">
                                <div class="col-12">
                                    <h6 class="fw-bold text-secondary mb-2">
                                        <i class="fas fa-bed me-2"></i>Hospedaje en Aguas Calientes
                                    </h6>
                                </div>
                                <div class="col-md-12 mb-2">
                                    <label class="form-label">Nombre del Hospedaje</label>
                                    <input type="text" id="machu_hospedaje" class="form-control" 
                                           placeholder="Ej: Hotel Inka">
                                </div>
                            </div>

                            {{-- BY CAR - FECHAS ESPECIALES --}}
                            <div class="row mb-3" id="machu_bycar_fields" style="display:none;">
                                <div class="col-12">
                                    <h6 class="fw-bold text-secondary mb-2">
                                        <i class="fas fa-car me-2"></i>Detalles By Car / Hidroeléctrica
                                    </h6>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label class="form-label">Fecha de Ida</label>
                                    <input type="date" id="machu_fecha_ida" class="form-control">
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label class="form-label">Fecha de Retorno</label>
                                    <input type="date" id="machu_fecha_retorno" class="form-control">
                                </div>
                            </div>

                        </div>
                    </div>

                    {{-- ===================================================
                        🟢 DETALLES ESPECIALES: BOLETO TURÍSTICO
                    =================================================== --}}
                    <div id="detalles_boleto" class="d-none">
                        <div class="campo-especial boleto">
                            <div class="seccion-titulo">
                                <i class="fas fa-ticket-alt text-success fs-5"></i>
                                <span class="text-success fs-5">DETALLES BOLETO TURÍSTICO</span>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Tipo de Boleto</label>
                                    <select id="boleto_tipo_boleto" class="form-select">
                                        <option value="">-- Seleccionar --</option>
                                        <option value="Integral">Boleto Integral</option>
                                        <option value="Parcial">Boleto Parcial</option>
                                    </select>
                                </div>

                                <div class="col-md-4 mb-3" id="boleto_requiere_compra_field" style="display:none;">
                                    <label class="form-label">¿Se debe comprar?</label>
                                    <select id="boleto_requiere_compra" class="form-select">
                                        <option value="">-- Seleccionar --</option>
                                        <option value="1">Sí, debe comprar</option>
                                        <option value="0">No, ya tiene</option>
                                    </select>
                                </div>

                                <div class="col-md-4 mb-3" id="boleto_tipo_compra_field" style="display:none;">
                                    <label class="form-label">¿Quién compra?</label>
                                    <select id="boleto_tipo_compra" class="form-select">
                                        <option value="">-- Seleccionar --</option>
                                        <option value="Personal">Compra personal</option>
                                        <option value="Guia">Compra por el guía</option>
                                    </select>
                                </div>

                                {{-- PROPIEDADES PRIVADAS --}}
                                <div class="col-12" id="boleto_propiedad_privada_fields" style="display:none;">
                                    <div class="alert alert-warning mb-3">
                                        <i class="fas fa-exclamation-triangle me-2"></i>
                                        Este tour incluye entrada a <strong id="nombre_propiedad_privada"></strong>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-4 mb-2">
                                            <label class="form-label">¿Incluye entrada a propiedad privada?</label>
                                            <select id="boleto_incluye_entrada_priv" class="form-select">
                                                <option value="">-- Seleccionar --</option>
                                                <option value="1">Sí</option>
                                                <option value="0">No</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4 mb-2" id="boleto_quien_compra_priv_field" style="display:none;">
                                            <label class="form-label">¿Quién compra la entrada?</label>
                                            <select id="boleto_quien_compra_priv" class="form-select">
                                                <option value="">-- Seleccionar --</option>
                                                <option value="guia">Guía</option>
                                                <option value="pasajero">Pasajero</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4 mb-2" id="boleto_comentario_priv_field" style="display:none;">
                                            <label class="form-label">Observación</label>
                                            <input type="text" id="boleto_comentario_priv" class="form-control" 
                                                   placeholder="Detalles adicionales">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- BOTONES DE ACCIÓN --}}
                    <div class="border-top pt-3 mt-3">
                        <button type="button" class="btn btn-success btn-lg" onclick="guardarTour()">
                            <i class="fas fa-save me-2"></i>
                            <span id="btn_tour_text">Agregar Tour</span>
                        </button>
                        <button type="button" class="btn btn-secondary btn-lg" onclick="cancelarTour()">
                            <i class="fas fa-times me-2"></i> Cancelar
                        </button>
                    </div>
                </div>
            </div>

            {{-- LISTA DE TOURS AGREGADOS --}}
            <div id="listaTours" class="list-group">
                @if($mode === 'edit')
                    @foreach($reserva->toursReservas as $i => $tr)
                        <div class="list-group-item" data-index="{{ $i }}">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">
                                        <i class="fas fa-route me-2 text-primary"></i>
                                        {{ $tr->tour->nombreTour }}
                                    </h6>
                                    <div class="d-flex flex-wrap gap-2 mb-2">
                                        <span class="badge bg-info">
                                            <i class="far fa-calendar me-1"></i>
                                            {{ $tr->fecha?->format('d/m/Y') }}
                                        </span>
                                        <span class="badge bg-secondary">{{ $tr->tipo_tour }}</span>
                                        <span class="badge bg-{{ $tr->estado == 'Programado' ? 'warning' : ($tr->estado == 'Confirmado' ? 'success' : 'danger') }}">
                                            {{ $tr->estado }}
                                        </span>
                                        <span class="badge bg-dark">
                                            ${{ number_format($tr->precio_unitario, 2) }} x {{ $tr->cantidad }}
                                        </span>
                                    </div>
                                    @if($tr->lugar_recojo || $tr->hora_recojo)
                                        <small class="text-muted">
                                            <i class="fas fa-map-marker-alt me-1"></i>
                                            {{ $tr->lugar_recojo }} 
                                            @if($tr->hora_recojo)
                                                | <i class="far fa-clock me-1"></i>{{ $tr->hora_recojo->format('H:i') }}
                                            @endif
                                        </small>
                                    @endif
                                </div>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-warning" onclick="editarTour({{ $i }})">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-danger" onclick="eliminarTour(this)">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>

                            {{-- Hidden inputs (mantener datos) --}}
                            <input type="hidden" name="tours[{{ $i }}][id]" value="{{ $tr->id }}">
                            <input type="hidden" name="tours[{{ $i }}][tour_id]" value="{{ $tr->tour_id }}">
                            <input type="hidden" name="tours[{{ $i }}][fecha]" value="{{ $tr->fecha?->format('Y-m-d') }}">
                            <input type="hidden" name="tours[{{ $i }}][tipo_tour]" value="{{ $tr->tipo_tour }}">
                            <input type="hidden" name="tours[{{ $i }}][estado]" value="{{ $tr->estado }}">
                            <input type="hidden" name="tours[{{ $i }}][lugar_recojo]" value="{{ $tr->lugar_recojo }}">
                            <input type="hidden" name="tours[{{ $i }}][hora_recojo]" value="{{ $tr->hora_recojo?->format('H:i') }}">
                            <input type="hidden" name="tours[{{ $i }}][idioma]" value="{{ $tr->idioma }}">
                            <input type="hidden" name="tours[{{ $i }}][empresa]" value="{{ $tr->empresa }}">
                            <input type="hidden" name="tours[{{ $i }}][precio_unitario]" value="{{ $tr->precio_unitario }}">
                            <input type="hidden" name="tours[{{ $i }}][cantidad]" value="{{ $tr->cantidad }}">
                            <input type="hidden" name="tours[{{ $i }}][observaciones]" value="{{ $tr->observaciones }}">
                            <input type="hidden" name="tours[{{ $i }}][incluye_entrada]" value="{{ $tr->incluye_entrada ? '1' : '0' }}">
                            <input type="hidden" name="tours[{{ $i }}][incluye_tren]" value="{{ $tr->incluye_tren ? '1' : '0' }}">
                            
                            {{-- Detalles Machupicchu si existen --}}
                            @if($tr->detalleMachupicchu)
                                @foreach([
                                    'hay_entrada', 'tipo_entrada', 'ruta1', 'ruta2', 'ruta3', 
                                    'horario_entrada', 'comentario_entrada',
                                    'tipo_tren', 'empresa_tren', 'codigo_tren', 
                                    'horario_ida', 'horario_retorno',
                                    'fecha_tren_ida', 'fecha_tren_retorno',
                                    'tiene_ticket', 'comentario_ticket',
                                    'fecha_ida', 'fecha_retorno', 'hospedaje',
                                    'tipo_servicio', 'tipo_consetur', 'comentario_consetur',
                                    'transp_ida', 'horario_recojo_ida', 'comentario_trans_ida',
                                    'transp_ret', 'horario_recojo_ret', 'comentario_trans_ret'
                                ] as $campo)
                                    <input type="hidden" name="tours[{{ $i }}][detalles_machu][{{ $campo }}]" 
                                           value="{{ $tr->detalleMachupicchu->$campo }}">
                                @endforeach
                            @endif

                            {{-- Detalles Boleto Turístico si existen --}}
                            @if($tr->detalleBoletoTuristico)
                                @foreach([
                                    'tipo_boleto', 'requiere_compra', 'tipo_compra',
                                    'incluye_entrada_propiedad_priv', 
                                    'quien_compra_propiedad_priv', 
                                    'comentario_entrada_propiedad_priv'
                                ] as $campo)
                                    <input type="hidden" name="tours[{{ $i }}][detalles_boleto][{{ $campo }}]" 
                                           value="{{ $tr->detalleBoletoTuristico->$campo }}">
                                @endforeach
                            @endif
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>

    {{-- ========================================
        SECCIÓN 6: ESTADÍAS
    ======================================== --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-secondary text-white">
            <h5 class="mb-0"><i class="fas fa-hotel me-2"></i>Estadías</h5>
        </div>
        <div class="card-body">
            
            <button type="button" class="btn btn-primary mb-3" data-bs-toggle="collapse" 
                    data-bs-target="#formEstadia">
                <i class="fas fa-plus-circle me-1"></i> Agregar Estadía
            </button>

            <div class="collapse" id="formEstadia">
                <div class="card card-body bg-light mb-3">
                    <div class="row">
                        <div class="col-md-2 mb-2">
                            <label class="form-label">Tipo</label>
                            <select id="estadia_tipo" class="form-select">
                                <option value="Hostal">Hostal</option>
                                <option value="Hospedaje">Hospedaje</option>
                                <option value="Airbnb">Airbnb</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="form-label">Nombre *</label>
                            <input type="text" id="estadia_nombre" class="form-control" 
                                   placeholder="Ej: Hostal Chakana">
                        </div>
                        <div class="col-md-3 mb-2">
                            <label class="form-label">Ubicación</label>
                            <input type="text" id="estadia_ubicacion" class="form-control" 
                                   placeholder="Dirección">
                        </div>
                        <div class="col-md-2 mb-2">
                            <label class="form-label">Fecha</label>
                            <input type="date" id="estadia_fecha" class="form-control">
                        </div>
                        <div class="col-md-8 mb-2">
                            <label class="form-label">Habitación</label>
                            <input type="text" id="estadia_habitacion" class="form-control" 
                                   placeholder="Ej: 201 - Matrimonial">
                        </div>
                        <div class="col-md-4 mb-2 d-flex align-items-end">
                            <button type="button" class="btn btn-success w-100" onclick="agregarEstadia()">
                                <i class="fas fa-check me-1"></i> Agregar
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div id="listaEstadias" class="list-group">
                @if($mode === 'edit')
                    @foreach($reserva->estadias as $i => $estadia)
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <strong><i class="fas fa-bed me-2 text-secondary"></i>{{ $estadia->nombre_estadia }}</strong> 
                                <span class="badge bg-secondary">{{ $estadia->tipo_estadia }}</span>
                                <br><small class="text-muted">
                                    <i class="fas fa-map-marker-alt me-1"></i>{{ $estadia->ubicacion }} | 
                                    <i class="far fa-calendar me-1"></i>{{ $estadia->fecha?->format('d/m/Y') }} | 
                                    Hab: {{ $estadia->habitacion }}
                                </small>
                            </div>
                            <button type="button" class="btn btn-sm btn-danger" onclick="eliminarEstadia(this)">
                                <i class="fas fa-trash"></i>
                            </button>
                            <input type="hidden" name="estadias[{{ $i }}][tipo_estadia]" value="{{ $estadia->tipo_estadia }}">
                            <input type="hidden" name="estadias[{{ $i }}][nombre_estadia]" value="{{ $estadia->nombre_estadia }}">
                            <input type="hidden" name="estadias[{{ $i }}][ubicacion]" value="{{ $estadia->ubicacion }}">
                            <input type="hidden" name="estadias[{{ $i }}][fecha]" value="{{ $estadia->fecha?->format('Y-m-d') }}">
                            <input type="hidden" name="estadias[{{ $i }}][habitacion]" value="{{ $estadia->habitacion }}">
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>

    {{-- ========================================
        BOTONES DE ACCIÓN FINAL
    ======================================== --}}
    <div class="d-flex gap-3 mb-5">
        <button type="submit" class="btn btn-primary btn-lg px-5">
            <i class="fas fa-save me-2"></i>
            {{ $mode === 'create' ? 'Crear Reserva' : 'Actualizar Reserva' }}
        </button>
        <a href="{{ route('admin.reservas.index') }}" class="btn btn-secondary btn-lg px-5">
            <i class="fas fa-times me-2"></i> Cancelar
        </a>
    </div>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        
        // Variables globales
        let depositoIndex = {{ $mode === 'edit' ? $reserva->depositos->count() : 0 }};
        let tourIndex = {{ $mode === 'edit' ? $reserva->toursReservas->count() : 0 }};
        let estadiaIndex = {{ $mode === 'edit' ? $reserva->estadias->count() : 0 }};
        let tourEditando = null;

        const pasajerosAgregados = new Set();
        @if($mode === 'edit')
            @foreach($reserva->pasajeros as $p)
                pasajerosAgregados.add('{{ $p->id }}');
            @endforeach
        @endif

        // Mapeos de tours especiales
        const toursMachupicchu = [
            'Machupicchu Full Day',
            'Machupicchu Conexión',
            'Machupicchu 2D/1N',
            'Machupicchu By car'
        ];

        const toursBoleto = [
            'Valle Sagrado',
            'City Tour',
            'Valle Sur',
            'Maras Moray',
            'Valle Sagrado VIP'
        ];

        const lugaresPrivados = {
            'City Tour': 'Qoricancha',
            'Valle Sagrado': 'Salineras',
            'Valle Sagrado VIP': 'Salineras',
            'Maras Moray': 'Salineras',
            'Valle Sur': 'Andahuaylillas'
        };

        // =============================================================================
        // 1. TIPO RESERVA → PROVEEDOR
        // =============================================================================
        const tipoReserva = document.getElementById('tipo_reserva');
        const proveedorContainer = document.getElementById('proveedor_container');

        tipoReserva.addEventListener('change', function() {
            proveedorContainer.style.display = (this.value === 'Agencia') ? 'block' : 'none';
            if (this.value !== 'Agencia') {
                document.getElementById('proveedor_id').value = '';
            }
        });

        if (tipoReserva.value === 'Agencia') {
            proveedorContainer.style.display = 'block';
        }

        // =============================================================================
        // 2. TITULAR
        // =============================================================================
        window.seleccionarTitular = function() {
            const input = document.getElementById('busquedaTitular');
            const valor = input.value.trim();
            
            if (!valor) {
                alert('Escribe o selecciona un pasajero.');
                return;
            }

            const options = document.querySelectorAll('#listaTitulares option');
            let encontrado = false;
            
            options.forEach(opt => {
                if (opt.value === valor) {
                    const id = opt.dataset.id;
                    document.getElementById('titular_id').value = id;
                    
                    document.getElementById('titularSeleccionado').innerHTML = `
                        <div class="alert alert-success p-2 mb-0">
                            <i class="fas fa-user-check me-2"></i>
                            <strong>${valor}</strong>
                        </div>
                    `;
                    encontrado = true;
                }
            });

            if (!encontrado) {
                alert('Selecciona un pasajero válido de la lista.');
            }
        };

        // =============================================================================
        // 3. PASAJEROS
        // =============================================================================
        window.agregarPasajero = function() {
            const input = document.getElementById('busquedaPasajero');
            const valor = input.value.trim();
            
            if (!valor) return;

            const options = document.querySelectorAll('#listaPasajeros option');
            let id = null;
            let nombre = '';
            
            options.forEach(opt => {
                if (opt.value === valor) {
                    id = opt.dataset.id;
                    nombre = opt.value;
                }
            });

            if (!id) {
                alert('Selecciona un pasajero válido.');
                return;
            }

            if (pasajerosAgregados.has(id)) {
                alert('Este pasajero ya está agregado.');
                return;
            }

            pasajerosAgregados.add(id);

            const lista = document.getElementById('listaPasajerosAgregados');
            const div = document.createElement('div');
            div.className = 'list-group-item d-flex justify-content-between align-items-center';
            div.dataset.id = id;
            div.innerHTML = `
                <div>
                    <i class="fas fa-user me-2 text-primary"></i>
                    ${nombre}
                </div>
                <div>
                    <input type="hidden" name="pasajeros[]" value="${id}">
                    <button type="button" class="btn btn-sm btn-danger" onclick="eliminarPasajero(this)">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            `;
            lista.appendChild(div);
            
            input.value = '';
            actualizarIntegrantesTour();
        };

        window.eliminarPasajero = function(btn) {
            const item = btn.closest('.list-group-item');
            const id = item.dataset.id;
            pasajerosAgregados.delete(id);
            item.remove();
            actualizarIntegrantesTour();
        };

        // =============================================================================
        // 4. DEPÓSITOS
        // =============================================================================
        window.agregarDeposito = function() {
            const nombre = document.getElementById('deposito_nombre').value.trim();
            const monto = parseFloat(document.getElementById('deposito_monto').value) || 0;
            const fecha = document.getElementById('deposito_fecha').value;
            const tipo = document.getElementById('deposito_tipo').value;
            const obs = document.getElementById('deposito_obs').value.trim();

            if (!nombre || monto <= 0 || !fecha || !tipo) {
                alert('Completa todos los campos obligatorios.');
                return;
            }

            const lista = document.getElementById('listaDepositos');
            const div = document.createElement('div');
            div.className = 'list-group-item';
            div.innerHTML = `
                <div class="d-flex justify-content-between">
                    <div>
                        <strong>${nombre}</strong> - $${monto.toFixed(2)} 
                        <span class="badge bg-info">${tipo}</span>
                        <br><small class="text-muted">${formatearFecha(fecha)}</small>
                    </div>
                    <button type="button" class="btn btn-sm btn-danger" onclick="eliminarDeposito(this)">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
                <input type="hidden" name="depositos[${depositoIndex}][nombre_depositante]" value="${nombre}">
                <input type="hidden" name="depositos[${depositoIndex}][monto]" value="${monto}">
                <input type="hidden" name="depositos[${depositoIndex}][fecha]" value="${fecha}">
                <input type="hidden" name="depositos[${depositoIndex}][tipo_deposito]" value="${tipo}">
                <input type="hidden" name="depositos[${depositoIndex}][observaciones]" value="${obs}">
            `;
            lista.appendChild(div);
            depositoIndex++;

            // Limpiar
            document.getElementById('deposito_nombre').value = '';
            document.getElementById('deposito_monto').value = '';
            document.getElementById('deposito_fecha').value = '';
            document.getElementById('deposito_tipo').value = '';
            document.getElementById('deposito_obs').value = '';

            calcularFinanzas();
        };

        window.eliminarDeposito = function(btn) {
            btn.closest('.list-group-item').remove();
            calcularFinanzas();
        };

        function calcularFinanzas() {
            const total = parseFloat(document.getElementById('total').value) || 0;
            let adelanto = 0;

            document.querySelectorAll('#listaDepositos input[name*="[monto]"]').forEach(input => {
                adelanto += parseFloat(input.value) || 0;
            });

            const saldo = total - adelanto;

            document.getElementById('adelanto_display').value = adelanto.toFixed(2);
            document.getElementById('saldo_display').value = saldo.toFixed(2);
        }

        document.getElementById('total').addEventListener('input', calcularFinanzas);

        // =============================================================================
        // 5. TOURS - SELECTOR Y CAMPOS ESPECIALES
        // =============================================================================
        const tourSelect = document.getElementById('tour_id');
        
        tourSelect.addEventListener('change', function() {
            const opt = this.options[this.selectedIndex];
            const nombreTour = opt.dataset.nombre || '';

            // Limpiar todos los campos especiales primero
            limpiarCamposEspeciales();

            // Verificar tipo de tour
            const esMachu = toursMachupicchu.includes(nombreTour);
            const esBoleto = toursBoleto.includes(nombreTour);

            // Mostrar/ocultar secciones
            document.getElementById('detalles_machupicchu').classList.toggle('d-none', !esMachu);
            document.getElementById('detalles_boleto').classList.toggle('d-none', !esBoleto);

            // Configurar campos especiales para Boleto Turístico
            if (esBoleto) {
                const lugarPrivado = lugaresPrivados[nombreTour];
                if (lugarPrivado) {
                    document.getElementById('nombre_propiedad_privada').textContent = lugarPrivado;
                    document.getElementById('boleto_propiedad_privada_fields').style.display = 'block';
                }
            }

            // Configurar hospedaje para Machupicchu 2D/1N y By Car
            if (nombreTour === 'Machupicchu 2D/1N' || nombreTour === 'Machupicchu By car') {
                document.getElementById('machu_hospedaje_fields').style.display = 'block';
            }

            // Mostrar campos By Car
            if (nombreTour === 'Machupicchu By car') {
                document.getElementById('machu_bycar_fields').style.display = 'block';
            }
        });

        // =============================================================================
        // 6. MACHUPICCHU - LÓGICA CONDICIONAL
        // =============================================================================
        
        // Entrada
        const machuHayEntrada = document.getElementById('machu_hay_entrada');
        machuHayEntrada?.addEventListener('change', function() {
            const entradaFields = document.getElementById('machu_entrada_fields');
            const comentarioField = document.getElementById('machu_comentario_entrada_field');
            
            if (this.value == '1') {
                entradaFields.style.display = 'block';
                comentarioField.style.display = 'none';
            } else if (this.value == '0') {
                entradaFields.style.display = 'none';
                comentarioField.style.display = 'block';
            } else {
                entradaFields.style.display = 'none';
                comentarioField.style.display = 'none';
            }
        });

        // Tipo de entrada → rutas
        const machuTipoEntrada = document.getElementById('machu_tipo_entrada');
        machuTipoEntrada?.addEventListener('change', function() {
            document.getElementById('machu_ruta1_field').style.display = 
                (this.value === 'circuito1') ? 'block' : 'none';
            document.getElementById('machu_ruta2_field').style.display = 
                (this.value === 'circuito2') ? 'block' : 'none';
            document.getElementById('machu_ruta3_field').style.display = 
                (this.value === 'circuito3') ? 'block' : 'none';
        });

        // Tipo de tren
        const machuTipoTren = document.getElementById('machu_tipo_tren');
        machuTipoTren?.addEventListener('change', function() {
            const turisticoFields = document.getElementById('machu_tren_turistico_fields');
            const localFields = document.getElementById('machu_tren_local_fields');
            const fechasFields = document.getElementById('machu_tren_fechas_fields');

            if (this.value === 'Turístico') {
                turisticoFields.style.display = 'block';
                localFields.style.display = 'none';
                fechasFields.style.display = 'block';
            } else if (this.value === 'Local') {
                turisticoFields.style.display = 'none';
                localFields.style.display = 'block';
                fechasFields.style.display = 'block';
            } else {
                turisticoFields.style.display = 'none';
                localFields.style.display = 'none';
                fechasFields.style.display = 'none';
            }
        });

        // Tiene ticket (tren local)
        const machuTieneTicket = document.getElementById('machu_tiene_ticket');
        machuTieneTicket?.addEventListener('change', function() {
            const comentarioField = document.getElementById('machu_comentario_ticket_field');
            comentarioField.style.display = (this.value !== '') ? 'block' : 'none';
        });

        // Consetur
        const machuTipoServicio = document.getElementById('machu_tipo_servicio');
        machuTipoServicio?.addEventListener('change', function() {
            const show = (this.value === 'Comprar' || this.value === 'Tiene');
            document.getElementById('machu_tipo_consetur_field').style.display = show ? 'block' : 'none';
            document.getElementById('machu_comentario_consetur_field').style.display = show ? 'block' : 'none';
        });

        // Transporte ida
        const machuTranspIda = document.getElementById('machu_transp_ida');
        machuTranspIda?.addEventListener('change', function() {
            const show = (this.value !== '');
            document.getElementById('machu_horario_recojo_ida_field').style.display = show ? 'block' : 'none';
            document.getElementById('machu_comentario_trans_ida_field').style.display = show ? 'block' : 'none';
        });

        // Transporte retorno
        const machuTranspRet = document.getElementById('machu_transp_ret');
        machuTranspRet?.addEventListener('change', function() {
            const show = (this.value !== '');
            document.getElementById('machu_horario_recojo_ret_field').style.display = show ? 'block' : 'none';
            document.getElementById('machu_comentario_trans_ret_field').style.display = show ? 'block' : 'none';
        });

        // =============================================================================
        // 7. BOLETO TURÍSTICO - LÓGICA CONDICIONAL
        // =============================================================================
        
        const boletoTipo = document.getElementById('boleto_tipo_boleto');
        boletoTipo?.addEventListener('change', function() {
            document.getElementById('boleto_requiere_compra_field').style.display = 
                (this.value !== '') ? 'block' : 'none';
        });

        const boletoRequiereCompra = document.getElementById('boleto_requiere_compra');
        boletoRequiereCompra?.addEventListener('change', function() {
            document.getElementById('boleto_tipo_compra_field').style.display = 
                (this.value == '1') ? 'block' : 'none';
        });

        const boletoIncluyePriv = document.getElementById('boleto_incluye_entrada_priv');
        boletoIncluyePriv?.addEventListener('change', function() {
            const show = (this.value == '1');
            document.getElementById('boleto_quien_compra_priv_field').style.display = show ? 'block' : 'none';
            document.getElementById('boleto_comentario_priv_field').style.display = 
                (this.value !== '') ? 'block' : 'none';
        });

        // =============================================================================
        // 8. INTEGRANTES DEL TOUR
        // =============================================================================
        document.querySelectorAll('input[name="tour_modo"]').forEach(radio => {
            radio.addEventListener('change', function() {
                const personalizado = document.getElementById('integrantes_personalizados');
                if (this.value === 'personalizado') {
                    personalizado.classList.remove('d-none');
                    actualizarIntegrantesTour();
                } else {
                    personalizado.classList.add('d-none');
                }
            });
        });

        function actualizarIntegrantesTour() {
            const contenedor = document.getElementById('lista_integrantes_tour');
            contenedor.innerHTML = '';

            const pasajeros = document.querySelectorAll('#listaPasajerosAgregados .list-group-item');
            
            if (pasajeros.length === 0) {
                contenedor.innerHTML = '<div class="col-12"><div class="alert alert-warning">Primero agrega pasajeros a la reserva</div></div>';
                return;
            }

            pasajeros.forEach(item => {
                const id = item.dataset.id;
                const nombre = item.querySelector('div').textContent.trim();
                
                const div = document.createElement('div');
                div.className = 'col-md-6 mb-2';
                div.innerHTML = `
                    <div class="card">
                        <div class="card-body p-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" 
                                    value="${id}" id="integrante_${id}" 
                                    name="tour_pasajeros[]">
                                <label class="form-check-label" for="integrante_${id}">
                                    ${nombre}
                                </label>
                            </div>
                            <input type="text" class="form-control form-control-sm mt-1" 
                                placeholder="Comentario (opcional)" 
                                name="tour_comentarios[${id}]">
                        </div>
                    </div>
                `;
                contenedor.appendChild(div);
            });
        }

        // =============================================================================
        // 9. GUARDAR TOUR
        // =============================================================================
        window.guardarTour = function() {
            const tourId = document.getElementById('tour_id').value;
            const tourOpt = document.querySelector(`#tour_id option[value="${tourId}"]`);
            
            if (!tourId) {
                alert('Selecciona un tour.');
                return;
            }

            const nombreTour = tourOpt.dataset.nombre;
            const fecha = document.getElementById('tour_fecha').value;
            const tipo = document.getElementById('tour_tipo').value;
            const estado = document.getElementById('tour_estado').value;
            const precio = document.getElementById('tour_precio').value;
            const cantidad = document.getElementById('tour_cantidad').value;

            const index = tourEditando !== null ? tourEditando : tourIndex;

            // Recopilar todos los datos del tour
            const tourData = {
                tour_id: tourId,
                nombreTour: nombreTour,
                fecha: fecha,
                tipo_tour: tipo,
                estado: estado,
                lugar_recojo: document.getElementById('tour_lugar_recojo').value,
                hora_recojo: document.getElementById('tour_hora_recojo').value,
                idioma: document.getElementById('tour_idioma').value,
                empresa: document.getElementById('tour_empresa').value,
                precio_unitario: precio,
                cantidad: cantidad,
                observaciones: document.getElementById('tour_observaciones').value,
                incluye_entrada: document.getElementById('tour_incluye_entrada').checked ? '1' : '0',
                incluye_tren: document.getElementById('tour_incluye_tren').checked ? '1' : '0'
            };

            // Recopilar modo de integrantes
            const modo = document.querySelector('input[name="tour_modo"]:checked').value;
            tourData.modo = modo;

            // Si es personalizado, recopilar pasajeros seleccionados
            if (modo === 'personalizado') {
                tourData.pasajeros = [];
                tourData.comentarios = {};
                document.querySelectorAll('input[name="tour_pasajeros[]"]:checked').forEach(chk => {
                    const pasajeroId = chk.value;
                    tourData.pasajeros.push(pasajeroId);
                    const comentario = document.querySelector(`input[name="tour_comentarios[${pasajeroId}]"]`).value;
                    if (comentario) {
                        tourData.comentarios[pasajeroId] = comentario;
                    }
                });
            }

            // Recopilar detalles de Machupicchu si aplica
            if (toursMachupicchu.includes(nombreTour)) {
                tourData.detalles_machu = {
                    hay_entrada: getValue('machu_hay_entrada'),
                    tipo_entrada: getValue('machu_tipo_entrada'),
                    ruta1: getValue('machu_ruta1'),
                    ruta2: getValue('machu_ruta2'),
                    ruta3: getValue('machu_ruta3'),
                    horario_entrada: getValue('machu_horario_entrada'),
                    comentario_entrada: getValue('machu_comentario_entrada'),
                    tipo_tren: getValue('machu_tipo_tren'),
                    empresa_tren: getValue('machu_empresa_tren'),
                    codigo_tren: getValue('machu_codigo_tren'),
                    horario_ida: getValue('machu_horario_ida'),
                    horario_retorno: getValue('machu_horario_retorno'),
                    fecha_tren_ida: getValue('machu_fecha_tren_ida'),
                    fecha_tren_retorno: getValue('machu_fecha_tren_retorno'),
                    tiene_ticket: getValue('machu_tiene_ticket'),
                    comentario_ticket: getValue('machu_comentario_ticket'),
                    fecha_ida: getValue('machu_fecha_ida'),
                    fecha_retorno: getValue('machu_fecha_retorno'),
                    hospedaje: getValue('machu_hospedaje'),
                    tipo_servicio: getValue('machu_tipo_servicio'),
                    tipo_consetur: getValue('machu_tipo_consetur'),
                    comentario_consetur: getValue('machu_comentario_consetur'),
                    transp_ida: getValue('machu_transp_ida'),
                    horario_recojo_ida: getValue('machu_horario_recojo_ida'),
                    comentario_trans_ida: getValue('machu_comentario_trans_ida'),
                    transp_ret: getValue('machu_transp_ret'),
                    horario_recojo_ret: getValue('machu_horario_recojo_ret'),
                    comentario_trans_ret: getValue('machu_comentario_trans_ret')
                };
            }

            // Recopilar detalles de Boleto Turístico si aplica
            if (toursBoleto.includes(nombreTour)) {
                tourData.detalles_boleto = {
                    tipo_boleto: getValue('boleto_tipo_boleto'),
                    requiere_compra: getValue('boleto_requiere_compra'),
                    tipo_compra: getValue('boleto_tipo_compra'),
                    incluye_entrada_propiedad_priv: getValue('boleto_incluye_entrada_priv'),
                    quien_compra_propiedad_priv: getValue('boleto_quien_compra_priv'),
                    comentario_entrada_propiedad_priv: getValue('boleto_comentario_priv')
                };
            }

            // Agregar o actualizar en la lista
            agregarTourALista(index, tourData);

            if (tourEditando === null) {
                tourIndex++;
            }

            cancelarTour();
        };

        function agregarTourALista(index, data) {
            const lista = document.getElementById('listaTours');
            let item = tourEditando !== null 
                ? lista.querySelector(`[data-index="${index}"]`)
                : document.createElement('div');

            if (tourEditando === null) {
                item.className = 'list-group-item';
                item.dataset.index = index;
            }

            const estadoBadge = data.estado === 'Programado' ? 'warning' : 
                            data.estado === 'Confirmado' ? 'success' : 
                            data.estado === 'Cancelado' ? 'danger' : 'secondary';

            item.innerHTML = `
                <div class="d-flex justify-content-between align-items-start">
                    <div class="flex-grow-1">
                        <h6 class="mb-1">
                            <i class="fas fa-route me-2 text-primary"></i>
                            ${data.nombreTour}
                        </h6>
                        <div class="d-flex flex-wrap gap-2 mb-2">
                            <span class="badge bg-info">
                                <i class="far fa-calendar me-1"></i>${formatearFecha(data.fecha)}
                            </span>
                            <span class="badge bg-secondary">${data.tipo_tour}</span>
                            <span class="badge bg-${estadoBadge}">${data.estado}</span>
                            <span class="badge bg-dark">$${parseFloat(data.precio_unitario).toFixed(2)} x ${data.cantidad}</span>
                        </div>
                        ${data.lugar_recojo ? `<small class="text-muted"><i class="fas fa-map-marker-alt me-1"></i>${data.lugar_recojo} | <i class="far fa-clock me-1"></i>${data.hora_recojo}</small>` : ''}
                    </div>
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-warning" onclick="editarTour(${index})">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-danger" onclick="eliminarTour(this)">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
                ${crearHiddenInputs(index, data)}
            `;

            if (tourEditando === null) {
                lista.appendChild(item);
            }
        }

        function crearHiddenInputs(index, data) {
            let html = `
                <input type="hidden" name="tours[${index}][tour_id]" value="${data.tour_id}">
                <input type="hidden" name="tours[${index}][fecha]" value="${data.fecha}">
                <input type="hidden" name="tours[${index}][tipo_tour]" value="${data.tipo_tour}">
                <input type="hidden" name="tours[${index}][estado]" value="${data.estado}">
                <input type="hidden" name="tours[${index}][lugar_recojo]" value="${data.lugar_recojo}">
                <input type="hidden" name="tours[${index}][hora_recojo]" value="${data.hora_recojo}">
                <input type="hidden" name="tours[${index}][idioma]" value="${data.idioma}">
                <input type="hidden" name="tours[${index}][empresa]" value="${data.empresa}">
                <input type="hidden" name="tours[${index}][precio_unitario]" value="${data.precio_unitario}">
                <input type="hidden" name="tours[${index}][cantidad]" value="${data.cantidad}">
                <input type="hidden" name="tours[${index}][observaciones]" value="${data.observaciones}">
                <input type="hidden" name="tours[${index}][incluye_entrada]" value="${data.incluye_entrada}">
                <input type="hidden" name="tours[${index}][incluye_tren]" value="${data.incluye_tren}">
                <input type="hidden" name="tours[${index}][modo]" value="${data.modo}">
            `;

            // Pasajeros
            if (data.modo === 'personalizado' && data.pasajeros) {
                data.pasajeros.forEach(pid => {
                    html += `<input type="hidden" name="tours[${index}][pasajeros][]" value="${pid}">`;
                    if (data.comentarios && data.comentarios[pid]) {
                        html += `<input type="hidden" name="tours[${index}][comentarios][${pid}]" value="${data.comentarios[pid]}">`;
                    }
                });
            }

            // Detalles Machupicchu
            if (data.detalles_machu) {
                Object.keys(data.detalles_machu).forEach(key => {
                    const val = data.detalles_machu[key];
                    if (val) {
                        html += `<input type="hidden" name="tours[${index}][detalles_machu][${key}]" value="${val}">`;
                    }
                });
            }

            // Detalles Boleto
            if (data.detalles_boleto) {
                Object.keys(data.detalles_boleto).forEach(key => {
                    const val = data.detalles_boleto[key];
                    if (val) {
                        html += `<input type="hidden" name="tours[${index}][detalles_boleto][${key}]" value="${val}">`;
                    }
                });
            }

            return html;
        }

        window.editarTour = function(index) {
            // Implementación simplificada - cargar valores de los hidden inputs
            alert('Función de editar tour - cargar valores del tour ' + index);
            tourEditando = index;
            document.getElementById('btn_tour_text').textContent = 'Actualizar Tour';
            
            const collapse = new bootstrap.Collapse(document.getElementById('formTour'), {
                toggle: true
            });
        };

        window.eliminarTour = function(btn) {
            if (confirm('¿Eliminar este tour?')) {
                btn.closest('.list-group-item').remove();
            }
        };

        window.cancelarTour = function() {
            tourEditando = null;
            limpiarFormularioTour();
            document.getElementById('btn_tour_text').textContent = 'Agregar Tour';
            
            const collapse = bootstrap.Collapse.getInstance(document.getElementById('formTour'));
            if (collapse) collapse.hide();
        };

        // =============================================================================
        // 10. ESTADÍAS
        // =============================================================================
        window.agregarEstadia = function() {
            const tipo = document.getElementById('estadia_tipo').value;
            const nombre = document.getElementById('estadia_nombre').value.trim();
            const ubicacion = document.getElementById('estadia_ubicacion').value.trim();
            const fecha = document.getElementById('estadia_fecha').value;
            const habitacion = document.getElementById('estadia_habitacion').value.trim();

            if (!nombre) {
                alert('Ingresa el nombre de la estadía.');
                return;
            }

            const lista = document.getElementById('listaEstadias');
            const div = document.createElement('div');
            div.className = 'list-group-item d-flex justify-content-between align-items-center';
            div.innerHTML = `
                <div>
                    <strong><i class="fas fa-bed me-2 text-secondary"></i>${nombre}</strong> 
                    <span class="badge bg-secondary">${tipo}</span>
                    <br><small class="text-muted">
                        <i class="fas fa-map-marker-alt me-1"></i>${ubicacion || 'Sin ubicación'} | 
                        <i class="far fa-calendar me-1"></i>${formatearFecha(fecha)} | 
                        Hab: ${habitacion || 'N/A'}
                    </small>
                </div>
                <button type="button" class="btn btn-sm btn-danger" onclick="eliminarEstadia(this)">
                    <i class="fas fa-trash"></i>
                </button>
                <input type="hidden" name="estadias[${estadiaIndex}][tipo_estadia]" value="${tipo}">
                <input type="hidden" name="estadias[${estadiaIndex}][nombre_estadia]" value="${nombre}">
                <input type="hidden" name="estadias[${estadiaIndex}][ubicacion]" value="${ubicacion}">
                <input type="hidden" name="estadias[${estadiaIndex}][fecha]" value="${fecha}">
                <input type="hidden" name="estadias[${estadiaIndex}][habitacion]" value="${habitacion}">
            `;
            lista.appendChild(div);
            estadiaIndex++;

            // Limpiar formulario
            document.getElementById('estadia_nombre').value = '';
            document.getElementById('estadia_ubicacion').value = '';
            document.getElementById('estadia_fecha').value = '';
            document.getElementById('estadia_habitacion').value = '';
        };

        window.eliminarEstadia = function(btn) {
            if (confirm('¿Eliminar esta estadía?')) {
                btn.closest('.list-group-item').remove();
            }
        };

        // =============================================================================
        // UTILIDADES
        // =============================================================================
        function formatearFecha(fecha) {
            if (!fecha) return 'Sin fecha';
            const [y, m, d] = fecha.split('-');
            return `${d}/${m}/${y}`;
        }

        function getValue(id) {
            const el = document.getElementById(id);
            return el ? el.value : '';
        }

        function limpiarFormularioTour() {
            // Limpiar campos básicos
            document.getElementById('tour_id').value = '';
            document.getElementById('tour_fecha').value = '';
            document.getElementById('tour_tipo').value = 'Grupal';
            document.getElementById('tour_estado').value = 'Programado';
            document.getElementById('tour_lugar_recojo').value = '';
            document.getElementById('tour_hora_recojo').value = '';
            document.getElementById('tour_idioma').value = '';
            document.getElementById('tour_empresa').value = '';
            document.getElementById('tour_precio').value = '0';
            document.getElementById('tour_cantidad').value = '1';
            document.getElementById('tour_observaciones').value = '';
            document.getElementById('tour_incluye_entrada').checked = false;
            document.getElementById('tour_incluye_tren').checked = false;

            // Resetear modo de integrantes
            document.getElementById('modo_todos').checked = true;
            document.getElementById('integrantes_personalizados').classList.add('d-none');

            // Limpiar campos especiales
            limpiarCamposEspeciales();

            // Ocultar secciones especiales
            document.getElementById('detalles_machupicchu').classList.add('d-none');
            document.getElementById('detalles_boleto').classList.add('d-none');
        }

        function limpiarCamposEspeciales() {
            // Machupicchu
            const camposMachu = [
                'machu_hay_entrada', 'machu_tipo_entrada', 'machu_ruta1', 'machu_ruta2', 'machu_ruta3',
                'machu_horario_entrada', 'machu_comentario_entrada',
                'machu_tipo_tren', 'machu_empresa_tren', 'machu_codigo_tren',
                'machu_horario_ida', 'machu_horario_retorno',
                'machu_fecha_tren_ida', 'machu_fecha_tren_retorno',
                'machu_tiene_ticket', 'machu_comentario_ticket',
                'machu_fecha_ida', 'machu_fecha_retorno', 'machu_hospedaje',
                'machu_tipo_servicio', 'machu_tipo_consetur', 'machu_comentario_consetur',
                'machu_transp_ida', 'machu_horario_recojo_ida', 'machu_comentario_trans_ida',
                'machu_transp_ret', 'machu_horario_recojo_ret', 'machu_comentario_trans_ret'
            ];

            camposMachu.forEach(id => {
                const el = document.getElementById(id);
                if (el) el.value = '';
            });

            // Boleto Turístico
            const camposBoleto = [
                'boleto_tipo_boleto', 'boleto_requiere_compra', 'boleto_tipo_compra',
                'boleto_incluye_entrada_priv', 'boleto_quien_compra_priv', 'boleto_comentario_priv'
            ];

            camposBoleto.forEach(id => {
                const el = document.getElementById(id);
                if (el) el.value = '';
            });

            // Ocultar todos los campos condicionales
            const fieldsToHide = [
                'machu_entrada_fields', 'machu_comentario_entrada_field',
                'machu_ruta1_field', 'machu_ruta2_field', 'machu_ruta3_field',
                'machu_tren_turistico_fields', 'machu_tren_local_fields', 'machu_tren_fechas_fields',
                'machu_comentario_ticket_field', 'machu_tipo_consetur_field', 'machu_comentario_consetur_field',
                'machu_horario_recojo_ida_field', 'machu_comentario_trans_ida_field',
                'machu_horario_recojo_ret_field', 'machu_comentario_trans_ret_field',
                'machu_hospedaje_fields', 'machu_bycar_fields',
                'boleto_requiere_compra_field', 'boleto_tipo_compra_field',
                'boleto_propiedad_privada_fields', 'boleto_quien_compra_priv_field', 'boleto_comentario_priv_field'
            ];

            fieldsToHide.forEach(id => {
                const el = document.getElementById(id);
                if (el) el.style.display = 'none';
            });
        }

        // Inicializar
        calcularFinanzas();
    });
</script>


