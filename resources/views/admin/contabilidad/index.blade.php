@extends('layouts.template')

@section('title', 'Contabilidad - Expediciones Allinkay')
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
                        <li class="breadcrumb-item active">Contabilidad</li>
                    </ol>
                </nav>
            </div>
            
                <!-- CONTENIDO -->
                <div class="container">
                    <!-- Header de página -->
                    <div class="page-header">
                        <h1 class="page-title"><i class="fas fa-calendar-check me-2" style="color: var(--primary);"></i>Pagos a Contabilidad</h1>
                        <a href="{{ route('admin.contabilidad.create') }}" class="btn btn-primary-custom">
                            <i class="fa fa-plus"></i> Registrar Nuevo Pago
                        </a>
                    </div>

                    <!-- Lista de contabilidad -->
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-list me-2"   style="color: var(--light);"></i> Lista de pagos</span>
                            <span class="badge bg-light text-dark">{{ $contabilidades->count() }} registros</span>
                        </div>
                        <div class="card-body p-0">
                            @if($contabilidades)
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0" id="reservasTable">
                                        <thead>
                                            <tr>
                                                <th>Año</th>
                                                <th>Mes</th>
                                                <th>Fecha de Pago</th>
                                                <th>ESSALUD</th>
                                                <th>AFP</th>
                                                <th>SERVICIOS</th>
                                                <th>IR</th>
                                                <th>Renta Anual</th>
                                                <th>Total</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($contabilidades as $item)
                                                <tr>
                                                    <td>{{ $item->anio_recibo }}</td>
                                                    <td>{{ $item->mes_recibo }}</td>
                                                    <td>{{ $item->fecha_pago  ? \Carbon\Carbon::parse($item->fecha_pago)->format('d/m/Y') : 'N/A' }}</td>
                                                    <td>S/.{{ number_format($item->essalud, 2) }}</td>
                                                    <td>S/.{{ number_format($item->afp, 2) }}</td>
                                                    <td>S/.{{ number_format($item->servicios, 2) }}</td>
                                                    <td>{{ $item->ir ? 'S/. '.number_format($item->ir, 2) : '-' }}</td>
                                                    <td>{{ $item->renta_anual ? 'S/. '.number_format($item->renta_anual, 2) : '-' }}</td>
                                                    <td>S/.{{ number_format($item->total, 2) }}</td>

                                                    <td>
                                                        <div class="d-flex gap-2">
                                                            
                                                            <a href="{{ route('admin.contabilidad.edit', $item->id) }}" 
                                                            class="btn-action btn-edit" 
                                                            data-bs-toggle="tooltip" title="Editar">
                                                                <i class="fa fa-edit"></i>
                                                            </a>
                                                            <form action="{{ route('admin.contabilidad.destroy', $item->id) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button class="btn-action btn-delete" 
                                                                        onclick="return confirm('¿Estás seguro de eliminar este registro?')"
                                                                        data-bs-toggle="tooltip" title="Eliminar">
                                                                    <i class="fa fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="8" class="text-center">No hay pagos registrados.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                
                                <!-- Paginación -->
                                @if($contabilidades->hasPages())
                                <div class="card-footer">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="text-muted">
                                            Mostrando {{ $contabilidades->firstItem() }} - {{ $contabilidades->lastItem() }} de {{ $contabilidades->total() }} registros
                                        </div>
                                        <div>
                                            {{ $contabilidades->links() }}
                                        </div>
                                    </div>
                                </div>
                                @endif
                                
                            @else
                                <div class="empty-state">
                                    <i class="fas fa-calendar-times"></i>
                                    <h4>No hay pagos registradas</h4>
                                    <p>Comienza creando tu primer pago</p>
                                    <a href="{{ route('admin.contabilidad.create') }}" class="btn btn-primary-custom mt-2">
                                        <i class="fa fa-plus"></i> Registrar nuevo pago
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