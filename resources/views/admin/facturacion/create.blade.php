@extends('layouts.template')

@section('content')
<h1 class="mt-4">Crear Comprobante (Facturación)</h1>

<form action="{{ route('admin.facturacion.store') }}" method="POST">
    @csrf

    {{-- Tipo de Facturación --}}
    <div class="mb-3">
        <label for="tipo_fac">Tipo:</label>
        <select name="tipo_fac" id="tipo_fac" class="form-control" required>
            <option value="Paquete">Paquete</option>
            <option value="Comision">Comisión</option>
        </select>
    </div>


    {{-- Buscar Reserva --}}
    <div id="reserva-section">
        <div class="mb-3">
            <label>Reserva (busque por nombre o código):</label>
            <input list="listaReservas" id="busquedaReserva" class="form-control" placeholder="Ej. José Ram...">
            <datalist id="listaReservas">
                @foreach($reservas as $r)
                    <option value="{{ $r->id }} - {{ $r->titular->nombre }} {{ $r->titular->apellido }}"
                            data-id="{{ $r->id }}"
                            data-documento="{{ $r->titular->documento }}"
                            data-nombre="{{ $r->titular->nombre }} {{ $r->titular->apellido }}"
                            data-pais="{{ $r->titular->pais_residencia }}">
                @endforeach
            </datalist>

            <input type="hidden" name="reserva_id" id="reserva_id_hidden">
        </div>
    </div>
    

    <div class="row">
        
        {{-- Documento (datalist) --}}
        <div class="col-md-4 mb-3">
            <label for="documento">Documento (DNI / Pasaporte):</label>
            <input list="listaDocumentos" id="documento" name="documento" class="form-control" value="{{ old('documento') }}" required>
            <datalist id="listaDocumentos">
                @foreach($pasajeros as $p)
                    <option value="{{ $p->documento }}" data-nombre="{{ $p->nombre }} {{ $p->apellido }}"></option>
                @endforeach
            </datalist>
            @error('documento') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        {{-- Titular --}}
        <div class="col-md-4 mb-3">
            <label for="titular">Titular (nombre):</label>
            <input type="text" name="titular" id="titular" class="form-control" value="{{ old('titular') }}" required>
            @foreach($reservas as $r)
                    <option value="{{ $r->titular->nombre }} {{ $r->titular->apellido }}">
                @endforeach
            @error('titular') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        {{-- País --}}
        <div class="col-md-4 mb-3">
            <label for="pais">País:</label>
            <input type="text" name="pais" id="pais" class="form-control" value="{{ old('pais') }}" required>
            <datalist id="listaPaises">
                @foreach($pasajeros as $p)
                <option value="{{ $p->pais_residencia }}"></option>
                @endforeach
            </datalist>
            @error('pais') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>
    </div>

    <div class="row">
        {{-- Fecha de giro --}}
        <div class="col-md-3 mb-3">
            <label for="fecha_giro">Fecha de giro:</label>
            <input type="date" name="fecha_giro" id="fecha_giro" class="form-control" required>
            @error('fecha_giro') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        {{-- Tipo --}}
        <div class="col-md-3 mb-3">
            <label for="tipo">Tipo:</label>
            <select name="tipo" id="tipo" class="form-control" required>
                <option value="">-- Seleccionar --</option>
                <option value="Boleta" {{ old('tipo')=='Boleta' ? 'selected':'' }}>Boleta</option>
                <option value="Factura" {{ old('tipo')=='Factura' ? 'selected':'' }}>Factura</option>
            </select>
            @error('tipo') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        {{-- Total facturado --}}
        <div class="col-md-3 mb-3">
            <label for="total_facturado">Total facturado:</label>
            <input type="number" step="0.01" name="total_facturado" id="total_facturado" class="form-control" value="{{ old('total_facturado') }}" required>
            @error('total_facturado') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        {{-- Estado --}}
        <div class="col-md-3 mb-3">
            <label for="estado">Estado:</label>
            <select name="estado" id="estado" class="form-control" required>
                <option value="Sin realizar" {{ old('estado')=='Sin realizar' ? 'selected':'' }}>Sin realizar</option>
                <option value="Realizado" {{ old('estado')=='Realizado' ? 'selected':'' }}>Realizado</option>
            </select>
            @error('estado') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>
    </div>

    {{-- Descripción / Observaciones --}}
    <div class="mb-3">
        <label for="descripcion">Descripción / Observaciones:</label>
        <textarea name="descripcion" id="descripcion" class="form-control" rows="3">{{ old('descripcion') }}</textarea>
        @error('descripcion') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    <button class="btn btn-primary" type="submit">Guardar</button>
    <a href="{{ route('admin.facturacion.index') }}" class="btn btn-secondary">Cancelar</a>
</form>

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
