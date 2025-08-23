@extends('layouts.template')
@section('content')
    <h1 class="mt-4">Editar Reserva</h1>
    @include('admin.reservas.form', [
        'mode'    => 'edit',
        'reserva' => $reserva
    ])
    <script>
        // ---- Al cargar en modo edición, actualizar contadores ----
        document.addEventListener('DOMContentLoaded', function () {
            // Tours
            let totalTours = document.querySelectorAll('#listaToursAgregados li').length;
            if (document.getElementById('cantidad_tours')) {
                document.getElementById('cantidad_tours').value = totalTours;
            }
            // Estadías
            let totalEstadias = document.querySelectorAll('#listaEstadiasAgregadas li').length;
            if (document.getElementById('cantidad_estadias')) {
                document.getElementById('cantidad_estadias').value = totalEstadias;
            }
            // Pasajeros
            let totalPasajeros = document.querySelectorAll('#listaPasajerosAgregados li').length;
            if (document.getElementById('cantidad_pasajeros')) {
                document.getElementById('cantidad_pasajeros').value = totalPasajeros;
            }
        });
    </script>
@endsection
