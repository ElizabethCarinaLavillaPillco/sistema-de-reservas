@extends('layouts.template')

@section('content')
<h1 class="mt-4">Detalles de la Reserva {{ $reserva->id }}</h1>

<a href="{{ route('admin.reservas.index') }}" class="btn btn-secondary mb-3">← Volver a la lista</a>

{{-- Información general --}}
<div class="card mb-4">
    <div class="card-header">Información General</div>
    <div class="card-body">
        <p><strong>Titular:</strong> {{ $reserva->titular->nombre }} {{ $reserva->titular->apellido }}</p>
        <p><strong>Tipo de Reserva:</strong> {{ $reserva->tipo_reserva }}</p>
        <p><strong>Cantidad de Pasajeros:</strong> {{ $reserva->cantidad_pasajeros }}</p>
        <p><strong>Fechas:</strong> 
            {{ \Carbon\Carbon::parse($reserva->fecha_llegada)->format('d/m/Y') }} 
            – 
            {{ \Carbon\Carbon::parse($reserva->fecha_salida)->format('d/m/Y') }}
        </p>
        <p><strong>Cantidad de Tours:</strong> {{ $reserva->cantidad_tours }}</p>
        <p><strong>Total:</strong> S/ {{ number_format($reserva->total, 2) }}</p>
        <p><strong>Adelanto:</strong> S/ {{ number_format($reserva->adelanto, 2) }}</p>
        <p><strong>Saldo:</strong> S/ {{ number_format($reserva->total - $reserva->adelanto, 2) }}</p>
    </div>
</div>

{{-- Lista de pasajeros --}}
<div class="card mb-4">
    <div class="card-header">Pasajeros Asociados</div>
    <div class="card-body">
        @if ($reserva->pasajeros->isEmpty())
            <p class="text-muted">No hay pasajeros registrados en esta reserva.</p>
        @else
            <table class="table table-sm table-striped">
                <thead>
                    <tr>
                        <th>Documento</th>
                        <th>Nombre</th>
                        <th>País Nacimiento</th>
                        <th>País Residencia</th>
                        <th>Ciudad</th>
                        <th>Fecha Nacimiento</th>
                        <th>Tarifa</th>
                        <th>Teléfono</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reserva->pasajeros as $p)
                    <tr>
                        <td>{{ $p->documento }}</td>
                        <td>{{ $p->nombre }} {{ $p->apellido }}</td>
                        <td>{{ $p->pais_nacimiento }}</td>
                        <td>{{ $p->pais_residencia }}</td>
                        <td>{{ $p->ciudad }}</td>
                        <td>{{ $p->fecha_nacimiento }}</td>
                        <td>{{ $p->tarifa }}</td>
                        <td>{{ $p->telefono ?? 'No registrado' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>

{{-- Lista de tours --}}
<div class="card mb-4">
    <div class="card-header">Tours Asociados</div>
    <div class="card-body">
        @if ($reserva->tours->isEmpty())
            <p class="text-muted">No hay tours registrados para esta reserva.</p>
        @else
            <table class="table table-sm table-striped">
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
