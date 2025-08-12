@extends('layouts.template')

@section('content')
<h1 class="mt-4">Editar Tour</h1>


<form action="{{ route('admin.tours.update', $tours->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>Id:</label>
        <input type="text" name="id" class="form-control" value="{{ $tours->id }}" readonly>
    </div>

    <div class="mb-3">
        <label>Tour Nombre:</label>
        <input type="text" name="nombreTour" class="form-control" value="{{ $tours->nombreTour }}" required>
    </div>

    <div class="mb-3">
        <label>Descripcion:</label>
        <input type="text" name="descripcion" class="form-control" value="{{ $tours->descripcion }}">
    </div>

    

    <button type="submit" class="btn btn-success">Actualizar</button>
    <a href="{{ route('admin.tours.index') }}" class="btn btn-secondary">Cancelar</a>
</form>

@endsection
