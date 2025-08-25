@extends('layouts.template')

@section('content')
<h1 class="mt-4">Lista de reservas</h1>

<a href="{{ route('admin.reservas.create') }}" class="btn btn-primary mb-3">
    <i class="fa fa-plus"></i> Nueva Reserva
</a>

<table class="table table-hover table-bordered">
    <thead class="table-info">
        <tr>
            <th>ID</th>
            <th>Titular</th>
            <th>Pasajeros</th>
            <th>Fecha llegada</th>
            <th>N° Vuelo</th>
            <th>Tours</th>
            <th>Estadía</th>
            <th>Total</th>
            <th>Adelanto</th>
            <th>Saldo</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @forelse($reservas as $reserva)
            <tr>
                <td>{{ $reserva->id }}</td>
                <td>{{ $reserva->titular->nombre ?? '-' }} {{ $reserva->titular->apellido ?? '' }}</td>
                <td>{{ $reserva->cantidad_pasajeros }}</td>
                <td>{{ $reserva->fecha_llegada}}</td>
                <td>{{ $reserva->nro_vuelo_llegada ?? '-' }}</td>
                <td>
                    {{ $reserva->cantidad_tours }}<br>
                    @if($reserva->tourReserva->count() > 0)
                        <small>
                            @foreach($reserva->tourReserva->take(2) as $t)
                                • {{ $t->tour->nombreTour }} <br>
                            @endforeach
                            @if($reserva->tourReserva->count() > 2)
                                <em>+{{ $reserva->tourReserva->count() - 2 }} más</em>
                            @endif
                        </small>
                    @endif
                </td>
                <td>
                    {{ $reserva->cantidad_estadias }}<br>
                    {{ $reserva->estadias->first()->nombre_estadia ?? '-' }}
                </td>
                <td>S/ {{ number_format($reserva->total,2) }}</td>
                <td>S/ {{ number_format($reserva->adelanto,2) }}</td>
                <td>
                    @php $saldo = $reserva->total - $reserva->adelanto; @endphp
                    <strong class="{{ $saldo <= 0 ? 'text-success' : 'text-danger' }}">
                        S/ {{ number_format($saldo,2) }}
                    </strong>
                </td>
                <td class="text-end">
                    <a href="{{ route('admin.reservas.show', $reserva->id) }}" class="btn btn-sm btn-outline-primary">
                        <i class="fa fa-eye"></i>
                    </a>
                    <a href="{{ route('admin.reservas.edit', $reserva->id) }}" class="btn btn-sm btn-outline-warning">
                        <i class="fa fa-edit"></i>
                    </a>
                    <form action="{{ route('admin.reservas.destroy', $reserva->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Eliminar esta reserva?')">
                            <i class="fa fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="11" class="text-center">No hay reservas registradas.</td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection
