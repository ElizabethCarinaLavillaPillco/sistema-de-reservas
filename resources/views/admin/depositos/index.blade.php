@extends('layouts.template')

@section('content')
<div class="container">
    <h1 class="mb-4">Lista de Depósitos</h1>

    <!-- Botón Crear Nuevo -->
    <a href="{{ route('admin.depositos.create') }}" class="btn btn-primary mb-3">Nuevo Depósito</a>


    <!-- Tabla de depósitos -->
    <table class="table table-bordered table-striped">
            <thead class="table-success">
                <tr>
                    <th>ID</th>
                    <th>Nombre del Depositante</th>
                    <th>ID Reserva</th>
                    <th>Monto</th>
                    <th>Fecha</th>
                    <th>Tipo de Depósito</th>
                    <th>Observaciones</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($depositos as $deposito)
                    <tr>
                        <td>{{ $deposito->id }}</td>
                        <td>{{ $deposito->nombre_depositante }}</td>
                        
                        <td>
                            @if ($deposito->reserva)
                                <a href="{{ route('admin.reservas.show', $deposito->reserva_id) }}">
                                    {{ $deposito->reserva_id }}</a>
                            @else
                                <span class="text-muted">No asociada</span>
                            @endif
                        </td>
                        <td>$ {{ number_format($deposito->monto, 2) }}</td>
                        <td>{{ $deposito->fecha->format('Y-m-d') }}</td>
                        <td>{{ $deposito->tipo_deposito }}</td>
                        <td>{{ $deposito->observaciones }}</td>
                        <td>
                            <a href="{{ route('admin.depositos.edit', $deposito->id) }}" class="btn btn-warning btn-sm">Editar</a>

                            <form action="{{ route('admin.depositos.destroy', $deposito->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que deseas eliminar este depósito?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                @if($depositos->isEmpty())
                    <tr>
                        <td colspan="8" class="text-center">No se encontraron depósitos.</td>
                    </tr>
                @endif
            </tbody>
        </table>    

    
</div>
@endsection
