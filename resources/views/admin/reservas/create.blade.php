@extends('layouts.template')

@section('title', 'Reservas - Expediciones Allinkay')

@section('content')
<div class="container-fluid py-4">
    <div class="page-header">
        <h1 class="page-title">Nueva Reserva</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.reservas.index') }}">Reservas</a></li>
                <li class="breadcrumb-item active">Nueva Reserva</li>
            </ol>
        </nav>
    </div>
    
    <!-- CONTENIDO -->
        <div class="container">
            @include('admin.reservas._form', ['mode' => 'create'])
        </div>
</div>

@endsection

