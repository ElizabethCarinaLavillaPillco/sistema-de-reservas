@extends('layouts.template')

@section('content')
<div class="container">
    <h1 class="mb-4">Lista de Depósitos</h1>

    <!-- Botón Crear Nuevo -->
    <a href="{{ route('admin.depositos.create') }}" class="btn btn-primary mb-3">Nuevo Depósito</a>

    <!-- Formulario de búsqueda -->
    <form method="GET" action="{{ route('admin.depositos.index') }}" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Buscar por ID de reserva (Ej: R001)" value="{{ request('search') }}">
            <button class="btn btn-outline-secondary" type="submit">Buscar</button>
        </div>
    </form>

    <!-- Tabla de depósitos -->
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre del Depositante</th>
                    <th>ID Reserva</th>
                    <th>Monto</th>
                    <th>Fecha</th>
                    <th>Tipo de Depósito</th>
                    <th>Observaciones</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($depositos as $deposito)
                    <tr>
                        <td>{{ $deposito->id }}</td>
                        <td>{{ $deposito->nombre_depositante }}</td>
                        <td>{{ $deposito->reserva_id }}</td>
                        <td>S/. {{ number_format($deposito->monto, 2) }}</td>
                        <td>{{ $deposito->fecha }}</td>
                        <td>{{ $deposito->tipo_deposito }}</td>
                        <td>{{ $deposito->observaciones }}</td>
                        <td>
                            <a href="{{ route('admin.depositos.edit', $depositos->id) }}" class="btn btn-warning btn-sm">Editar</a>
                            <form action="{{ route('admin.depositos.destroy', $depositos->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que deseas eliminar este depósito?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">No hay depósitos registrados</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    
</div>
@endsection
