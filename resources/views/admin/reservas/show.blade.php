    @extends('layouts.template')

    @section('content')
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

        .page-header {
            background: white;
            border-radius: var(--border-radius);
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: var(--shadow);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
            animation: fadeIn 0.6s ease;
        }

        .page-title {
            font-size: 1.8rem;
            font-weight: 600;
            color: var(--dark);
            margin: 0;
        }

        .info-badge {
            background-color: var(--primary-light);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .card {
            border: none;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            transition: all 0.3s;
            margin-bottom: 1.5rem;
            overflow: hidden;
            animation: fadeIn 0.8s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-hover);
        }

        .card-header {
            background: linear-gradient(to right, var(--primary), var(--primary-light));
            color: white;
            font-weight: 600;
            padding: 1rem 1.5rem;
            border-bottom: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .card-body {
            padding: 1.5rem;
        }

        .progress-bar-container {
            background-color: #e9ecef;
            border-radius: 10px;
            height: 8px;
            margin-top: 0.5rem;
            overflow: hidden;
        }

        .progress-bar {
            height: 100%;
            background: linear-gradient(to right, var(--primary-light), var(--primary));
            border-radius: 10px;
        }

        .detail-item {
            margin-bottom: 0.75rem;
            display: flex;
            flex-wrap: wrap;
        }

        .detail-label {
            font-weight: 600;
            min-width: 180px;
            color: var(--primary-dark);
        }

        .detail-value {
            flex: 1;
        }

        .badge-status {
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-weight: 500;
            font-size: 0.8rem;
        }

        .badge-success {
            background-color: rgba(40, 167, 69, 0.15);
            color: var(--success);
        }

        .badge-warning {
            background-color: rgba(255, 193, 7, 0.15);
            color: var(--warning);
        }

        .badge-danger {
            background-color: rgba(220, 53, 69, 0.15);
            color: #dc3545;
        }

        .badge-primary {
            background-color: var(--primary-transparent);
            color: var(--primary);
        }

        .btn-secondary {
            background: #6c757d;
            border: none;
            border-radius: var(--border-radius);
            padding: 0.7rem 1.5rem;
            font-weight: 500;
            color: white;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-secondary:hover {
            background: #5a6268;
            transform: translateY(-2px);
            color: white;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            border: none;
            border-radius: var(--border-radius);
            padding: 0.7rem 1.5rem;
            font-weight: 500;
            color: white;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 100%);
            transform: translateY(-2px);
            color: white;
        }

        .btn-outline-primary {
            border: 2px solid var(--primary);
            border-radius: var(--border-radius);
            padding: 0.7rem 1.5rem;
            font-weight: 500;
            color: var(--primary);
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-outline-primary:hover {
            background: var(--primary);
            color: white;
        }

        .sticky-actions {
            position: sticky;
            bottom: 20px;
            background: white;
            border-radius: var(--border-radius);
            padding: 1rem;
            box-shadow: var(--shadow-hover);
            z-index: 100;
            animation: slideUp 0.5s ease;
        }

        .accordion-button {
            font-weight: 500;
            padding: 1rem 1.25rem;
        }

        .accordion-button:not(.collapsed) {
            background-color: var(--primary-transparent);
            color: var(--primary-dark);
        }

        .accordion-button:focus {
            box-shadow: none;
            border-color: rgba(20, 165, 181, 0.25);
        }

        .empty-state {
            text-align: center;
            padding: 2rem;
            color: #6c757d;
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: #dee2e6;
        }

        /* Animaciones */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes slideUp {
            from { transform: translateY(20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .page-header {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .detail-item {
                flex-direction: column;
            }
            
            .detail-label {
                min-width: auto;
                margin-bottom: 0.25rem;
            }
            
            .sticky-actions {
                position: relative;
                bottom: 0;
            }
            
            .sticky-actions .d-flex {
                flex-direction: column;
                gap: 1rem;
            }
            
            .sticky-actions .d-flex > div {
                width: 100%;
            }
            
            .sticky-actions .btn {
                width: 100%;
                justify-content: center;
            }
        }

        .table {
            border-collapse: separate;
            border-spacing: 0;
            width: 100%;
        }

        .table th {
            background-color: #f8f9fa;
            color: var(--primary);
            font-weight: 600;
            padding: 1rem;
            border-top: 1px solid #dee2e6;
        }

        .table td {
            padding: 1rem;
            vertical-align: middle;
            border-top: 1px solid #dee2e6;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(20, 165, 181, 0.05);
        }

        .section-icon {
            font-size: 1.2rem;
        }
    </style>

    <div class="container py-4">
        <!-- Encabezado -->
        <div class="page-header">
            <div>
                <h1 class="page-title"><i class="fas fa-calendar-check me-2"></i>Detalle de Reserva</h1>
                <p class="mb-0 opacity-75">Información completa de la reserva #{{ $reserva->id }}</p>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <span class="info-badge"><i class="fas fa-user me-1"></i> {{ $reserva->titular->nombre }} {{ $reserva->titular->apellido }}</span>
                <span class="info-badge"><i class="fas fa-building me-1"></i> {{ $reserva->proveedor->nombreAgencia ?? '-' }}</span>
            </div>
        </div>

        <!-- Barra de progreso de pago -->
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="text-muted">Progreso de pago</span>
                    <span class="fw-bold">{{ number_format(($reserva->adelanto / $reserva->total) * 100, 0) }}%</span>
                </div>
                <div class="progress-bar-container">
                    <div class="progress-bar" style="width: {{ ($reserva->adelanto / $reserva->total) * 100 }}%"></div>
                </div>
                <div class="d-flex justify-content-between mt-2">
                    <small class="text-muted">Adelanto: S/. {{ number_format($reserva->adelanto, 2) }}</small>
                    <small class="text-muted">Total: S/. {{ number_format($reserva->total, 2) }}</small>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Columna izquierda - Información General -->
            <div class="col-lg-8">
                <!-- Información General -->
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-info-circle section-icon"></i> Información General
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="detail-item">
                                    <span class="detail-label">Tipo de Reserva:</span>
                                    <span class="detail-value">{{ $reserva->tipo_reserva }}</span>
                                </div>
                                <div class="detail-item">
                                    <span class="detail-label">Proveedor:</span>
                                    <span class="detail-value">{{ $reserva->proveedor->nombreAgencia ?? '-' }}</span>
                                </div>
                                <div class="detail-item">
                                    <span class="detail-label">Fecha Llegada:</span>
                                    <span class="detail-value">{{ $reserva->fecha_llegada ?? '-' }} {{ $reserva->hora_llegada ? ' - '.$reserva->hora_llegada : '' }}</span>
                                </div>
                                <div class="detail-item">
                                    <span class="detail-label">Nro Vuelo Llegada:</span>
                                    <span class="detail-value">{{ $reserva->nro_vuelo_llegada ?? '-' }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="detail-item">
                                    <span class="detail-label">Fecha Salida:</span>
                                    <span class="detail-value">{{ $reserva->fecha_salida ?? '-' }} {{ $reserva->hora_salida ? ' - '.$reserva->hora_salida : '' }}</span>
                                </div>
                                <div class="detail-item">
                                    <span class="detail-label">Nro Vuelo Retorno:</span>
                                    <span class="detail-value">{{ $reserva->nro_vuelo_retorno ?? '-' }}</span>
                                </div>
                                <div class="detail-item">
                                    <span class="detail-label">Total:</span>
                                    <span class="detail-value"><span class="badge bg-success">S/. {{ number_format($reserva->total, 2) }}</span></span>
                                </div>
                                <div class="detail-item">
                                    <span class="detail-label">Adelanto:</span>
                                    <span class="detail-value"><span class="badge bg-warning text-dark">S/. {{ number_format($reserva->adelanto, 2) }}</span></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pasajeros -->
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-users section-icon"></i> Pasajeros
                    </div>
                    <div class="card-body">
                        @if($reserva->pasajeros->count())
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Documento</th>
                                            <th>Fecha Nacimiento</th>
                                            <th>País Residencia</th>
                                            <th>Tarifa</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($reserva->pasajeros as $pasajero)
                                        <tr>
                                            <td>{{ $pasajero->nombre }} {{ $pasajero->apellido }}</td>
                                            <td>{{ $pasajero->documento }}</td>
                                            <td>{{ $pasajero->fecha_nacimiento }}</td>
                                            <td>{{ $pasajero->pais_residencia }}</td>
                                            <td>{{ $pasajero->tarifa }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="text-center mt-3">
                                <button class="btn btn-outline-primary" type="button" data-bs-toggle="collapse" data-bs-target="#pasajerosDetails">
                                    <i class="fas fa-chevron-down me-1"></i> Ver detalles completos
                                </button>
                            </div>
                            <div class="collapse mt-3" id="pasajerosDetails">
                                <div class="card card-body">
                                    @foreach($reserva->pasajeros as $pasajero)
                                        <div class="mb-3 pb-2 border-bottom">
                                            <h6 class="text-primary">{{ $pasajero->nombre }} {{ $pasajero->apellido }}</h6>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <small class="text-muted">Documento: {{ $pasajero->documento }}</small>
                                                </div>
                                                <div class="col-md-6">
                                                    <small class="text-muted">Nacimiento: {{ $pasajero->fecha_nacimiento }}</small>
                                                </div>
                                                <div class="col-md-6">
                                                    <small class="text-muted">País Residencia: {{ $pasajero->pais_residencia }}</small>
                                                </div>
                                                <div class="col-md-6">
                                                    <small class="text-muted">Ciudad: {{ $pasajero->ciudad }}</small>
                                                </div>
                                                <div class="col-md-6">
                                                    <small class="text-muted">Tarifa: {{ $pasajero->tarifa }}</small>
                                                </div>
                                                <div class="col-md-6">
                                                    <small class="text-muted">Teléfono: {{ $pasajero->telefono }}</small>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <div class="empty-state">
                                <i class="fas fa-users fa-3x"></i>
                                <p class="text-muted">No hay pasajeros registrados.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Tours -->
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-route section-icon"></i> Tours
                    </div>
                    <div class="card-body">
                        @if($reserva->tourReserva->count())
                            <div class="accordion" id="accordionTours">
                                @foreach($reserva->tourReserva as $index => $tour)
                                    <div class="accordion-item mb-2 border-0">
                                        <h2 class="accordion-header" id="heading{{ $index }}">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $index }}" aria-expanded="false" aria-controls="collapse{{ $index }}">
                                                <i class="fas fa-map-marker-alt me-2 text-primary"></i>
                                                {{ $tour->tour->nombreTour }}
                                                @if($tour->detalleBoletoTuristico)
                                                    <span class="badge bg-primary ms-2">Boleto Turístico</span>
                                                @endif
                                                @if($tour->detalleMachupicchu)
                                                    <span class="badge bg-success ms-2">Machu Picchu</span>
                                                @endif
                                            </button>
                                        </h2>
                                        <div id="collapse{{ $index }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $index }}" data-bs-parent="#accordionTours">
                                            <div class="accordion-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="detail-item">
                                                            <span class="detail-label">Fecha:</span>
                                                            <span class="detail-value">{{ $tour->fecha ?? '-' }}</span>
                                                        </div>
                                                        <div class="detail-item">
                                                            <span class="detail-label">Empresa:</span>
                                                            <span class="detail-value">{{ $tour->empresa ?? '-' }}</span>
                                                        </div>
                                                        <div class="detail-item">
                                                            <span class="detail-label">Precio Unitario:</span>
                                                            <span class="detail-value">S/. {{ number_format($tour->precio_unitario ?? 0, 2) }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="detail-item">
                                                            <span class="detail-label">Cantidad:</span>
                                                            <span class="detail-value">{{ $tour->cantidad ?? 1 }}</span>
                                                        </div>
                                                        <div class="detail-item">
                                                            <span class="detail-label">Observaciones:</span>
                                                            <span class="detail-value">{{ $tour->observaciones ?? '-' }}</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                {{-- Detalles Boleto Turístico --}}
                                                @if($tour->detalleBoletoTuristico)
                                                    <hr>
                                                    <h6><i class="fas fa-ticket-alt me-2 text-primary"></i> Boleto Turístico</h6>
                                                    <div class="row mt-3">
                                                        <div class="col-md-6">
                                                            <div class="detail-item">
                                                                <span class="detail-label">Tipo Boleto:</span>
                                                                <span class="detail-value">{{ $tour->detalleBoletoTuristico->tipo_boleto }}</span>
                                                            </div>
                                                            <div class="detail-item">
                                                                <span class="detail-label">Requiere Compra:</span>
                                                                <span class="detail-value">{{ $tour->detalleBoletoTuristico->requiere_compra ? 'Sí' : 'No' }}</span>
                                                            </div>
                                                            <div class="detail-item">
                                                                <span class="detail-label">Tipo Compra:</span>
                                                                <span class="detail-value">{{ $tour->detalleBoletoTuristico->tipo_compra ?? '-' }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="detail-item">
                                                                <span class="detail-label">Incluye Propiedad Privada:</span>
                                                                <span class="detail-value">{{ $tour->detalleBoletoTuristico->incluye_entrada_propiedad_priv ? 'Sí' : 'No' }}</span>
                                                            </div>
                                                            <div class="detail-item">
                                                                <span class="detail-label">Quién Compra:</span>
                                                                <span class="detail-value">{{ $tour->detalleBoletoTuristico->quien_compra_propiedad_priv ?? '-' }}</span>
                                                            </div>
                                                            <div class="detail-item">
                                                                <span class="detail-label">Comentario:</span>
                                                                <span class="detail-value">{{ $tour->detalleBoletoTuristico->comentario_entrada_propiedad_priv ?? '-' }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif

                                                {{-- Detalles Machu Picchu --}}
                                                @if($tour->detalleMachupicchu)
                                                    <hr>
                                                    <h6><i class="fas fa-mountain me-2 text-primary"></i> Machu Picchu</h6>
                                                    <div class="row mt-3">
                                                        <div class="col-md-6">
                                                            <div class="detail-item">
                                                                <span class="detail-label">Tipo Entrada:</span>
                                                                <span class="detail-value">{{ $tour->detalleMachupicchu->tipo_entrada ?? '-' }}</span>
                                                            </div>
                                                            <div class="detail-item">
                                                                <span class="detail-label">Ruta 1:</span>
                                                                <span class="detail-value">{{ $tour->detalleMachupicchu->ruta1 ?? '-' }}</span>
                                                            </div>
                                                            <div class="detail-item">
                                                                <span class="detail-label">Ruta 2:</span>
                                                                <span class="detail-value">{{ $tour->detalleMachupicchu->ruta2 ?? '-' }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="detail-item">
                                                                <span class="detail-label">Ruta 3:</span>
                                                                <span class="detail-value">{{ $tour->detalleMachupicchu->ruta3 ?? '-' }}</span>
                                                            </div>
                                                            <div class="detail-item">
                                                                <span class="detail-label">Horario Entrada:</span>
                                                                <span class="detail-value">{{ $tour->detalleMachupicchu->horario_entrada ?? '-' }}</span>
                                                            </div>
                                                            <div class="detail-item">
                                                                <span class="detail-label">Comentario:</span>
                                                                <span class="detail-value">{{ $tour->detalleMachupicchu->comentario_entrada ?? '-' }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="empty-state">
                                <i class="fas fa-route fa-3x"></i>
                                <p class="text-muted">No hay tours asociados.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Estadías -->
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-hotel section-icon"></i> Estadías
                    </div>
                    <div class="card-body">
                        @if($reserva->estadias->count())
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Tipo</th>
                                            <th>Nombre</th>
                                            <th>Ubicación</th>
                                            <th>Fecha</th>
                                            <th>Habitación</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($reserva->estadias as $estadia)
                                            <tr>
                                                <td><i class="fas fa-bed text-primary me-2"></i> {{ $estadia->tipo_estadia }}</td>
                                                <td>{{ $estadia->nombre_estadia }}</td>
                                                <td>{{ $estadia->ubicacion ?? '-' }}</td>
                                                <td>{{ $estadia->fecha ?? '-' }}</td>
                                                <td>{{ $estadia->habitacion ?? '-' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="empty-state">
                                <i class="fas fa-hotel fa-3x"></i>
                                <p class="text-muted">No hay estadías registradas.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Columna derecha -->
            <div class="col-lg-4">
                <!-- Depositos realizados -->
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-money-bill-wave section-icon"></i> Depósitos
                    </div>
                    <div class="card-body">
                        @if($reserva->depositos->count())
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Depositante</th>
                                            <th>Monto</th>
                                            <th>Fecha</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($reserva->depositos as $deposito)
                                            <tr>
                                                <td>{{ $deposito->nombre_depositante }}</td>
                                                <td>S/. {{ number_format($deposito->monto, 2) }}</td>
                                                <td>{{ $deposito->fecha ?? '-' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="text-center mt-3">
                                <button class="btn btn-outline-primary" type="button" data-bs-toggle="collapse" data-bs-target="#depositosDetails">
                                    <i class="fas fa-chevron-down me-1"></i> Ver detalles completos
                                </button>
                            </div>
                            <div class="collapse mt-3" id="depositosDetails">
                                <div class="card card-body">
                                    @foreach($reserva->depositos as $deposito)
                                        <div class="mb-3 pb-2 border-bottom">
                                            <h6 class="text-primary">{{ $deposito->nombre_depositante }}</h6>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <small class="text-muted">Monto: S/. {{ number_format($deposito->monto, 2) }}</small>
                                                </div>
                                                <div class="col-md-6">
                                                    <small class="text-muted">Tipo: {{ $deposito->tipo_deposito ?? '-' }}</small>
                                                </div>
                                                <div class="col-md-6">
                                                    <small class="text-muted">Fecha: {{ $deposito->fecha ?? '-' }}</small>
                                                </div>
                                                <div class="col-12 mt-2">
                                                    <small class="text-muted">Observaciones: {{ $deposito->observaciones ?? 'Sin observaciones' }}</small>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <div class="empty-state">
                                <i class="fas fa-money-bill-wave fa-3x"></i>
                                <p class="text-muted">No se realizaron depósitos.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Facturación -->
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-file-invoice-dollar section-icon"></i> Facturación
                    </div>
                    <div class="card-body">
                        @if($reserva->facturaciones->count())
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Titular</th>
                                            <th>Tipo</th>
                                            <th>Monto</th>
                                            <th>Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($reserva->facturaciones as $facturacion)
                                            <tr>
                                                <td>{{ $facturacion->titular }}</td>
                                                <td>{{ $facturacion->tipo }}</td>
                                                <td>S/. {{ number_format($facturacion->total_facturado, 2) }}</td>
                                                <td>
                                                    @if($facturacion->estado === 'Realizado')
                                                        <span class="badge bg-success">Realizado</span>
                                                    @else
                                                        <span class="badge bg-secondary">No Realizado</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="text-center mt-3">
                                <button class="btn btn-outline-primary" type="button" data-bs-toggle="collapse" data-bs-target="#facturacionDetails">
                                    <i class="fas fa-chevron-down me-1"></i> Ver detalles completos
                                </button>
                            </div>
                            <div class="collapse mt-3" id="facturacionDetails">
                                <div class="card card-body">
                                    @foreach($reserva->facturaciones as $facturacion)
                                        <div class="mb-3 pb-2 border-bottom">
                                            <h6 class="text-primary">{{ $facturacion->titular }}</h6>
                                            
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <small class="text-muted">Doc: {{ $facturacion->documento ?? '-' }}</small>
                                                </div>
                                                <div class="col-md-6">
                                                    <small class="text-muted">País: {{ $facturacion->pais ?? '-' }}</small>
                                                </div>
                                                <div class="col-md-6">
                                                    <small class="text-muted">Monto: S/. {{ number_format($facturacion->total_facturado, 2) }}</small>
                                                </div>
                                                <div class="col-md-6">
                                                    <small class="text-muted">Tipo: {{ $facturacion->tipo ?? '-' }}</small>
                                                </div>
                                                <div class="col-md-6">
                                                    <small class="text-muted">Tipo de giro: {{ $facturacion->tipo_fac ?? '-' }}</small>
                                                </div>
                                                <div class="col-md-6">
                                                    <small class="text-muted">Fecha: {{ $facturacion->fecha_giro ?? '-' }}</small>
                                                </div>
                                                <div class="col-12 mt-2">
                                                    <small class="text-muted">Observaciones: {{ $facturacion->descripcion ?? 'Sin observaciones' }}</small>
                                                </div>
                                                <div class="col-12 mt-2">
                                                    <small class="text-muted">Estado: {{ $facturacion->estado }}</small>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <div class="empty-state">
                                <i class="fas fa-file-invoice-dollar fa-3x"></i>
                                <p class="text-muted">No se realizaron facturaciones.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Resumen financiero -->
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-chart-pie section-icon"></i> Resumen Financiero
                    </div>
                    <div class="card-body">
                        <div class="detail-item">
                            <span class="detail-label">Total Reserva:</span>
                            <span class="detail-value fw-bold">S/. {{ number_format($reserva->total, 2) }}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Adelanto:</span>
                            <span class="detail-value">S/. {{ number_format($reserva->adelanto, 2) }}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Saldo Pendiente:</span>
                            <span class="detail-value fw-bold text-danger">S/. {{ number_format($reserva->total - $reserva->adelanto, 2) }}</span>
                        </div>
                        <hr>
                        <div class="detail-item">
                            <span class="detail-label">Total Depósitos:</span>
                            <span class="detail-value">S/. {{ number_format($reserva->depositos->sum('monto'), 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Acciones -->
        <div class="sticky-actions mt-4">
            <div class="d-flex justify-content-between">
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.reservas.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Volver
                    </a>
                    <a href="{{ route('admin.reservas.edit', $reserva->id) }}" class="btn btn-primary">
                        <i class="fas fa-edit me-2"></i>Editar
                    </a>
                </div>
                <div class="d-flex gap-2">
                    {{-- Depósitos --}}
                    @if($reserva->depositos->count())
                        <a href="{{ route('admin.depositos.edit', $reserva->depositos->last()->id) }}" 
                        class="btn btn-outline-primary">
                            <i class="fas fa-money-bill me-2"></i> Depósitos
                        </a>
                    @else
                        <a href="{{ route('admin.depositos.create', ['reserva_id' => $reserva->id]) }}" 
                        class="btn btn-outline-primary">
                            <i class="fas fa-money-bill me-2"></i> Depósitos
                        </a>
                    @endif

                    {{-- Facturación --}}
                    @if($reserva->facturaciones->count())
                        <a href="{{ route('admin.facturacion.edit', $reserva->facturaciones->last()->id) }}" 
                        class="btn btn-outline-primary">
                            <i class="fas fa-file-invoice me-2"></i> Facturación
                        </a>
                    @else
                        <a href="{{ route('admin.facturacion.create', ['reserva_id' => $reserva->id]) }}" 
                        class="btn btn-outline-primary">
                            <i class="fas fa-file-invoice me-2"></i> Facturación
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Animación de entrada para las tarjetas
            const cards = document.querySelectorAll('.card');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                
                setTimeout(() => {
                    card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, 100 + (index * 100));
            });
            
            // Efectos de hover para botones
            const buttons = document.querySelectorAll('.btn');
            buttons.forEach(button => {
                button.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-2px)';
                });
                
                button.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });
            
            // Tooltips para elementos interactivos
            const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
            const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
        });
    </script>
    @endsection