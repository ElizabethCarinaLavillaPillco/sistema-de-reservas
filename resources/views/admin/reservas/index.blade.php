@extends('layouts.template')

@section('content')
<h1 class="mt-4">Reservas</h1>

<a href="{{ route('admin.reservas.create') }}" class="btn btn-primary mb-3">Nueva Reserva</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Titular</th>
            <th>Pasajeros</th>
            <th>Llegada</th>
            <th>Salida</th>
            <th>Tours</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($reservas as $reserva)
        <tr>
            <td>{{ $reserva->id }}</td>
            <td>{{ $reserva->titular->nombre }} {{ $reserva->titular->apellido }}</td>
            <td>{{ $reserva->cantidad_pasajeros }}</td>
            <td>{{ $reserva->fecha_llegada }}</td>
            <td>{{ $reserva->fecha_salida }}</td>
            <td>{{ $reserva->cantidad_tours }}</td>
            <td>
                <a href="{{ route('admin.reservas.show', $reserva->id) }}" class="btn btn-sm btn-info">Ver</a>
                <a href="{{ route('admin.reservas.edit', $reserva->id) }}" class="btn btn-sm btn-warning">Editar</a>

                <form action="{{ route('admin.reservas.destroy', $reserva->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar esta reserva?')">Eliminar</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
