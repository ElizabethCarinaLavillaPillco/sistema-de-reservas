// Funciones comunes para todas las páginas
document.addEventListener('DOMContentLoaded', function() {

    // Toggle sidebar
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('mainContent');
    const sidebarToggle = document.getElementById('sidebarToggle');

    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', function(e) {
            e.stopPropagation();
            sidebar.classList.toggle('show');
            sidebar.classList.toggle('collapsed');
            if(mainContent){
                mainContent.classList.toggle('expanded');
            }
            localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('collapsed'));

            
        });
    }

    // Cargar estado del sidebar
    if (localStorage.getItem('sidebarCollapsed') === 'true' && sidebar) {
        sidebar.classList.add('collapsed');
        if(mainContent){
            mainContent.classList.add('expanded');
        }
    }

    // Notificaciones
    const notifBtn = document.getElementById('notificationBtn');
    const notifDropdown = document.getElementById('notificationDropdown');

    if (notifBtn && notifDropdown) {
        notifBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            notifDropdown.classList.toggle('show');
        });

        // Cerrar si se hace click fuera
        document.addEventListener('click', function(e) {
            if (notifDropdown && !notifDropdown.contains(e.target) && e.target !== notifBtn) {
                notifDropdown.classList.remove('show');
            }
        });
    }

    // Dropdown de usuario
    const userMenuButton = document.getElementById('userMenuButton');
    const userDropdown = document.getElementById('userDropdown');
    
    if (userMenuButton && userDropdown) {
        userMenuButton.addEventListener('click', function(e) {
            e.stopPropagation();
            userDropdown.classList.toggle('show');
        });
        
        // Cerrar dropdown al hacer clic fuera
        document.addEventListener('click', function(e) {
            if (userDropdown && !userDropdown.contains(e.target) && e.target !== userMenuButton) {
                userDropdown.classList.remove('show');
            }
        });
        // 🔥 Botón logout
        const logoutLinks = document.querySelectorAll("a.dropdown-item[href='#']");
        logoutLinks.forEach(link => {
            link.addEventListener("click", function(e) {
                e.preventDefault();
                const form = document.getElementById("logout-form");
                if (form) form.submit();
            });
        });
    }
    
    // Responsive: cerrar sidebar al hacer clic en un enlace en móviles
    if (window.innerWidth < 992) {
        const menuItems = document.querySelectorAll('.menu-item');
        menuItems.forEach(item => {
            item.addEventListener('click', function() {
                if (sidebar) sidebar.classList.remove('show');
            });
        });
    }



    // Inicializar tooltips
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
    
    // Animaciones de entrada
    const animatedElements = document.querySelectorAll('.animate-fade-in, .animate-slide-in');
    animatedElements.forEach((el, index) => {
        el.style.animationDelay = `${index * 0.1}s`;
    });

    // Efecto de filtrado con JavaScript (si es necesario)
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('keyup', function() {
            const filter = this.value.toLowerCase();
            const rows = document.querySelectorAll('#reservasTable tbody tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.indexOf(filter) > -1 ? '' : 'none';
            });
        });
    }


    // Animación de entrada para las filas
    const tableRows = document.querySelectorAll('.reserva-item');
    tableRows.forEach((row, index) => {
        row.style.opacity = '0';
        row.style.transform = 'translateY(10px)';
        
        setTimeout(() => {
            row.style.transition = 'opacity 0.5s ease, transform 0.5s ease, background-color 0.3s ease';
            row.style.opacity = '1';
            row.style.transform = 'translateY(0)';
        }, 100 + (index * 50));
    });


});

// Función para calcular saldo
function calcularSaldo(totalId, adelantoId, saldoId) {
    const totalInput = document.getElementById(totalId);
    const adelantoInput = document.getElementById(adelantoId);
    const saldoInput = document.getElementById(saldoId);
    
    function actualizarSaldo() {
        const total = parseFloat(totalInput.value) || 0;
        const adelanto = parseFloat(adelantoInput.value) || 0;
        saldoInput.value = (total - adelanto).toFixed(2);
        
        // Actualizar barra de progreso si existe
        const progressBar = document.getElementById('progress-bar-pago');
        if (progressBar && total > 0) {
            const porcentaje = (adelanto / total) * 100;
            progressBar.style.width = `${porcentaje}%`;
            document.getElementById('progress-text').textContent = `${porcentaje.toFixed(0)}%`;
        }
    }
    
    if (totalInput && adelantoInput && saldoInput) {
        totalInput.addEventListener('input', actualizarSaldo);
        adelantoInput.addEventListener('input', actualizarSaldo);
        actualizarSaldo(); // Calcular inicialmente
    }
}

// Función para mostrar/ocultar campos condicionales
function toggleCampoCondicional(selectId, campoId, valoresVisibles) {
    const select = document.getElementById(selectId);
    const campo = document.getElementById(campoId);
    
    if (select && campo) {
        function actualizarVisibilidad() {
            campo.classList.toggle('show', valoresVisibles.includes(select.value));
        }
        
        select.addEventListener('change', actualizarVisibilidad);
        actualizarVisibilidad(); // Establecer visibilidad inicial
    }
}