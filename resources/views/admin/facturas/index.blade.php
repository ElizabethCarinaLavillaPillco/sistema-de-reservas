@extends('layouts.template')

@section('title', 'Facturas - Expediciones Allinkay')
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
                        <li class="breadcrumb-item active">Facturas</li>
                    </ol>
                </nav>
            </div>
            
                <!-- CONTENIDO -->
                <div class="container">
                    <!-- Header de página -->
                    <div class="page-header">
                        <h1 class="page-title"><i class="fas fa-calendar-check me-2" style="color: var(--primary);"></i>Facturas</h1>
                        <a href="{{ route('admin.facturas.create') }}" class="btn btn-primary-custom">
                            <i class="fa fa-plus"></i> Nueva factura
                        </a>
                    </div>

                    <!-- Lista de facturas -->
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-list me-2"   style="color: var(--light);"></i> Lista de facturas</span>
                            <span class="badge bg-light text-dark">{{ $facturas->count() }} registros</span>
                        </div>
                        <div class="card-body p-0">
                            @if($facturas)
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0" id="reservasTable">
                                        <thead>
                                            <tr>
                                                <th>N°</th>
                                                <th>Titular</th>
                                                <th>RUC</th>
                                                <th>Fecha</th>
                                                <th>Monto</th>
                                                <th>Descripción</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($facturas as $factura)
                                                <tr>
                                                    <td>{{ $factura->id }}</td>
                                                    <td><div class="fw-bold">{{ $factura->titular }}</div></td>
                                                    <td>{{ $factura->ruc }}</td>
                                                    <td>{{ $factura->fecha  ? \Carbon\Carbon::parse($factura->fecha)->format('d/m/Y') : 'N/A' }}</td>
                                                    <td>S/.{{ number_format($factura->monto, 2) }}</td>
                                                    <td>{{ $factura->descripcion }}</td>
                                                    <td>
                                                        <div class="d-flex gap-2">
                                                            
                                                            <a href="{{ route('admin.facturas.edit', $factura->id) }}" 
                                                            class="btn-action btn-edit" 
                                                            data-bs-toggle="tooltip" title="Editar">
                                                                <i class="fa fa-edit"></i>
                                                            </a>
                                                            <form action="{{ route('admin.facturas.destroy', $factura->id) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button class="btn-action btn-delete" 
                                                                        onclick="return confirm('¿Estás seguro de eliminar esta factura?')"
                                                                        data-bs-toggle="tooltip" title="Eliminar">
                                                                    <i class="fa fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="8" class="text-center">No hay facturas registrados.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                
                                <!-- Paginación -->
                                @if($facturas->hasPages())
                                <div class="card-footer">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="text-muted">
                                            Mostrando {{ $facturas->firstItem() }} - {{ $facturas->lastItem() }} de {{ $pasajeros->total() }} registros
                                        </div>
                                        <div>
                                            {{ $pasajeros->links() }}
                                        </div>
                                    </div>
                                </div>
                                @endif
                                
                            @else
                                <div class="empty-state">
                                    <i class="fas fa-calendar-times"></i>
                                    <h4>No hay pasajeros registradas</h4>
                                    <p>Comienza creando tu primera cliente</p>
                                    <a href="{{ route('admin.pasajeros.create') }}" class="btn btn-primary-custom mt-2">
                                        <i class="fa fa-plus"></i> Registrar nuevo pasajeros
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
