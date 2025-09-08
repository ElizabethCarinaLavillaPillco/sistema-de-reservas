@extends('layouts.template')

@section('content')
<h1 class="mt-4">Detalles del Pasajero</h1>

<div class="card">
    <div class="card-body">
        <h5 class="card-title">{{ $pasajero->nombre }} {{ $pasajero->apellido }}</h5>

        <p><strong>Documento:</strong> {{ $pasajero->documento }}</p>
        <p><strong>Fecha de nacimiento:</strong> {{ $pasajero->fecha_nacimiento }}</p>
        <p><strong>País de nacimiento:</strong> {{ $pasajero->pais_nacimiento }}</p>
        <p><strong>País de residencia:</strong> {{ $pasajero->pais_residencia }}</p>
        <p><strong>Ciudad:</strong> {{ $pasajero->ciudad ?? 'No especificado' }}</p>
        <p><strong>Teléfono:</strong> {{ $pasajero->telefono ?? 'No registrado' }}</p>
        <p><strong>Edad:</strong> {{ $pasajero->edad }} años</p>
        <p><strong>Reserva Asociada:</strong>
            @if ($pasajero->reserva)
                <a href="{{ route('admin.reservas.show', $pasajero->reserva->id) }}">
                    {{ $pasajero->reserva->id }}
                    - {{ $pasajero->reserva->titular->nombre ?? '' }} {{ $pasajero->reserva->titular->apellido ?? '' }}
                </a>
            @else
                <span class="text-muted">No asociada</span>
            @endif
        </p>
        <h4>Tarifas diferenciadas:</h4>
        <ul>
            @foreach($pasajero->tarifas_detalle as $servicio => $tarifa)
                <li>Tarifa para {{ $servicio }}: {{ $tarifa }}</li>
            @endforeach
        </ul>




    </div>
</div>

<a href="{{ route('admin.pasajeros.index') }}" class="btn btn-secondary mt-3">Volver a la lista</a>
@endsection
