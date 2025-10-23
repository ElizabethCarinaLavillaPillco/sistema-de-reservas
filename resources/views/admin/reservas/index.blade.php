<?php
// =============================================================================
// 1️⃣ ARREGLAR RESERVA INDEX - resources/views/admin/reservas/index.blade.php
// =============================================================================
?>
@extends('layouts.template')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-8">
    <div class="container mx-auto px-4">
        
        {{-- HEADER --}}
        <div class="bg-white rounded-2xl shadow-lg p-6 mb-8">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h1 class="text-3xl font-bold bg-gradient-to-r from-primary-600 to-primary-800 bg-clip-text text-transparent">
                        📋 Gestión de Reservas
                    </h1>
                    <p class="text-gray-600 mt-1">Administra todas las reservas del sistema</p>
                </div>
                <a href="{{ route('admin.reservas.create') }}" 
                   class="bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700 text-white px-6 py-3 rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-300 flex items-center gap-2">
                    <i class="fas fa-plus-circle"></i>
                    Nueva Reserva
                </a>
            </div>
        </div>

        {{-- FILTROS --}}
        <div class="bg-white rounded-2xl shadow-lg p-6 mb-8">
            <form method="GET" action="{{ route('admin.reservas.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Buscar</label>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Nombre del titular..."
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Estado</label>
                    <select name="estado" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500">
                        <option value="">Todos</option>
                        <option value="En espera" {{ request('estado') == 'En espera' ? 'selected' : '' }}>En espera</option>
                        <option value="Activa" {{ request('estado') == 'Activa' ? 'selected' : '' }}>Activa</option>
                        <option value="Finalizada" {{ request('estado') == 'Finalizada' ? 'selected' : '' }}>Finalizada</option>
                        <option value="Cancelada" {{ request('estado') == 'Cancelada' ? 'selected' : '' }}>Cancelada</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Fecha Inicio</label>
                    <input type="date" name="fecha_inicio" value="{{ request('fecha_inicio') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Fecha Fin</label>
                    <input type="date" name="fecha_fin" value="{{ request('fecha_fin') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500">
                </div>

                <div class="md:col-span-4 flex gap-3">
                    <button type="submit" class="bg-primary-500 hover:bg-primary-600 text-white px-6 py-2 rounded-lg font-medium transition-colors">
                        <i class="fas fa-search mr-2"></i>Buscar
                    </button>
                    <a href="{{ route('admin.reservas.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-2 rounded-lg font-medium transition-colors">
                        <i class="fas fa-times mr-2"></i>Limpiar
                    </a>
                </div>
            </form>
        </div>

        {{-- ESTADÍSTICAS RÁPIDAS --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl shadow-lg p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-100 text-sm font-medium">Total Reservas</p>
                        <p class="text-3xl font-bold mt-2">{{ $reservas->total() }}</p>
                    </div>
                    <div class="bg-white bg-opacity-20 rounded-full p-4">
                        <i class="fas fa-clipboard-list text-3xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-2xl shadow-lg p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-100 text-sm font-medium">Activas</p>
                        <p class="text-3xl font-bold mt-2">{{ \App\Models\Reserva::where('estado', 'Activa')->count() }}</p>
                    </div>
                    <div class="bg-white bg-opacity-20 rounded-full p-4">
                        <i class="fas fa-check-circle text-3xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-2xl shadow-lg p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-yellow-100 text-sm font-medium">En Espera</p>
                        <p class="text-3xl font-bold mt-2">{{ \App\Models\Reserva::where('estado', 'En espera')->count() }}</p>
                    </div>
                    <div class="bg-white bg-opacity-20 rounded-full p-4">
                        <i class="fas fa-clock text-3xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl shadow-lg p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-purple-100 text-sm font-medium">Este Mes</p>
                        <p class="text-3xl font-bold mt-2">{{ \App\Models\Reserva::whereMonth('created_at', now()->month)->count() }}</p>
                    </div>
                    <div class="bg-white bg-opacity-20 rounded-full p-4">
                        <i class="fas fa-calendar-alt text-3xl"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- TABLA DE RESERVAS --}}
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-primary-500 to-primary-600 text-white">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Código</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Titular</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Llegada</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Pasajeros</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Total</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Estado</th>
                            <th class="px-6 py-4 text-center text-sm font-semibold">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($reservas as $reserva)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">
                                    <span class="font-bold text-primary-600">{{ $reserva->id }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 font-bold">
                                            {{ strtoupper(substr($reserva->titular->nombre ?? 'S/N', 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="font-semibold text-gray-900">{{ $reserva->titular->nombre_completo ?? 'Sin titular' }}</p>
                                            <p class="text-sm text-gray-500">{{ $reserva->titular->documento ?? '-' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @if($reserva->fecha_llegada)
                                        <div class="flex items-center gap-2">
                                            <i class="fas fa-calendar text-primary-500"></i>
                                            <span class="text-sm">{{ $reserva->fecha_llegada->format('d/m/Y') }}</span>
                                        </div>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm font-medium">
                                        <i class="fas fa-users mr-1"></i>{{ $reserva->cantidad_pasajeros ?? 0 }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div>
                                        <p class="font-bold text-gray-900">${{ number_format($reserva->total, 2) }}</p>
                                        <p class="text-xs text-gray-500">Saldo: ${{ number_format($reserva->saldo, 2) }}</p>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $badgeClass = match($reserva->estado) {
                                            'Activa' => 'bg-green-100 text-green-700',
                                            'En espera' => 'bg-yellow-100 text-yellow-700',
                                            'Finalizada' => 'bg-gray-100 text-gray-700',
                                            'Cancelada' => 'bg-red-100 text-red-700',
                                            default => 'bg-gray-100 text-gray-700'
                                        };
                                    @endphp
                                    <span class="{{ $badgeClass }} px-3 py-1 rounded-full text-sm font-medium">
                                        {{ $reserva->estado }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('admin.reservas.show', $reserva->id) }}" 
                                           class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded-lg transition-colors"
                                           title="Ver detalles">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.reservas.edit', $reserva->id) }}" 
                                           class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-2 rounded-lg transition-colors"
                                           title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.reservas.destroy', $reserva->id) }}" 
                                              method="POST" 
                                              onsubmit="return confirm('¿Eliminar esta reserva?')"
                                              class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-lg transition-colors"
                                                    title="Eliminar">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <i class="fas fa-inbox text-6xl text-gray-300 mb-4"></i>
                                        <p class="text-gray-500 text-lg">No hay reservas disponibles</p>
                                        <a href="{{ route('admin.reservas.create') }}" class="mt-4 text-primary-600 hover:text-primary-700 font-semibold">
                                            Crear primera reserva →
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- PAGINACIÓN --}}
            @if($reservas->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $reservas->links() }}
                </div>
            @endif
        </div>

    </div>
</div>
@endsection

<?php
// =============================================================================
// 2️⃣ CORREGIR CONTROLADOR - ReservaController.php (método index)
// =============================================================================
?>

public function index(Request $request)
{
    $hoy = Carbon::today();

    // Query principal con filtros
    $reservas = Reserva::with(['proveedor', 'titular', 'pasajeros', 'toursReservas']);

    // 🔍 Filtro por búsqueda (nombre del titular)
    if ($request->filled('search')) {
        $busqueda = $request->search;
        $reservas->whereHas('titular', function ($q) use ($busqueda) {
            $q->where(DB::raw("CONCAT(nombre,' ',apellido)"), 'LIKE', "%{$busqueda}%");
        });
    }

    // 🔍 Filtro por estado
    if ($request->filled('estado')) {
        $reservas->where('estado', $request->estado);
    }

    // 🔍 Filtro por rango de fechas
    if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
        $inicio = Carbon::parse($request->fecha_inicio)->startOfDay();
        $fin = Carbon::parse($request->fecha_fin)->endOfDay();

        $reservas->where(function ($q) use ($inicio, $fin) {
            $q->whereBetween('fecha_llegada', [$inicio, $fin])
              ->orWhereBetween('fecha_salida', [$inicio, $fin]);
        });
    }

    // 🔍 Filtro de entrantes
    if ($request->get('entrantes') == 1) {
        $reservas->whereDate('fecha_llegada', '>=', $hoy);
    }

    $reservas = $reservas->orderBy('created_at', 'desc')->paginate(15);

    return view('admin.reservas.index', compact('reservas'));
}

<?php
// =============================================================================
// 3️⃣ VISTA SHOW MEJORADA - resources/views/admin/reservas/show.blade.php
// =============================================================================
?>
@extends('layouts.template')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-8">
    <div class="container mx-auto px-4">
        
        {{-- HEADER CON BREADCRUMB --}}
        <div class="mb-6">
            <nav class="text-sm mb-4">
                <ol class="flex items-center space-x-2 text-gray-600">
                    <li><a href="{{ route('dashboard') }}" class="hover:text-primary-600">Dashboard</a></li>
                    <li><i class="fas fa-chevron-right text-xs"></i></li>
                    <li><a href="{{ route('admin.reservas.index') }}" class="hover:text-primary-600">Reservas</a></li>
                    <li><i class="fas fa-chevron-right text-xs"></i></li>
                    <li class="text-primary-600 font-semibold">{{ $reserva->id }}</li>
                </ol>
            </nav>

            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Reserva {{ $reserva->id }}</h1>
                    <p class="text-gray-600 mt-1">Detalles completos de la reserva</p>
                </div>
                <div class="flex gap-3">
                    @php
                        $estadoBadge = match($reserva->estado) {
                            'Activa' => 'bg-green-500',
                            'En espera' => 'bg-yellow-500',
                            'Finalizada' => 'bg-gray-500',
                            'Cancelada' => 'bg-red-500',
                            default => 'bg-gray-500'
                        };
                    @endphp
                    <span class="{{ $estadoBadge }} text-white px-6 py-2 rounded-full font-semibold text-lg">
                        {{ $reserva->estado }}
                    </span>
                    <a href="{{ route('admin.reservas.edit', $reserva->id) }}" 
                       class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-2 rounded-full font-semibold transition-all">
                        <i class="fas fa-edit mr-2"></i>Editar
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            {{-- COLUMNA PRINCIPAL --}}
            <div class="lg:col-span-2 space-y-6">
                
                {{-- INFORMACIÓN GENERAL --}}
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <i class="fas fa-info-circle text-primary-500"></i>
                        Información General
                    </h2>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Tipo de Reserva</p>
                            <p class="font-semibold text-gray-900">{{ $reserva->tipo_reserva }}</p>
                        </div>
                        @if($reserva->proveedor)
                            <div>
                                <p class="text-sm text-gray-500">Proveedor</p>
                                <p class="font-semibold text-gray-900">{{ $reserva->proveedor->nombreAgencia }}</p>
                            </div>
                        @endif
                        <div>
                            <p class="text-sm text-gray-500">Fecha Creación</p>
                            <p class="font-semibold text-gray-900">{{ $reserva->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Última Actualización</p>
                            <p class="font-semibold text-gray-900">{{ $reserva->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>

                {{-- VUELOS --}}
                @if($reserva->fecha_llegada || $reserva->fecha_salida)
                    <div class="bg-white rounded-2xl shadow-lg p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <i class="fas fa-plane text-blue-500"></i>
                            Información de Vuelos
                        </h2>
                        <div class="grid grid-cols-2 gap-6">
                            <div class="border-l-4 border-green-500 pl-4">
                                <p class="text-sm text-gray-500 mb-2">Llegada</p>
                                <p class="font-bold text-lg">{{ $reserva->fecha_llegada?->format('d/m/Y') }}</p>
                                <p class="text-sm text-gray-600">{{ $reserva->hora_llegada }}</p>
                                <p class="text-xs text-gray-500">Vuelo: {{ $reserva->nro_vuelo_llegada ?? '-' }}</p>
                            </div>
                            <div class="border-l-4 border-red-500 pl-4">
                                <p class="text-sm text-gray-500 mb-2">Salida</p>
                                <p class="font-bold text-lg">{{ $reserva->fecha_salida?->format('d/m/Y') }}</p>
                                <p class="text-sm text-gray-600">{{ $reserva->hora_salida }}</p>
                                <p class="text-xs text-gray-500">Vuelo: {{ $reserva->nro_vuelo_retorno ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- PASAJEROS --}}
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <i class="fas fa-users text-purple-500"></i>
                        Pasajeros ({{ $reserva->pasajeros->count() }})
                    </h2>
                    <div class="space-y-3">
                        @foreach($reserva->pasajeros as $pasajero)
                            <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors">
                                <div class="w-12 h-12 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 font-bold text-lg">
                                    {{ strtoupper(substr($pasajero->nombre, 0, 1)) }}
                                </div>
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-900">
                                        {{ $pasajero->nombre_completo }}
                                        @if($pasajero->id == $reserva->titular_id)
                                            <span class="ml-2 text-xs bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full">Titular</span>
                                        @endif
                                    </p>
                                    <p class="text-sm text-gray-500">{{ $pasajero->documento }} • {{ $pasajero->pais_residencia }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-medium text-gray-700">{{ $pasajero->edad }} años</p>
                                    <p class="text-xs text-gray-500">{{ $pasajero->tipo_pasajero }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- TOURS --}}
                @if($reserva->toursReservas->count() > 0)
                    <div class="bg-white rounded-2xl shadow-lg p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <i class="fas fa-route text-red-500"></i>
                            Tours Contratados ({{ $reserva->toursReservas->count() }})
                        </h2>
                        <div class="space-y-4">
                            @foreach($reserva->toursReservas as $tr)
                                <div class="border border-gray-200 rounded-xl p-4 hover:border-primary-300 transition-colors">
                                    <div class="flex justify-between items-start mb-3">
                                        <div>
                                            <h3 class="font-bold text-lg text-gray-900">{{ $tr->tour->nombreTour }}</h3>
                                            <p class="text-sm text-gray-500 mt-1">
                                                <i class="far fa-calendar mr-1"></i>{{ $tr->fecha?->format('d/m/Y') }}
                                                @if($tr->hora_recojo)
                                                    • <i class="far fa-clock mr-1"></i>{{ $tr->hora_recojo->format('H:i') }}
                                                @endif
                                            </p>
                                        </div>
                                        @php
                                            $estadoTourBadge = match($tr->estado) {
                                                'Confirmado' => 'bg-green-100 text-green-700',
                                                'Programado' => 'bg-blue-100 text-blue-700',
                                                'Cancelado' => 'bg-red-100 text-red-700',
                                                'Completado' => 'bg-gray-100 text-gray-700',
                                                default => 'bg-gray-100 text-gray-700'
                                            };
                                        @endphp
                                        <span class="{{ $estadoTourBadge }} px-3 py-1 rounded-full text-sm font-medium">
                                            {{ $tr->estado }}
                                        </span>
                                    </div>
                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 text-sm">
                                        <div>
                                            <p class="text-gray-500">Tipo</p>
                                            <p class="font-semibold">{{ $tr->tipo_tour }}</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-500">Precio Unit.</p>
                                            <p class="font-semibold">${{ number_format($tr->precio_unitario, 2) }}</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-500">Cantidad</p>
                                            <p class="font-semibold">{{ $tr->cantidad }}</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-500">Subtotal</p>
                                            <p class="font-bold text-primary-600">${{ number_format($tr->precio_unitario * $tr->cantidad, 2) }}</p>
                                        </div>
                                    </div>
                                    @if($tr->lugar_recojo)
                                        <p class="mt-3 text-sm text-gray-600">
                                            <i class="fas fa-map-marker-alt text-red-500 mr-1"></i>
                                            Recojo: {{ $tr->lugar_recojo }}
                                        </p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- ESTADÍAS --}}
                @if($reserva->estadias->count() > 0)
                    <div class="bg-white rounded-2xl shadow-lg p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <i class="fas fa-hotel text-indigo-500"></i>
                            Estadías ({{ $reserva->estadias->count() }})
                        </h2>
                        <div class="space-y-3">
                            @foreach($reserva->estadias as $estadia)
                                <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-xl">
                                    <i class="fas fa-bed text-2xl text-indigo-500"></i>
                                    <div class="flex-1">
                                        <p class="font-semibold text-gray-900">{{ $estadia->nombre_estadia }}</p>
                                        <p class="text-sm text-gray-500">{{ $estadia->ubicacion }} • {{ $estadia->fecha?->format('d/m/Y') }}</p>
                                    </div>
                                    <span class="text-xs bg-gray-200 text-gray-700 px-3 py-1 rounded-full">{{ $estadia->tipo_estadia }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

            </div>

            {{-- COLUMNA LATERAL --}}
            <div class="space-y-6">
                
                {{-- RESUMEN FINANCIERO --}}
                <div class="bg-gradient-to-br from-primary-500 to-primary-600 rounded-2xl shadow-lg p-6 text-white">
                    <h2 class="text-xl font-bold mb-6 flex items-center gap-2">
                        <i class="fas fa-dollar-sign"></i>
                        Resumen Financiero
                    </h2>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center pb-4 border-b border-white border-opacity-20">
                            <span class="text-sm opacity-90">Total</span>
                            <span class="text-2xl font-bold">${{ number_format($reserva->total, 2) }}</span>
                        </div>
                        <div class="flex justify-between items-center pb-4 border-b border-white border-opacity-20">
                            <span class="text-sm opacity-90">Adelanto</span>
                            <span class="text-xl font-semibold">${{ number_format($reserva->adelanto, 2) }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm opacity-90">Saldo Pendiente</span>
                            <span class="text-2xl font-bold">${{ number_format($reserva->saldo, 2) }}</span>
                        </div>
                    </div>
                    
                    @if($reserva->saldo > 0)
                        <div class="mt-6 bg-white bg-opacity-20 rounded-xl p-4">
                            <p class="text-sm text-center">
                                <i class="fas fa-info-circle mr-2"></i>
                                Saldo pendiente de pago
                            </p>
                        </div>
                    @else
                        <div class="mt-6 bg-green-500 bg-opacity-50 rounded-xl p-4">
                            <p class="text-sm text-center font-semibold">
                                <i class="fas fa-check-circle mr-2"></i>
                                Pago completado
                            </p>
                        </div>
                    @endif
                </div>

                {{-- DEPÓSITOS --}}
                @if($reserva->depositos->count() > 0)
                    <div class="bg-white rounded-2xl shadow-lg p-6">
                        <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <i class="fas fa-money-bill-wave text-green-500"></i>
                            Depósitos ({{ $reserva->depositos->count() }})
                        </h2>
                        <div class="space-y-3">
                            @foreach($reserva->depositos as $deposito)
                                <div class="border-l-4 border-green-500 pl-3 py-2">
                                    <p class="font-semibold text-gray-900">${{ number_format($deposito->monto, 2) }}</p>
                                    <p class="text-xs text-gray-500">{{ $deposito->nombre_depositante }}</p>
                                    <p class="text-xs text-gray-500">{{ $deposito->fecha->format('d/m/Y') }} • {{ $deposito->tipo_deposito }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- ACCIONES RÁPIDAS --}}
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">Acciones Rápidas</h2>
                    <div class="space-y-3">
                        <a href="{{ route('admin.reservas.edit', $reserva->id) }}" 
                           class="w-full bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-3 rounded-lg font-medium transition-all flex items-center justify-center gap-2">
                            <i class="fas fa-edit"></i>
                            Editar Reserva
                        </a>
                        <button onclick="window.print()" 
                                class="w-full bg-blue-500 hover:bg-blue-600 text-white px-4 py-3 rounded-lg font-medium transition-all flex items-center justify-center gap-2">
                            <i class="fas fa-print"></i>
                            Imprimir
                        </button>
                        <a href="mailto:{{ $reserva->titular->email ?? '' }}" 
                           class="w-full bg-green-500 hover:bg-green-600 text-white px-4 py-3 rounded-lg font-medium transition-all flex items-center justify-center gap-2">
                            <i class="fas fa-envelope"></i>
                            Enviar Email
                        </a>
                    </div>
                </div>

            </div>

        </div>

    </div>
</div>
@endsection