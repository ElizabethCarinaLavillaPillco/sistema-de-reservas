@extends('layouts.template')

@section('title', 'Pasajeros - Expediciones Allinkay')
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
                        <li class="breadcrumb-item active">Depositos</li>
                    </ol>
                </nav>
            </div>
            
                <!-- CONTENIDO -->
                <div class="container">
                    <!-- Header de página -->
                    <div class="page-header">
                        <h1 class="page-title"><i class="fas fa-calendar-check me-2" style="color: var(--primary);"></i>Depositos</h1>
                        <a href="{{ route('admin.depositos.create') }}" class="btn btn-primary-custom">
                            <i class="fa fa-plus"></i> Nuevo deposito
                        </a>
                    </div>
                <!-- Lista de depositos -->
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-list me-2"   style="color: var(--light);"></i> Lista de depositos</span>
                            <span class="badge bg-light text-dark">{{ $depositos->count() }} registros</span>
                        </div>
                        <div class="card-body p-0">
                            @if($depositos)
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0" id="reservasTable">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Reserva</th>
                                                <th>Nombre del Depositante</th>
                                                
                                                <th>Monto</th>
                                                <th>Fecha</th>
                                                <th>Tipo de Depósito</th>
                                                <th>Observaciones</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($depositos as $deposito)
                                                <tr>
                                                    <td>{{ $deposito->id }}</td>

                                                    <td>
                                                        @if ($deposito->reserva)
                                                            <a href="{{ route('admin.reservas.show', $deposito->reserva_id) }}" 
                                                                class="btn-action-ver-reserva btn-ver-reserva"
                                                                    data-bs-toggle="tooltip" title="Ver Reserva">
                                                                    {{ $deposito->reserva_id }}
                                                                </a>
                                                        @else
                                                            <span class="text-muted">No asociada</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="fw-bold">{{ $deposito->nombre_depositante }}
                                                        </div>
                                                    </td>
                                                    
                                                    
                                                    <td>${{ number_format($deposito->monto, 2) }}</td>
                                                    <td>{{ $deposito->fecha  ? \Carbon\Carbon::parse($deposito->fecha)->format('d/m/Y') : 'N/A'  }}</td>
                                                    <td>{{ $deposito->tipo_deposito }}</td>
                                                    <td>{{ $deposito->observaciones }}</td>

                                                    <td>
                                                        <div class="d-flex gap-2">
                                                            
                                                            <a href="{{ route('admin.depositos.edit', $deposito->id) }}" 
                                                            class="btn-action btn-edit" 
                                                            data-bs-toggle="tooltip" title="Editar">
                                                                <i class="fa fa-edit"></i>
                                                            </a>
                                                            <form action="{{ route('admin.depositos.destroy', $deposito->id) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button class="btn-action btn-delete" 
                                                                        onclick="return confirm('¿Estás seguro de eliminar este deposito?')"
                                                                        data-bs-toggle="tooltip" title="Eliminar">
                                                                    <i class="fa fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="8" class="text-center">No hay depositos registrados.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                
                                <!-- Paginación -->
                                @if($depositos->hasPages())
                                <div class="card-footer">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="text-muted">
                                            Mostrando {{ $depositos->firstItem() }} - {{ $depositos->lastItem() }} de {{ $depositos->total() }} registros
                                        </div>
                                        <div>
                                            {{ $depositos->links() }}
                                        </div>
                                    </div>
                                </div>
                                @endif
                                
                            @else
                                <div class="empty-state">
                                    <i class="fas fa-calendar-times"></i>
                                    <h4>No hay depositos registradas</h4>
                                    <p>Comienza creando tu primera deposito</p>
                                    <a href="{{ route('admin.depositos.create') }}" class="btn btn-primary-custom mt-2">
                                        <i class="fa fa-plus"></i> Registrar nuevo deposito
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