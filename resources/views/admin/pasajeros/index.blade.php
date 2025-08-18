@extends('layouts.template')

@section('content')
<h1 class="mt-4">Lista de Pasajeros</h1>

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<a href="{{ route('admin.pasajeros.create') }}" class="btn btn-primary mb-3">
    <i class="fa fa-plus"></i> Nuevo Pasajero
        
    </a>

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


<table class="table table-bordered table-striped">
    <thead class="table-info">
        <tr>
            <th>ID</th>
            <th>Nombre Completo</th>
            <th>Documento</th>
            <th>País Nacimiento</th>
            <th>País Residencia</th>
            <th>Tarifa</th>
            <th>Reserva</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @forelse($pasajeros as $pasajero)
            <tr>
                <td>{{ $pasajero->id }}</td>
                <td>{{ $pasajero->nombre }} {{ $pasajero->apellido }}</td>
                <td>{{ $pasajero->documento }}</td>
                <td>{{ $pasajero->pais_nacimiento }}</td>
                <td>{{ $pasajero->pais_residencia }}</td>
                <td>{{ $pasajero->tarifa }}</td>
                <td>
                    @if ($pasajero->reserva)
                        <a href="{{ route('admin.reservas.show', $pasajero->reserva_id) }}">
                            {{ $pasajero->reserva_id }}</a>
                    @else
                        <span class="text-muted">No asociada</span>
                    @endif
                </td>
                <td class="text-nowrap">
                    <a href="{{ route('admin.pasajeros.show', $pasajero->id) }}" class="btn btn-sm btn-info">Ver</a>
                    <a href="{{ route('admin.pasajeros.edit', $pasajero->id) }}" class="btn btn-sm btn-warning">Editar</a>
                    <form action="{{ route('admin.pasajeros.destroy', $pasajero->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar pasajero?')">Eliminar</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8" class="text-center">No hay pasajeros registrados.</td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection
