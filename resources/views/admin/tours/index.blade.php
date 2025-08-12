@extends('layouts.template')

@section('content')
<h1 class="mt-4">Lista de Tours</h1>

<a href="{{ route('admin.tours.create') }}" class="btn btn-success mb-3">Nuevo Tour</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($tours as $tour)
        <tr>
            <td>{{ $tour->id }}</td>
            <td>{{ $tour->nombreTour }}</td>
            <td>{{ $tour->descripcion }}</td>
            <td>
                <a href="{{ route('admin.tours.edit', $tour->id) }}" class="btn btn-sm btn-primary">Editar</a>

                <form action="{{ route('admin.tours.destroy', $tour->id) }}" method="POST" style="display:inline;">
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
