@extends('layouts.template')

@section('title', 'Reservas - Expediciones Allinkay')
    
        <style>
        
            .stats-container {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
                gap: 1rem;
                margin-bottom: 2rem;
            }

            .stat-card {
                display: flex;
                align-items: center;
                gap: 1rem;
                padding: 1rem;
                background: #fff;
                border-radius: var(--border-radius);
                box-shadow: var(--shadow);
                transition: .3s;
            }

            .stat-card:hover {
                transform: translateY(-2px); 
                box-shadow: var(--shadow-hover);
            }

            .stat-icon {
                width: 48px;
                height: 48px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.25rem;
                color: #fff;
            }

            .stat-primary {
                background: var(--primary);
            }

            .stat-content {
                flex: 1;
            }

            .stat-value {
                font-size: 1.5rem;
                font-weight: 700;
                margin-bottom: 1rem;
            }

            .stat-label {
                font-size: .9rem; 
                color: #6c757d;
            }

            .filters-container {
                background: #fff;
                border-radius: var(--border-radius);
                box-shadow: var(--shadow);
                padding: 1rem 1.5rem;
            }

            .filter-title {
                margin-bottom: .75rem;
                font-size: 1.1rem;
                font-weight: 600;
                display: flex;
                align-items: center;
                gap: .5rem;
            }

            .form-label { 
                margin-bottom: .25rem; 
                font-size: .85rem; 
            }


            .badge-warning {
                background-color: #ffc107 !important;
                color: #000 !important;
            }

            .badge-danger {
                background-color: #dc3545 !important;
                color: #fff !important;
            }

            .badge-success {
                background-color: #28a745 !important;
                color: #fff !important;
            }

            .bg-secondary{
                background-color: var(--primary) !important;
                color: #fff !important;
            }

            .badge-cant{
                background-color: var(--primary-dark) !important;
                margin-right: 0.5rem;
                color: #fff !important;
            }

            .empty-state {
                text-align: center;
                padding: 3rem;
                color: #097ee3ff;
            }

            .empty-state i {
                font-size: 4rem;
                margin-bottom: 1rem;
                color: #dee2e6;
            }

            .progress {
                height: 8px;
                border-radius: 4px;
                background-color: #e9ecef;
                overflow: hidden;
            }

            .progress-bar {
                border-radius: 4px;
            }

            
            
            /* Botón compacto dentro de la tarjeta de estadísticas */
            .arrival-button-desktop {
                margin-top: auto; /* se pega al fondo */
            }

            .btn-reserva {
                display: inline-flex;
                align-items: center;
                gap: 0.4rem;
                padding: 0.45rem 0.9rem;
                font-size: 0.8rem;
                font-weight: 600;
                border: none;
                border-radius: 20px;
                background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
                color: #fff;
                text-decoration: none;
                transition: all 0.3s ease;
                box-shadow: var(--shadow);
            }

            .btn-reserva:hover {
                transform: translateY(-2px);
                box-shadow: var(--shadow-hover);
                background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 100%);
            }

            /* Pulso */
            .btn-reserva.pulse {
                animation: pulse 2s infinite;
            }

            @keyframes pulse {
                0%   { box-shadow: 0 0 0 0 rgba(20, 165, 181, 0.4); }
                70%  { box-shadow: 0 0 0 8px rgba(20, 165, 181, 0); }
                100% { box-shadow: 0 0 0 0 rgba(20, 165, 181, 0); }
            }

            /* RESPONSIVE */
            @media (max-width: 992px) {
                .dashboard-top-section {
                    grid-template-columns: 1fr;
                }
                
                .stats-container {
                    flex-direction: row;
                    overflow-x: auto;
                    padding-bottom: 1rem;
                }
                
                .stat-card {
                    min-width: 250px;
                }
            }

            

            /* Estilos para el rango de fechas */
            .date-range-container {
                display: flex;
                gap: .5rem;
                align-items: center;
            }

            .date-range-container .w-100 { flex: 1; }
            .date-range-separator { font-size: .75rem; color: #6c757d; }

            .date-range-separator {
                display: flex;
                align-items: center;
                justify-content: center;
                padding-top: 1.8rem;
                font-weight: bold;
            }
            /* CONTENEDOR PRINCIPAL DE ESTADÍSTICAS Y FILTROS */
            .dashboard-top-section {
                display: grid;
                grid-template-columns: 1fr 2fr; /* 1/3 - 2/3 */
                gap: 1.5rem;
                margin-bottom: 1.5rem;
            }
            @media (max-width: 768px) {
                .dashboard-top-section {
                    grid-template-columns: 1fr; /* Un solo contenedor en móvil */
                }
            }

            @media (max-width: 576px) {
                .date-range-container {
                    padding-bottom: 0.6rem;
                }
                
                .date-range-separator {
                    padding-top: 0;
                    padding-bottom: 0.5rem;
                }
            }
            /* Mejoras para los botones de filtro */
            .filter-buttons {
                display: flex;
                gap: .5rem;
            }

            .btn-filter, .btn-reset {
                flex: 1;
                padding: .5rem 1rem;
                font-size: .85rem;
                border-radius: var(--border-radius);
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: .4rem;
                transition: .3s;
            }

            @media (min-width: 769px) {
                .filter-buttons {
                    flex-direction: column;
                }
                
                .btn-filter, .btn-reset {
                    width: 100%;
                }
            }

            @media (max-width: 576px) {
                .filter-buttons { flex-direction: column; }
            }
        </style>
    @section('styles')    
    @endsection

    @section('content')
        <div class="container-fluid py-4">
            <div class="page-header">
                
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Reservas</li>
                    </ol>
                </nav>
            </div>
            
                <!-- CONTENIDO -->
                <div class="container">
                    <!-- Header de página -->
                    <div class="page-header">
                        <h1 class="page-title"><i class="fas fa-calendar-check me-2" style="color: var(--primary);"></i>Gestión de Reservas</h1>
                        <a href="{{ route('admin.reservas.create') }}" class="btn btn-primary-custom">
                            <i class="fa fa-plus"></i> Nueva Reserva
                        </a>
                    </div>

                    <!-- Contenedor principal para estadísticas y filtros -->
                    <div class="dashboard-top-section">
                        <!-- Estadísticas -->
                        <div class="stats-container">
                            <div class="stat-card">
                                <div class="stat-icon stat-primary">
                                    <i class="fas fa-calendar"></i>
                                </div>
                                <div class="stat-content">
                                    <div class="stat-value">{{ $proximasReservas->count() }}</div>
                                    <div class="stat-label">Total de Reservas Entrantes</div>
                                </div>

                                <!-- Botón Mostrar Reservas Entrantes -->
                                <div class="arrival-button-desktop">
                                    <a href="{{ route('admin.reservas.index', ['entrantes' => 1]) }}" class="btn-reserva pulse">
                                        <i class="fas fa-eye"></i> Mostrar Reservas
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Filtros -->
                        <div class="filters-container">
                            <h3 class="filter-title"><i class="fas fa-filter"></i> Filtros</h3>
                            <form method="GET" action="{{ route('admin.reservas.index') }}">
                                <div class="row">
                                    <!-- Buscar por nombre -->
                                    <div class="col-md-12 mb-3">
                                        <label for="searchInput" class="form-label">Búsqueda por nombre:</label>
                                        <input type="text" name="search" id="searchInput"
                                            class="form-control"
                                            placeholder="Nombre o apellido..."
                                            value="{{ request('search') }}">
                                    </div>

                                    <!-- Estado de pago -->
                                    <div class="col-md-6 mb-3">
                                        <label for="statusFilter" class="form-label">Estado de pago</label>
                                        <select name="estado_pago" class="form-select" id="statusFilter">
                                            <option value="">Todos</option>
                                            <option value="paid" {{ request('estado_pago') == 'paid' ? 'selected' : '' }}>Pagado</option>
                                            <option value="partial" {{ request('estado_pago') == 'partial' ? 'selected' : '' }}>Pago parcial</option>
                                            <option value="pending" {{ request('estado_pago') == 'pending' ? 'selected' : '' }}>Pendiente</option>
                                        </select>
                                    </div>

                                    <!-- Rango de fechas -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Rango de fechas</label>
                                        <div class="date-range-container">
                                            <div class="w-100">
                                                <input type="date" name="fecha_inicio" class="form-control"
                                                    value="{{ request('fecha_inicio') }}">
                                            </div>
                                            <div class="date-range-separator">a</div>
                                            <div class="w-100">
                                                <input type="date" name="fecha_fin" class="form-control"
                                                    value="{{ request('fecha_fin') }}">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Botones -->
                                    <div class="col-md-12 mb-0">
                                        <div class="filter-buttons">
                                            <button type="submit" class="btn-filter">
                                                <i class="fas fa-search"></i> Aplicar Filtros
                                            </button>
                                            <a href="{{ route('admin.reservas.index') }}" class="btn-reset">
                                                <i class="fas fa-sync-alt"></i> Limpiar
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>


                    <!-- Lista de reservas -->
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-list me-2"   style="color: var(--light);"></i> Lista de Reservas</span>
                            <span class="badge bg-light text-dark">{{ $reservas->count() }} registros</span>
                        </div>
                        <div class="card-body p-0">
                            @if($reservas)
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0" id="reservasTable">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Titular</th>
                                                <th>PAX</th>
                                                <th>Llegada</th>
                                                <th>Vuelo</th>
                                                <th>Tours</th>
                                                <th>Estadía</th>
                                                <th>Total</th>
                                                <th>Adelanto</th>
                                                <th>Saldo</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($reservas as $reserva)
                                                @php
                                                    $saldo = $reserva->total - $reserva->adelanto;
                                                    if ($saldo <= 0) {
                                                        $estado = 'Pagado';
                                                        $badgeClass = 'badge-success';
                                                    } elseif ($reserva->adelanto > 0) {
                                                        $estado = 'Pago parcial';
                                                        $badgeClass = 'badge-warning';
                                                    } else {
                                                        $estado = 'Pendiente';
                                                        $badgeClass = 'badge-danger';
                                                    }
                                                @endphp
                                                <tr class="reserva-item">
                                                    <td>
                                                        <small>#{{ $reserva->id }}</small>
                                                    </td>
                                                    <td>
                                                        <div class="fw-bold">{{ $reserva->titular->nombre ?? '-' }} {{ $reserva->titular->apellido ?? '' }}</div>
                                                        <small class="badge {{ $badgeClass }}">{{ $estado }}</small>
                                                    </td>
                                                    <td>
                                                        <span class="badge badge-primary">{{ $reserva->cantidad_pasajeros }}</span>
                                                    </td>
                                                    <td>
                                                        <div class="fw-medium">{{ $reserva->fecha_llegada ? \Carbon\Carbon::parse($reserva->fecha_llegada)->format('d/m/Y') : 'N/A' }}</div>
                                                        @if($reserva->hora_llegada)
                                                            <small class="text-muted"><i class="fa-regular fa-clock"></i> {{ $reserva->hora_llegada }}</small>
                                                        @endif
                                                    </td>
                                                    <td>{{ $reserva->nro_vuelo_llegada ?? '-' }}</td>
                                                    <td>
                                                        @if($reserva->tourReserva->count() > 0)
                                                            <div class="d-flex align-items-center">
                                                                <span class="badge badge-cant"> {{ $reserva->cantidad_tours }}</span>
                                                                
                                                                <div>
                                                                    @foreach($reserva->tourReserva->take(1) as $t)
                                                                        <div class="small">{{ $t->tour->nombreTour }}</div>
                                                                    @endforeach
                                                                    @if($reserva->tourReserva->count() > 1)
                                                                        <em class="small">+{{ $reserva->tourReserva->count() - 1 }} más</em>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        @else
                                                            <span class="text-muted small">Sin tours</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($reserva->estadias->count() > 0)
                                                            <div class="d-flex align-items-center">
                                                                <div class="small">{{ $reserva->estadias->first()->nombre_estadia ?? '-' }}</div>
                                                            </div>
                                                        @else
                                                            <span class="text-muted small">Sin estadía</span>
                                                        @endif
                                                    </td>
                                                    <td class="fw-bold">S/.{{ number_format($reserva->total, 2) }}</td>
                                                    <td>S/.{{ number_format($reserva->adelanto, 2) }}</td>
                                                    <td>
                                                        <strong class="{{ $saldo <= 0 ? 'text-success' : 'text-danger' }}">
                                                            S/.{{ number_format($saldo, 2) }}
                                                        </strong>
                                                        @if($saldo > 0)
                                                            <div class="progress mt-1" style="height: 5px; width: 60px;">
                                                                @php
                                                                    $porcentaje = ($reserva->adelanto / $reserva->total) * 100;
                                                                @endphp
                                                                <div class="progress-bar bg-{{ $saldo <= 0 ? 'success' : 'warning' }}" 
                                                                    role="progressbar" style="width: {{ $porcentaje }}%" 
                                                                    aria-valuenow="{{ $porcentaje }}" aria-valuemin="0" aria-valuemax="100">
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="d-flex gap-2">
                                                            <a href="{{ route('admin.reservas.show', $reserva->id) }}" 
                                                            class="btn-action btn-view" 
                                                            data-bs-toggle="tooltip" title="Ver detalles">
                                                                <i class="fa fa-eye"></i>
                                                            </a>
                                                            <a href="{{ route('admin.reservas.edit', $reserva->id) }}" 
                                                            class="btn-action btn-edit" 
                                                            data-bs-toggle="tooltip" title="Editar">
                                                                <i class="fa fa-edit"></i>
                                                            </a>
                                                            <form action="{{ route('admin.reservas.destroy', $reserva->id) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button class="btn-action btn-delete" 
                                                                        onclick="return confirm('¿Estás seguro de eliminar esta reserva?')"
                                                                        data-bs-toggle="tooltip" title="Eliminar">
                                                                    <i class="fa fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                
                                <!-- Paginación -->
                                @if($reservas->hasPages())
                                <div class="card-footer">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="text-muted">
                                            Mostrando {{ $reservas->firstItem() }} - {{ $reservas->lastItem() }} de {{ $reservas->total() }} registros
                                        </div>
                                        <div>
                                            {{ $reservas->links() }}
                                        </div>
                                    </div>
                                </div>
                                @endif
                                
                            @else
                                <div class="empty-state">
                                    <i class="fas fa-calendar-times"></i>
                                    <h4>No hay reservas registradas</h4>
                                    <p>Comienza creando tu primera reserva</p>
                                    <a href="{{ route('admin.reservas.create') }}" class="btn btn-primary-custom mt-2">
                                        <i class="fa fa-plus"></i> Crear Reserva
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
        </div>
    @endsection
