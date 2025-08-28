<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistema de gestión de Expediciones Allinkay">
    <title>@yield('title', 'Expediciones Allinkay')</title>
    
    <!-- Fuentes -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    
    <!-- Estilos propios -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    
    <!-- Estilos específicos de la página -->
    @yield('styles')
</head>
<body>
    @include('admin.partials.header')
    @include('admin.partials.sidebar')
    
    <main class="main-content" id="mainContent">
        @yield('content')
    </main>
    
    <!-- Scripts globales -->
    <script src="{{ asset('js/app.js') }}"></script>
    
    <!-- Scripts específicos de la página -->
    @yield('scripts')
</body>
</html>