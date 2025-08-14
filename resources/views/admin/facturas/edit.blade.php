@extends('layouts.template')

@section('content')
<div class="container">
    <h1>Editar Factura</h1>

    <form action="{{ route('admin.facturas.update', $factura->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="titular">Titular</label>
            <input type="text" name="titular" id="titular" class="form-control" value="{{ $factura->titular }}" required>
        </div>

        <div class="form-group">
            <label for="ruc">RUC</label>
            <input type="text" name="ruc" id="ruc" class="form-control" value="{{ $factura->ruc }}" required>
        </div>

        <div class="form-group">
            <label for="fecha">Fecha</label>
            <input type="date" name="fecha" id="fecha" class="form-control" value="{{ $factura->fecha }}" required>
        </div>

        <div class="form-group">
            <label for="monto">Monto</label>
            <input type="number" step="0.01" name="monto" id="monto" class="form-control" value="{{ $factura->monto }}" required>
        </div>

        <div class="form-group">
            <label for="descripcion">Descripción</label>
            <textarea name="descripcion" id="descripcion" class="form-control">{{ $factura->descripcion }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary mt-2">Actualizar</button>
        <a href="{{ route('admin.facturas.index') }}" class="btn btn-secondary mt-2">Cancelar</a>
    </form>
</div>
@endsection
