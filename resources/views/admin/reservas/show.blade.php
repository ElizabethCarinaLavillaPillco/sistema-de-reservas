@extends('layouts.template')

@section('content')
<div class="container">
    <h1 class="mt-4">Detalle de Reserva</h1>

    {{-- Información General --}}
    <div class="card mb-4">
        <div class="card-header">
            <strong>Información General</strong>
        </div>
        <div class="card-body">
            <p><strong>ID:</strong> {{ $reserva->id }}</p>
            <p><strong>Tipo de Reserva:</strong> {{ $reserva->tipo_reserva }}</p>
            <p><strong>Proveedor:</strong> {{ $reserva->proveedor->nombre ?? '-' }}</p>
            <p><strong>Titular:</strong> {{ $reserva->titular->nombre }} {{ $reserva->titular->apellido }}</p>
            <p><strong>Fecha Llegada:</strong> {{ $reserva->fecha_llegada ?? '-' }} {{ $reserva->hora_llegada ? ' - '.$reserva->hora_llegada : '' }}</p>
            <p><strong>Nro Vuelo Llegada:</strong> {{ $reserva->nro_vuelo_llegada ?? '-' }}</p>
            <p><strong>Fecha Salida:</strong> {{ $reserva->fecha_salida ?? '-' }} {{ $reserva->hora_salida ? ' - '.$reserva->hora_salida : '' }}</p>
            <p><strong>Nro Vuelo Retorno:</strong> {{ $reserva->nro_vuelo_retorno ?? '-' }}</p>
            <p><strong>Total:</strong> S/. {{ number_format($reserva->total, 2) }}</p>
            <p><strong>Adelanto:</strong> S/. {{ number_format($reserva->adelanto, 2) }}</p>
        </div>
    </div>

    {{-- Pasajeros --}}
    <div class="card mb-4">
        <div class="card-header">
            <strong>Pasajeros</strong>
        </div>
        <div class="card-body">
            @if($reserva->pasajeros->count())
                <ul>
                    @foreach($reserva->pasajeros as $pasajero)
                        <li>{{ $pasajero->nombre }} {{ $pasajero->apellido }} - {{ $pasajero->documento }}</li>
                    @endforeach
                </ul>
            @else
                <p>No hay pasajeros registrados.</p>
            @endif
        </div>
    </div>

    {{-- Tours --}}
    <div class="card mb-4">
        <div class="card-header">
            <strong>Tours</strong>
        </div>
        <div class="card-body">
            @if($reserva->tourReserva->count())
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Tour</th>
                            <th>Fecha</th>
                            <th>Empresa</th>
                            <th>Precio Unit.</th>
                            <th>Cantidad</th>
                            <th>Observaciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reserva->tourReserva as $tour)
                            <tr>
                                <td>{{ $tour->tour->nombreTour }}</td>
                                <td>{{ $tour->fecha ?? '-' }}</td>
                                <td>{{ $tour->empresa ?? '-' }}</td>
                                <td>S/. {{ number_format($tour->precio_unitario ?? 0, 2) }}</td>
                                <td>{{ $tour->cantidad ?? 1 }}</td>
                                <td>{{ $tour->observaciones ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>No hay tours asociados.</p>
            @endif
        </div>
    </div>

    {{-- Estadías --}}
    <div class="card mb-4">
        <div class="card-header">
            <strong>Estadías</strong>
        </div>
        <div class="card-body">
            @if($reserva->estadias->count())
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Tipo</th>
                            <th>Nombre</th>
                            <th>Ubicación</th>
                            <th>Fecha</th>
                            <th>Habitación</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reserva->estadias as $estadia)
                            <tr>
                                <td>{{ $estadia->tipo_estadia }}</td>
                                <td>{{ $estadia->nombre_estadia }}</td>
                                <td>{{ $estadia->ubicacion ?? '-' }}</td>
                                <td>{{ $estadia->fecha ?? '-' }}</td>
                                <td>{{ $estadia->habitacion ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>No hay estadías registradas.</p>
            @endif
        </div>
    </div>

    

    <div class="mt-4">
        <a href="{{ route('admin.depositos.index', $reserva->id) }}" class="btn btn-primary">Ver Depósitos</a>
        <a href="{{ route('admin.facturacion.index', $reserva->id) }}" class="btn btn-secondary">Ver Facturación</a>
    </div>

    <a href="{{ route('admin.reservas.index') }}" class="btn btn-secondary">Volver</a>
    <a href="{{ route('admin.reservas.edit', $reserva->id) }}" class="btn btn-primary">Editar</a>
</div>
@endsection
