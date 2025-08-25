@extends('layouts.template')

@section('content')
<div class="container">
    <h1 class="mt-4">Nueva Reserva</h1>
    @include('admin.reservas._form', ['mode' => 'create'])
</div>
@endsection
