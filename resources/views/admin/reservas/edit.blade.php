@extends('layouts.template')
@section('title', 'Reservas - Expediciones Allinkay')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="display-6">
                <i class="fas fa-edit me-2 text-warning"></i>Editar Reserva: 
                <span class="text-primary">{{ $reserva->id }}</span>
            </h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.reservas.index') }}">Reservas</a></li>
                    <li class="breadcrumb-item active">{{ $reserva->id }}</li>
                </ol>
            </nav>
        </div>
        <div>
            <span class="badge bg-{{ 
                $reserva->estado == 'Activa' ? 'success' : 
                ($reserva->estado == 'En espera' ? 'warning' : 
                ($reserva->estado == 'Finalizada' ? 'secondary' : 'danger'))
            }} fs-5 px-4 py-2">
                {{ $reserva->estado }}
            </span>
        </div>
    </div>

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <h5 class="alert-heading"><i class="fas fa-exclamation-triangle me-2"></i>Errores de validación</h5>
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @include('admin.reservas._form')
</div>
@endsection

<?php