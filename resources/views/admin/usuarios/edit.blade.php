@extends('layouts.template')

@section('content')
<h1 class="mt-4">Editar Usuario</h1>

<form action="{{ route('admin.usuarios.update', $usuario->idUsuario) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>Nombre:</label>
        <input type="text" name="name" class="form-control" value="{{ $usuario->name }}" required>
    </div>

    <div class="mb-3">
        <label>Email:</label>
        <input type="email" name="email" class="form-control" value="{{ $usuario->email }}" required>
    </div>

    <div class="mb-3">
        <label>Estado:</label>
        <select name="activo" class="form-control">
            <option value="1" {{ $usuario->activo ? 'selected' : '' }}>Activo</option>
            <option value="0" {{ !$usuario->activo ? 'selected' : '' }}>Inactivo</option>
        </select>
    </div>

    <button type="submit" class="btn btn-success">Actualizar</button>
    <a href="{{ route('admin.usuarios.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection
