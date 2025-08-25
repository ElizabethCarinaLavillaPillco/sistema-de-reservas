@extends('layouts.template')

@section('content')
<div class="container">
    <h1 class="mt-4">Editar Reserva</h1>
    @include('admin.reservas._form', ['mode' => 'edit'])
</div>
@endsection
