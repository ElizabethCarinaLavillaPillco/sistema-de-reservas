@extends('layouts.template')

@section('content')
<div class="container-fluid py-4">
    <div class="page-header">
        <h1 class="page-title">Nuevo Pasajero</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.pasajeros.index') }}">Pasajeros</a></li>
                <li class="breadcrumb-item active">Nuevo Pasajero</li>
            </ol>
        </nav>
    </div>
    
    <!-- CONTENIDO -->
        <div class="container">
                @include('admin.pasajeros._form', ['mode' => 'create'])
        </div>
</div>
@endsection
