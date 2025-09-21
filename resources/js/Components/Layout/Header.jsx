import React, { useState, useEffect } from 'react';
import { Link } from '@inertiajs/react';

export default function Header() {
    const [isMenuOpen, setIsMenuOpen] = useState(false);
    const [isToursMenuOpen, setIsToursMenuOpen] = useState(false);
    const [isToursMachuMenuOpen, setIsToursMachuMenuOpen] = useState(false);
    const [isToursCusMenuOpen, setIsToursCusMenuOpen] = useState(false);
    const [isToursPunMenuOpen, setIsToursPunMenuOpen] = useState(false);
    const [isToursLimMenuOpen, setIsToursLimMenuOpen] = useState(false);
    const [isLoaded, setIsLoaded] = useState(false);

    // Efecto de carga al montar el componente
    useEffect(() => {
        const timer = setTimeout(() => {
            setIsLoaded(true);
        }, 300);
        return () => clearTimeout(timer);
    }, []);

    const tourMachuCategories = [
        {
            name: "Tours a Machu Picchu",
            tours: [
                "Tour Machu Picchu 1 día",
                "Machu Picchu + Huayna Picchu",
                "Machu Picchu 2 días/1 noche",
                "Camino Inca 4 días"
            ]
        }
    ];

    const tourCusCategories = [
        {
            name: "Tours en Cusco",
            tours: [
                "City Tour Cusco",
                "Valle Sagrado",
                "Montaña de 7 Colores",
                "Tour Maras y Moray"
            ]
        }
    ];

    const tourOtrosCategories = [
        {
            name: "Otros destinos",
            tours: [
                "Ica y Paracas",
                "Puno y Lago Titicaca",
                "Lima",
                "Arequipa"
            ]
        }
    ];

    const tourCategories = [
        ...tourMachuCategories,
        ...tourCusCategories,
        ...tourOtrosCategories
        ];

    return (
        <>
            {/* Top Bar - Información de contacto mejorada y responsive */}
            <div className="bg-gradient-to-r from-primary-900 to-primary-800 text-white text-sm py-3 border-b border-primary-400/30 shadow-lg">
                <div className="container mx-auto px-4">
                    {/* Versión para escritorio (lg y mayores) */}
                    <div className="hidden lg:flex flex-row justify-between items-center">
                        {/* Información de contacto - fila horizontal completa */}
                        <div className="flex items-center space-x-4">
                            <span className="flex items-center space-x-1 bg-primary-700/50 px-3 py-1 rounded-full">
                                <span className="animate-pulse">📞</span>
                                <span>+51 995 669 380</span>
                            </span>
                            <span className="flex items-center space-x-1 bg-primary-700/50 px-3 py-1 rounded-full">
                                <span>✉️</span>
                                <span>expedicionesallinkay158@gmail.com</span>
                            </span>
                            <span className="flex items-center space-x-1 bg-primary-700/50 px-3 py-1 rounded-full">
                                <span>📍</span>
                                <span>Cusco, Perú</span>
                            </span>
                        </div>
                        
                        {/* Redes sociales - con textos completos */}
                        <div className="flex items-center space-x-4">
                            <a href="#" className="hover:text-primary-200 transition transform hover:scale-105 flex items-center space-x-1 bg-primary-700/50 px-3 py-1 rounded-full">
                                <span>Facebook</span>
                            </a>
                            <a href="#" className="hover:text-primary-200 transition transform hover:scale-105 flex items-center space-x-1 bg-primary-700/50 px-3 py-1 rounded-full">
                                <span>Instagram</span>
                            </a>
                            <a href="#" className="hover:text-primary-200 transition transform hover:scale-105 flex items-center space-x-1 bg-primary-700/50 px-3 py-1 rounded-full">
                                <span>WhatsApp</span>
                            </a>
                        </div>
                    </div>
                    
                    {/* Versión para móvil (por debajo de lg) */}
                    <div className="lg:hidden flex flex-col space-y-3">
                        {/* Fila 2: Redes sociales - solo iconos */}
                        <div className="flex items-center justify-center space-x-4">
                            <a href="#" className="hover:text-primary-200 transition transform hover:scale-110 flex items-center justify-center w-10 h-10 bg-primary-700/50 rounded-full">
                                <span className="text-lg">📞</span>
                            </a>
                            <a href="#" className="hover:text-primary-200 transition transform hover:scale-110 flex items-center justify-center w-10 h-10 bg-primary-700/50 rounded-full">
                                <span className="text-lg">f</span>
                            </a>
                            <a href="#" className="hover:text-primary-200 transition transform hover:scale-110 flex items-center justify-center w-10 h-10 bg-primary-700/50 rounded-full">
                                <span className="text-lg">📷</span>
                            </a>
                            <a href="#" className="hover:text-primary-200 transition transform hover:scale-110 flex items-center justify-center w-10 h-10 bg-primary-700/50 rounded-full">
                                <span className="text-lg">💬</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>


            {/* Second Top Bar - RUC y razón social mejorada */}
            <div className="bg-gradient-to-r from-primary-800 to-primary-700 text-white text-xs py-1.5 border-b border-primary-400/30 shadow-md">
                <div className="container mx-auto px-4 text-center">
                    <span className="font-mono tracking-wider bg-primary-600/50 px-4 py-1 rounded-full inline-block">
                        RUC: 20608596861 | Razón Social: Expediciones Allinkay E.I.R.L.
                    </span>
                </div>
            </div>

            {/* Main Navigation - Header estático */}
            <header className={`sticky top-0 z-50 transition-all duration-1000 ${isLoaded ? 'translate-y-0 opacity-100' : '-translate-y-full opacity-0'}`}>
                <div className="relative container mx-auto px-4 pt-2">
                    {/* Fondo con efecto neón solo en lados y abajo */}
                    <div className="neon-border-sides-bottom animate-glow">
                        <div className="bg-white/95 backdrop-blur-sm rounded-xl p-4">
                            <div className="flex justify-between items-center">
                                {/* Logo con margen a la derecha */}
                                <Link href="/" className="flex items-center group mr-6">
                                    <div className="relative">
                                        <img 
                                            src="/images/logo.png" 
                                            alt="Expediciones Allinkay" 
                                            className="h-12 md:h-14 max-h-14 object-contain transition-transform group-hover:scale-105"
                                            onError={(e) => {
                                                e.target.src = 'https://via.placeholder.com/150x50/14b8a6/white?text=ExpedicionesAllinkay';
                                            }}
                                        />
                                    </div>
                                </Link>

                                {/* Desktop Navigation */}
                                <nav className="hidden lg:flex items-center space-x-6">
                                    <Link href="/" className="menu-item text-gray-800 hover:text-primary-600 font-medium transition transform hover:scale-105 hover:-translate-y-1">Inicio</Link>
                                    <Link href="/about" className="menu-item text-gray-800 hover:text-primary-600 font-medium transition transform hover:scale-105 hover:-translate-y-1">Nosotros</Link>
                                    
                                    {/* Tours machu - contenedor más pequeño */}
                                    <div className="dropdown relative">
                                        <button className="menu-item text-gray-800 hover:text-primary-600 font-medium transition flex items-center transform hover:scale-105 hover:-translate-y-1">
                                            Tours a Machupicchu
                                            <svg className="ml-1 w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </button>
                                        
                                        <div className="dropdown-menu absolute left-0 mt-2 w-80 bg-white/95 backdrop-blur-sm rounded-xl p-4 border-2 border-primary-300 shadow-2xl">
                                            {tourMachuCategories.map((category, index) => (
                                                <div key={index} className="transform transition-all duration-300 hover:scale-105">
                                                    <h3 className="font-bold text-primary-700 mb-3 text-lg flex items-center">
                                                        <span className="w-2 h-2 bg-primary-500 rounded-full mr-2 animate-pulse"></span>
                                                        {category.name}
                                                    </h3>
                                                    <ul className="space-y-2">
                                                        {category.tours.map((tour, tourIndex) => (
                                                            <li key={tourIndex}>
                                                                <a 
                                                                    href="#" 
                                                                    className="text-gray-600 hover:text-primary-600 text-sm transition flex items-center group/tour"
                                                                >
                                                                    <span className="w-1 h-1 bg-primary-400 rounded-full mr-2 group-hover/tour:bg-primary-500 transition-colors"></span>
                                                                    {tour}
                                                                </a>
                                                            </li>
                                                        ))}
                                                    </ul>
                                                </div>
                                            ))}
                                        </div>
                                    </div>

                                    {/* Tours cusco - contenedor más pequeño */}
                                    <div className="dropdown relative">
                                        <button className="menu-item text-gray-800 hover:text-primary-600 font-medium transition flex items-center transform hover:scale-105 hover:-translate-y-1">
                                            Tours en Cusco
                                            <svg className="ml-1 w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </button>
                                        
                                        <div className="dropdown-menu absolute left-0 mt-2 w-80 bg-white/95 backdrop-blur-sm rounded-xl p-4 border-2 border-primary-300 shadow-2xl">
                                            {tourCusCategories.map((category, index) => (
                                                <div key={index} className="transform transition-all duration-300 hover:scale-105">
                                                    <h3 className="font-bold text-primary-700 mb-3 text-lg flex items-center">
                                                        <span className="w-2 h-2 bg-primary-500 rounded-full mr-2 animate-pulse"></span>
                                                        {category.name}
                                                    </h3>
                                                    <ul className="space-y-2">
                                                        {category.tours.map((tour, tourIndex) => (
                                                            <li key={tourIndex}>
                                                                <a 
                                                                    href="#" 
                                                                    className="text-gray-600 hover:text-primary-600 text-sm transition flex items-center group/tour"
                                                                >
                                                                    <span className="w-1 h-1 bg-primary-400 rounded-full mr-2 group-hover/tour:bg-primary-500 transition-colors"></span>
                                                                    {tour}
                                                                </a>
                                                            </li>
                                                        ))}
                                                    </ul>
                                                </div>
                                            ))}
                                        </div>
                                    </div>

                                    {/* Otros destins - contenedor más pequeño */}
                                    <div className="dropdown relative">
                                        <button className="menu-item text-gray-800 hover:text-primary-600 font-medium transition flex items-center transform hover:scale-105 hover:-translate-y-1">
                                            Otros destinos
                                            <svg className="ml-1 w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </button>
                                        
                                        <div className="dropdown-menu absolute left-0 mt-2 w-80 bg-white/95 backdrop-blur-sm rounded-xl p-4 border-2 border-primary-300 shadow-2xl">
                                            {tourOtrosCategories.map((category, index) => (
                                                <div key={index} className="transform transition-all duration-300 hover:scale-105">
                                                    <h3 className="font-bold text-primary-700 mb-3 text-lg flex items-center">
                                                        <span className="w-2 h-2 bg-primary-500 rounded-full mr-2 animate-pulse"></span>
                                                        {category.name}
                                                    </h3>
                                                    <ul className="space-y-2">
                                                        {category.tours.map((tour, tourIndex) => (
                                                            <li key={tourIndex}>
                                                                <a 
                                                                    href="#" 
                                                                    className="text-gray-600 hover:text-primary-600 text-sm transition flex items-center group/tour"
                                                                >
                                                                    <span className="w-1 h-1 bg-primary-400 rounded-full mr-2 group-hover/tour:bg-primary-500 transition-colors"></span>
                                                                    {tour}
                                                                </a>
                                                            </li>
                                                        ))}
                                                    </ul>
                                                </div>
                                            ))}
                                        </div>
                                    </div>

                                    <Link href="/contact" className="menu-item text-gray-800 hover:text-primary-600 font-medium transition transform hover:scale-105 hover:-translate-y-1">Contacto</Link>
                                </nav>

                                {/* Action Buttons */}
                                <div className="hidden lg:flex items-center space-x-4">
                                    <a 
                                        href="https://wa.me/51995669380?text=Hola%20,%20me%20interesa%20reservar%20un%20tour" 
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        className="btn-glow bg-gradient-to-r from-secondary-500 to-secondary-600 text-white px-4 py-2 rounded-full hover:from-secondary-500 hover:to-secondary-500 transition-all transform hover:scale-105 shadow-lg hover:shadow-xl relative overflow-hidden group text-sm"
                                    >
                                        <span className="relative z-10 flex items-center">
                                            <span className="animate-pulse mr-2">📞</span>
                                            Reserva ya
                                        </span>
                                    </a>
                                    <Link 
                                        href="/login" 
                                        className="btn-glow bg-gradient-to-r from-primary-500 to-primary-600 text-white px-4 py-2 rounded-full hover:from-primary-500 hover:to-primary-500 transition-all transform hover:scale-105 shadow-lg hover:shadow-xl relative overflow-hidden group text-sm"
                                    >
                                        Acceder
                                    </Link>
                                </div>

                                {/* Mobile Menu Button */}
                                <button 
                                    className="lg:hidden p-2 bg-primary-100 rounded-lg hover:bg-primary-200 transition transform hover:rotate-90"
                                    onClick={() => setIsMenuOpen(!isMenuOpen)}
                                >
                                    <svg className="w-6 h-6 text-primary-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M4 6h16M4 12h16M4 18h16" />
                                    </svg>
                                </button>
                            </div>

                            {/* Mobile Navigation */}
                            {isMenuOpen && (
                                <div className="lg:hidden mt-4 animate-fade-in">
                                    <div className="flex flex-col space-y-4">
                                        <Link href="/" className="text-gray-800 hover:text-primary-600 py-2 px-4 rounded-lg hover:bg-primary-50 transition transform hover:scale-105">Inicio</Link>
                                        <Link href="/about" className="text-gray-800 hover:text-primary-600 py-2 px-4 rounded-lg hover:bg-primary-50 transition transform hover:scale-105">Nosotros</Link>
                                        
                                        <div>
                                            <button 
                                                className="text-gray-800 hover:text-primary-600 flex items-center justify-between w-full py-2 px-4 rounded-lg hover:bg-primary-50 transition transform hover:scale-105"
                                                onClick={() => setIsToursMenuOpen(!isToursMenuOpen)}
                                            >
                                                Tours
                                                <svg className={`w-4 h-4 transform transition-transform ${isToursMenuOpen ? 'rotate-180' : ''}`} fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M19 9l-7 7-7-7" />
                                                </svg>
                                            </button>
                                            
                                            {isToursMenuOpen && (
                                                <div className="pl-4 mt-2 space-y-2 animate-fade-in">
                                                    {tourCategories.map((category, index) => (
                                                        <div key={index} className="mb-4">
                                                            <h4 className="font-medium text-primary-700 mb-2 flex items-center">
                                                                <span className="w-2 h-2 bg-primary-500 rounded-full mr-2"></span>
                                                                {category.name}
                                                            </h4>
                                                            <ul className="pl-4 space-y-1">
                                                                {category.tours.slice(0, 3).map((tour, tourIndex) => (
                                                                    <li key={tourIndex}>
                                                                        <a href="#" className="text-sm text-gray-600 hover:text-primary-600 flex items-center group">
                                                                            <span className="w-1 h-1 bg-primary-400 rounded-full mr-2 group-hover:bg-primary-500 transition-colors"></span>
                                                                            {tour}
                                                                        </a>
                                                                    </li>
                                                                ))}
                                                            </ul>
                                                        </div>
                                                    ))}
                                                </div>
                                            )}
                                        </div>

                                        <Link href="/contact" className="text-gray-800 hover:text-primary-600 py-2 px-4 rounded-lg hover:bg-primary-50 transition transform hover:scale-105">Contacto</Link>
                                        
                                        <div className="pt-4 border-t border-primary-200/50 space-y-3">
                                            <a 
                                                href="https://wa.me/51995669380?text=Hola%20,%20me%20interesa%20reservar%20un%20tour" 
                                                target="_blank"
                                                rel="noopener noreferrer"
                                                className="block bg-gradient-to-r from-secondary-500 to-secondary-600 text-white px-4 py-2 rounded-full text-center hover:from-secondary-600 hover:to-secondary-700 transition-all transform hover:scale-105 shadow-lg text-sm"
                                            >
                                                <span className="flex items-center justify-center">
                                                    <span className="animate-pulse mr-2">📞</span>
                                                    Reserva ya
                                                </span>
                                            </a>
                                            <Link 
                                                href="/login" 
                                                className="block bg-gradient-to-r from-primary-600 to-primary-700 text-white px-4 py-2 rounded-full text-center hover:from-primary-700 hover:to-primary-800 transition-all transform hover:scale-105 shadow-lg text-sm"
                                            >
                                                Acceder
                                            </Link>
                                        </div>
                                    </div>
                                </div>
                            )}
                        </div>
                    </div>
                </div>
            </header>
        </>
    );
}