@extends('layouts.template')

@section('content')
<div class="container">
    <h1>Listado de Facturas</h1>

    <a href="{{ route('admin.facturas.create') }}" class="btn btn-success mb-3">Crear Factura</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>N°</th>
                <th>Titular</th>
                <th>RUC</th>
                <th>Fecha</th>
                <th>Monto</th>
                <th>Descripción</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($facturas as $factura)
                <tr>
                    <td>{{ $factura->id }}</td>
                    <td>{{ $factura->titular }}</td>
                    <td>{{ $factura->ruc }}</td>
                    <td>{{ $factura->fecha }}</td>
                    <td>S/. {{ number_format($factura->monto, 2) }}</td>
                    <td>{{ $factura->descripcion }}</td>
                    <td>
                        <a href="{{ route('admin.facturas.edit', $facturas->id) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form action="{{ route('admin.facturas.destroy', $facturas->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar esta factura?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">No hay facturas registradas.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
