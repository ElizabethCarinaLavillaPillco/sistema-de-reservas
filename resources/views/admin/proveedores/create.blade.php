@extends('layouts.template')

@section('content')
<h1 class="mt-4">Crear nuevo Proveedor</h1>

<form action="{{ route('admin.proveedores.store') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label for="nombreAgencia">Nombre de la Agencia:</label>
        <input type="text" name="nombreAgencia" class="form-control" value="{{ old('nombreAgencia') }}" required>
        @error('nombreAgencia')
            <small class="text-danger">{{ $message }}</small>
        @enderror


    </div>    <div class="mb-3">
        <label for="nombreEncargado">Nombre del Encargado:</label>
        <input type="text" name="nombreEncargado" class="form-control" value="{{ old('nombreEncargado') }}" required>
        @error('nombreEncargado')   
            <small class="text-danger">{{ $message }}</small>       

        @enderror

    </div>
    <div class="mb-3">
        <label for="pais">País:</label>
        <input type="text" name="pais" class="form-control" value="{{ old('pais') }}" required>
        @error('pais')
            <small class="text-danger">{{ $message }}</small>
        @enderror

    </div>

    <div class="mb-3">
        <label for="telefono">Teléfono:</label>
        <input type="text" name="telefono" class="form-control" value="{{ old('telefono') }}">
        @error('telefono')
            <small class="text-danger">{{ $message }}</small>
        @enderror   

    </div>

    <div class="mb-3">
        <label for="estado">Estado:</label>
        <select name="estado" class="form-control" required>
            <option value="activo" {{ old('estado') == 'activo' ? 'selected' : '' }}>Activo</option>
            <option value="inactivo" {{ old('estado') == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
        </select>
        @error('estado')
            <small class="text-danger">{{ $message }}</small>
        @enderror   
    </div>
    

    <button type="submit" class="btn btn-primary">Guardar</button>
    <a href="{{ route('admin.proveedores.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection
