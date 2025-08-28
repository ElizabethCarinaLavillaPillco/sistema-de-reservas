@extends('layouts.template')

@section('title', 'Editar Reservas - Expediciones Allinkay')
@section('content')

@section('styles')
@endsection
<div class="container-fluid py-4">
    <div class="page-header">
        <h1 class="page-title">Editar Reserva</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.reservas.index') }}">Reservas</a></li>
                <li class="breadcrumb-item active">Editar Reserva</li>
            </ol>
        </nav>
    </div>
    
    <!-- CONTENIDO -->
        <div class="container">
            @include('admin.reservas._form', ['mode' => 'edit'])
        </div>
</div>

@endsection

@section('scripts')
@endsection
