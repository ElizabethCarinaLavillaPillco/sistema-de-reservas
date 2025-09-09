@extends('layouts.template')

@section('title', 'Facturacion - Expediciones Allinkay')
    @section('styles')
        <style>
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
        </style>
    @endsection    

    @section('content')
        <div class="container-fluid py-4">
            <div class="page-header">
                
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Facturacion</li>
                    </ol>
                </nav>
            </div>
            
                <!-- CONTENIDO -->
                <div class="container">
                    <!-- Header de página -->
                    <div class="page-header">
                        <h1 class="page-title"><i class="fas fa-calendar-check me-2" style="color: var(--primary);"></i>Facturacion Emitida</h1>
                        <a href="{{ route('admin.facturacion.create') }}" class="btn btn-primary-custom">
                            <i class="fa fa-plus"></i> Nuevo facturación a emitir
                        </a>
                    </div>

                    <!-- Lista de facturacion -->
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-list me-2"   style="color: var(--light);"></i> Lista de facturaciones</span>
                            <span class="badge bg-light text-dark">{{ $facturacion->count() }} registros</span>
                        </div>
                        <div class="card-body p-0">
                            @if($facturacion)
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0" id="reservasTable">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Reserva</th>
                                                <th>Tipo</th>
                                                
                                                <th>Titular</th>
                                                <th>Pais</th>
                                                <th>Fecha Giro</th>
                                                <th>Tipo</th>
                                                <th>Total</th>
                                                <th>Estado</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($facturacion as $f)
                                                <tr>
                                                    <td>{{ $f->id }}</td>
                                                    <td>
                                                        @if ($f->reserva)
                                                            <a href="{{ route('admin.facturacion.show', $f->reserva_id) }}" 
                                                                class="btn-action-ver-reserva btn-ver-reserva"
                                                                    data-bs-toggle="tooltip" title="Ver Reserva">
                                                                    {{ $f->reserva_id }}
                                                                </a>
                                                        @else
                                                            <span class="text-muted">No asociada</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $f->tipo_fac }}</td>
                                                    
                                                    
                                                    <td>
                                                        <div class="fw-bold">{{ $f->titular }}</div>
                                                    </td>
                                                    <td>{{ $f->pais }}</td>
                                                    <td>{{ $f->fecha_giro ? \Carbon\Carbon::parse($f->fecha_giro)->format('d/m/Y') : 'N/A' }}</td>
                                                    <td>{{ $f->tipo }}</td>
                                                    <td>${{ number_format($f->total_facturado, 2) }}</td>
                                                    
                                                    <td>
                                                        @if($f->estado === 'Realizado')
                                                            <span class="badge bg-success">Realizado</span>
                                                        @else
                                                            <span class="badge bg-secondary">No Realizado</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="d-flex gap-2">
                                                            <a href="{{ route('admin.facturacion.show', $f->id) }}" 
                                                            class="btn-action btn-view" 
                                                            data-bs-toggle="tooltip" title="Ver detalles">
                                                                <i class="fa fa-eye"></i>
                                                            </a>
                                                            <a href="{{ route('admin.facturacion.edit', $f->id) }}" 
                                                            class="btn-action btn-edit" 
                                                            data-bs-toggle="tooltip" title="Editar">
                                                                <i class="fa fa-edit"></i>
                                                            </a>
                                                            <form action="{{ route('admin.facturacion.destroy', $f->id) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button class="btn-action btn-delete" 
                                                                        onclick="return confirm('¿Estás seguro de eliminar este facturacion?')"
                                                                        data-bs-toggle="tooltip" title="Eliminar">
                                                                    <i class="fa fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="8" class="text-center">No hay facturacion registrados.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                
                                <!-- facturacion -->
                                @if($facturacion->hasPages())
                                <div class="card-footer">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="text-muted">
                                            Mostrando {{ $facturacion->firstItem() }} - {{ $facturacion->lastItem() }} de {{ $facturacion->total() }} registros
                                        </div>
                                        <div>
                                            {{ $facturacion->links() }}
                                        </div>
                                    </div>
                                </div>
                                @endif
                                
                            @else
                                <div class="empty-state">
                                    <i class="fas fa-calendar-times"></i>
                                    <h4>No hay facturaciones registradas</h4>
                                    <p>Comienza creando tu primera facturacion</p>
                                    <a href="{{ route('admin.facturacion.create') }}" class="btn btn-primary-custom mt-2">
                                        <i class="fa fa-plus"></i> Registrar nueva facturacion
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
        </div>
    @endsection

@section('scripts')
@endsection