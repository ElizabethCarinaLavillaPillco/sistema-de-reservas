@extends('layouts.template')

@section('title', 'Tours - Expediciones Allinkay')
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
                        <li class="breadcrumb-item active">Tours</li>
                    </ol>
                </nav>
            </div>
            
                <!-- CONTENIDO -->
                <div class="container">
                    <!-- Header de página -->
                    <div class="page-header">
                        <h1 class="page-title"><i class="fas fa-calendar-check me-2" style="color: var(--primary);"></i>Tours</h1>
                        <a href="{{ route('admin.tours.create') }}" class="btn btn-primary-custom">
                            <i class="fa fa-plus"></i> Nuevo Tour
                        </a>
                    </div>


                    <!-- Lista de tours -->
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-list me-2"   style="color: var(--light);"></i> Lista de Tours</span>
                            <span class="badge bg-light text-dark">{{ $tours->count() }} registros</span>
                        </div>
                        <div class="card-body p-0">
                            @if($tours)
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0" id="reservasTable">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Nombre</th>
                                                <th>Descripción</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($tours as $tour)
                                            <tr>
                                                <td>{{ $tour->id }}</td>
                                                <td>
                                                    <div class="fw-bold">{{ $tour->nombreTour }}
                                                        </div>
                                                    </td>
                                                <td>{{ $tour->descripcion }}</td>
                                                <td>
                                                        <div class="d-flex gap-2">
                                                            
                                                            <a href="{{ route('admin.tours.edit', $tour->id) }}" 
                                                            class="btn-action btn-edit" 
                                                            data-bs-toggle="tooltip" title="Editar">
                                                                <i class="fa fa-edit"></i>
                                                            </a>
                                                            <form action="{{ route('admin.tours.destroy', $tour->id) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button class="btn-action btn-delete" 
                                                                        onclick="return confirm('¿Estás seguro de eliminar este tour?')"
                                                                        data-bs-toggle="tooltip" title="Eliminar">
                                                                    <i class="fa fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="8" class="text-center">No hay tours registrados.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                
                        
                                
                            @else
                                <div class="empty-state">
                                    <i class="fas fa-calendar-times"></i>
                                    <h4>No hay tours registrados</h4>
                                    <p>Comienza creando tu primera tour</p>
                                    <a href="{{ route('admin.tours.create') }}" class="btn btn-primary-custom mt-2">
                                        <i class="fa fa-plus"></i> Registrar nuevo tour
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
