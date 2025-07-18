@extends('layouts.template')

@section('content')
<h1 class="mt-4">Detalle del Usuario</h1>

<ul class="list-group">
    <li class="list-group-item"><strong>Nombre:</strong> {{ $usuario->name }}</li>
    <li class="list-group-item"><strong>Email:</strong> {{ $usuario->email }}</li>
    <li class="list-group-item"><strong>Estado:</strong>
        @if($usuario->activo)
            <span class="badge bg-success">Activo</span>
        @else
            <span class="badge bg-secondary">Inactivo</span>
        @endif
    </li>
</ul>

<a href="{{ route('admin.usuarios.index') }}" class="btn btn-primary mt-3">Volver</a>
@endsection
