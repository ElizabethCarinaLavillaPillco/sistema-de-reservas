@extends('layouts.template')

@section('content')
<h1 class="mt-4">Lista de Pasajeros</h1>

<a href="{{ route('admin.pasajeros.create') }}" class="btn btn-primary mb-3">Nuevo Pasajero</a>

<table class="table table-bordered table-striped">
    <thead>
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
                    <a href="{{ route('admin.reservas.show', $pasajero->reserva_id) }}">
                        {{ $pasajero->reserva_id }}
                    </a>
                </td>
                <td>
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
                <td colspan="8">No hay pasajeros registrados.</td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection
