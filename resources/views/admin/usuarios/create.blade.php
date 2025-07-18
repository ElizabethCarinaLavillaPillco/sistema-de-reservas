@extends('layouts.template')

@section('content')
<h1 class="mt-4">Crear Usuario</h1>



<form action="{{ route('admin.usuarios.store') }}" method="POST">
    @csrf

  

    <div class="mb-3">
        <label>Nombre de Usuario:</label>
        <input type="text" name="usuario" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Correo Electrónico:</label>
        <input type="email" name="correo" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Contraseña:</label>
        <input type="password" name="password" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Estado:</label>
        <select name="activo" class="form-control">
            <option value="1" selected>Activo</option>
            <option value="0">Inactivo</option>
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Guardar</button>
    <a href="{{ route('admin.usuarios.index') }}" class="btn btn-secondary">Cancelar</a>
</form>

@endsection


