@extends('layouts.template')

@section('content')
<h1 class="mt-4">Lista de Proveedores</h1>

<a href="{{ route('admin.proveedores.create') }}" class="btn btn-success mb-3">Nuevo Proveedor</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre de la agencia</th>
            <th>Nombre del encargado</th>
            <th>Pais</th>
            <th>Telefono</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($proveedores as $proveedor)
        <tr>
            <td>{{ $proveedor->id }}</td>
            <td>{{ $proveedor->nombreAgencia }}</td>
            <td>{{ $proveedor->nombreEncargado }}</td>
            <td>{{ $proveedor->pais }}</td>
            <td>{{ $proveedor->telefono }}</td>
            <td>
                <a href="{{ route('admin.proveedores.edit', $proveedor->id) }}" class="btn btn-sm btn-primary">Editar</a>

                <form action="{{ route('admin.proveedores.destroy', $proveedor->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro?')">Eliminar</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
