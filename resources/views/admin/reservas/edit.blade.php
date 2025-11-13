@extends('layouts.app')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Nueva Reserva</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.reservas.index') }}">Reservas</a></li>
                <li class="breadcrumb-item active">Crear</li>
            </ol>
        </nav>
    </div>
</div>

<div class="form-container">
    @include('admin.reservas._form', ['mode' => 'edit'])
</div>
@endsection