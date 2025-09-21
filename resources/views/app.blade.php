<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title inertia>{{ config('app.name', 'Turismo xddddddd Adventures') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=poppins:300,400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Favicon -->
        <link rel="icon" type="image/png" href="/images/logo.png">

        <!-- Scripts -->
        @viteReactRefresh
        @vite(['resources/js/app.jsx', 'resources/css/app.css'])
        @inertiaHead
    </head>
    <body class="font-sans antialiased">
        @inertia
    </body>
</html>

@if (request()->is('dashboard', 'admin/*'))
<script>
// Intentar pantalla completa automáticamente para rutas del sistema
document.addEventListener('DOMContentLoaded', function() {
    function enterFullscreen() {
        const elem = document.documentElement;
        if (elem.requestFullscreen && !document.fullscreenElement) {
            elem.requestFullscreen().catch(err => {
                console.log('Error al intentar pantalla completa:', err);
            });
        }
    }
    
    // Intentar al cargar
    enterFullscreen();
    
    // También intentar con la primera interacción del usuario
    document.addEventListener('click', function firstClick() {
        enterFullscreen();
        document.removeEventListener('click', firstClick);
    });
});
</script>
@endif