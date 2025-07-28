@extends('layouts.template')

@section('content')
<h1 class="mt-4">Detalle de la Reserva</h1>

<div class="card">
    <div class="card-body">
        <h5 class="card-title">Reserva #{{ $reserva->id }}</h5>

        <p><strong>Titular:</strong> {{ $reserva->titular->nombre }} {{ $reserva->titular->apellido }}</p>
        <p><strong>Tipo:</strong> {{ $reserva->tipo_reserva }}</p>

        @if($reserva->proveedor)
            <p><strong>Proveedor:</strong> {{ $reserva->proveedor->nombre }}</p>
        @endif

        <p><strong>Cantidad de Pasajeros:</strong> {{ $reserva->cantidad_pasajeros }}</p>
        <p><strong>Fechas:</strong> {{ $reserva->fecha_llegada }} al {{ $reserva->fecha_salida }}</p>
        <p><strong>Cantidad de Tours:</strong> {{ $reserva->cantidad_tours }}</p>
        <p><strong>Total:</strong> S/ {{ number_format($reserva->total, 2) }}</p>
        <p><strong>Adelanto:</strong> S/ {{ number_format($reserva->adelanto, 2) }}</p>
        <p><strong>Saldo:</strong> S/ {{ number_format($reserva->saldo, 2) }}</p>

        <hr>
        <h5>Pasajeros:</h5>
        <ul>
            @foreach($reserva->pasajeros as $pasajero)
                <li>{{ $pasajero->nombre }} {{ $pasajero->apellido }} ({{ $pasajero->documento }})</li>
            @endforeach
        </ul>

        <hr>
        <h5>Tours:</h5>
        @forelse ($reserva->toursEscritos as $tour)
            <div class="mb-3">
                <p><strong>Nombre:</strong> {{ $tour->nombre_tour }}</p>
                <p><strong>Fecha:</strong> {{ $tour->fecha }}</p>
                <p><strong>Empresa:</strong> {{ $tour->empresa }}</p>
                <p><strong>Precio Unitario:</strong> S/ {{ number_format($tour->precio_unitario, 2) }}</p>
                <p><strong>Cantidad:</strong> {{ $tour->cantidad }}</p>
                <p><strong>Observaciones:</strong> {{ $tour->observaciones }}</p>
                <hr>
            </div>
        @empty
            <p>No hay tours registrados.</p>
        @endforelse
    </div>
</div>

<a href="{{ route('admin.reservas.index') }}" class="btn btn-secondary mt-3">Volver</a>
@endsection
