import React, { useState } from 'react';
import { Link } from '@inertiajs/react';

export default function Header() {
    const [isMenuOpen, setIsMenuOpen] = useState(false);
    const [isToursMenuOpen, setIsToursMenuOpen] = useState(false);

    const tourCategories = [
        {
            name: "Tours a Machu Picchu",
            tours: [
                "Tour Machu Picchu 1 día",
                "Machu Picchu + Huayna Picchu",
                "Machu Picchu 2 días/1 noche",
                "Camino Inca 4 días"
            ]
        },
        {
            name: "Tours en Cusco",
            tours: [
                "City Tour Cusco",
                "Valle Sagrado",
                "Montaña de 7 Colores",
                "Tour Maras y Moray"
            ]
        },
        {
            name: "Tours en Puno",
            tours: [
                "Islas Uros",
                "Isla Taquile",
                "Lago Titicaca Completo",
                "Sillustani"
            ]
        },
        {
            name: "Tours en Lima",
            tours: [
                "City Tour Lima",
                "Tour Gastronómico",
                "Paracas e Ica",
                "Lunahuaná"
            ]
        },
        {
            name: "Tours en Arequipa",
            tours: [
                "City Tour Arequipa",
                "Cañón del Colca",
                "Volcán Misti",
                "Ruta del Sillar"
            ]
        }
    ];

    return (
        <>
            {/* Top Bar - Información de contacto */}
            <div className="bg-gray-800 text-white text-sm py-2">
                <div className="container mx-auto px-4 flex flex-col md:flex-row justify-between items-center">
                    <div className="flex items-center space-x-4 mb-2 md:mb-0">
                        <span>📞 +51 123 456 789</span>
                        <span>✉️ info@turisticos.com</span>
                        <span>📍 Cusco, Perú</span>
                    </div>
                    <div className="flex items-center space-x-4">
                        <a href="#" className="hover:text-primary-300 transition">Facebook</a>
                        <a href="#" className="hover:text-primary-300 transition">Instagram</a>
                        <a href="#" className="hover:text-primary-300 transition">WhatsApp</a>
                    </div>
                </div>
            </div>

            {/* Second Top Bar - RUC y razón social */}
            <div className="bg-primary-800 text-white text-xs py-1">
                <div className="container mx-auto px-4 text-center">
                    <span>RUC: 20123456789 | Razón Social: TURISMO ADVENTURES SAC</span>
                </div>
            </div>

            {/* Main Navigation */}
            <header className="bg-white shadow-lg sticky top-0 z-50">
                <div className="container mx-auto px-4">
                    <div className="flex justify-between items-center py-4">
                        {/* Logo */}
                        <Link href="/" className="flex items-center">
                            <img 
                                src="/images/logo.png" 
                                alt="Turismo Adventures" 
                                className="h-10 md:h-12 max-h-12 object-contain" 
                                onError={(e) => {
                                    e.target.src = 'https://via.placeholder.com/150x50/14b8a6/white?text=Turismo+Adventures';
                                }}
                            />
                        </Link>

                        {/* Desktop Navigation */}
                        <nav className="hidden lg:flex items-center space-x-8">
                            <Link href="/" className="text-gray-700 hover:text-primary-600 font-medium transition">Inicio</Link>
                            <Link href="/about" className="text-gray-700 hover:text-primary-600 font-medium transition">Nosotros</Link>
                            
                            {/* Tours Dropdown */}
                            <div 
                                className="relative group"
                                onMouseEnter={() => setIsToursMenuOpen(true)}
                                onMouseLeave={() => setIsToursMenuOpen(false)}
                            >
                                <button className="text-gray-700 hover:text-primary-600 font-medium transition flex items-center">
                                    Tours
                                    <svg className="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                                
                                {/* Mega Menu */}
                                {isToursMenuOpen && (
                                    <div className="absolute left-0 mt-2 w-screen max-w-6xl bg-white shadow-2xl rounded-lg p-6 grid grid-cols-5 gap-6">
                                        {tourCategories.map((category, index) => (
                                            <div key={index}>
                                                <h3 className="font-bold text-primary-700 mb-3">{category.name}</h3>
                                                <ul className="space-y-2">
                                                    {category.tours.map((tour, tourIndex) => (
                                                        <li key={tourIndex}>
                                                            <a href="#" className="text-gray-600 hover:text-primary-600 text-sm transition">
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

                            <Link href="/contact" className="text-gray-700 hover:text-primary-600 font-medium transition">Contacto</Link>
                        </nav>

                        {/* Action Buttons */}
                        <div className="hidden lg:flex items-center space-x-4">
                            <a 
                                href="https://wa.me/51123456789?text=Hola,%20me%20interesa%20reservar%20un%20tour" 
                                target="_blank"
                                rel="noopener noreferrer"
                                className="bg-secondary-500 text-white px-6 py-2 rounded-full hover:bg-secondary-600 transition shadow-md hover:shadow-lg"
                            >
                                📞 Reservar Ahora
                            </a>
                            <Link 
                                href="/login" 
                                className="bg-primary-600 text-white px-6 py-2 rounded-full hover:bg-primary-700 transition"
                            >
                                Acceder al Sistema
                            </Link>
                        </div>

                        {/* Mobile Menu Button */}
                        <button 
                            className="lg:hidden p-2"
                            onClick={() => setIsMenuOpen(!isMenuOpen)}
                        >
                            <svg className="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    </div>

                    {/* Mobile Navigation */}
                    {isMenuOpen && (
                        <div className="lg:hidden py-4 border-t">
                            <div className="flex flex-col space-y-4">
                                <Link href="/" className="text-gray-700 hover:text-primary-600">Inicio</Link>
                                <Link href="/about" className="text-gray-700 hover:text-primary-600">Nosotros</Link>
                                
                                <div>
                                    <button 
                                        className="text-gray-700 hover:text-primary-600 flex items-center justify-between w-full"
                                        onClick={() => setIsToursMenuOpen(!isToursMenuOpen)}
                                    >
                                        Tours
                                        <svg className={`w-4 h-4 transform ${isToursMenuOpen ? 'rotate-180' : ''}`} fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </button>
                                    
                                    {isToursMenuOpen && (
                                        <div className="pl-4 mt-2 space-y-2">
                                            {tourCategories.map((category, index) => (
                                                <div key={index}>
                                                    <h4 className="font-medium text-primary-700 mb-2">{category.name}</h4>
                                                    <ul className="pl-4 space-y-1 mb-3">
                                                        {category.tours.slice(0, 3).map((tour, tourIndex) => (
                                                            <li key={tourIndex}>
                                                                <a href="#" className="text-sm text-gray-600 hover:text-primary-600">
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

                                <Link href="/contact" className="text-gray-700 hover:text-primary-600">Contacto</Link>
                                
                                <div className="pt-4 border-t space-y-3">
                                    <a 
                                        href="https://wa.me/51123456789?text=Hola,%20me%20interesa%20reservar%20un%20tour" 
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        className="block bg-secondary-500 text-white px-6 py-2 rounded-full text-center hover:bg-secondary-600 transition"
                                    >
                                        📞 Reservar Ahora
                                    </a>
                                    <Link 
                                        href="/login" 
                                        className="block bg-primary-600 text-white px-6 py-2 rounded-full text-center hover:bg-primary-700 transition"
                                    >
                                        Acceder al Sistema
                                    </Link>
                                </div>
                            </div>
                        </div>
                    )}
                </div>
            </header>
        </>
    );
}