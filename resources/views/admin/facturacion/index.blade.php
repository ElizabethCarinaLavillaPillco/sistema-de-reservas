@extends('layouts.template')

@section('content')
<h1 class="mt-4">Facturacines Realizadas</h1>

<a href="{{ route('admin.facturacion.create') }}" class="btn btn-primary mb-3">Nueva Facturación</a>

<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>#</th>
            <th>Documento</th>
            <th>Titular</th>
            <th>Reserva</th>
            <th>Pais</th>
            <th>Servicio</th>
            <th>Fecha Giro</th>
            <th>Tipo</th>
            <th>Total</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @forelse($facturacion as $f)
            <tr>
                <td>{{ $f->id }}</td>
                <td>{{ $f->documento }}</td>
                <td>{{ $f->titular }}</td>
                <td>{{ $f->reserva_id }}</td>
                <td>{{ $f->pais }}</td>
                <td>{{ $f->servicio }}</td>
                <td>{{ $f->fecha_giro ? $f->fecha_giro->format('d-m-Y') : '-' }}</td>
                <td>{{ $f->tipo }}</td>
                <td>{{ number_format($f->total_facturado, 2) }}</td>
                <td>{{ $f->estado }}</td>
                <td>
                    <a href="{{ route('admin.facturacion.edit', $f->id) }}" class="btn btn-sm btn-warning">Editar</a>
                    <form action="{{ route('admin.facturacion.destroy', $f->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Eliminar este comprobante?')">Eliminar</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="11" class="text-center">No hay registros.</td></tr>
        @endforelse
    </tbody>
</table>

{{ $facturacion->links() }}
@endsection
