@extends('layouts.template')

@section('content')
<h1 class="mt-4">Editar Reserva</h1>

<form action="{{ route('admin.reservas.update', $reserva->id) }}" method="POST">
    @csrf
    @method('PUT')

    <!-- TIPO DE RESERVA -->
    <div class="mb-3">
        <label for="tipo_reserva">Tipo de Reserva:</label>
        <select name="tipo_reserva" id="tipo_reserva" class="form-control" required>
            <option value="">-- Seleccionar tipo --</option>
            @foreach (["Directo", "Recomendacion", "Publicidad", "Agencia"] as $tipo)
                <option value="{{ $tipo }}" {{ $reserva->tipo_reserva === $tipo ? 'selected' : '' }}>{{ $tipo }}</option>
            @endforeach
        </select>
    </div>

    <!-- PROVEEDOR -->
    <div class="mb-3" id="proveedor_container" style="{{ $reserva->tipo_reserva === 'Agencia' ? '' : 'display:none' }}">
        <label for="proveedor_id">Proveedor:</label>
        <select name="proveedor_id" class="form-control">
            <option value="">-- Seleccionar proveedor --</option>
            @foreach ($proveedores as $proveedor)
                <option value="{{ $proveedor->id }}" {{ $reserva->proveedor_id == $proveedor->id ? 'selected' : '' }}>{{ $proveedor->nombre }}</option>
            @endforeach
        </select>
    </div>

    <!-- TITULAR -->
    <div class="mb-3">
        <label for="titular_id">Titular:</label>
        <select name="titular_id" id="titular_id" class="form-control" required>
            <option value="">-- Seleccionar titular (pasajero) --</option>
            @foreach ($pasajeros as $pasajero)
                <option value="{{ $pasajero->id }}" {{ $reserva->titular_id == $pasajero->id ? 'selected' : '' }}>
                    {{ $pasajero->nombre }} {{ $pasajero->apellido }} ({{ $pasajero->documento }})
                </option>
            @endforeach
        </select>
    </div>

    <!-- FECHAS Y DATOS NUMERICOS -->
    <div class="mb-3">
        <label for="fecha_llegada">Fecha de Llegada:</label>
        <input type="date" name="fecha_llegada" class="form-control" value="{{ $reserva->fecha_llegada }}" required>
    </div>
    <div class="mb-3">
        <label for="fecha_salida">Fecha de Salida:</label>
        <input type="date" name="fecha_salida" class="form-control" value="{{ $reserva->fecha_salida }}" required>
    </div>

    <div class="mb-3">
        <label for="cantidad_pasajeros">Cantidad de Pasajeros:</label>
        <input type="number" name="cantidad_pasajeros" class="form-control" value="{{ $reserva->cantidad_pasajeros }}" required>
    </div>

    <div class="mb-3">
        <label for="cantidad_tours">Cantidad de Tours:</label>
        <input type="number" name="cantidad_tours" class="form-control" value="{{ $reserva->cantidad_tours }}" required>
    </div>

    <div class="mb-3">
        <label for="total">Total (S/.):</label>
        <input type="number" step="0.01" name="total" class="form-control" value="{{ $reserva->total }}" required>
    </div>
    <div class="mb-3">
        <label for="adelanto">Adelanto (S/.):</label>
        <input type="number" step="0.01" name="adelanto" class="form-control" value="{{ $reserva->adelanto }}">
    </div>

    <button type="submit" class="btn btn-success">Actualizar Reserva</button>
    <a href="{{ route('admin.reservas.index') }}" class="btn btn-secondary">Cancelar</a>
</form>

<script>
    const tipoReservaSelect = document.getElementById('tipo_reserva');
    const proveedorContainer = document.getElementById('proveedor_container');

    tipoReservaSelect.addEventListener('change', function () {
        proveedorContainer.style.display = this.value === 'Agencia' ? 'block' : 'none';
    });
</script>
@endsection
