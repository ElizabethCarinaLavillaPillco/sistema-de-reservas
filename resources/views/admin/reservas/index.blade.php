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
                --border-radius: 12px;
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

            .btn-primary-custom {
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
                box-shadow: var(--shadow);
                text-decoration: none;
            }

            .btn-filter {
                background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
                border: none;
                border-radius: var(--border-radius);
                padding: 0.7rem 1rem;
                color: white;
                font-weight: 500;
                transition: all 0.3s;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 0.5rem;
            }

            .btn-filter:hover {
                background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 100%);
                transform: translateY(-2px);
                box-shadow: var(--shadow-hover);
            }

            .btn-reset {
                background: transparent;
                border: 1px solid #dee2e6;
                border-radius: var(--border-radius);
                padding: 0.7rem 1rem;
                color: #6c757d;
                transition: all 0.3s;
                display: flex;
                align-items: center;
                justify-content: center;
                
            }

            .btn-reset:hover {
                background-color: #f8f9fa;
                border-color: var(--primary);
                color: var(--primary);
            }

            .btn-primary-custom:hover {
                background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 100%);
                transform: translateY(-2px);
                box-shadow: var(--shadow-hover);
                color: white;
            }

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

            .form-control, .form-select { 
                font-size: .9rem; 
                padding: .45rem .75rem; 
            }

            .form-control:focus, .form-select:focus {
                border-color: var(--primary);
                box-shadow: 0 0 0 0.25rem rgba(20, 165, 181, 0.25);
            }

            .btn-outline-secondary {
                border-radius: var(--border-radius);
                padding: 0.7rem 1rem;
                transition: all 0.3s;
            }

            .btn-outline-secondary:hover {
                background-color: var(--primary);
                border-color: var(--primary);
                color: white;
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
                background: white;
                border-bottom: 1px solid rgba(0,0,0,0.1);
                padding: 1rem 1.5rem;
                font-weight: 600;
                color: var(--dark);
                display: flex;
                align-items: center;
                justify-content: space-between;
            }

            .card-header i {
                color: var(--primary);
                margin-right: 0.5rem;
            }

            .reserva-item {
                border-left: 4px solid var(--primary);
                transition: all 0.3s;
            }

            .reserva-item:hover {
                border-left-color: var(--primary-dark);
                background-color: var(--primary-transparent);
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

            .btn-action {
                width: 36px;
                height: 36px;
                border-radius: 50%;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                transition: all 0.3s;
            }

            .btn-view {
                background-color: rgba(20, 165, 181, 0.1);
                color: var(--primary);
            }

            .btn-view:hover {
                background-color: var(--primary);
                color: white;
            }

            .btn-edit {
                background-color: rgba(255, 193, 7, 0.1);
                color: var(--warning);
            }

            .btn-edit:hover {
                background-color: var(--warning);
                color: white;
            }

            .btn-delete {
                background-color: rgba(220, 53, 69, 0.1);
                color: #dc3545;
            }

            .btn-delete:hover {
                background-color: #dc3545;
                color: white;
            }

            .empty-state {
                text-align: center;
                padding: 3rem;
                color: #6c757d;
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

            /* Animaciones */
            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(10px); }
                to { opacity: 1; transform: translateY(0); }
            }

            @keyframes slideIn {
                from { transform: translateX(-20px); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }

            /* Responsive */
            @media (max-width: 768px) {
                .page-header {
                    flex-direction: column;
                    align-items: flex-start;
                }
                
                .stats-container {
                    grid-template-columns: 1fr;
                }
                
                .table-responsive {
                    overflow-x: auto;
                }
                
                .reserva-item td {
                    min-width: 120px;
                }
                
                .btn-action {
                    width: 32px;
                    height: 32px;
                    font-size: 0.8rem;
                }
                /*nuevoz*/
                .filter-buttons {
                    flex-direction: column;
                }
                
                .btn-filter, .btn-reset {
                    width: 100%;
                    margin-bottom: 0.5rem;
                }
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

            /* Estilos para la tabla */
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

        <div class="container-fluid py-4">
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
                    <span><i class="fas fa-list me-2"></i> Lista de Reservas</span>
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
                                        <th>Fecha Llegada</th>
                                        <th>N° Vuelo</th>
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
                                            <td><small>#{{ $reserva->id }}</small></td>
                                            <td>
                                                <div class="fw-bold">{{ $reserva->titular->nombre ?? '-' }} {{ $reserva->titular->apellido ?? '' }}</div>
                                                <small class="badge {{ $badgeClass }}">{{ $estado }}</small>
                                            </td>
                                            <td>
                                                <span class="badge bg-secondary">{{ $reserva->cantidad_pasajeros }}</span>
                                            </td>
                                            <td>
                                                <div class="fw-medium">{{ $reserva->fecha_llegada }}</div>
                                                @if($reserva->hora_llegada)
                                                    <small class="text-muted">{{ $reserva->hora_llegada }}</small>
                                                @endif
                                            </td>
                                            <td>{{ $reserva->nro_vuelo_llegada ?? '-' }}</td>
                                            <td>
                                                @if($reserva->tourReserva->count() > 0)
                                                    <div class="d-flex align-items-center">
                                                        <span class="badge bg-primary me-1">{{ $reserva->cantidad_tours }}</span>
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
                                            <td class="fw-bold">S/ {{ number_format($reserva->total, 2) }}</td>
                                            <td>S/ {{ number_format($reserva->adelanto, 2) }}</td>
                                            <td>
                                                <strong class="{{ $saldo <= 0 ? 'text-success' : 'text-danger' }}">
                                                    S/ {{ number_format($saldo, 2) }}
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

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Inicializar tooltips
                const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
                const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
                
                // Animación de entrada para las filas
                const tableRows = document.querySelectorAll('.reserva-item');
                tableRows.forEach((row, index) => {
                    row.style.opacity = '0';
                    row.style.transform = 'translateY(10px)';
                    
                    setTimeout(() => {
                        row.style.transition = 'opacity 0.5s ease, transform 0.5s ease, background-color 0.3s ease';
                        row.style.opacity = '1';
                        row.style.transform = 'translateY(0)';
                    }, 100 + (index * 50));
                });
                
                // Efecto de filtrado con JavaScript (si es necesario)
                const searchInput = document.getElementById('searchInput');
                if (searchInput) {
                    searchInput.addEventListener('keyup', function() {
                        const filter = this.value.toLowerCase();
                        const rows = document.querySelectorAll('#reservasTable tbody tr');
                        
                        rows.forEach(row => {
                            const text = row.textContent.toLowerCase();
                            row.style.display = text.indexOf(filter) > -1 ? '' : 'none';
                        });
                    });
                }
                
                // Efectos de hover mejorados
                const actionButtons = document.querySelectorAll('.btn-action');
                actionButtons.forEach(button => {
                    button.addEventListener('mouseenter', function() {
                        this.style.transform = 'scale(1.1)';
                    });
                    
                    button.addEventListener('mouseleave', function() {
                        this.style.transform = 'scale(1)';
                    });
                });
            });
        </script>
    @endsection
