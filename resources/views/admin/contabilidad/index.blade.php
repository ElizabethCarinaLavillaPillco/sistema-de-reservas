@extends('layouts.template')

@section('content')
<div class="container">
    <h1>Lista de Pagos - Contabilidad</h1>
    <a href="{{ route('admin.contabilidad.create') }}" class="btn btn-primary mb-3">Nuevo Registro</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Fecha de Pago</th>
                <th>Mes</th>
                <th>Año</th>
                <th>ESSALUD</th>
                <th>AFP</th>
                <th>SERVICIOS</th>
                <th>IR</th>
                <th>Renta Anual</th>
                <th>Total</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($contabilidades as $item)
                <tr>
                    <td>{{ $item->fecha_pago }}</td>
                    <td>{{ $item->mes_recibo }}</td>
                    <td>{{ $item->anio_recibo }}</td>
                    <td>S/. {{ number_format($item->essalud, 2) }}</td>
                    <td>S/. {{ number_format($item->afp, 2) }}</td>
                    <td>S/. {{ number_format($item->servicios, 2) }}</td>
                    <td>{{ $item->ir ? 'S/. '.number_format($item->ir, 2) : '-' }}</td>
                    <td>{{ $item->renta_anual ? 'S/. '.number_format($item->renta_anual, 2) : '-' }}</td>
                    <td>S/ {{ number_format($item->total, 2) }}</td>

                    <td>
                        <a href="{{ route('admin.contabilidad.edit', $item->id) }}" class="btn btn-warning btn-sm">Editar</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="10" class="text-center">No hay registros</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
