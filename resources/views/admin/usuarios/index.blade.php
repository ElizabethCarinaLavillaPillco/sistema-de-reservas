    @extends('layouts.template')

    @section('content')
    <h1 class="mt-4">Usuarios</h1>

    <a href="{{ route('admin.usuarios.create') }}" class="btn btn-primary mb-3">Nuevo Usuario</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($usuarios as $usuario)
        <tr>
            <td>{{ $usuario->idUsuario}}</td>
            <td>{{ $usuario->usuario }}</td>
            <td>{{ $usuario->correo }}</td>
            <td>
                @if($usuario->activo)
                    <span class="badge bg-success">Activo</span>
                @else
                    <span class="badge bg-secondary">Inactivo</span>
                @endif
            </td>
            <td>
                <a href="{{ route('admin.usuarios.edit', $usuario->idUsuario) }}" class="btn btn-sm btn-warning">Editar</a>

            <form action="{{ route('admin.usuarios.destroy', $usuario) }}" method="POST" style="display:inline;">

                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este usuario?')">Eliminar</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
