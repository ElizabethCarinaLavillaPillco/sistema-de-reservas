@extends('layouts.template')

@section('content')
<h1 class="mt-4">Reservas</h1>

<a href="{{ route('admin.reservas.create') }}" class="btn btn-primary mb-3">Nueva Reserva</a>

<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Titular</th>
            <th>Tipo</th>
            <th>Pasajeros</th>
            <th>Fechas</th>
            <th>Tours</th>
            <th>Total (S/)</th>
            <th>Adelanto (S/)</th>
            <th>Saldo (S/)</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($reservas as $reserva)
        <tr>
            <td>{{ $reserva->id }}</td>
            <td>
                {{ $reserva->titular->nombre ?? '-' }} {{ $reserva->titular->apellido ?? '' }}
            </td>
            <td>{{ $reserva->tipo_reserva }}</td>
            <td>{{ $reserva->cantidad_pasajeros }}</td>
            <td>
                <small>{{ $reserva->fecha_llegada }}<br>al<br>{{ $reserva->fecha_salida }}</small>
            </td>
            <td>
                {{ $reserva->cantidad_tours }}<br>
                <small>
                    @foreach($reserva->toursEscritos->take(2) as $tour)
                        • {{ $tour->nombre_tour }}<br>
                    @endforeach
                    @if($reserva->toursEscritos->count() > 2)
                        <em>+{{ $reserva->toursEscritos->count() - 2 }} más</em>
                    @endif
                </small>
            </td>
            <td>S/ {{ number_format($reserva->total, 2) }}</td>
            <td>S/ {{ number_format($reserva->adelanto, 2) }}</td>
            <td>S/ {{ number_format($reserva->saldo, 2) }}</td>
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
        @empty
        <tr>
            <td colspan="10" class="text-center">No hay reservas registradas xd.</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection
