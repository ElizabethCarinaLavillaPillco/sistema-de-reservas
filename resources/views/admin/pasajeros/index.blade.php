@extends('layouts.template')

@section('title', 'Pasajeros - Expediciones Allinkay')
    @section('styles')
        <style>
            a{
                text-decoration: none;
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

        </style>
    @endsection    

    @section('content')
        <div class="container-fluid py-4">
            <div class="page-header">
                
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Pasajeros</li>
                    </ol>
                </nav>
            </div>
            
                <!-- CONTENIDO -->
                <div class="container">
                    <!-- Header de página -->
                    <div class="page-header">
                        <h1 class="page-title"><i class="fas fa-calendar-check me-2" style="color: var(--primary);"></i>Pasajeros</h1>
                        <a href="{{ route('admin.pasajeros.create') }}" class="btn btn-primary-custom">
                            <i class="fa fa-plus"></i> Nueva Pasajero
                        </a>
                    </div>

                    <!-- Formulario de búsqueda -->
                    <form method="GET" action="{{ route('admin.pasajeros.index') }}" class="mb-3">
                        <div class="input-group">
                            <input
                                type="text"
                                name="search"
                                class="form-control"
                                placeholder="Buscar por nombre o apellido"
                                value="{{ request('search') }}" >

                            <button class="btn btn-outline-secondary" type="submit">Buscar</button>

                            {{-- botón de limpiar solo cuando hay una búsqueda activa --}}
                            @if(request('search'))
                                <a href="{{ route('admin.pasajeros.index') }}" class="btn btn-outline-danger">Limpiar</a>
                            @endif
                        </div>
                    </form>

                    <!-- Lista de pasajeros -->
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-list me-2"   style="color: var(--light);"></i> Lista de Pasajeros</span>
                            <span class="badge bg-light text-dark">{{ $pasajeros->count() }} registros</span>
                        </div>
                        <div class="card-body p-0">
                            @if($pasajeros)
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0" id="reservasTable">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Nombre Completo</th>
                                                <th>Documento</th>
                                                <th>Nacionalidad</th>
                                                <th>Fecha Nac</th>
                                                <th>Edad</th>
                                                <th>Reserva</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($pasajeros as $pasajero)
                                                <tr class="reserva-item">
                                                    <td>{{ $pasajero->id }}</td>
                                                    <td>
                                                        <div class="fw-bold">{{ $pasajero->nombre }} {{ $pasajero->apellido }}</div>
                                                    </td>
                                                    <td>{{ $pasajero->documento }}</td>
                                                    <td>{{ $pasajero->pais_residencia }}</td>
                                                    <td>{{ $pasajero->fecha_nacimiento  ? \Carbon\Carbon::parse($pasajero->fecha_nacimiento)->format('d/m/Y') : 'N/A' }}</td>
                                                    <td>{{ $pasajero->edad }}</td>
                                                    <td>
                                                        @if ($pasajero->reserva)
                                                                <a href="{{ route('admin.reservas.show', $pasajero->reserva_id) }}" 
                                                                class="btn-action-ver-reserva btn-ver-reserva"
                                                                    data-bs-toggle="tooltip" title="Ver Reserva">
                                                                    {{ $pasajero->reserva_id }}
                                                                </a>
                                                        
                                                        @else
                                                            <span class="badge bg-secondary">No asociada</span>
                                                        @endif

                                                    
                                                    </td>
                                                    <td>
                                                        <div class="d-flex gap-2">
                                                            <a href="{{ route('admin.pasajeros.show', $pasajero->id) }}" 
                                                            class="btn-action btn-view" 
                                                            data-bs-toggle="tooltip" title="Ver detalles">
                                                                <i class="fa fa-eye"></i>
                                                            </a>
                                                            <a href="{{ route('admin.pasajeros.edit', $pasajero->id) }}" 
                                                            class="btn-action btn-edit" 
                                                            data-bs-toggle="tooltip" title="Editar">
                                                                <i class="fa fa-edit"></i>
                                                            </a>
                                                            <form action="{{ route('admin.pasajeros.destroy', $pasajero->id) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button class="btn-action btn-delete" 
                                                                        onclick="return confirm('¿Estás seguro de eliminar este pasajero?')"
                                                                        data-bs-toggle="tooltip" title="Eliminar">
                                                                    <i class="fa fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="8" class="text-center">No hay pasajeros registrados.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                
                                <!-- Paginación -->
                                @if($pasajeros->hasPages())
                                <div class="card-footer">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="text-muted">
                                            Mostrando {{ $pasajeros->firstItem() }} - {{ $pasajeros->lastItem() }} de {{ $pasajeros->total() }} registros
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
