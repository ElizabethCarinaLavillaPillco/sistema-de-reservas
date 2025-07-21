@extends('layouts.template')

@section('content')
<h1 class="mt-4">Detalles de la Reserva {{ $reserva->id }}</h1>

<a href="{{ route('admin.reservas.index') }}" class="btn btn-secondary mb-3">Volver</a>

{{-- Información general de la reserva --}}
<div class="card mb-4">
    <div class="card-header">Información de la Reserva</div>
    <div class="card-body">
        <p><strong>Titular:</strong> {{ $reserva->titular->nombre }} {{ $reserva->titular->apellido }}</p>
        <p><strong>Cantidad de Pasajeros:</strong> {{ $reserva->cantidad_pasajeros }}</p>
        <p><strong>Fecha de Llegada:</strong> {{ $reserva->fecha_llegada }}</p>
        <p><strong>Fecha de Salida:</strong> {{ $reserva->fecha_salida }}</p>
        <p><strong>Cantidad de Tours:</strong> {{ $reserva->cantidad_tours }}</p>
        <p><strong>Total:</strong> S/ {{ $reserva->total }}</p>
        <p><strong>Adelanto:</strong> S/ {{ $reserva->adelanto }}</p>
        <p><strong>Saldo:</strong> S/ {{ $reserva->saldo }}</p>
    </div>
</div>

{{-- Lista de pasajeros --}}
<div class="card mb-4">
    <div class="card-header">Pasajeros</div>
    <div class="card-body">
        @if ($reserva->pasajeros->isEmpty())
            <p>No hay pasajeros registrados.</p>
        @else
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th>Documento</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>País Nacimiento</th>
                        <th>País Residencia</th>
                        <th>Ciudad</th>
                        <th>Fecha Nacimiento</th>
                        <th>Tarifa</th>
                        <th>Teléfono</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reserva->pasajeros as $pasajero)
                    <tr>
                        <td>{{ $pasajero->documento }}</td>
                        <td>{{ $pasajero->nombre }}</td>
                        <td>{{ $pasajero->apellido }}</td>
                        <td>{{ $pasajero->pais_nacimiento }}</td>
                        <td>{{ $pasajero->pais_residencia }}</td>
                        <td>{{ $pasajero->ciudad }}</td>
                        <td>{{ $pasajero->fecha_nacimiento }}</td>
                        <td>{{ $pasajero->tarifa }}</td>
                        <td>{{ $pasajero->telefono }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>

{{-- Tours --}}
<div class="card mb-4">
    <div class="card-header">Tours Contratados</div>
    <div class="card-body">
        @if ($reserva->tours->isEmpty())
            <p>No hay tours registrados para esta reserva.</p>
        @else
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tipo</th>
                        <th>Fecha</th>
                        <th>Descripción</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reserva->tours as $tour)
                    <tr>
                        <td>{{ $tour->id }}</td>
                        <td>{{ $tour->tipo }}</td>
                        <td>{{ $tour->fecha }}</td>
                        <td>{{ $tour->descripcion }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
@endsection
