@extends('layouts.template')

@section('content')
<div class="container">
<h2 class="mt-4">Editar Comprobante #{{ $facturacion->id }}</h2>


<form action="{{ route('admin.facturacion.update', $facturacion->id) }}" method="POST">
    @csrf
    @method('PUT')

    {{-- Tipo de Facturación --}}
    <div class="mb-3">
        <label for="tipo_fac">Tipo:</label>
        <select name="tipo_fac" id="tipo_fac" class="form-control" required>
            <option value="Paquete" {{ old('tipo_fac', $facturacion->tipo_fac) == 'Paquete' ? 'selected' : '' }}>Paquete</option>
            <option value="Comision" {{ old('tipo_fac', $facturacion->tipo_fac) == 'Comision' ? 'selected' : '' }}>Comision</option>
            
        </select>
    </div>


    {{-- Buscar Reserva --}}
    <div id="reserva-section">
        <div class="mb-3">
            <label>Reserva (busque por nombre o código):</label>
            <input
                list="listaReservas"
                id="busquedaReserva"
                class="form-control"
                value="{{ $facturacion->reserva ? ($facturacion->reserva->id.' - '.$facturacion->reserva->titular->nombre.' '.$facturacion->reserva->titular->apellido) : '' }}"
            >

            <datalist id="listaReservas">
                @foreach($reservas as $r)
                    <option
                        value="{{ $r->id }} - {{ $r->titular->nombre }} {{ $r->titular->apellido }}"
                        data-id="{{ $r->id }}"
                        data-documento="{{ $r->titular->documento }}"
                        data-nombre="{{ $r->titular->nombre }} {{ $r->titular->apellido }}"
                        data-pais="{{ $r->titular->pais_residencia }}">
                @endforeach
            </datalist>

            <input
                type="hidden"
                name="reserva_id"
                id="reserva_id_hidden"
                value="{{ $facturacion->reserva_id }}">
        </div>

    </div>

    <div class="row">
        {{-- Documento --}}
        <div class="col-md-4 mb-3">
            <label>Documento (DNI / Pasaporte)</label>
            <input type="text" id="documento" name="documento" class="form-control"
                value="{{ old('documento', $facturacion->documento) }}" required>
        </div>

        {{-- Titular --}}
        <div class="col-md-4 mb-3">
            <label>Titular</label>
            <input type="text" id="titular" name="titular" class="form-control"
                value="{{ old('titular', $facturacion->titular) }}" required>
        </div>

        {{-- País --}}
        <div class="col-md-4 mb-3">
            <label>País</label>
            <input type="text" id="pais" name="pais" class="form-control"
                value="{{ old('pais', $facturacion->pais) }}" required>
        </div>
    </div>



    <div class="row">
        {{-- Fecha de giro --}}
        <div class="col-md-3 mb-3">
            <label for="fecha_giro">Fecha de giro:</label>
            <input type="date" name="fecha_giro" id="fecha_giro" class="form-control" value="{{ old('fecha_giro', $facturacion->fecha_giro) }}" required>
            @error('fecha_giro') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        {{-- Tipo --}}
        <div class="col-md-md-3 mb-3">
            <label for="tipo">Tipo:</label>
            <select name="tipo" id="tipo" class="form-control" required>
                <option value="Boleta" {{ old('tipo', $facturacion->tipo)=='Boleta' ? 'selected':'' }}>Boleta</option>
                <option value="Factura" {{ old('tipo', $facturacion->tipo)=='Factura' ? 'selected':'' }}>Factura</option>
            </select>
            @error('tipo') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        {{-- Total facturado --}}
        <div class="col-md-3 mb-3">
            <label for="total_facturado">Total facturado:</label>
            <input type="number" step="0.01" name="total_facturado" id="total_facturado" class="form-control" value="{{ old('total_facturado', $facturacion->total_facturado) }}" required>
            @error('total_facturado') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        {{-- Estado --}}
        <div class="col-md-3 mb-3">
            <label for="estado">Estado:</label>
            <select name="estado" id="estado" class="form-control" required>
                <option value="Sin realizar" {{ old('estado', $facturacion->estado)=='Sin realizar' ? 'selected':'' }}>Sin realizar</option>
                <option value="Realizado" {{ old('estado', $facturacion->estado)=='Realizado' ? 'selected':'' }}>Realizado</option>
            </select>
            @error('estado') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>
    </div>


    {{-- Descripción / Observaciones --}}
    <div class="mb-3">
        <label for="descripcion">Descripción / Observaciones:</label>
        <textarea name="descripcion" id="descripcion" class="form-control" rows="3">{{ old('descripcion', $facturacion->descripcion) }}</textarea>
        @error('descripcion') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    <button type="submit" class="btn btn-success">Actualizar</button>
    <a href="{{ route('admin.facturacion.index') }}" class="btn btn-secondary">Cancelar</a>

</form>
</div>

<script>
    document.getElementById('busquedaReserva').addEventListener('input', function(){
        const val = this.value;
        const opt = Array.from(document.querySelectorAll('#listaReservas option'))
                        .find(o => o.value === val);

        if (opt) {
            document.getElementById('reserva_id_hidden').value = opt.dataset.id;
            document.getElementById('documento').value           = opt.dataset.documento;
            document.getElementById('titular').value             = opt.dataset.nombre;
            document.getElementById('pais').value                = opt.dataset.pais;
        } else {
            document.getElementById('reserva_id_hidden').value = '';
            // opcional: limpiar los campos
            document.getElementById('documento').value = '';
            document.getElementById('titular').value   = '';
            document.getElementById('pais').value      = '';
        }
    });

    document.getElementById('tipo_fac').addEventListener('change', function () {
        if (this.value === 'Comision') {
            document.getElementById('reserva-section').style.display = 'none';
            // limpiar campos si estaban llenos
            document.getElementById('reserva_id_hidden').value = '';
            document.getElementById('busquedaReserva').value   = '';
        } else {
            document.getElementById('reserva-section').style.display = 'block';
        }
    });

    // Ejecutarlo al cargar la página por si viene seleccionado por defecto
    document.getElementById('tipo_fac').dispatchEvent(new Event('change'));



</script>
@endsection
