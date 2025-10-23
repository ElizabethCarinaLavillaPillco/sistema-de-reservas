<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Viaje - {{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Poppins', sans-serif; }
    </style>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            500: '#14a5b5',
                            600: '#0f8a97',
                            700: '#0a6f79',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">

    {{-- NAVBAR --}}
    <nav class="bg-white shadow-lg sticky top-0 z-50">
        <div class="container mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <i class="fas fa-mountain text-primary-500 text-3xl"></i>
                    <div>
                        <h1 class="font-bold text-xl text-gray-900">Mi Viaje</h1>
                        <p class="text-xs text-gray-500">{{ $pasajero->nombre_completo }}</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('cliente.logout') }}">
                    @csrf
                    <button class="text-gray-600 hover:text-red-500 transition-colors">
                        <i class="fas fa-sign-out-alt mr-2"></i>Cerrar Sesión
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mx-auto px-4 py-8">

        {{-- BIENVENIDA --}}
        <div class="bg-gradient-to-r from-primary-500 to-primary-700 rounded-3xl shadow-2xl p-8 mb-8 text-white">
            <h2 class="text-3xl font-bold mb-2">¡Bienvenido, {{ $pasajero->nombre }}! 🎉</h2>
            <p class="text-primary-100">Tu aventura está a punto de comenzar</p>
        </div>

        {{-- TOUR DE HOY --}}
        @if($tourHoy)
            <div class="bg-gradient-to-br from-yellow-400 to-orange-500 rounded-3xl shadow-2xl p-8 mb-8 text-white">
                <div class="flex items-center gap-4 mb-4">
                    <div class="bg-white bg-opacity-20 rounded-full p-4">
                        <i class="fas fa-calendar-day text-4xl"></i>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold">¡Hoy tienes tour!</h3>
                        <p class="text-yellow-100">{{ $tourHoy->tour->nombreTour }}</p>
                    </div>
                </div>
                <div class="bg-white bg-opacity-20 rounded-2xl p-6 space-y-3">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-clock text-2xl"></i>
                        <div>
                            <p class="text-sm text-yellow-100">Hora de Recojo</p>
                            <p class="text-xl font-bold">{{ $tourHoy->hora_recojo?->format('H:i') ?? 'Por confirmar' }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <i class="fas fa-map-marker-alt text-2xl"></i>
                        <div>
                            <p class="text-sm text-yellow-100">Lugar de Recojo</p>
                            <p class="font-semibold">{{ $tourHoy->lugar_recojo ?? 'Por confirmar' }}</p>
                        </div>
                    </div>
                </div>
                <div class="mt-6 bg-white bg-opacity-20 rounded-xl p-4">
                    <p class="text-sm">
                        <i class="fas fa-info-circle mr-2"></i>
                        <strong>Recomendaciones:</strong> Llega 10 minutos antes. Lleva protector solar, agua y cámara.
                    </p>
                </div>
                <a href="https://wa.me/51984123456" target="_blank" 
                   class="mt-4 block w-full bg-green-500 hover:bg-green-600 text-white text-center py-3 rounded-xl font-semibold transition-all">
                    <i class="fab fa-whatsapp mr-2"></i>¿Necesitas ayuda? Escríbenos
                </a>
            </div>
        @endif

        {{-- PRÓXIMOS TOURS --}}
        @if($toursProximos->count() > 0)
            <div class="bg-white rounded-3xl shadow-lg p-8 mb-8">
                <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                    <i class="fas fa-route text-primary-500"></i>
                    Próximos Tours
                </h3>
                <div class="space-y-4">
                    @foreach($toursProximos as $tour)
                        <div class="border-l-4 border-primary-500 bg-gray-50 rounded-r-xl p-4 hover:shadow-md transition-shadow">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h4 class="font-bold text-lg text-gray-900">{{ $tour->tour->nombreTour }}</h4>
                                    <p class="text-gray-600 mt-1">
                                        <i class="far fa-calendar mr-2"></i>{{ $tour->fecha->format('d/m/Y') }}
                                        @if($tour->hora_recojo)
                                            • <i class="far fa-clock mr-2"></i>{{ $tour->hora_recojo->format('H:i') }}
                                        @endif
                                    </p>
                                </div>
                                @php
                                    $diasRestantes = Carbon::today()->diffInDays($tour->fecha, false);
                                @endphp
                                @if($diasRestantes >= 0)
                                    <span class="bg-primary-100 text-primary-700 px-3 py-1 rounded-full text-sm font-semibold">
                                        {{ $diasRestantes == 0 ? 'Hoy' : "En $diasRestantes días" }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- MIS RESERVAS --}}
        <div class="bg-white rounded-3xl shadow-lg p-8">
            <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                <i class="fas fa-suitcase text-primary-500"></i>
                Mis Reservas
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($reservas as $reserva)
                    <div class="border border-gray-200 rounded-2xl p-6 hover:shadow-xl transition-all {{ $reserva->estado == 'Cancelada' ? 'bg-red-50 border-red-300' : 'hover:border-primary-300' }}">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h4 class="font-bold text-xl text-gray-900">Reserva {{ $reserva->id }}</h4>
                                <p class="text-sm text-gray-500">{{ $reserva->fecha_llegada?->format('d M Y') }} - {{ $reserva->fecha_salida?->format('d M Y') }}</p>
                            </div>
                            @php
                                $estadoBadge = match($reserva->estado) {
                                    'Activa' => 'bg-green-500',
                                    'En espera' => 'bg-yellow-500',
                                    'Finalizada' => 'bg-gray-500',
                                    'Cancelada' => 'bg-red-500',
                                    default => 'bg-gray-500'
                                };
                            @endphp
                            <span class="{{ $estadoBadge }} text-white px-3 py-1 rounded-full text-sm font-semibold">
                                {{ $reserva->estado }}
                            </span>
                        </div>
                        <div class="space-y-2 text-sm text-gray-600 mb-4">
                            <p><i class="fas fa-users text-primary-500 w-5"></i> {{ $reserva->cantidad_pasajeros }} pasajeros</p>
                            <p><i class="fas fa-map-marked-alt text-primary-500 w-5"></i> {{ $reserva->cantidad_tours }} tours</p>
                            <p><i class="fas fa-hotel text-primary-500 w-5"></i> {{ $reserva->cantidad_estadias }} estadías</p>
                        </div>
                        <a href="{{ route('cliente.reserva.show', $reserva->id) }}" 
                           class="block w-full bg-primary-500 hover:bg-primary-600 text-white text-center py-2 rounded-lg font-semibold transition-colors">
                            Ver Detalle Completo
                        </a>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- CONTACTO --}}
        <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-3xl shadow-lg p-8 mt-8 text-white text-center">
            <i class="fab fa-whatsapp text-6xl mb-4"></i>
            <h3 class="text-2xl font-bold mb-2">¿Necesitas ayuda?</h3>
            <p class="mb-6">Estamos disponibles 24/7 para asistirte</p>
            <a href="https://wa.me/51984123456" target="_blank" 
               class="inline-block bg-white text-green-600 px-8 py-3 rounded-full font-bold hover:shadow-xl transition-all">
                Contactar por WhatsApp
            </a>
        </div>

    </div>

</body>
</html>