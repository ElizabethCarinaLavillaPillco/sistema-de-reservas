    <style>
        :root {
            --primary: #14a5b5;
            --primary-light: #5ec8d4;
            --primary-dark: #0e7e8a;
            --primary-transparent: rgba(20, 165, 181, 0.1);
            --secondary: #f8f9fa;
            --accent: #ff6b6b;
            --success: #28a745;
            --warning: #ffc107;
            --dark: #2d3e50;
            --light: #f8f9fa;
            --border-radius: 12px;
            --shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            --shadow-hover: 0 8px 25px rgba(0, 0, 0, 0.12);
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f7f9;
            color: #495057;
        }

        .form-container {
            background: white;
            border-radius: var(--border-radius);
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: var(--shadow);
        }

        .form-header {
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid var(--primary-light);
        }

        .form-title {
            font-size: 1.8rem;
            font-weight: 600;
            color: var(--dark);
            margin: 0;
        }

        .form-section {
            margin-bottom: 2.5rem;
            padding: 1.5rem;
            border-radius: var(--border-radius);
            background: var(--light);
            border-left: 4px solid var(--primary);
        }

        .form-section-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--primary-dark);
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-label {
            font-weight: 500;
            color: var(--dark);
            margin-bottom: 0.5rem;
        }

        .form-control, .form-select {
            border-radius: var(--border-radius);
            padding: 0.75rem 1rem;
            border: 2px solid #e9ecef;
            transition: all 0.3s;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.25rem rgba(20, 165, 181, 0.25);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            border: none;
            border-radius: var(--border-radius);
            padding: 0.75rem 1.5rem;
            font-weight: 500;
            color: white;
            transition: all 0.3s;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 100%);
            transform: translateY(-2px);
            box-shadow: var(--shadow-hover);
        }

        .btn-secondary {
            background: #6c757d;
            border: none;
            border-radius: var(--border-radius);
            padding: 0.75rem 1.5rem;
            font-weight: 500;
            color: white;
            transition: all 0.3s;
        }

        .btn-secondary:hover {
            background: #5a6268;
            color: white;
        }

        .btn-outline-primary {
            border: 2px solid var(--primary);
            border-radius: var(--border-radius);
            padding: 0.5rem 1rem;
            font-weight: 500;
            color: var(--primary);
            transition: all 0.3s;
        }

        .btn-outline-primary:hover {
            background: var(--primary);
            color: white;
        }

        .btn-success {
            background: var(--success);
            border: none;
            border-radius: var(--border-radius);
            padding: 0.5rem 1rem;
            font-weight: 500;
            color: white;
            transition: all 0.3s;
        }

        .btn-success:hover {
            background: #218838;
            transform: translateY(-2px);
        }

        .btn-warning {
            background: var(--warning);
            border: none;
            border-radius: var(--border-radius);
            padding: 0.5rem 1rem;
            font-weight: 500;
            color: #212529;
            transition: all 0.3s;
        }

        .btn-warning:hover {
            background: #e0a800;
            transform: translateY(-2px);
        }

        .btn-danger {
            background: #dc3545;
            border: none;
            border-radius: var(--border-radius);
            padding: 0.5rem 1rem;
            font-weight: 500;
            color: white;
            transition: all 0.3s;
        }

        .btn-danger:hover {
            background: #c82333;
            transform: translateY(-2px);
        }

        .list-group-item {
            border-radius: var(--border-radius);
            margin-bottom: 0.5rem;
            border: 1px solid rgba(0, 0, 0, 0.1);
            transition: all 0.3s;
        }

        .list-group-item:hover {
            background-color: var(--primary-transparent);
            transform: translateX(5px);
        }

        .alert {
            border-radius: var(--border-radius);
            border: none;
            padding: 0.75rem 1rem;
        }

        .badge {
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-weight: 500;
        }

        .badge-primary {
            background-color: var(--primary-transparent);
            color: var(--primary);
        }

        .badge-success {
            background-color: rgba(40, 167, 69, 0.15);
            color: var(--success);
        }

        .card {
            border: none;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            margin-bottom: 1.5rem;
        }

        .card-header {
            background: linear-gradient(to right, var(--primary), var(--primary-light));
            color: white;
            font-weight: 600;
            padding: 1rem 1.5rem;
            border-bottom: none;
            border-radius: var(--border-radius) var(--border-radius) 0 0;
        }

        .card-body {
            padding: 1.5rem;
        }

        .detail-container {
            background: white;
            border-radius: var(--border-radius);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: var(--shadow);
        }

        .detail-item {
            margin-bottom: 0.75rem;
            display: flex;
            flex-wrap: wrap;
        }

        .detail-label {
            font-weight: 600;
            min-width: 150px;
            color: var(--primary-dark);
        }

        .detail-value {
            flex: 1;
        }

        /* Animaciones */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes slideIn {
            from { transform: translateX(-20px); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        .animate-fade-in {
            animation: fadeIn 0.5s ease;
        }

        .animate-slide-in {
            animation: slideIn 0.5s ease;
        }

        /* Estados de edición */
        .editing {
            background-color: #fff3cd;
            border: 1px solid #ffeeba;
        }

        .flash {
            animation: flashHighlight 1s ease-in-out 2;
        }

        @keyframes flashHighlight {
            0% { background-color: #fff3cd; }
            50% { background-color: #ffe8a1; }
            100% { background-color: #fff3cd; }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .form-container {
                padding: 1.5rem;
            }
            
            .form-section {
                padding: 1rem;
            }
            
            .detail-item {
                flex-direction: column;
            }
            
            .detail-label {
                min-width: auto;
                margin-bottom: 0.25rem;
            }
        }

        /* Estilos para campos condicionales */
        .conditional-field {
            overflow: hidden;
            max-height: 0;
            opacity: 0;
            transition: all 0.5s ease;
        }
        
        .conditional-field.show {
            max-height: 500px;
            opacity: 1;
            margin-top: 1rem;
            padding: 1rem;
            background: white;
            border-radius: var(--border-radius);
            border-left: 4px solid var(--primary-light);
        }

        /* Mejoras visuales para elementos de lista */
        .item-summary {
            padding: 1rem;
            border-radius: var(--border-radius);
            background: white;
            margin-bottom: 1rem;
            box-shadow: var(--shadow);
            transition: all 0.3s;
        }

        .item-summary:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-hover);
        }

        /* Estilos para el rango de fechas */
        .date-range-container {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .date-range-separator {
            font-weight: bold;
            color: var(--primary);
        }

        @media (max-width: 576px) {
            .date-range-container {
                flex-direction: column;
            }
            
            .date-range-separator {
                padding: 0.5rem 0;
            }
        }
    </style>


{{-- FORMULARIO RESERVA (create & edit) --}}
@if($mode === 'create')
    <form action="{{ route('admin.reservas.store') }}" method="POST">
@else
    <form action="{{ route('admin.reservas.update', $reserva->id) }}" method="POST">
        @method('PUT')
@endif
@csrf

            <!-- SECCIÓN: INFORMACIÓN BÁSICA -->
            <div class="form-section animate-slide-in">
                <h3 class="form-section-title">
                    <i class="fas fa-info-circle"></i> Información Básica
                </h3>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="tipo_reserva" class="form-label">Tipo de Reserva</label>
                        <select name="tipo_reserva" id="tipo_reserva" class="form-select" required>
                            <option value="">-- Seleccionar tipo --</option>
                            @foreach(['Directo','Recomendacion','Publicidad','Agencia'] as $tipo)
                                <option value="{{ $tipo }}"
                                    {{ old('tipo_reserva', $reserva->tipo_reserva ?? '') == $tipo ? 'selected' : '' }}>
                                    {{ $tipo }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- PROVEEDOR (solo si tipo = Agencia) -->
                    <div class="col-md-6 conditional-field" id="proveedor_container" style="{{ old('tipo_reserva', $reserva->tipo_reserva ?? '') === 'Agencia' ? 'max-height: 500px; opacity: 1;' : '' }}">
                        <label for="proveedor_id" class="form-label">Proveedor</label>
                        <select name="proveedor_id" id="proveedor_id" class="form-select">
                            <option value="">-- Seleccionar proveedor --</option>
                            @foreach($proveedores as $proveedor)
                                <option value="{{ $proveedor->id }}"
                                    {{ (string)old('proveedor_id', $reserva->proveedor_id ?? '') === (string)$proveedor->id ? 'selected' : '' }}>
                                    {{ $proveedor->nombreAgencia ?? $proveedor->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <!-- SECCIÓN: TITULAR Y PASAJEROS -->
            <div class="form-section animate-slide-in" style="animation-delay: 0.1s;">
                <h3 class="form-section-title">
                    <i class="fas fa-users"></i> Titular y Pasajeros
                </h3>
                
                <!-- TITULAR (BUSCADOR) -->
                <div class="detail-container mb-4">
                    <label class="form-label">Titular (buscar pasajero)</label>
                    <div class="input-group">
                        <input list="listaTitulares" id="busquedaTitular" class="form-control"
                            placeholder="Escribe nombre del pasajero (seleccionar)">
                        <datalist id="listaTitulares">
                            @foreach($pasajeros as $p)
                                <option value="{{ $p->nombre }} {{ $p->apellido }} ({{ $p->documento }})" data-id="{{ $p->id }}"></option>
                            @endforeach
                        </datalist>
                        <button type="button" id="btnSeleccionarTitular" class="btn btn-outline-primary">
                            <i class="fas fa-check me-1"></i> Seleccionar
                        </button>
                        <button type="button" id="btnLimpiarTitular" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-1"></i> Limpiar
                        </button>
                    </div>
                    
                    <input type="hidden" name="titular_id" id="titular_id_hidden"
                        value="{{ old('titular_id', $reserva->titular_id ?? '') }}">

                    <div id="titularSeleccionado" class="mt-2">
                        @if(old('titular_id', $reserva->titular_id ?? false))
                            @php
                                $titSel = $pasajeros->firstWhere('id', old('titular_id', $reserva->titular_id ?? null));
                            @endphp
                            @if($titSel)
                                <div class="alert alert-success mt-2">
                                    <i class="fas fa-user-check me-2"></i>
                                    Titular seleccionado: <strong>{{ $titSel->nombre }} {{ $titSel->apellido }} ({{ $titSel->documento }})</strong>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>

                <!-- PASAJEROS (MÚLTIPLES) -->
                <div class="detail-container">
                    <label class="form-label">Agregar Pasajeros</label>
                    <div class="input-group mb-3">
                        <input list="listaPasajeros" id="busquedaPasajero" class="form-control" 
                               placeholder="Escribe el nombre del pasajero">
                        <datalist id="listaPasajeros">
                            @foreach ($pasajeros as $pasajero)
                                <option value="{{ $pasajero->nombre }} {{ $pasajero->apellido }} ({{ $pasajero->documento }})" data-id="{{ $pasajero->id }}"></option>
                            @endforeach
                        </datalist>
                        <button type="button" onclick="agregarPasajero()" class="btn btn-primary">
                            <i class="fas fa-plus me-1"></i> Agregar
                        </button>
                    </div>

                    <div id="pasajerosSeleccionados">
                        <strong class="d-block mb-2">Pasajeros seleccionados:</strong>
                        <ul id="listaPasajerosAgregados" class="list-group">
                            @php
                                $pasajerosOld = old('pasajeros', $mode === 'edit'
                                    ? ($reserva->pasajeros->pluck('id')->toArray() ?? [])
                                    : []);
                            @endphp
                            @foreach($pasajerosOld as $pid)
                                @php $p = $pasajeros->firstWhere('id', $pid); @endphp
                                @if($p)
                                    <li class="list-group-item d-flex justify-content-between align-items-center" data-id="{{ $p->id }}">
                                        <div>
                                            <i class="fas fa-user me-2 text-primary"></i>
                                            {{ $p->nombre }} {{ $p->apellido }} ({{ $p->documento }})
                                        </div>
                                        <div>
                                            <input type="hidden" name="pasajeros[]" value="{{ $p->id }}">
                                            <button type="button" class="btn btn-sm btn-danger" onclick="eliminarPasajero(this, '{{ $p->id }}')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
                
                <input type="hidden" name="cantidad_pasajeros" id="cantidad_pasajeros" value="{{ count($pasajerosOld) }}">
            </div>

            <!-- SECCIÓN: FECHAS Y VUELOS -->
            <div class="form-section animate-slide-in" style="animation-delay: 0.2s;">
                <h3 class="form-section-title">
                    <i class="fas fa-plane"></i> Fechas y Vuelos
                </h3>
                
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="fecha_llegada" class="form-label">Fecha de Llegada</label>
                        <input type="date" name="fecha_llegada" id="fecha_llegada" class="form-control"
                            value="{{ old('fecha_llegada', $reserva->fecha_llegada ?? '') }}">
                    </div>
                    <div class="col-md-4">
                        <label for="hora_llegada" class="form-label">Hora de Llegada</label>
                        <input type="time" name="hora_llegada" id="hora_llegada" class="form-control"
                            value="{{ old('hora_llegada', $reserva->hora_llegada ?? '') }}">
                    </div>
                    <div class="col-md-4">
                        <label for="nro_vuelo_llegada" class="form-label">N° Vuelo Llegada</label>
                        <input type="text" name="nro_vuelo_llegada" id="nro_vuelo_llegada" class="form-control"
                            value="{{ old('nro_vuelo_llegada', $reserva->nro_vuelo_llegada ?? '') }}">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="fecha_salida" class="form-label">Fecha de Salida</label>
                        <input type="date" name="fecha_salida" id="fecha_salida" class="form-control"
                            value="{{ old('fecha_salida', $reserva->fecha_salida ?? '') }}">
                    </div>
                    <div class="col-md-4">
                        <label for="hora_salida" class="form-label">Hora de Salida</label>
                        <input type="time" name="hora_salida" id="hora_salida" class="form-control"
                            value="{{ old('hora_salida', $reserva->hora_salida ?? '') }}">
                    </div>
                    <div class="col-md-4">
                        <label for="nro_vuelo_salida" class="form-label">N° Vuelo Salida</label>
                        <input type="text" name="nro_vuelo_salida" id="nro_vuelo_salida" class="form-control"
                            value="{{ old('nro_vuelo_salida', $reserva->nro_vuelo_salida ?? '') }}">
                    </div>
                </div>
            </div>

            <!-- SECCIÓN: FINANZAS -->
            <div class="form-section animate-slide-in" style="animation-delay: 0.3s;">
                <h3 class="form-section-title">
                    <i class="fas fa-money-bill-wave"></i> Información Financiera
                </h3>
                
                <div class="row">
                    <div class="col-md-4">
                        <label for="total" class="form-label">Total ($)</label>
                        <input type="number" step="0.01" name="total" id="total" class="form-control"
                            value="{{ old('total', $reserva->total ?? '') }}">
                    </div>
                    <div class="col-md-4">
                        <label for="adelanto" class="form-label">Adelanto ($)</label>
                        <input type="number" step="0.01" name="adelanto" id="adelanto" class="form-control"
                            value="{{ old('adelanto', $reserva->adelanto ?? '') }}">
                    </div>
                    <div class="col-md-4">
                        <label for="saldo" class="form-label">Saldo ($)</label>
                        <input type="number" step="0.01" id="saldo" class="form-control" readonly>
                    </div>
                </div>
                
                <div class="progress mt-3" style="height: 10px;">
                    <div class="progress-bar" id="progress-bar-pago" role="progressbar" style="width: 0%"></div>
                </div>
                <div class="d-flex justify-content-between mt-1">
                    <small class="text-muted">0%</small>
                    <small class="text-muted" id="progress-text">0%</small>
                    <small class="text-muted">100%</small>
                </div>
            </div>

            <!-- SECCIÓN: TOURS -->
            <div class="form-section animate-slide-in" style="animation-delay: 0.4s;">
                <h3 class="form-section-title">
                    <i class="fas fa-route"></i> Tours Contratados
                </h3>
                
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-plus-circle me-2"></i> Agregar Tour
                    </div>
                    <div class="card-body">
                        <!-- Contenido del formulario de tours (se mantiene igual) -->
                    <div id="form-tours" class="card card-body mb-3 bg-light">
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
                                    <input type="date" id="fecha" class="form-control" name="fecha">
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
                                    <input type="text" id="lugar_recojo" class="form-control" name="lugar_recojo">
                                </div>

                                <!-- HORA DE RECOJO -->
                                <div class="col md">
                                    <label>Hora de Recojo:</label>
                                    <input type="time" id="hora_recojo" class="form-control" name="hora_recojo">
                                </div>
                            </div>


                            <div class="row mb-3">
                                <!-- IDIOMA DEL TOUR -->
                                <div class="col-md-4">
                                    <label>Idioma:</label>
                                    <input type="text" id="idioma" class="form-control" name="idioma">
                                </div>

                                <!-- PRECIO POR PERSONA -->
                                <div class="col-md-4">
                                    <label>Precio Unitario:</label>
                                    <input type="number" id="precio_unitario" step="0.01" class="form-control" name="precio_unitario">
                                </div>

                                <!-- CANTIDAD DE PERSONAS QUE IRAN AL TOUR -->
                                <div class="col-md-4">
                                    <label>Cantidad:</label>
                                    <input type="number" id="cantidad" min="1" value="1" class="form-control" name="cantidad">
                                </div>
                            </div>


                            <div class="row mb-2">
                                <!-- EMPRESA QUE BRINDA EL TOUR -->
                                <div class="col md">
                                    <div class="form-group" id="empresa_tour_field" style="display:none;">
                                        <label>Empresa:</label>
                                        <input type="text" id="empresa" class="form-control" name="empresa">
                                    </div>
                                </div>

                                <!-- OBSERVACIONES -->
                                <div class="col md">
                                    <div class="form-group" id="observaciones_tour_field" style="display:none;">
                                        <label>Observaciones:</label>
                                        <input type="text" id="observaciones" class="form-control" name="observaciones">
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
                                        <select id="ruta1" class="form-control" name="ruta1">
                                            <option value="">-- Seleccione --</option>
                                            <option value="ruta1a">Ruta 1-A: Ruta Montaña Machupicchu</option>
                                            <option value="ruta1b">Ruta 1-B: Ruta terraza superior</option>
                                            <option value="ruta1c">Ruta 1-C: Ruta Portada Intipunku</option>
                                            <option value="ruta1d">Ruta 1-D: Ruta Puente Inka</option>
                                        </select>
                                    </div>

                                    <div class="form-group" id="ruta2-field" style="display:none;">
                                        <label>Seleccione ruta de recorrido:</label>
                                        <select id="ruta2" class="form-control" name="ruta2">
                                            <option value="">-- Seleccione --</option>
                                            <option value="ruta2a">Ruta 2-A: Ruta clásico diseñada</option>
                                            <option value="ruta2b">Ruta 2-B: Ruta terraza inferior</option>
                                        </select>
                                    </div>

                                    <div class="form-group" id="ruta3-field" style="display:none;">
                                        <label>Seleccione ruta de recorrido:</label>
                                        <select id="ruta3" class="form-control" name="ruta3">
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
                                        <input type="time" id="horario_entrada" class="form-control" name="horario_entrada">
                                    </div>

                                </div>

                                <!-- Comentario entrada -->
                                <div class="form-group" id="comentario-entrada-field" style="display:none;">
                                    <label>Observacion acerca de la entrada</label>
                                    <input type="text" name="comentario_entrada" id="comentario_entrada" class="form-control" placeholder="Ej: Tramitar en pueblo">
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
                                        <select name="empresa_tren" class="form-control" id="empresa_tren">
                                            <option value="">-- Seleccione --</option>
                                            <option value="Inca Rail">Inca Rail</option>
                                            <option value="Peru Rail">Peru Rail</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Código de Tren</label>
                                        <input type="text" name="codigo_tren" class="form-control" id="codigo_tren" placeholder="Ej: 1234AB"> 
                                    </div>
                                </div>

                                <!-- horarios tren -->
                                <div id="tren-horarios-fields" style="display:none;">
                                    <div class="form-group">
                                        <label>Horario Ida</label>
                                        <input type="time" name="horario_ida" class="form-control" id="horario_ida">
                                    </div>
                                    <div class="form-group">
                                        <label>Horario Retorno</label>
                                        <input type="time" name="horario_retorno" class="form-control" id="horario_retorno">
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
                                                    <input type="time" name="horario_ida" class="form-control" id="horario_ida">
                                                </div>
                                            </div>
                                            <div class="col mb">
                                                <div class="form-group">
                                                    <label>Horario Retorno</label>
                                                    <input type="time" name="horario_retorno" class="form-control" id="horario_retorno">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="comentario-ticket-field" style="display:none;">
                                        <label>Comentario Ticket</label>
                                        <input type="text" name="comentario_ticket" class="form-control" placeholder="Ej: Hacer cola" id="comentario_ticket">
                                    </div>
                                </div>

                                <!-- fechas tren -->
                                <div id="tren-fechas-fields" style="display:none;">
                                    <div class="form-group">
                                        <label>Fecha Tren Ida</label>
                                        <input type="date" name="fecha_tren_ida" class="form-control" id="fecha_tren_ida">
                                    </div>
                                    <div class="form-group">
                                        <label>Fecha Tren Retorno</label>
                                        <input type="date" name="fecha_tren_retorno" class="form-control" id="fecha_tren_retorno">
                                    </div>
                                </div>

                                <hr>

                                <!-- Hospedaje -->
                                <div class="hospedaje-fields" style="display:none;">
                                    <label>Hospedaje</label>
                                    <input type="text" name="hospedaje" class="form-control" id="hospedaje" placeholder="Ej: Hotel Inka">
                                </div>


                                <!-- Transporte -->
                                <!-- Ida -->
                                <div class="form-group">
                                    <label>Transporte de ida:</label>
                                    <select name="transp_ida" id="transp_ida" class="form-control">
                                        <option value="">-- Seleccione --</option>
                                        <option value="busLucy">Bus Lucy</option>
                                        <option value="Bimodal">Bimodal</option>
                                        <option value="BimodalDoor">Bimodal Door</option>
                                        <option value="Privado">Transporte Privado</option>
                                        <option value="otro">Otro</option>
                                        <option value="porCuentaPropia">Por cuenta propia</option>
                                    </select>
                                </div>

                                <div id="horario_recojo_ida-field" style="display:none;">
                                    <label>Horario de recojo: </label>
                                    <input type="time" name="horario_recojo_ida" class="form-control" id="horario_recojo_ida">
                                </div>

                                <div id="comentario_trans_ida-field" style="display:none;">
                                    <label>Observacion: </label>
                                    <input type="text" name="comentario_trans_ida" class="form-control" id="comentario_trans_ida">
                                </div>

                                <!-- Retorno -->
                                <div class="form-group">
                                    <label>Transporte de retorno:</label>
                                    <select name="transp_ret" id="transp_ret" class="form-control">
                                        <option value="">-- Seleccione --</option>
                                        <option value="busLucy">Bus Lucy</option>
                                        <option value="Bimodal">Bimodal</option>
                                        <option value="BimodalDoor">Bimodal Door</option>
                                        <option value="Privado">Transporte Privado</option>
                                        <option value="otro">Otro</option>
                                        <option value="porCuentaPropia">Por cuenta propia</option>
                                    </select>
                                </div>

                                <div id="horario_recojo_ret-field" style="display:none;">
                                    <label>Horario de recojo: </label>
                                    <input type="time" name="horario_recojo_ret" class="form-control" id="horario_recojo_ret">
                                </div>

                                <div id="comentario_trans_ret-field" style="display:none;">
                                    <label>Observacion: </label>
                                    <input type="text" name="comentario_trans_ret" class="form-control" id="comentario_trans_ret">
                                </div>

                                <hr>


                                <!-- consetur -->
                                <div id="form-group">
                                    <label>¿Consetur o ira  a pie?</label>
                                    <select name="tipo_servicio" id="tipo_servicio" class="form-control">
                                        <option value="">-- Seleccione --</option>
                                        <option value="Comprar">Comprar</option>
                                        <option value="Caminando">Caminando</option>
                                        <option value="Tiene">Tiene</option>
                                    </select>
                                </div>
                                
                                <div id="tipo_consetur-field" style="display:none;">
                                    <label>Tipo de Consetur</label>
                                    <select name="tipo_consetur" class="form-control" id="tipo_consetur">
                                        <option value="">-- Seleccione --</option>
                                        <option value="ambos">Ida y Retorno</option>
                                        <option value="ida">Ida</option>
                                        <option value="ret">Retorno</option>
                                    </select>
                                </div>    

                                <div id="comentario_consetur-field" style="display:none;">
                                    <label>Observacion acerca del consetur</label>
                                    <input type="text" name="comentario_consetur" class="form-control" placeholder="Ej: Tramitar en pueblo" id="comentario_consetur">
                                </div>

                                <hr>

                                <!-- By Car fechas -->
                                <div id="bycar-fields" style="display:none;">
                                    <div class="form-group">
                                        <label>Fecha Ida</label>
                                        <input type="date" name="fecha_ida" class="form-control" id="fecha_ida">
                                    </div>
                                    <div class="form-group">
                                        <label>Fecha Retorno</label>
                                        <input type="date" name="fecha_retorno" class="form-control" id="fecha_retorno">
                                    </div>
                                    <!-- Hospedaje -->
                                    <div class="form-group">
                                        <label>Hospedaje</label>
                                        <input type="text" name="hospedaje" class="form-control" id="hospedaje_bycar" placeholder="Ej: Hotel Inka">
                                    </div>
                                </div>

                            </div>

                            <!-- CAMPOS BOLETO TURISTICO -->
                            <div id="boleto-turistico-details" class="col-12 mt-3"
                                style="display:none; border-top:1px solid #ccc; padding-top:10px;">
                                <h5>Detalles Boleto Turístico</h5>

                                {{-- Tipo de boleto --}}
                                <div class="form-group">
                                    <label>Tipo de Boleto:</label>
                                    <select class="form-control" id="tipo_boleto" name="tipo_boleto">
                                        <option value="">-- Seleccionar --</option>
                                        <option value="Integral">Boleto Integral</option>
                                        <option value="Parcial">Boleto Parcial</option>
                                    </select>
                                </div>

                                {{-- ¿Se debe comprar? --}}
                                <div id="requiere_compra-field" style="display:none;">
                                    <label>¿Se debe comprar?</label>
                                    <select class="form-control" id="requiere_compra" name="requiere_compra">
                                        <option value="">-- Seleccionar --</option>
                                        <option value="0">Ya tiene</option>
                                        <option value="1">Tiene que comprar</option>
                                    </select>
                                </div>

                                {{-- Tipo de compra (solo si requiere_compra = 1 ) --}}
                                <div id="tipo_compra-field" style="display:none;">
                                    <label>Tipo de Compra:</label>
                                    <select class="form-control" id="tipo_compra" name="tipo_compra">
                                        <option value="">-- Seleccionar --</option>
                                        <option value="Personal">Compra personal</option>
                                        <option value="Guia">Compra por el guía</option>
                                    </select>
                                </div>

                                {{-- Bloque genérico para entrada privada --}}
                                <div id="lugares-priv-fields" style="display:none;">
                                    <div class="form-group">
                                        <label>¿Incluye entrada a <strong id="nombrePropiedadPrivada"></strong>?</label>
                                        <select class="form-control" id="incluye_entrada_propiedad_priv" name="incluye_entrada_propiedad_priv">
                                            <option value="">-- Seleccionar --</option>
                                            <option value="1">Sí</option>
                                            <option value="0">No</option>
                                        </select>
                                    </div>

                                    <div id="quien-compra-field" style="display:none;">
                                        <label>¿Quién compra la entrada?</label>
                                        <select class="form-control" name="quien_compra_propiedad_priv" id="quien_compra_propiedad_priv">
                                            <option value="">-- Seleccionar --</option>
                                            <option value="guia">Guía</option>
                                            <option value="pasajero">Pasajero</option>
                                        </select>
                                    </div>

                                    <div id="comentario-entrada-priv-field" style="display:none;">
                                        <label>Comentario:</label>
                                        <input type="text" name="comentario_entrada_propiedad_priv" class="form-control" id="comentario_entrada_propiedad_priv" placeholder="Ej: Tramitar en pueblo">
                                    </div>
                                </div>

                            </div>
                                
                            <!-- Botones para agregar/actualizar tour -->
                            <div class="col-12 text-end">
                                <button type="button" class="btn btn-success"  id="btn-agregar-tour" onclick="agregarTour()">Agregar Tour</button>
                            </div>

                        </div>
                    </div>
                    

                    </div>
                </div>

                <div id="tours-agregados">
                    <strong class="d-block mb-3">Tours agregados:</strong>
                    <ul id="listaToursAgregados" class="list-group">
                        <!-- Los tours se agregarán aquí dinámicamente -->
                    </ul>
                </div>
            </div>

            <!-- SECCIÓN: ESTADÍAS -->
            <div class="form-section animate-slide-in" style="animation-delay: 0.5s;">
                <h3 class="form-section-title">
                    <i class="fas fa-hotel"></i> Estadías
                </h3>
                
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-plus-circle me-2"></i> Agregar Estadía
                    </div>
                    <div class="card-body">
                        <!-- Contenido del formulario de estadías (se mantiene igual) -->
                        <div id="form-estadia" class="card card-body mb-3 bg-light" >
                            <div class="row">
                                <div class="col-md-4 mb-2">
                                    <label>Tipo Estadia</label>
                                    <select id="tipo_estadia_input" class="form-control" name="tipo_estadia_input"> 
                                        <option value="Hostal">Hotel</option>
                                        <option value="Hospedaje">Hospedaje</option>
                                        <option value="Airbnb">Airbnb</option>
                                    </select>
                                </div>

                                <div class="col-md-4 mb-2">
                                    <label>Nombre Estadia</label>
                                    <input type="text" id="nombre_estadia_input" class="form-control" name="nombre_estadia_input">
                                </div>

                                <div class="col-md-4 mb-2">
                                    <label>Ubicación</label>
                                    <input type="text" id="ubicacion_estadia_input" class="form-control" name="ubicacion_estadia_input">
                                </div>

                                <div class="col-md-4 mb-2">
                                    <label>Fecha</label>
                                    <input type="date" id="fecha_estadia_input" class="form-control" name="fecha_estadia_input">
                                </div>

                                <div class="col-md-4 mb-2">
                                    <label>Habitación</label>
                                    <input type="text" id="habitacion_estadia_input" class="form-control" name="habitacion_estadia_input">
                                </div>

                                <div class="col-12 text-end">
                                    <button type="button" class="btn btn-success" id="btn-agregar-estadia" onclick="agregarEstadia()">Agregar Estadia</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="estadias-agregadas">
                    <strong class="d-block mb-3">Estadías agregadas:</strong>
                    <ul id="listaEstadiasAgregadas" class="list-group">
                        <!-- Las estadías se agregarán aquí dinámicamente -->
                    </ul>
                </div>
            </div>

            <!-- BOTONES DE ACCIÓN -->
            <div class="d-flex gap-3 mt-4">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="fas fa-save me-2"></i>
                    {{ $mode === 'create' ? 'Crear Reserva' : 'Actualizar Reserva' }}
                </button>
                <a href="{{ route('admin.reservas.index') }}" class="btn btn-secondary btn-lg">
                    <i class="fas fa-times me-2"></i> Cancelar
                </a>
            </div>
        </form>
    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
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
    

    /* ---------------- VARIABLES GLOBALES ---------------- */
    let nombreNormalizado = "";
    let tourSeleccionadoNormalizado = '';

    let estadiaIndex = {{ $mode === 'edit' ? $reserva->estadias->count() : 0 }};
    let editandoEstadia = null;
    
    let tourIndex = {{ $mode === 'edit' ? $reserva->tourReserva->count() : 0 }};
    let editandoTour = null;

    let idTourReserva = '';
    let indexUsado;



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
    const lugaresPrivados = {
        'city tour'        : 'qoricancha',
        'valle sagrado'    : 'salineras',
        'valle sagrado vip': 'salineras',
        'maras moray'      : 'salineras',
        'valle sur'        : 'andahuaylillas'
    };

    // SELECCION DE TOURS
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

        // === BOLETO TURISTICO Y PRIVADO ===
        const nombreBoleto = nombreNormalizado;
        const esBoletoTuristico = toursBoleto.includes(nombreBoleto);
        const boletoDetails = document.getElementById('boleto-turistico-details');
        const bloquePrivado = document.getElementById('lugares-priv-fields');

        boletoDetails.style.display = esBoletoTuristico ? 'block' : 'none';

        if (esBoletoTuristico) {
            // Verificar si el tour tiene lugar privado
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

    //consetur
    document.getElementById('tipo_servicio').addEventListener('change', function () {
        if (this.value === 'Comprar' || this.value === 'Tiene') {
            document.getElementById('tipo_consetur-field').style.display = 'block';
            document.getElementById('comentario_consetur-field').style.display = 'block';
        } else if (this.value === 'Caminando') {
            document.getElementById('tipo_consetur-field').style.display = 'none';
            document.getElementById('comentario_consetur-field').style.display = 'none';
        }
    });

    // transporte
    document.getElementById('transp_ida').addEventListener('change', () => {
        document.getElementById('horario_recojo_ida-field').style.display = 'block';
        document.getElementById('comentario_trans_ida-field').style.display = 'block';
    });

    document.getElementById('transp_ret').addEventListener('change', () => {
        document.getElementById('horario_recojo_ret-field').style.display = 'block';
        document.getElementById('comentario_trans_ret-field').style.display = 'block';
    });


    // ---------------- BOLETO TURÍSTICO ----------------
    // Requiere compra boleto
    document.getElementById('tipo_boleto').addEventListener('change', () => {
        document.getElementById('requiere_compra-field').style.display = 'block';
    });

    document.getElementById('requiere_compra-field').addEventListener('change', e => {
        document.getElementById('tipo_compra-field').style.display = (e.target.value == '1') ? 'block' : 'none';
    });

    document.getElementById('incluye_entrada_propiedad_priv').addEventListener('change', e => {
        const showCompra = (e.target.value == '1');
        document.getElementById('quien-compra-field').style.display = showCompra ? 'block' : 'none';
        document.getElementById('comentario-entrada-priv-field').style.display = 'block';
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


    // ------------- TOURS (AGREGAR, EDITAR)----------------
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
        }

        

        if (editandoTour) {
            idTourReserva = editandoTour.querySelector('input[name*="[id]"]')?.value || '';
            indexUsado = editandoTour.dataset.index; // 👈 Usar el índice del LI actual
        } else {
            indexUsado = tourIndex; // 👈 Usar el global SOLO para nuevos
        }


        const nombreNormalizado = nombre.toLowerCase().trim();
        let extras = '';
        let extrasPreview = '';
        

        // ---- MACHUPICCHU ----
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
                <input type="hidden" name="tours[${indexUsado}][detalles_machu][horario_ida]" value="${safeValue('horario_ida')}">
                <input type="hidden" name="tours[${indexUsado}][detalles_machu][horario_retorno]" value="${safeValue('horario_retorno')}">
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
            extrasPreview = `
                    <strong>Entrada: </strong>${safeValue('tipo_entrada') || '-'}<br>
                    <strong>Horario entrada: </strong>${safeValue('horario_entrada') || '-'}<br>
                    <strong>Tren: </strong>${safeValue('tipo_tren') || '-'} (${safeValue('empresa_tren') || '-'})<br>
                    <strong>Transporte ida: </strong>${safeValue('transp_ida') || '-'} (${safeValue('horario_recojo_ida') || '-'})<br>
                    <strong>Transporte retorno: </strong>${safeValue('transp_ret') || '-'} (${safeValue('horario_recojo_ret') || '-'})<br>
                    <strong>Consetur: </strong>${safeValue('tipo_servicio') || '-'} (${safeValue('tipo_consetur') || '-'})<br>
            `;

        }

        if (toursBoleto.includes(nombreBoleto)) {
            extras += `
                <input type="hidden" name="tours[${indexUsado}][detalles_boleto][tipo_boleto]" value="${safeValue('tipo_boleto')}">
                <input type="hidden" name="tours[${indexUsado}][detalles_boleto][requiere_compra]" value="${safeValue('requiere_compra')}">
                <input type="hidden" name="tours[${indexUsado}][detalles_boleto][tipo_compra]" value="${safeValue('tipo_compra')}">
                <input type="hidden" name="tours[${indexUsado}][detalles_boleto][incluye_entrada_propiedad_priv]"
                    value="${safeValue('incluye_entrada_propiedad_priv')}">
                <input type="hidden" name="tours[${indexUsado}][detalles_boleto][quien_compra_propiedad_priv]"
                    value="${safeValue('quien_compra_propiedad_priv')}">
                <input type="hidden" name="tours[${indexUsado}][detalles_boleto][comentario_entrada_propiedad_priv]"
                    value="${safeValue('comentario_entrada_propiedad_priv')}">
            `;
            extrasPreview = `
                    <strong>Boleto turistico: </strong> ${safeValue('tipo_boleto') || '-'}<br>
                    <strong>Requiere compra? </strong> ${safeValue('requiere_compra') || '-'}(${safeValue('tipo_compra') || '-'})<br>
                    <strong>Incluye entrada a prop. priv?: </strong> ${safeValue('incluye_entrada_propiedad_priv') || '-'} (${safeValue('quien_compra_propiedad_priv') || '-'})<br>
            `;
        }

        if (editandoTour) {
            editandoTour.innerHTML = `
                <div><strong>Tour:</strong> ${nombre}</div>
                <div><strong>Fecha:</strong> ${fecha || '-'}</div>
                <div><strong>Tipo de Servicio:</strong> ${tipo || '-'}</div>
                <div><strong>Lugar de recojo:</strong> ${lugarRecojo || '-'}</div>
                <div><strong>Hora de recojo:</strong> ${horaRecojo || '-'}</div>
                <div><strong>Idioma:</strong> ${idioma || '-'}</div>
                <div><strong>Empresa:</strong> ${empresa || '-'}</div>
                <div><strong>Precio:</strong> S/. ${precio || '0.00'}</div>
                <div><strong>Cantidad:</strong> ${cantidad}</div>
                <div><strong>Observaciones:</strong> ${observaciones || '-'}</div>
                ${extrasPreview}

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

                <div class="mt-2">
                    <button type="button" class="btn btn-sm btn-warning" onclick="editarTour(this)">Editar</button>
                    <button type="button" class="btn btn-sm btn-danger" onclick="eliminarTour(this)">Eliminar</button>
                </div>
            `;

            // resetear estado
            editandoTour = null;
            document.getElementById('btn-agregar-tour').innerText = "Agregar Tour";

        }else{
            const li = document.createElement('li');
            li.classList.add('list-group-item');
            li.dataset.index = tourIndex;

            li.innerHTML = `
                <div><strong>Tour:</strong> ${nombre}</div>
                <div><strong>Fecha:</strong> ${fecha || '-'}</div>
                <div><strong>Tipo de Servicio:</strong> ${tipo || '-'}</div>
                <div><strong>Lugar de recojo:</strong> ${lugarRecojo || '-'}</div>
                <div><strong>Hora de recojo:</strong> ${horaRecojo || '-'}</div>
                <div><strong>Idioma:</strong> ${idioma || '-'}</div>
                <div><strong>Empresa:</strong> ${empresa || '-'}</div>
                <div><strong>Precio:</strong> S/. ${precio || '0.00'}</div>
                <div><strong>Cantidad:</strong> ${cantidad}</div>
                <div><strong>Observaciones:</strong> ${observaciones || '-'}</div>
                ${extrasPreview}

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

                <div class="mt-2">
                    <button type="button" class="btn btn-sm btn-warning" onclick="editarTour(this)">Editar</button>
                    <button type="button" class="btn btn-sm btn-danger" onclick="eliminarTour(this)">Eliminar</button>
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

        // Cargar valores
        const idTourReserva = li.querySelector('input[name*="[id]"]')?.value || '';
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

        // Mandar a los inputs
        document.getElementById('fecha').value = fecha;
        document.getElementById('tipo_tour').value = tipo;
        document.getElementById('lugar_recojo').value = lugarRecojo;
        document.getElementById('hora_recojo').value = horaRecojo;
        document.getElementById('idioma').value = idioma;
        document.getElementById('empresa').value = empresa;
        document.getElementById('precio_unitario').value = precio;
        document.getElementById('cantidad').value = cantidad;
        document.getElementById('observaciones').value = observaciones;

        if (fecha) {
            document.getElementById('fecha').value = fecha.split(' ')[0];
        } else {
            document.getElementById('fecha').value = '';
        }

        if (horaRecojo) {
            // Si viene con fecha completa tipo "2025-08-25 09:00:00"
            let soloHora = horaRecojo.split(' ')[1]; // "09:00:00"
            document.getElementById('hora_recojo').value = horaRecojo.substring(0,5); // "09:00"
        } else {
            document.getElementById('hora_recojo').value = '';
        }


        //Campos especiales
        const specialFields = [
            'hay_entrada','tipo_entrada', 'ruta1', 'ruta2', 'ruta3', 'horario_entrada','comentario_entrada',
            'tipo_tren', 'empresa_tren', 'codigo_tren', 'horario_ida', 'horario_retorno','fecha_tren_ida', 'fecha_tren_retorno',
            'tiene_ticket', 'comentario_ticket',
            'fecha_ida', 'fecha_retorno', 'hospedaje', 
            'tipo_servicio', 'tipo_consetur', 'comentario_consetur',
            'transp_ida','horario_recojo_ida','comentario_trans_ida','transp_ret','horario_recojo_ret','comentario_trans_ret'
        ];
        
        const boletoFields = [
            'tipo_boleto', 'requiere_compra', 'tipo_compra',
            'incluye_entrada_propiedad_priv','quien_compra_propiedad_priv', 'comentario_entrada_propiedad_priv'
        ];

        specialFields.forEach(field => {
        const el = document.getElementById(field);
            if (el) {
                const hiddenInput = li.querySelector(`input[name*="[detalles_machu][${field}]"]`);
                el.value = hiddenInput ? hiddenInput.value : '';
            }
        });

        boletoFields.forEach(field => {
            const el = document.getElementById(field);
            if (el) {
                const hiddenInput = li.querySelector(`input[name*="[detalles_boleto][${field}]"]`);
                el.value = hiddenInput ? hiddenInput.value : '';
            }
        });


    
        const btnAdd = document.getElementById('btn-agregar-tour');
        btnAdd.innerText = "Actualizar Tour";
        btnAdd.classList.add("editing");
        document.getElementById('form-tours').classList.add("editing");

        // Scroll y animación
        document.getElementById('form-tours').scrollIntoView({
            behavior: 'smooth',
            block: 'center' // centra el bloque en la pantalla
        });

        const form = document.getElementById('form-tours');
        form.classList.add('flash');
        setTimeout(() => form.classList.remove('flash'), 2000);

    }

    function resetFieldsTour() {
        // Limpiar inputs principales
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

        // Ocultar contenedores principales
        const containers = [
            'boleto-turistico-details',
            'machupicchu-details'
        ];
        containers.forEach(id => {
            const el = document.getElementById(id);
            if (el) el.style.display = 'none';
        });

        // Ocultar TODOS los fields condicionales
        const conditionalFields = [
            'machupicchu-details',
            'boleto-turistico-details',
            'entrada-fields',
            'ruta1-field',
            'ruta2-field',
            'ruta3-field',
            'comentario-entrada-field',
            'tren-turistico-fields',
            'tren-horarios-fields',
            'tren-local-fields',
            'tren-fechas-fields',
            'hospedaje-fields',
            'horario_recojo_ida-field',
            'comentario_trans_ida-field',
            'horario_recojo_ret-field',
            'comentario_trans_ret-field',
            'tipo_consetur-field',
            'comentario_consetur-field',
            'bycar-fields',
            'requiere_compra-field',
            'tipo_compra-field',
            'lugares-priv-fields',
            'quien-compra-field',
            'comentario-entrada-priv-field'
        ];

        conditionalFields.forEach(id => {
            const el = document.getElementById(id);
            if (el) el.style.display = 'none';
        });

        // Resetear botón
        const btnAdd = document.getElementById('btn-agregar-tour');
        btnAdd.innerText = "Agregar Tour";
        btnAdd.classList.remove("editing");

        // Quitar modo edición
        editandoTour = null;
        document.getElementById('form-tours').classList.remove("editing");
    }



    function safeValue(id) {
        return document.getElementById(id)?.value || '';
    }

    /* ---------------- ESTADÍAS (MÚLTIPLES) ---------------- */   
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

        //const li = document.createElement('li');
        //li.classList.add('list-group-item');
        //li.innerHTML = `
        if (editandoEstadia) {
            editandoEstadia.innerHTML = `
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
                    <button type="button" class="btn btn-sm btn-warning" onclick="editarEstadia(this)">Editar</button>    
                    <button type="button" class="btn btn-sm btn-danger" onclick="eliminarEstadia(this)">Eliminar</button>
                </div>
            `;

            // resetear estado
            editandoEstadia = null;
            const btnAdd = document.getElementById('btn-agregar-estadia');
            btnAdd.innerText = "Agregar Estadía";
            btnAdd.classList.remove("editing");
            document.getElementById('form-estadia').classList.remove("editing");


        } else {
            const li = document.createElement('li');
            li.classList.add('list-group-item');
            li.dataset.index = estadiaIndex;

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
                    <button type="button" class="btn btn-sm btn-warning" onclick="editarEstadia(this)">Editar</button>
                    <button type="button" class="btn btn-sm btn-danger" onclick="eliminarEstadia(this)">Eliminar</button>
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
        editandoEstadia = li; // guardamos el que estamos editando

        // recuperar valores de los inputs hidden
        const tipo = li.querySelector('input[name*="[tipo_estadia]"]').value;
        const nombre = li.querySelector('input[name*="[nombre_estadia]"]').value;
        const ubicacion = li.querySelector('input[name*="[ubicacion]"]').value;
        const fecha = li.querySelector('input[name*="[fecha]"]').value;
        const habitacion = li.querySelector('input[name*="[habitacion]"]').value;

        // pasamos a los inputs del formulario
        document.getElementById('tipo_estadia_input').value = tipo;
        document.getElementById('nombre_estadia_input').value = nombre;
        document.getElementById('ubicacion_estadia_input').value = ubicacion;
        document.getElementById('fecha_estadia_input').value = fecha;
        document.getElementById('habitacion_estadia_input').value = habitacion;

        // cambiar botón
        const btnAdd = document.getElementById('btn-agregar-estadia');
        btnAdd.innerText = "Actualizar Estadía";
        btnAdd.classList.add("editing");
        document.getElementById('form-estadia').classList.add("editing");

         // 🔹 Scroll suave hacia el formulario
        document.getElementById('form-estadia').scrollIntoView({
            behavior: 'smooth',
            block: 'center' // centra el bloque en la pantalla
        });

        const form = document.getElementById('form-estadia');
        form.classList.add('flash');
        setTimeout(() => form.classList.remove('flash'), 2000); // quitar animación

    }

    function limpiarCamposEstadia() {
        document.getElementById('tipo_estadia_input').value = '';
        document.getElementById('nombre_estadia_input').value = '';
        document.getElementById('ubicacion_estadia_input').value = '';
        document.getElementById('fecha_estadia_input').value = '';
        document.getElementById('habitacion_estadia_input').value = '';
    }


</script>
