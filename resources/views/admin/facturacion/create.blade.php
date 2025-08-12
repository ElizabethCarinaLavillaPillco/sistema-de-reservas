@extends('layouts.template')

@section('content')
<h1 class="mt-4">Crear Comprobante (Facturación)</h1>

<form action="{{ route('admin.facturacion.store') }}" method="POST">
    @csrf

    {{-- Documento (datalist) --}}
    <div class="mb-3">
        <label for="documento">Documento (DNI / Pasaporte):</label>
        <input list="listaDocumentos" id="documento" name="documento" class="form-control" value="{{ old('documento') }}" required>
        <datalist id="listaDocumentos">
            @foreach($pasajeros as $p)
                <option value="{{ $p->documento }}" data-nombre="{{ $p->nombre }} {{ $p->apellido }}"></option>
            @endforeach
        </datalist>
        @error('documento') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    {{-- Titular (se autocompleta desde el documento, editable) --}}
    <div class="mb-3">
        <label for="titular">Titular (nombre):</label>
        <input type="text" name="titular" id="titular" class="form-control" value="{{ old('titular') }}" required>
        @error('titular') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    {{-- Reserva (buscar por id) --}}
    <div class="mb-3">
        <label for="reserva_id">Reserva (ID):</label>
        <input list="listaReservas" id="reserva_id" name="reserva_id" class="form-control" value="{{ old('reserva_id') }}" required>
        <datalist id="listaReservas">
            @foreach($reservas as $r)
                <option value="{{ $r->id }}"></option>
            @endforeach
        </datalist>
        @error('reserva_id') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    <div class="row">
        <div class="col-md-4 mb-3">
            <label for="pais">País:</label>
            <input type="text" name="pais" id="pais" class="form-control" value="{{ old('pais') }}" required>
            @error('pais') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-4 mb-3">
            <label for="servicio">Servicio:</label>
            <select name="servicio" id="servicio" class="form-control" required>
                <option value="">-- Seleccionar --</option>
                <option value="Machupicchu" {{ old('servicio')=='Machupicchu' ? 'selected':'' }}>Machupicchu</option>
                <option value="Comision" {{ old('servicio')=='Comision' ? 'selected':'' }}>Comisión</option>
            </select>
            @error('servicio') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-4 mb-3">
            <label for="fecha_giro">Fecha de giro:</label>
            <input type="date" name="fecha_giro" id="fecha_giro" class="form-control" value="{{ old('fecha_giro') }}" required>
            @error('fecha_giro') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 mb-3">
            <label for="tipo">Tipo:</label>
            <select name="tipo" id="tipo" class="form-control" required>
                <option value="">-- Seleccionar --</option>
                <option value="Boleta" {{ old('tipo')=='Boleta' ? 'selected':'' }}>Boleta</option>
                <option value="Factura" {{ old('tipo')=='Factura' ? 'selected':'' }}>Factura</option>
            </select>
            @error('tipo') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-4 mb-3">
            <label for="total_facturado">Total facturado:</label>
            <input type="number" step="0.01" name="total_facturado" id="total_facturado" class="form-control" value="{{ old('total_facturado') }}" required>
            @error('total_facturado') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-4 mb-3">
            <label for="estado">Estado:</label>
            <select name="estado" id="estado" class="form-control" required>
                <option value="Sin realizar" {{ old('estado')=='Sin realizar' ? 'selected':'' }}>Sin realizar</option>
                <option value="Realizado" {{ old('estado')=='Realizado' ? 'selected':'' }}>Realizado</option>
            </select>
            @error('estado') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>
    </div>

    <div class="mb-3">
        <label for="descripcion">Descripción / Observaciones:</label>
        <textarea name="descripcion" id="descripcion" class="form-control" rows="3">{{ old('descripcion') }}</textarea>
        @error('descripcion') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    <button class="btn btn-primary" type="submit">Guardar</button>
    <a href="{{ route('admin.facturacion.index') }}" class="btn btn-secondary">Cancelar</a>
</form>

<script>
    // Autocompletar titular cuando seleccionan documento desde datalist
    document.getElementById('documento').addEventListener('input', function () {
        const val = this.value;
        const opts = document.querySelectorAll('#listaDocumentos option');
        let nombre = '';
        opts.forEach(o => {
            if (o.value === val) {
                nombre = o.dataset.nombre || '';
            }
        });
        if (nombre) {
            document.getElementById('titular').value = nombre;
        }
    });
</script>
@endsection
