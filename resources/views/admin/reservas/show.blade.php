@extends('layouts.template')

@section('content')
<div class="container">
    <h1 class="mt-4">Detalle de Reserva</h1>

    {{-- Información General --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-primary text-white">
            <strong>Información General</strong>
        </div>
        <div class="card-body">
            <p><strong>ID:</strong> {{ $reserva->id }}</p>
            <p><strong>Tipo de Reserva:</strong> {{ $reserva->tipo_reserva }}</p>
            <p><strong>Proveedor:</strong> {{ $reserva->proveedor->nombreAgencia ?? '-' }}</p>
            <p><strong>Titular:</strong> {{ $reserva->titular->nombre }} {{ $reserva->titular->apellido }}</p>
            <p><strong>Fecha Llegada:</strong> {{ $reserva->fecha_llegada ?? '-' }} {{ $reserva->hora_llegada ? ' - '.$reserva->hora_llegada : '' }}</p>
            <p><strong>Nro Vuelo Llegada:</strong> {{ $reserva->nro_vuelo_llegada ?? '-' }}</p>
            <p><strong>Fecha Salida:</strong> {{ $reserva->fecha_salida ?? '-' }} {{ $reserva->hora_salida ? ' - '.$reserva->hora_salida : '' }}</p>
            <p><strong>Nro Vuelo Retorno:</strong> {{ $reserva->nro_vuelo_retorno ?? '-' }}</p>
            <p><strong>Total:</strong> <span class="badge bg-success">S/. {{ number_format($reserva->total, 2) }}</span></p>
            <p><strong>Adelanto:</strong> <span class="badge bg-warning">S/. {{ number_format($reserva->adelanto, 2) }}</span></p>
        </div>
    </div>

    {{-- Pasajeros --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-info text-white">
            <strong>Pasajeros</strong>
        </div>
        <div class="card-body">
            @if($reserva->pasajeros->count())
                <ul class="list-group">
                    @foreach($reserva->pasajeros as $pasajero)
                        <li class="list-group-item">
                            {{ $pasajero->nombre }} {{ $pasajero->apellido }}
                            <span class="text-muted">({{ $pasajero->documento }})</span>
                        </li>
                    @endforeach
                </ul>
            @else
                <p>No hay pasajeros registrados.</p>
            @endif
        </div>
    </div>

    {{-- Tours --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-secondary text-white">
            <strong>Tours</strong>
        </div>
        <div class="card-body">
            @if($reserva->tourReserva->count())
                <div class="accordion" id="accordionTours">
                    @foreach($reserva->tourReserva as $index => $tour)
                        <div class="accordion-item mb-2">
                            <h2 class="accordion-header" id="heading{{ $index }}">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $index }}">
                                    {{ $tour->tour->nombreTour }}
                                    @if($tour->detallesBoletoTuristico)
                                        <span class="badge bg-primary ms-2">Boleto Turístico</span>
                                    @endif
                                    @if($tour->detallesTourMachupicchu)
                                        <span class="badge bg-danger ms-2">Machu Picchu</span>
                                    @endif
                                </button>
                            </h2>
                            <div id="collapse{{ $index }}" class="accordion-collapse collapse" data-bs-parent="#accordionTours">
                                <div class="accordion-body">
                                    <p><strong>Fecha:</strong> {{ $tour->fecha ?? '-' }}</p>
                                    <p><strong>Empresa:</strong> {{ $tour->empresa ?? '-' }}</p>
                                    <p><strong>Precio Unitario:</strong> S/. {{ number_format($tour->precio_unitario ?? 0, 2) }}</p>
                                    <p><strong>Cantidad:</strong> {{ $tour->cantidad ?? 1 }}</p>
                                    <p><strong>Observaciones:</strong> {{ $tour->observaciones ?? '-' }}</p>

                                    {{-- Detalles Boleto Turístico --}}
                                    @if($tour->detalleBoletoTuristico)
                                        <hr>
                                        <h6>Boleto Turístico</h6>
                                        <p><strong>Tipo Boleto:</strong> {{ $tour->detalleBoletoTuristico->tipo_boleto }}</p>
                                        <p><strong>Requiere Compra:</strong> {{ $tour->detalleBoletoTuristico->requiere_compra ? 'Sí' : 'No' }}</p>
                                        <p><strong>Tipo Compra:</strong> {{ $tour->detalleBoletoTuristico->tipo_compra ?? '-' }}</p>
                                        <p><strong>Incluye Propiedad Privada:</strong> {{ $tour->detalleBoletoTuristico->incluye_entrada_propiedad_priv ? 'Sí' : 'No' }}</p>
                                        <p><strong>Quién Compra:</strong> {{ $tour->detalleBoletoTuristico->quien_compra_propiedad_priv ?? '-' }}</p>
                                        <p><strong>Comentario:</strong> {{ $tour->detalleBoletoTuristico->comentario_entrada_propiedad_priv ?? '-' }}</p>
                                    @endif

                                    {{-- Detalles Machu Picchu --}}
                                    @if($tour->detalleMachupicchu)
                                        <hr>
                                        <h6>Machu Picchu</h6>
                                        <p><strong>Tipo Entrada:</strong> {{ $tour->detalleMachupicchu->tipo_entrada ?? '-' }}</p>
                                        <p><strong>Ruta 1:</strong> {{ $tour->detalleMachupicchu->ruta1 ?? '-' }}</p>
                                        <p><strong>Ruta 2:</strong> {{ $tour->detalleMachupicchu->ruta2 ?? '-' }}</p>
                                        <p><strong>Ruta 3:</strong> {{ $tour->detalleMachupicchu->ruta3 ?? '-' }}</p>
                                        <p><strong>Horario Entrada:</strong> {{ $tour->detalleMachupicchu->horario_entrada ?? '-' }}</p>
                                        <p><strong>Comentario:</strong> {{ $tour->detalleMachupicchu->comentario_entrada ?? '-' }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p>No hay tours asociados.</p>
            @endif
        </div>
    </div>

    {{-- Estadías --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-dark text-white">
            <strong>Estadías</strong>
        </div>
        <div class="card-body">
            @if($reserva->estadias->count())
                <table class="table table-striped">
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

    {{-- Acciones --}}
    <div class="mt-4 d-flex justify-content-between">
        <div>
            <a href="{{ route('admin.depositos.index', $reserva->id) }}" class="btn btn-outline-primary">Ver Depósitos</a>
            <a href="{{ route('admin.facturacion.index', $reserva->id) }}" class="btn btn-outline-secondary">Ver Facturación</a>
        </div>
        <div>
            <a href="{{ route('admin.reservas.index') }}" class="btn btn-secondary">Volver</a>
            <a href="{{ route('admin.reservas.edit', $reserva->id) }}" class="btn btn-primary">Editar</a>
        </div>
    </div>
</div>
@endsection
