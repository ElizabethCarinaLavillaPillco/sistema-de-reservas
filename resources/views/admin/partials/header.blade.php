<!-- Header superior -->
<header class="top-header">
    <div class="logo-container">
        <button class="menu-toggle" id="sidebarToggle">
            <i class="fas fa-bars"></i>
        </button>
        <div class="logo">
            <i class="fas fa-mountain"></i>
        </div>
        <div class="brand-text">Expediciones Allinkay</div>
    </div>
    
    <div class="search-container">
        <i class="fas fa-search search-icon"></i>
        <input type="text" class="search-box" placeholder="Buscar...">
    </div>
    
    <div class="header-actions">
        <button class="notification-btn" id="notificationBtn">
            <i class="fas fa-bell"></i>
            <span class="notification-badge">3</span>
        </button>
        
        <div class="user-menu">
            <div class="user-avatar" id="userMenuButton">
                <span>AD</span>
            </div>
            
            <div class="user-dropdown" id="userDropdown">
                <div class="dropdown-header">
                    <div class="dropdown-avatar">AD</div>
                    <div class="dropdown-user-info">
                        <div class="dropdown-user-name">Admin User</div>
                        <div class="dropdown-user-role">Administrador</div>
                    </div>
                </div>
                
                <ul class="dropdown-menu">
                    <li>
                        <a href="{{ route('admin.usuarios.index') }}" class="dropdown-item">
                            <i class="fas fa-cog"></i>
                            <span>Ajustes</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.usuarios.index') }}#activity-log" class="dropdown-item">
                            <i class="fas fa-history"></i>
                            <span>Activity Log</span>
                        </a>
                    </li>
                    <li class="dropdown-divider"></li>
                    <li>
                        <a href="#" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Salir</span>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>

<div class="notification-dropdown" id="notificationDropdown">
    <div class="dropdown-header">
        <strong>Próximas llegadas</strong>
    </div>
    <ul class="notification-list">
        @forelse($notificaciones as $reserva)
            <li>
                <a href="{{ route('admin.reservas.show', $reserva->id) }}">
                    <div class="notif-title">
                        {{ $reserva->titular->nombre ?? 'N/A' }} {{ $reserva->titular->apellido ?? '' }}
                    </div>
                    <div class="notif-meta">
                        <i class="fas fa-plane"></i> 
                        {{ \Carbon\Carbon::parse($reserva->fecha_llegada)->format('d M Y') }}
                        - Vuelo {{ $reserva->nro_vuelo_llegada ?? 'N/A' }}
                    </div>
                </a>
            </li>
        @empty
            <li class="empty">
                <span>No hay llegadas en la próxima semana</span>
            </li>
        @endforelse
    </ul>
</div>