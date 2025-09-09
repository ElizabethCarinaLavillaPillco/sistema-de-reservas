@extends('layouts.template')
@section('title', 'Dashboard - Expediciones Allinkay')

@section('styles')
    <style>
        .dashboard-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            padding: 1.5rem;
            border-radius: var(--border-radius);
            margin-bottom: 2rem;
            box-shadow: var(--shadow);
        }

        .dashboard-title {
            font-size: 1.8rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .dashboard-subtitle {
            opacity: 0.9;
            font-weight: 300;
        }


        .arrival-content{
            flex: 1;
        }

        .card-header i {
            color: var(--primary);
            margin-right: 0.5rem;
        }

        .card-body {
            padding: 1.5rem;
        }

        .card-highlight {
            border-top: 4px solid var(--primary);
        }

        .card-secondary {
            border-top: 4px solid var(--primary-light);
        }
        

        .card-alert {
            border-top: 4px solid var(--accent);
        }

        .card-success {
            border-top: 4px solid var(--success);
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
        .badge-salida{
            background-color: rgba(54, 61, 62, 0.15);
            color: var(--dark);
        }

        .badge-danger {
            background-color: rgba(220, 53, 69, 0.15);
            color: #dc3545;
        }

        .badge-primary {
            background-color: var(--primary-transparent);
            color: var(--primary);
        }

        .arrival-item, .departure-item {
            padding: 1rem;
            border-radius: var(--border-radius);
            margin-bottom: 0.75rem;
            transition: all 0.3s;
        }

        .arrival-item {
            background: var(--primary-transparent);
            border-left: 4px solid var(--primary);
        }

        .arrival-item:hover {
            background: rgba(20, 165, 181, 0.2);
        }

        .departure-item {
            background: #f8f9fa;
            border-left: 4px solid #dee2e6;
        }

        .departure-item:hover {
            background: #e9ecef;
        }

        .machu-card, .arrival-card {
            background: linear-gradient(to right, rgba(20, 165, 181, 0.1) 0%, rgba(20, 165, 181, 0.05) 100%);
            border-radius: var(--border-radius);
            padding: 1.5rem;
            margin-bottom: 1rem;
        }

        .factura-item {
            padding: 0.75rem;
            border-radius: var(--border-radius);
            background: #fff;
            border-left: 4px solid var(--accent);
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .factura-pendiente {
            background: rgba(220, 53, 69, 0.05);
        }

        .transaction-card, .factura-card {
            padding: 1.25rem;
            border-radius: var(--border-radius);
            background: white;
            box-shadow: var(--shadow);
            margin-bottom: 1rem;
        }

        .transaction-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            font-size: 1.25rem;
        }
        

        .transaction-deposit {
            background: rgba(40, 167, 69, 0.1);
            color: var(--success);
        }
        .transaction-factura {
            background: rgba(167, 40, 40, 0.1);
            color: #dc3545;
        }

        .transaction-invoice {
            background: rgba(20, 165, 181, 0.1);
            color: var(--primary);
        }

        .pago-status {
            padding: 1rem;
            border-radius: var(--border-radius);
            text-align: center;
            margin-bottom: 1rem;
        }

        .pago-pendiente {
            background: rgba(220, 53, 69, 0.1);
            color: #dc3545;
            border: 1px solid rgba(220, 53, 69, 0.2);
        }

        .pago-al-dia {
            background: rgba(40, 167, 69, 0.1);
            color: var(--success);
            border: 1px solid rgba(40, 167, 69, 0.2);
        }

        .pago-pendiente .btn-agregar {
            background: linear-gradient(135deg, rgba(220, 53, 69, 0.15) 0%, rgba(220, 53, 69, 0.3) 100%);
        }
        .pago-pendiente .btn-agregar:hover {
            background: linear-gradient(135deg, rgba(220, 53, 69, 0.3) 0%, rgba(220, 53, 69, 0.5) 100%);
        }

        .pago-al-dia .btn-agregar {
            background: linear-gradient(135deg, rgba(40, 167, 69, 0.15) 0%, rgba(40, 167, 69, 0.3) 100%);
        }
        .pago-al-dia .btn-agregar:hover {
            background: linear-gradient(135deg, rgba(40, 167, 69, 0.3) 0%, rgba(40, 167, 69, 0.5) 100%);
        }

        .chart-container {
            position: relative;
            height: 300px;
            margin-bottom: 2rem;
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            color: var(--dark);
            padding-bottom: 0.5rem;
            border-bottom: 2px solid var(--primary-light);
        }

        @media (max-width: 768px) {
            .dashboard-header {
                text-align: center;
            }
            
            .card-header {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .card-header .badge {
                margin-top: 0.5rem;
            }
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

        /* Estilos para los botones Ver Reserva */
        .btn-reserva {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            border: none;
            border-radius: 20px;
            padding: 0.5rem 1rem;
            color: white;
            font-weight: 500;
            font-size: 0.85rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s;
            text-decoration: none;
        }

        .btn-reservaz {
            background: linear-gradient(135deg, var(--primary-light) 0%, var(--primary) 100%);
            border: none;
            border-radius: 20px;
            padding: 0.4rem 0.8rem;          /* más pequeño */
            color: white;
            font-weight: 500;
            font-size: 0.8rem;               /* aún más pequeño */
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            transition: all 0.3s;
            text-decoration: none;
        }

        .btn-actualizar {
            background: linear-gradient(135deg, var(--warning) 0%, #ff9f43 100%);
            border: none;
            border-radius: 20px;
            padding: 0.4rem 0.8rem;
            color: white;
            font-weight: 500;
            font-size: 0.8rem;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            transition: all 0.3s;
            text-decoration: none;
        }

        .btn-agregar {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.4rem 0.8rem;
            font-size: 0.8rem;
            font-weight: 600;
            border: none;
            border-radius: 20px;
            text-decoration: none;
            color: inherit;              /* hereda el color del padre (.pago-pendiente o .pago-al-dia) */
            background: rgba(0,0,0,0.05);
            margin-top: 0.5rem;
        }

        .btn-agregar:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-hover);
        }

        .btn-reserva:hover {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
            color: white;
        }
        .btn-reservaz:hover {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
            color: white;
        }
        .btn-actualizar:hover{
            background: linear-gradient(135deg, #ff9f43 0%, var(--warning) 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
            color: white;
        }

        .btn-reserva-sm , .btn-reservaz-sm, .btn-actualizar-sm, .btn-agregar.sm {
            padding: 0.4rem 0.8rem;
            font-size: 0.8rem;
        }

        .btn-reservaz + .btn-actualizar {
            margin-left: 0.5rem;   /* ó 0.75rem / 1rem según necesites */
        }


        /* Animación para los botones */
        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(20, 165, 181, 0.4);
            }
            70% {
                box-shadow: 0 0 0 6px rgba(20, 165, 181, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(20, 165, 181, 0);
            }
        }

        .btn-reserva.pulse, .btn-reservaz.pulse, .btn-actualizar.pulse  {
            animation: pulse 2s infinite;
        }

        /* Responsive para botones */
        @media (max-width: 768px) {
            .btn-reserva, .btn-reservaz, .btn-actualizar, .btn-agregar  {
                width: 100%;
                justify-content: center;
                margin-top: 0.5rem;
            }
            
            .btn-container {
                flex-direction: column;
            }
        }
        /* Estilos para el layout de escritorio de Machupicchu */
        .machu-card-desktop, .arrival-card-desktop, .factura-card-desktop, .transaction-card-desktop  {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 2rem;
        }

        .machu-content {
            flex: 1;
        }

        .machu-button-desktop, .arrival-button-desktop, .factura-button-desktop, .transaction-button-desktop  {
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 140px;
            padding: 1rem;
        }

        .machu-button-mobile, .arrival-button-mobile, .factura-button-mobile, .transaction-button-mobile  {
            display: none;
        }

        /* Estilos responsive */
        @media (max-width: 992px) {
            .machu-card-desktop, .arrival-card-desktop, .factura-card-desktop, .transaction-card-desktop  {
                flex-direction: column;
                gap: 1rem;
            }
            
            .machu-button-desktop, .arrival-button-desktop, .factura-button-desktop, .transaction-button-desktop {
                display: none;
            }
            
            .machu-button-mobile, .arrival-button-mobile, .factura-button-mobile, .transaction-button-mobile {
                display: flex;
                justify-content: center;
                margin-top: 1.5rem;
                padding-top: 1.5rem;
                border-top: 1px solid rgba(0,0,0,0.1);
            }
        }

        /* Ajustes para pantallas muy grandes */
        @media (min-width: 1400px) {
            .machu-button-desktop, .arrival-button-desktop, .factura-button-desktop, .transaction-button-desktop {
                min-width: 160px;
            }
            
            .btn-reserva, .btn-reservaz, .btn-actualizar {
                padding: 0.6rem 1.2rem;
                font-size: 0.9rem;
            }
        }

        /* Mejora visual para la tarjeta de Machupicchu */
        .machu-card, .arrival-card, .factura-card, .transaction-card {
            position: relative;
            transition: all 0.3s ease;
        }

        .machu-card:hover, .arrival-card:hover, .card-alert:hover, .transaction-card:hover, .factura-card:hover  {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid py-4">
        <!-- Header -->
        <div class="dashboard-header">
            <h1 class="dashboard-title"><i class="fas fa-compass me-2"></i> Dashboard</h1>
            <p class="dashboard-subtitle">Resumen general de operaciones y actividades recientes</p>
        </div>

        <div class="row">
                <!-- Estadísticas Rápidas -->
                <div class="card card-highlight">
                    <div class="card-header">
                        <div>
                            <i class="fas fa-calendar-day"></i> Próximos Tours
                        </div>
                        <div>
                            @foreach($toursHoy as $tour)
                                @if($tour->fecha == \Carbon\Carbon::today()->toDateString() || $tour->fecha == \Carbon\Carbon::tomorrow()->toDateString())
                                    <span class="badge badge-status badge-success me-2">{{ $tour->nombre }}</span>
                                @endif
                            @endforeach
                            
                        </div>
                    </div>
                    <div class="card-header">
                        <div>
                            <span class="badge badge-primary me-2">Hoy: {{ $toursHoy->count() }}</span>
                            <span class="badge badge-info">Mañana: {{ $toursManana->count() }}</span>
                        </div>
                    </div>
                    
                    <div class="card-body p-0">
                    
                        <div class="row no-gutters">
                            <!-- Sección de Tours de Hoy -->
                            <div class="col-md-6 border-right">
                                <div class="p-3 bg-warning-light">
                                    <h5 class="mb-3"><i class="fas fa-sun me-2"></i> Tours de Hoy</h5>
                                    
                                    @if($toursHoy->count() > 0)
                                        @foreach($toursHoy as $tourHoy)
                                            <div class="arrival-card mb-3 p-2 bg-white rounded">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <div class="flex-grow-1">
                                                        <h5 class="mb-1">{{ $tourHoy->reserva->titular->nombre ?? 'N/A' }} {{ $tourHoy->reserva->titular->apellido ?? '' }}</h5>
                                                        <p class="mb-1"><i class="fas fa-users me-1"></i> {{ $tourHoy->reserva->cantidad_pasajeros }} pasajeros</p>
                                                        <p class="mb-1"><i class="fas fa-route me-1"></i> {{ $tourHoy->tour->nombreTour ?? 'N/A' }}</p>

                                                    </div>
                                                </div>
                                                <!-- Botón a la derecha (solo visible en escritorio) -->
                                                <div class="machu-button-desktop">
                                                    <a href="{{ route('admin.reservas.show', $tourHoy->reserva->id) }}" class="btn-reserva pulse">
                                                        <i class="fas fa-eye"></i> Ver Reserva
                                                    </a>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="text-center py-3">
                                            <i class="fas fa-calendar-times fa-2x mb-2 text-muted"></i>
                                            <p class="text-muted">No hay tours para hoy</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Sección de Tours de Mañana -->
                            <div class="col-md-6">
                                <div class="p-3 bg-info-light">
                                    <h5 class="mb-3"><i class="fas fa-cloud-sun me-2"></i> Tours de Mañana</h5>
                                    
                                    @if($toursManana->count() > 0)
                                        @foreach($toursManana as $tourM)
                                            <div class="arrival-card mb-3 p-2 bg-white rounded">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <div class="flex-grow-1">
                                                        <h5 class="mb-1">{{ $tourM->reserva->titular->nombre ?? 'N/A' }} {{ $tourHoy->reserva->titular->apellido ?? '' }}</h5>
                                                        <p class="mb-1"><i class="fas fa-users me-1"></i> {{ $tourM->reserva->cantidad_pasajeros }} pasajeros</p>
                                                        <p class="mb-1"><i class="fas fa-route me-1"></i> {{ $tourM->tour->nombreTour ?? 'N/A' }}</p>

                                                    </div>
                                                </div>
                                                <!-- Botón a la derecha (solo visible en escritorio) -->
                                                <div class="machu-button-desktop">
                                                    <a href="{{ route('admin.reservas.show', $tourM->reserva->id) }}" class="btn-reserva pulse">
                                                        <i class="fas fa-eye"></i> Ver Reserva
                                                    </a>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="text-center py-3">
                                            <i class="fas fa-calendar-times fa-2x mb-2 text-muted"></i>
                                            <p class="text-muted">No hay tours para mañana</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Próximas Llegadas -->
                <div class="card card-highlight">
                    <div class="card-header">
                        <div>
                            <i class="fas fa-plane-arrival"></i> Próximas Llegadas
                        </div>
                        <span class="badge badge-primary">{{ $proximasLlegadas->count() }} reservas</span>
                    </div>
                    <div class="card-body">
                        @foreach($proximasLlegadas as $reserva)
                            <div class="arrival-card mb-3">
                                <!-- Contenedor principal para escritorio -->
                                <div class="arrival-card-desktop">
                                    <!-- Contenido a la izquierda -->
                                    <div class="arrival-content">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h5 class="mb-1">{{ $reserva->titular->nombre ?? 'N/A' }} {{ $reserva->titular->apellido ?? '' }}</h5>
                                                <p class="mb-1"><i class="fas fa-users me-1"></i> {{ $reserva->cantidad_pasajeros }} pasajeros</p>
                                                <p class="mb-1"><i class="fas fa-plane me-1"></i> Vuelo: {{ $reserva->nro_vuelo_llegada ?? 'N/A' }}</p>
                                                <p class="mb-0"><i class="far fa-clock me-1"></i> {{ $reserva->hora_llegada ?? 'N/A' }}</p>
                                            </div>
                                            <div class="text-end">
                                                <span class="badge badge-primary">Próxima llegada</span>
                                                <div class="fw-bold mt-1">{{ \Carbon\Carbon::parse($reserva->fecha_llegada)->format('d M Y') }}</div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Botón a la derecha (solo visible en escritorio) -->
                                        
                                        <div class="arrival-button-desktop">
                                            <a href="{{ route('admin.reservas.show', $reserva->id) }}" class="btn-reserva pulse">
                                                <i class="fas fa-eye"></i> Ver Reserva
                                            </a>
                                        </div>
                                    
                                    
                                </div>

                                <!-- Botón para móvil (oculto en escritorio) -->
                                <div class="arrival-button-mobile">
                                    <a href="{{ route('admin.reservas.show', $reserva->id) }}" class="btn-reserva pulse">
                                        <i class="fas fa-eye"></i> Ver Reserva
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>


                </div>

                <!-- Próximas Salidas -->
                <div class="card card-secondary">
                    <div class="card-header">
                        <div>
                            <i class="fas fa-plane-departure"></i> Próximas Salidas
                        </div>
                    </div>
                    <div class="card-body">
                        @if($proximasSalidas->count() > 0)
                            @foreach($proximasSalidas as $reserva)
                                <div class="departure-item">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6 class="mb-1">{{ $reserva->titular->nombre ?? 'N/A' }} {{ $reserva->titular->apellido ?? '' }}</h6>
                                            <div class="d-flex flex-wrap">
                                                <span class="me-3"><i class="fas fa-users me-1"></i> {{ $reserva->cantidad_pasajeros }} pasajeros</span>
                                                <span class="me-3"><i class="fas fa-plane me-1"></i> Vuelo: {{ $reserva->nro_vuelo_retorno ?? 'N/A' }}</span>
                                                <span><i class="far fa-clock me-1"></i> {{ $reserva->hora_salida ?? 'N/A' }}</span>
                                            </div>
                                        </div>
                                        <div class="text-end">
                                            <span class="badge badge-salida">Próxima Salida</span>
                                            <div class="fw-bold mt-1">{{ \Carbon\Carbon::parse($reserva->fecha_salida)->format('d M Y') }}</div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="empty-state">
                                <i class="fas fa-plane-slash"></i>
                                <p>No hay salidas programadas</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Próximo Tour a Machupicchu -->
                <div class="card">
                    <div class="card-header">
                        <div>
                            <i class="fas fa-mountain"></i> Próximo Tour a Machupicchu
                        </div>
                    </div>

                    <div class="card-body">
                        @foreach($proximoMachu as $tourMachu)
                            <div class="machu-card mb-3">
                                <!-- Contenedor principal para escritorio -->
                                <div class="machu-card-desktop">
                                    <!-- Contenido a la izquierda -->
                                    <div class="machu-content">
                                        <div class="d-flex justify-content-between align-items-start mb-3">
                                            <div>
                                                <h5 class="mb-1">{{ $tourMachu->reserva->titular->nombre ?? 'N/A' }} {{ $tourMachu->reserva->titular->apellido ?? '' }}</h5>
                                                <p class="mb-1"><i class="fas fa-users me-1"></i> {{ $tourMachu->reserva->cantidad_pasajeros }} pasajeros</p>
                                                <p class="mb-1"><i class="fas fa-route me-1"></i> {{ $tourMachu->tour->nombreTour ?? 'N/A' }}</p>

                                            </div>
                                            <div class="text-end">
                                                <span class="badge badge-primary"><i class="far fa-calendar me-1"></i> Fecha del tour</span>
                                                <div class="fw-bold mt-1">{{ \Carbon\Carbon::parse($tourMachu->fecha)->format('d M Y')  }}</div>

                                            </div>
                                        </div>

                                        @if($tourMachu->detalleMachupicchu)
                                            @php $detalle = $tourMachu->detalleMachupicchu; @endphp
                                            <div class="row mt-3">
                                                <div class="col-md-6">
                                                    <p class="mb-0"><strong>Entrada:</strong> {{ $detalle->tipo_entrada ?? 'No especificado' }}</p>
                                                    <p class="mb-0"><strong>Circuito:</strong> {{ $detalle->ruta1 ?? $detalle->ruta2 ?? $detalle->ruta3 ?? '-' }}</p>
                                                    <p class="mb-0"><strong>Horario:</strong> {{ \Carbon\Carbon::parse($detalle->horario_entrada)->format('H:i')  ?? '-'}}</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <p class="mb-0"><strong>Tren:</strong> 
                                                        @if(isset($detalle->tipo_tren))
                                                            {{ $detalle->tipo_tren == 'turístico' ? 'Turístico' : 'Local' }}
                                                        @else
                                                            No especificado
                                                        @endif
                                                    </p>
                                                    <p class="mb-0"><strong>Fecha tren ida:</strong> {{ $detalle->fecha_tren_ida ?? 'No especificado' }}</p>
                                                    <p class="mb-0"><strong>Horario tren ida:</strong> {{ $detalle->horario_ida ?? 'No especificado' }}</p>
                                                </div>
                                            </div>
                                        @else
                                            <p class="mb-0 mt-2 text-muted">No hay detalles específicos de Machupicchu para este tour.</p>
                                        @endif
                                    </div>
                                    
                                    <!-- Botón a la derecha (solo visible en escritorio) -->
                                    <div class="machu-button-desktop">
                                        <a href="{{ route('admin.reservas.show', $tourMachu->reserva->id) }}" class="btn-reserva pulse">
                                            <i class="fas fa-eye"></i> Ver Reserva
                                        </a>
                                    </div>
                                </div>
                                
                                <!-- Botón para móvil (oculto en escritorio) -->
                                <div class="machu-button-mobile">
                                    <a href="{{ route('admin.reservas.show', $tourMachu->reserva->id) }}" class="btn-reserva pulse">
                                        <i class="fas fa-eye"></i> Ver Reserva
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>




                <!-- Último Depósito Recibido -->
                <div class="card">
                    <div class="card-header">
                        <div>
                            <i class="fas fa-money-bill-wave"></i> Último Depósito Recibido
                        </div>
                    </div>
                    <div class="card-body">
                        @if($ultimoDeposito)
                            <div class="transaction-card mb-3">
                                <!-- Contenedor principal para escritorio -->
                                <div class="transaction-card-desktop">
                                    <!-- Contenido a la izquierda -->
                                    <div class="transaction-content">
                                        <div class="d-flex align-items-center">
                                            <div class="transaction-icon transaction-deposit">
                                                <i class="fas fa-money-bill-wave"></i>
                                            </div>
                                            <div>
                                                <h5 class="mb-1">{{ $ultimoDeposito->nombre_depositante ?? 'N/A' }}</h5>
                                                <p class="mb-0">$ {{ number_format($ultimoDeposito->monto, 2) }}</p>
                                                <small class="text-muted">{{ $ultimoDeposito->tipo_deposito }}</small><br>
                                                <small class="text-muted">{{ \Carbon\Carbon::parse($ultimoDeposito->fecha)->format('d M Y') }}</small>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Botones a la derecha (escritorio) -->
                                    <div class="transaction-button-desktop">
                                        @if(isset($ultimoDeposito->reserva_id))
                                            <a href="{{ route('admin.reservas.show', $ultimoDeposito->reserva_id) }}" class="btn-reservaz btn-reservaz-sm">
                                                <i class="fas fa-eye"></i> Ver Reserva
                                            </a>
                                        @endif
                                        <a href="{{ route('admin.depositos.edit', $ultimoDeposito->id) }}" class="btn-actualizar btn-actualizar-sm">
                                            <i class="fas fa-edit"></i> Actualizar
                                        </a>
                                    </div>
                                </div>

                                <!-- Botones para móvil (oculto en escritorio) -->
                                <div class="transaction-button-mobile mt-2">
                                    @if(isset($ultimoDeposito->reserva_id))
                                        <a href="{{ route('admin.reservas.show', $ultimoDeposito->reserva_id) }}" class="btn-reservaz btn-reservaz-sm w-100 mb-2">
                                            <i class="fas fa-eye"></i> Ver Reserva
                                        </a>
                                    @endif
                                    <a href="{{ route('admin.depositos.edit', $ultimoDeposito->id) }}" class="btn-actualizar btn-actualizar-sm w-100">
                                        <i class="fas fa-edit"></i> Actualizar
                                    </a>
                                </div>
                            </div>
                        @else
                            <div class="empty-state">
                                <i class="fas fa-money-bill-wave"></i>
                                <p>No hay depósitos registrados</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Estado de Facturaciones -->
                <div class="card card-alert">
                    <div class="card-header">
                        <div>
                            <i class="fas fa-file-invoice-dollar"></i> Facturaciones Pendientes
                        </div>
                        <span class="badge badge-danger">{{ $factPendientes->count() }} pendientes</span>
                    </div>
                    <div class="card-body">
                        @if($factPendientes->count() > 0)
                            @foreach($factPendientes as $factura)
                                <div class="factura-card mb-3">
                                    <!-- Contenedor principal para escritorio -->
                                    <div class="factura-card-desktop">
                                        <div class="d-flex align-items-center">
                                            <!-- Contenido a la izquierda -->
                                            <div class="transaction-icon transaction-factura">
                                                <i class="fa-solid fa-circle-exclamation"></i>
                                            </div>

                                            <div>
                                                <h5 class="mb-0">{{ $factura->titular ?? 'N/A' }}</h5>
                                                <p class="mb-0">Tipo: {{ $factura->tipo }}</p>                                            
                                                <small class="text-muted">{{ \Carbon\Carbon::parse($factura->fecha_giro)->format('d M Y') }}</small>
                                            </div>
                                        </div>

                                        <!-- Botones a la derecha (escritorio) -->
                                        <div class="factura-button-desktop">
                                            @if(isset($factura->reserva_id))
                                                <a href="{{ route('admin.reservas.show', $factura->reserva_id) }}" class="btn-reservaz btn-reservaz-sm">
                                                    <i class="fas fa-eye"></i> Ver Reserva
                                                </a>
                                            @endif
                                            <a href="{{ route('admin.facturacion.edit', $factura->id) }}" class="btn-actualizar btn-actualizar-sm">
                                                <i class="fas fa-edit"></i> Actualizar
                                            </a>
                                        </div>
                                    </div>

                                    <!-- Botones para móvil (oculto en escritorio) -->
                                    <div class="factura-button-mobile mt-2">
                                        @if(isset($factura->reserva_id))
                                            <a href="{{ route('admin.reservas.show', $factura->reserva_id) }}" class="btn-reservaz btn-reservaz-sm w-100 mb-2">
                                                <i class="fas fa-eye"></i> Ver Reserva
                                            </a>
                                        @endif
                                        <a href="{{ route('admin.facturacion.edit', $factura->id) }}" class="btn-actualizar btn-actualizar-sm w-100">
                                            <i class="fas fa-edit"></i> Actualizar
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="empty-state">
                                <i class="fas fa-check-circle"></i>
                                <p>No hay facturaciones pendientes</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Última Factura Recibida -->
                <div class="card">
                    <div class="card-header">
                        <div>
                            <i class="fas fa-file-invoice"></i> Última Factura Recibida
                        </div>
                    </div>
                    <div class="card-body">
                        @if($ultimaFactura)
                            <div class="transaction-card">
                                <div class="d-flex align-items-center">
                                    <div class="transaction-icon transaction-invoice">
                                        <i class="fas fa-file-invoice"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">{{ $ultimaFactura->titular ?? 'N/A' }}</h6>
                                        <p class="mb-0">S/ {{ number_format($ultimaFactura->monto, 2) }}</p>
                                        <small class="text-muted">{{ \Carbon\Carbon::parse($ultimaFactura->fecha)->format('d M Y') }}</small>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="empty-state">
                                <i class="fas fa-file-invoice"></i>
                                <p>No hay facturas recibidas</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Estado de Pagos Contables -->
                <div class="card">
                    <div class="card-header">
                        <div>
                            <i class="fas fa-calculator"></i> Estado de Pagos Contables
                        </div>
                    </div>
                    <div class="card-body">
                        @if($estadoPagos)
                            @if($estadoPagos['estado'] == 'Pendiente')
                                <div class="pago-status pago-pendiente text-center">
                                    <i class="fas fa-exclamation-circle fa-2x mb-2"></i>
                                    <h5 class="mb-1">Pago Pendiente</h5>
                                    <p class="mb-1">Mes: {{ $estadoPagos['mes'] }}</p>
                                    <small>Último pago: {{ \Carbon\Carbon::parse($estadoPagos['ultimo_cubierto']->fecha_pago)->format('M Y') }}</small>

                                    <!-- Botón debajo -->
                                    <div class="mt-3">
                                        <a href="{{ route('admin.contabilidad.edit', $estadoPagos['ultimo_cubierto']->id) }}" 
                                        class="btn-agregar btn-agregar-sm">
                                            <i class="fas fa-plus"></i> Agregar
                                        </a>
                                    </div>
                                </div>
                            @else
                                <div class="pago-status pago-al-dia text-center">
                                    <i class="fas fa-check-circle fa-2x mb-2"></i>
                                    <h5 class="mb-1">Sin Deudas</h5>
                                    <p class="mb-1">Al día hasta: {{ \Carbon\Carbon::parse($estadoPagos['ultimo_cubierto']->fecha_pago)->format('M Y') }}</p>
                                    <small>Monto: S/ {{ number_format($estadoPagos['ultimo_cubierto']->monto, 2) }}</small>

                                    <!-- Botón debajo -->
                                    <div class="mt-3">
                                        <a href="{{ route('admin.contabilidad.edit', $estadoPagos['ultimo_cubierto']->id) }}" 
                                        class="btn-agregar btn-agregar-sm">
                                            <i class="fas fa-plus"></i> Agregar
                                        </a>
                                    </div>
                                </div>
                            @endif
                        @else
                            <div class="empty-state">
                                <i class="fas fa-calculator"></i>
                                <p>No hay información de pagos</p>
                            </div>
                        @endif
                    </div>

                </div>
            
        </div>

        <!-- Gráficos -->
        <div class="row mt-4">
            <div class="col-12">
                <h3 class="section-title"><i class="fas fa-chart-line me-2"></i>Métricas y Estadísticas</h3>
            </div>
            
            <!-- Gráfico 1: Depósitos mensuales -->
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-money-bill-wave me-2"></i>Depósitos Mensuales
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="depositosChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Gráfico 2: Total facturado emitido -->
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-file-export me-2"></i>Facturación Emitida
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="facturacionEmitidaChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Gráfico 3: Total facturado recibido -->
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-file-import me-2"></i>Facturación Recibida
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="facturacionRecibidaChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Gráfico 4: Demanda de reservas mensuales -->
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-chart-bar me-2"></i>Demanda de Reservas
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="demandaReservasChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

        </div>


    </div> 
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Datos de ejemplo para los gráficos (deben ser reemplazados con datos reales del controlador)
            const meses = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
            
            // Gráfico de Depósitos Mensuales
            const depositosCtx = document.getElementById('depositosChart').getContext('2d');
            new Chart(depositosCtx, {
                type: 'bar',
                data: {
                    labels: meses,
                    datasets: [{
                        label: 'Depósitos (S/)',
                        data: [12000, 19000, 15000, 25000, 22000, 30000, 28000, 26000, 31000, 35000, 40000, 42000],
                        backgroundColor: 'rgba(20, 165, 181, 0.7)',
                        borderColor: 'rgba(20, 165, 181, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return 'S/ ' + value.toLocaleString();
                                }
                            }
                        }
                    }
                }
            });
            
            // Gráfico de Facturación Emitida
            const facturacionEmitidaCtx = document.getElementById('facturacionEmitidaChart').getContext('2d');
            new Chart(facturacionEmitidaCtx, {
                type: 'line',
                data: {
                    labels: meses,
                    datasets: [{
                        label: 'Facturación Emitida (S/)',
                        data: [15000, 23000, 18000, 27000, 25000, 32000, 30000, 29000, 35000, 38000, 42000, 45000],
                        backgroundColor: 'rgba(40, 167, 69, 0.2)',
                        borderColor: 'rgba(40, 167, 69, 1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.3
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return 'S/ ' + value.toLocaleString();
                                }
                            }
                        }
                    }
                }
            });
            
            // Gráfico de Facturación Recibida
            const facturacionRecibidaCtx = document.getElementById('facturacionRecibidaChart').getContext('2d');
            new Chart(facturacionRecibidaCtx, {
                type: 'line',
                data: {
                    labels: meses,
                    datasets: [{
                        label: 'Facturación Recibida (S/)',
                        data: [10000, 17000, 14000, 22000, 20000, 27000, 25000, 24000, 29000, 32000, 37000, 40000],
                        backgroundColor: 'rgba(108, 117, 125, 0.2)',
                        borderColor: 'rgba(108, 117, 125, 1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.3
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return 'S/ ' + value.toLocaleString();
                                }
                            }
                        }
                    }
                }
            });
            
            // Gráfico de Demanda de Reservas
            const demandaReservasCtx = document.getElementById('demandaReservasChart').getContext('2d');
            new Chart(demandaReservasCtx, {
                type: 'bar',
                data: {
                    labels: meses,
                    datasets: [
                        {
                            label: 'Pasajeros',
                            data: [45, 52, 48, 65, 70, 85, 90, 78, 92, 88, 95, 110],
                            backgroundColor: 'rgba(20, 165, 181, 0.7)',
                            borderColor: 'rgba(20, 165, 181, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Tours',
                            data: [25, 30, 28, 35, 40, 45, 50, 42, 48, 45, 52, 60],
                            backgroundColor: 'rgba(255, 193, 7, 0.7)',
                            borderColor: 'rgba(255, 193, 7, 1)',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // 🔧 Selecciona todos los botones relevantes
            const buttons = document.querySelectorAll('.btn-reserva, .btn-reservaz, .btn-actualizar');
            const pulseButtons = document.querySelectorAll('.btn-reserva.pulse, .btn-reservaz.pulse, .btn-actualizar.pulse');

            // ✨ Efecto de aparición escalonada
            buttons.forEach((btn, i) => {
                btn.style.opacity = '0';
                btn.style.transform = 'translateY(10px)';
                setTimeout(() => {
                    btn.style.transition = 'opacity .5s ease, transform .5s ease';
                    btn.style.opacity = '1';
                    btn.style.transform = 'translateY(0)';
                }, 200 + i * 100);
            });

            // 📱 Tooltips en móvil
            if (window.innerWidth < 768) {
                buttons.forEach(btn => {
                    btn.setAttribute('title', btn.classList.contains('btn-actualizar') ? 'Editar' : 'Ver Reserva');
                });
                if (typeof bootstrap !== 'undefined') {
                    [...document.querySelectorAll('[title]')].forEach(el => new bootstrap.Tooltip(el));
                }
            }

            // ✅ Efecto de confirmación al hacer clic
            buttons.forEach(btn => {
                btn.addEventListener('click', function (e) {
                    const originalBg = getComputedStyle(this).background;
                    this.style.background = 'var(--success)';
                    setTimeout(() => this.style.background = originalBg, 300);
                });
            });

            const machuCards = document.querySelectorAll('.machu-card');
            const arrivalCards = document.querySelectorAll('.arrival-card');
            const facturaCards = document.querySelectorAll('.factura-card');
            const transactionCards = document.querySelectorAll('.transaction-card');
    
        

            // Combina ambos NodeList en un array y aplica el evento
            [...machuCards, ...arrivalCards, ...facturaCards, ...transactionCards].forEach(card => {
                card.addEventListener('mouseenter', function () {
                    this.style.boxShadow = '0 8px 25px rgba(0, 0, 0, 0.15)';
                    this.style.transform = 'translateY(-5px)';
                });

                card.addEventListener('mouseleave', function () {
                    this.style.boxShadow = '';
                    this.style.transform = '';
                });
            });
            
            // Ajustar altura del botón para que coincida con el contenido
            function adjustButtonHeights() {
                if (window.innerWidth >= 992) {
                    const machuContents = document.querySelectorAll('.machu-content');
                    const machuButtons = document.querySelectorAll('.machu-button-desktop');

                    const arrivalContents = document.querySelectorAll('.arrival-content');
                    const arrivalButtons = document.querySelectorAll('.arrival-button-desktop');

                    const facturaContents = document.querySelectorAll('.factura-content');
                    const facturaButtons = document.querySelectorAll('.factura-button-desktop');

                    const transactionContents = document.querySelectorAll('.transaction-content');
                    const transactionButtons = document.querySelectorAll('.transaction-button-desktop');
                    
                    machuContents.forEach((content, index) => {
                        if (machuButtons[index]) {
                            const contentHeight = content.offsetHeight;
                            machuButtons[index].style.minHeight = `${contentHeight}px`;
                        }
                    });

                    arrivalContents.forEach((content, index) => {
                        if (arrivalButtons[index]) {
                            const contentHeight = content.offsetHeight;
                            arrivalButtons[index].style.minHeight = `${contentHeight}px`;
                        }
                    });

                    facturaContents.forEach((content, index) => {
                        if (facturaButtons[index]) {
                            const contentHeight = content.offsetHeight;
                            facturaButtons[index].style.minHeight = `${contentHeight}px`;
                        }
                    });

                    transactionContents.forEach((content, index) => {
                        if (transactionButtons[index]) {
                            const contentHeight = content.offsetHeight;
                            transactionButtons[index].style.minHeight = `${contentHeight}px`;
                        }
                    });
                }
            }
            
            // Ejecutar al cargar y al redimensionar
            adjustButtonHeights();
            window.addEventListener('resize', adjustButtonHeights);
                });
    </script>
@endsection