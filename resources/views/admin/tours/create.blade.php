@extends('layouts.template')

@section('content')
<h1 class="mt-4">Crear nuevo Tour</h1>

<form action="{{ route('admin.tours.store') }}" method="POST">
    @csrf

    

    <div class="mb-3">
        <label>Nombre del Tour:</label>
        <input type="text" name="nombreTour" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Descripción:</label>
        <textarea name="descripcion" class="form-control"></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Guardar</button>
    <a href="{{ route('admin.tours.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection
