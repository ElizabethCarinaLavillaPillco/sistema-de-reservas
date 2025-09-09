@extends('layouts.template')

@section('title', 'Proveedores - Expediciones Allinkay')
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
                        <li class="breadcrumb-item active">Proveedores</li>
                    </ol>
                </nav>
            </div>
            
                <!-- CONTENIDO -->
                <div class="container">
                    <!-- Header de página -->
                    <div class="page-header">
                        <h1 class="page-title"><i class="fas fa-calendar-check me-2" style="color: var(--primary);"></i>Proveedores</h1>
                        <a href="{{ route('admin.proveedores.create') }}" class="btn btn-primary-custom">
                            <i class="fa fa-plus"></i> Nueva Proveedor
                        </a>
                    </div>

                    <!-- Lista de proveedores -->
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-list me-2"   style="color: var(--light);"></i> Lista de Pasajeros</span>
                            <span class="badge bg-light text-dark">{{ $proveedores->count() }} registros</span>
                        </div>
                        <div class="card-body p-0">
                            @if($proveedores)
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0" id="reservasTable">
                                        <thead>
                                            <tr>                                  
                                                <th>ID</th>
                                                <th>Nombre de la agencia</th>
                                                <th>Nombre del encargado</th>
                                                <th>Pais</th>
                                                <th>Telefono</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($proveedores as $proveedor)
                                            <tr>
                                                <td>{{ $proveedor->id }}</td>
                                                <td>
                                                    <div class="fw-bold">{{ $proveedor->nombreAgencia }}
                                                    </div>
                                                </td>
                                                <td>{{ $proveedor->nombreEncargado }}</td>
                                                <td>{{ $proveedor->pais }}</td>
                                                <td>{{ $proveedor->telefono }}</td>

                                                <td>
                                                        <div class="d-flex gap-2">
                                                            
                                                            <a href="{{ route('admin.proveedores.edit', $proveedor->id) }}" 
                                                            class="btn-action btn-edit" 
                                                            data-bs-toggle="tooltip" title="Editar">
                                                                <i class="fa fa-edit"></i>
                                                            </a>
                                                            <form action="{{ route('admin.proveedores.destroy', $proveedor->id) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button class="btn-action btn-delete" 
                                                                        onclick="return confirm('¿Estás seguro de eliminar este proveedor?')"
                                                                        data-bs-toggle="tooltip" title="Eliminar">
                                                                    <i class="fa fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="8" class="text-center">No hay proveedores registrados.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                
                            
                                
                            @else
                                <div class="empty-state">
                                    <i class="fas fa-calendar-times"></i>
                                    <h4>No hay proveedores registrados</h4>
                                    <p>Comienza creando tu proveedor</p>
                                    <a href="{{ route('admin.proveedores.create') }}" class="btn btn-primary-custom mt-2">
                                        <i class="fa fa-plus"></i> Registrar nuevos proveedores
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