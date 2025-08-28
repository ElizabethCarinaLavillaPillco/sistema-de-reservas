<!-- Sidebar -->
<aside class="sidebar" id="sidebar">
    <nav class="sidebar-menu">
        <div class="menu-section">
            <div class="menu-title"><span>Principal</span></div>
            <a href="{{ route('dashboard') }}" class="menu-item {{ Request::is('dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt"></i>
                <span class="menu-text">Dashboard</span>
            </a>
        </div>
        
        <div class="menu-section">
            <div class="menu-title"><span>Gestión</span></div>
            <a href="{{ route('admin.reservas.index') }}" class="menu-item {{ Request::is('admin/reservas*') ? 'active' : '' }}">
                <i class="fas fa-calendar-check"></i>
                <span class="menu-text">Reservas</span>
                <span class="badge badge-primary">5</span>
            </a>
            <a href="{{ route('admin.pasajeros.index') }}" class="menu-item {{ Request::is('admin/pasajeros*') ? 'active' : '' }}">
                <i class="fas fa-users"></i>
                <span class="menu-text">Pasajeros</span>
            </a>
            <a href="{{ route('admin.tours.index') }}" class="menu-item {{ Request::is('admin/tours*') ? 'active' : '' }}">
                <i class="fas fa-route"></i>
                <span class="menu-text">Tours</span>
            </a>
            <a href="{{ route('admin.proveedores.index') }}" class="menu-item {{ Request::is('admin/proveedores*') ? 'active' : '' }}">
                <i class="fas fa-truck"></i>
                <span class="menu-text">Proveedores</span>
            </a>
        </div>
        
        <div class="menu-section">
            <div class="menu-title"><span>Finanzas</span></div>
            <a href="{{ route('admin.depositos.index') }}" class="menu-item {{ Request::is('admin/depositos*') ? 'active' : '' }}">
                <i class="fas fa-money-bill-wave"></i>
                <span class="menu-text">Depositos</span>
            </a>
            <a href="{{ route('admin.facturacion.index') }}" class="menu-item {{ Request::is('admin/facturacion*') ? 'active' : '' }}">
                <i class="fas fa-file-invoice-dollar"></i>
                <span class="menu-text">Facturación Emitida</span>
            </a>
            <a href="{{ route('admin.facturas.index') }}" class="menu-item {{ Request::is('admin/facturas*') ? 'active' : '' }}">
                <i class="fas fa-file-invoice"></i>
                <span class="menu-text">Facturas Recibidas</span>
            </a>
            <a href="{{ route('admin.contabilidad.index') }}" class="menu-item {{ Request::is('admin/contabilidad*') ? 'active' : '' }}">
                <i class="fas fa-calculator"></i>
                <span class="menu-text">Pagos Contadora</span>
            </a>
        </div>
    </nav>
</aside>