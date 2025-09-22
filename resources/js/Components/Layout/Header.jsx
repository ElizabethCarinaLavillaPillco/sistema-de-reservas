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
                            {/* Facebook */}
                            <a href="#" className="relative group">
                                <div className="absolute -inset-0.5 bg-gradient-to-r from-blue-500 to-blue-600 rounded-full blur opacity-0 group-hover:opacity-75 transition duration-300"></div>
                                <div className="relative bg-primary-700/50 backdrop-blur-sm rounded-full px-4 py-2 flex items-center space-x-2 transition-transform group-hover:scale-105">
                                    <svg className="w-4 h-4 text-blue-400" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24,12.073z"/>
                                    </svg>
                                    <span className="text-white">Facebook</span>
                                </div>
                            </a>
                            
                            {/* Instagram */}
                            <a href="#" className="relative group">
                                <div className="absolute -inset-0.5 bg-gradient-to-r from-pink-500 to-purple-600 rounded-full blur opacity-0 group-hover:opacity-75 transition duration-300"></div>
                                <div className="relative bg-primary-700/50 backdrop-blur-sm rounded-full px-4 py-2 flex items-center space-x-2 transition-transform group-hover:scale-105">
                                    <svg className="w-4 h-4 text-pink-400" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zM5.838 12a6.162 6.162 0 1112.324 0 6.162 6.162 0 01-12.324 0zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/>
                                    </svg>
                                    <span className="text-white">Instagram</span>
                                </div>
                            </a>
                            
                            {/* TikTok */}
                            <a href="#" className="relative group">
                                <div className="absolute -inset-0.5 bg-gradient-to-r from-black to-gray-800 rounded-full blur opacity-0 group-hover:opacity-75 transition duration-300"></div>
                                <div className="relative bg-primary-700/50 backdrop-blur-sm rounded-full px-4 py-2 flex items-center space-x-2 transition-transform group-hover:scale-105">
                                    <svg className="w-4 h-4 text-black" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.67-3.92 9.6 9.6 0 0 0-.15-1.8V8.48a8.23 8.23 0 0 0 4.23 1.2 8.2 8.2 0 0 0 1.55-.15V6.69z"/>
                                    </svg>
                                    <span className="text-white">TikTok</span>
                                </div>
                            </a>

                            {/* WhatsApp */}
                            <a href="#" className="relative group">
                                <div className="absolute -inset-0.5 bg-gradient-to-r from-green-500 to-green-600 rounded-full blur opacity-0 group-hover:opacity-75 transition duration-300"></div>
                                <div className="relative bg-primary-700/50 backdrop-blur-sm rounded-full px-4 py-2 flex items-center space-x-2 transition-transform group-hover:scale-105">
                                    <svg className="w-4 h-4 text-green-400" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413"/>
                                    </svg>
                                    <span className="text-white">WhatsApp</span>
                                </div>
                            </a>
                        </div>
                    </div>
                    
                    {/* Versión para móvil (por debajo de lg) */}
                    <div className="lg:hidden flex flex-col space-y-3">
                        {/* Fila 2: Redes sociales - solo logos */}
                        <div className="flex items-center justify-center space-x-4">
                            {/* Facebook */}
                            <a href="#" className="relative group">
                                <div className="absolute -inset-0.5 bg-gradient-to-r from-blue-500 to-blue-600 rounded-full blur opacity-0 group-hover:opacity-75 transition duration-300"></div>
                                <div className="relative bg-primary-700/50 backdrop-blur-sm rounded-full w-10 h-10 flex items-center justify-center transition-transform group-hover:scale-110">
                                    <svg className="w-5 h-5 text-blue-400" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24,12.073z"/>
                                    </svg>
                                </div>
                            </a>
                            
                            {/* Instagram */}
                            <a href="#" className="relative group">
                                <div className="absolute -inset-0.5 bg-gradient-to-r from-pink-500 to-purple-600 rounded-full blur opacity-0 group-hover:opacity-75 transition duration-300"></div>
                                <div className="relative bg-primary-700/50 backdrop-blur-sm rounded-full w-10 h-10 flex items-center justify-center transition-transform group-hover:scale-110">
                                    <svg className="w-5 h-5 text-pink-400" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zM5.838 12a6.162 6.162 0 1112.324 0 6.162 6.162 0 01-12.324 0zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/>
                                    </svg>
                                </div>
                            </a>

                            {/* TikTok */}
                            <a href="#" className="relative group">
                                <div className="absolute -inset-0.5 bg-gradient-to-r from-black to-gray-800 rounded-full blur opacity-0 group-hover:opacity-75 transition duration-300"></div>
                                <div className="relative bg-primary-700/50 backdrop-blur-sm rounded-full w-10 h-10 flex items-center justify-center transition-transform group-hover:scale-110">
                                    <svg className="w-5 h-5 text-black" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.67-3.92 9.6 9.6 0 0 0-.15-1.8V8.48a8.23 8.23 0 0 0 4.23 1.2 8.2 8.2 0 0 0 1.55-.15V6.69z"/>
                                    </svg>
                                </div>
                            </a>
                            
                            {/* WhatsApp */}
                            <a href="#" className="relative group">
                                <div className="absolute -inset-0.5 bg-gradient-to-r from-green-500 to-green-600 rounded-full blur opacity-0 group-hover:opacity-75 transition duration-300"></div>
                                <div className="relative bg-primary-700/50 backdrop-blur-sm rounded-full w-10 h-10 flex items-center justify-center transition-transform group-hover:scale-110">
                                    <svg className="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413"/>
                                    </svg>
                                </div>
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
                                    <a 
                                        href="/login" 
                                        onClick={(e) => {
                                            e.preventDefault();
                                            window.location.href = '/login'; // Navegación normal
                                        }}
                                        className="bg-primary-600 text-white px-6 py-2 rounded-full hover:bg-primary-700 transition"
                                    >
                                        Acceder al Sistema
                                    </a>
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
                                                target="_blank"
                                                onClick={(e) => {
                                                    e.preventDefault();
                                                    window.location.href = '/login'; // Navegación normal
                                                }}
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