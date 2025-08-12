@extends('layouts.template')

@section('content')
<h1 class="mt-4">Editar Proveedor</h1>


<form action="{{ route('admin.proveedores.update', $proveedores->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>Id:</label>
        <input type="text" name="id" class="form-control" value="{{ $proveedores->id }}" readonly>
    </div>

    <div class="mb-3">
        <label>Nombre de la agencia:</label>
        <input type="text" name="nombreAgencia" class="form-control" value="{{ $proveedores->nombreAgencia }}" required>
    </div>

    <div class="mb-3">
        <label>Nombre del encargado:</label>
        <input type="text" name="nombreEncargado" class="form-control" value="{{ $proveedores->nombreEncargado }}" required>
    </div>

    <div class="mb-3">
        <label>País:</label>
        <input type="text" name="pais" class="form-control" value="{{ $proveedores->pais }}" required>
    </div>

    <div class="mb-3">
        <label>Teléfono:</label>
        <input type="text" name="telefono" class="form-control" value="{{ $proveedores->telefono }}">
    </div>
    
    <div class="mb-3">
        <label>Estado:</label>
        <select name="estado" class="form-control" required>
            <option value="activo" {{ $proveedores->estado == 'activo' ? 'selected' : '' }}>Activo</option>
            <option value="inactivo" {{ $proveedores->estado == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
        </select>

        @error('estado')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <button type="submit" class="btn btn-success">Actualizar</button>
    <a href="{{ route('admin.proveedores.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection
