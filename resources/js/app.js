// Función para toggle del menú móvil
function toggleMobileMenu() {
    const mobileMenu = document.getElementById('mobile-menu');
    if (mobileMenu) {
        mobileMenu.classList.toggle('hidden');
    }
}

// Función para toggle del menú de tours en móvil
function toggleToursMenu() {
    const toursMenu = document.getElementById('tours-menu');
    const toursIcon = document.getElementById('tours-icon');
    
    if (toursMenu) {
        toursMenu.classList.toggle('hidden');
    }
    
    if (toursIcon) {
        toursIcon.classList.toggle('rotate-180');
    }
}

// Efecto de carga al iniciar la página
document.addEventListener('DOMContentLoaded', function() {
    const header = document.querySelector('header');
    if (header) {
        header.style.opacity = '0';
        header.style.transform = 'translateY(-20px)';
        
        setTimeout(() => {
            header.style.transition = 'all 0.8s ease-out';
            header.style.opacity = '1';
            header.style.transform = 'translateY(0)';
        }, 300);
    }
});