import { router } from '@inertiajs/react'

// Configurar Inertia para que no intercepte ciertos enlaces
const originalVisit = router.visit;

router.visit = function (url, options = {}) {
    // Si el enlace es para el sistema admin, usar navegación normal
    if (url.startsWith('/login') || 
        url.startsWith('/dashboard') || 
        url.startsWith('/admin') ||
        url.startsWith('/logout') ||
        url === '/login-debug') {
        window.location.href = url;
        return;
    }
    
    // Para otras rutas, usar el comportamiento normal de Inertia
    return originalVisit.call(router, url, options);
}

// También podemos prevenir que Inertia intercepte enlaces específicos
document.addEventListener('click', (event) => {
    const link = event.target.closest('a');
    
    if (!link) return;
    
    const href = link.getAttribute('href');
    
    // Si es un enlace externo o para el sistema admin, no dejar que Inertia lo maneje
    if (href && (
        href.startsWith('http') ||
        href.startsWith('/login') ||
        href.startsWith('/dashboard') ||
        href.startsWith('/admin') ||
        href.startsWith('/logout') ||
        href === '/login-debug'
    )) {
        // Permitir navegación normal
        return;
    }
}, true);