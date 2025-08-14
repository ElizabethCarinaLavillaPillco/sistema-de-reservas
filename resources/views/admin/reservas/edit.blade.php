@extends('layouts.template')

@section('content')
<div class="container">
    <h1 class="mt-4">Editar Reserva</h1>

    <form action="{{ route('admin.reservas.update', $reserva->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Tipo de Reserva --}}
        <div class="mb-3">
            <label for="tipo_reserva" class="form-label">Tipo de Reserva</label>
            <select name="tipo_reserva" id="tipo_reserva" class="form-control" required>
                <option value="">Seleccione</option>
                @foreach(['Directo', 'Recomendacion', 'Publicidad', 'Agencia'] as $tipo)
                    <option value="{{ $tipo }}" {{ old('tipo_reserva', $reserva->tipo_reserva) == $tipo ? 'selected' : '' }}>
                        {{ $tipo }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Proveedor --}}
        <div class="mb-3">
            <label for="proveedor_id" class="form-label">Proveedor</label>
            <select name="proveedor_id" id="proveedor_id" class="form-control">
                <option value="">Seleccione</option>
                @foreach($proveedores as $proveedor)
                    <option value="{{ $proveedor->id }}" {{ old('proveedor_id', $reserva->proveedor_id) == $proveedor->id ? 'selected' : '' }}>
                        {{ $proveedor->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Titular --}}
        <div class="mb-3">
            <label for="titular_id" class="form-label">Titular</label>
            <select name="titular_id" id="titular_id" class="form-control" required>
                <option value="">Seleccione</option>
                @foreach($pasajeros as $pasajero)
                    <option value="{{ $pasajero->id }}" {{ old('titular_id', $reserva->titular_id) == $pasajero->id ? 'selected' : '' }}>
                        {{ $pasajero->nombre }} {{ $pasajero->apellido }} ({{ $pasajero->documento }})
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Fechas y vuelos --}}
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="fecha_llegada" class="form-label">Fecha Llegada</label>
                <input type="date" name="fecha_llegada" class="form-control" value="{{ old('fecha_llegada', $reserva->fecha_llegada) }}">
            </div>
            <div class="col-md-6 mb-3">
                <label for="hora_llegada" class="form-label">Hora Llegada</label>
                <input type="time" name="hora_llegada" class="form-control" value="{{ old('hora_llegada', $reserva->hora_llegada) }}">
            </div>
            <div class="col-md-6 mb-3">
                <label for="nro_vuelo_llegada" class="form-label">Nro Vuelo Llegada</label>
                <input type="text" name="nro_vuelo_llegada" class="form-control" value="{{ old('nro_vuelo_llegada', $reserva->nro_vuelo_llegada) }}">
            </div>

            <div class="col-md-6 mb-3">
                <label for="fecha_salida" class="form-label">Fecha Salida</label>
                <input type="date" name="fecha_salida" class="form-control" value="{{ old('fecha_salida', $reserva->fecha_salida) }}">
            </div>
            <div class="col-md-6 mb-3">
                <label for="hora_salida" class="form-label">Hora Salida</label>
                <input type="time" name="hora_salida" class="form-control" value="{{ old('hora_salida', $reserva->hora_salida) }}">
            </div>
            <div class="col-md-6 mb-3">
                <label for="nro_vuelo_retorno" class="form-label">Nro Vuelo Retorno</label>
                <input type="text" name="nro_vuelo_retorno" class="form-control" value="{{ old('nro_vuelo_retorno', $reserva->nro_vuelo_retorno) }}">
            </div>
        </div>

        {{-- Pasajeros --}}
        <div class="mb-3">
            <label class="form-label">Pasajeros</label>
            <div class="input-group mb-2">
                <select id="select-pasajero" class="form-control">
                    <option value="">Seleccione pasajero</option>
                    @foreach($pasajeros as $pasajero)
                        <option value="{{ $pasajero->id }}" data-nombre="{{ $pasajero->nombre }} {{ $pasajero->apellido }}">
                            {{ $pasajero->nombre }} {{ $pasajero->apellido }} ({{ $pasajero->documento }})
                        </option>
                    @endforeach
                </select>
                <button type="button" class="btn btn-success" onclick="agregarPasajero()">Agregar</button>
            </div>
            <ul id="lista-pasajeros" class="list-group">
                @foreach($reserva->pasajeros as $p)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        {{ $p->nombre }} {{ $p->apellido }}
                        <input type="hidden" name="pasajeros[]" value="{{ $p->id }}">
                        <button type="button" class="btn btn-sm btn-danger" onclick="eliminarPasajero(this)">Eliminar</button>
                    </li>
                @endforeach
            </ul>
        </div>

        {{-- Tours --}}
        <div class="mb-3">
            <label class="form-label">Tours</label>
            <div class="input-group mb-2">
                <select id="select-tour" class="form-control">
                    <option value="">Seleccione tour</option>
                    @foreach($tours as $tour)
                        <option value="{{ $tour->id }}" data-nombre="{{ $tour->nombreTour }}">
                            {{ $tour->nombreTour }}
                        </option>
                    @endforeach
                </select>
                <button type="button" class="btn btn-success" onclick="agregarTour()">Agregar</button>
            </div>
            <ul id="lista-tours" class="list-group">
                @foreach($reserva->tourReserva as $i => $tour)
                    <li class="list-group-item">
                        <div><strong>Tour:</strong> {{ $tour->tour->nombreTour }}</div>
                        <div><strong>Fecha:</strong> {{ $tour->fecha ?? '-' }}</div>
                        <div><strong>Empresa:</strong> {{ $tour->empresa ?? '-' }}</div>
                        <div><strong>Precio Unitario:</strong> S/. {{ $tour->precio_unitario ?? '0.00' }}</div>
                        <div><strong>Cantidad:</strong> {{ $tour->cantidad ?? 1 }}</div>
                        <div><strong>Observaciones:</strong> {{ $tour->observaciones ?? '-' }}</div>
                        <input type="hidden" name="tours[{{ $i }}][tour_id]" value="{{ $tour->tour_id }}">
                        <input type="hidden" name="tours[{{ $i }}][nombre_tour]" value="{{ $tour->tour->nombreTour }}">
                        <input type="hidden" name="tours[{{ $i }}][fecha]" value="{{ $tour->fecha }}">
                        <input type="hidden" name="tours[{{ $i }}][empresa]" value="{{ $tour->empresa }}">
                        <input type="hidden" name="tours[{{ $i }}][precio_unitario]" value="{{ $tour->precio_unitario }}">
                        <input type="hidden" name="tours[{{ $i }}][cantidad]" value="{{ $tour->cantidad }}">
                        <input type="hidden" name="tours[{{ $i }}][observaciones]" value="{{ $tour->observaciones }}">
                        <button type="button" class="btn btn-sm btn-danger mt-2" onclick="eliminarTour(this)">Eliminar</button>
                    </li>
                @endforeach
            </ul>
        </div>

        {{-- Totales --}}
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="total" class="form-label">Total</label>
                <input type="number" step="0.01" name="total" class="form-control" value="{{ old('total', $reserva->total) }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="adelanto" class="form-label">Adelanto</label>
                <input type="number" step="0.01" name="adelanto" class="form-control" value="{{ old('adelanto', $reserva->adelanto) }}">
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Actualizar Reserva</button>
        <a href="{{ route('admin.reservas.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<script>
    function agregarPasajero() {
        const select = document.getElementById('select-pasajero');
        const id = select.value;
        const nombre = select.options[select.selectedIndex].dataset.nombre;

        if (!id) return;

        const li = document.createElement('li');
        li.className = 'list-group-item d-flex justify-content-between align-items-center';
        li.innerHTML = `${nombre}<input type="hidden" name="pasajeros[]" value="${id}"><button type="button" class="btn btn-sm btn-danger" onclick="eliminarPasajero(this)">Eliminar</button>`;
        document.getElementById('lista-pasajeros').appendChild(li);

        select.value = '';
    }

    function eliminarPasajero(btn) {
        btn.parentElement.remove();
    }

    function agregarTour() {
        const select = document.getElementById('select-tour');
        const id = select.value;
        const nombre = select.options[select.selectedIndex].dataset.nombre;

        if (!id) return;

        const li = document.createElement('li');
        li.className = 'list-group-item';
        li.innerHTML = `<div><strong>Tour:</strong> ${nombre}</div>
            <input type="hidden" name="tours[][tour_id]" value="${id}">
            <input type="hidden" name="tours[][nombre_tour]" value="${nombre}">
            <button type="button" class="btn btn-sm btn-danger mt-2" onclick="eliminarTour(this)">Eliminar</button>`;
        document.getElementById('lista-tours').appendChild(li);

        select.value = '';
    }

    function eliminarTour(btn) {
        btn.parentElement.remove();
    }
</script>
@endsection
