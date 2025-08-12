@extends('layouts.template')

@section('content')
<div class="container">
    <h1>Editar Registro - Contabilidad</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ route('admin.contabilidad.update', $contabilidad->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Fecha de Pago</label>
            <input type="date" name="fecha_pago" class="form-control" value="{{ $contabilidad->fecha_pago }}" required>
        </div>

        <div class="mb-3">
            <label>Mes del Recibo</label>
            <input type="text" name="mes_recibo" class="form-control" value="{{ $contabilidad->mes_recibo }}" required>
        </div>

        <div class="mb-3">
            <label>Año del Recibo</label>
            <input type="number" name="anio_recibo" class="form-control" value="{{ $contabilidad->anio_recibo }}" required>
        </div>

        <div>
            <label for="essalud">ESSALUD</label>
            <input type="number" step="0.01" name="essalud" id="essalud" oninput="calcularTotal()" value="{{ old('essalud', $contabilidad->essalud ?? '') }}">
        </div>
        <div>
            <label for="afp">AFP</label>
            <input type="number" step="0.01" name="afp" id="afp" oninput="calcularTotal()" value="{{ old('afp', $contabilidad->afp ?? '') }}">
        </div>
        <div>
            <label for="servicios">Servicios</label>
            <input type="number" step="0.01" name="servicios" id="servicios" oninput="calcularTotal()" value="{{ old('servicios', $contabilidad->servicios ?? '') }}">
        </div>
        <div>
            <label for="ir">IR</label>
            <input type="number" step="0.01" name="ir" id="ir" oninput="calcularTotal()" value="{{ old('ir', $contabilidad->ir ?? '') }}">
        </div>
        <div>
            <label for="renta_anual">Renta Anual</label>
            <input type="number" step="0.01" name="renta_anual" id="renta_anual" oninput="calcularTotal()" value="{{ old('renta_anual', $contabilidad->renta_anual ?? '') }}">
        </div>

        <div>
            <label for="total">Total</label>
            <input type="number" step="0.01" name="total" id="total" readonly value="{{ old('total', $contabilidad->total ?? '') }}">
        </div>

        <button type="submit" class="btn btn-success">Actualizar</button>
        <a href="{{ route('admin.contabilidad.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>



        <script>
            function calcularTotal() {
                let essalud = parseFloat(document.getElementById('essalud').value) || 0;
                let afp = parseFloat(document.getElementById('afp').value) || 0;
                let servicios = parseFloat(document.getElementById('servicios').value) || 0;
                let ir = parseFloat(document.getElementById('ir').value) || 0;
                let renta = parseFloat(document.getElementById('renta_anual').value) || 0;

                document.getElementById('total').value = (essalud + afp + servicios + ir + renta).toFixed(2);
            }
        </script>

        
</div>
@endsection
