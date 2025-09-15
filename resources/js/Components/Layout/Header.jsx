import React from 'react';
import { Link } from '@inertiajs/react';

export default function Header() {
    return (
        <header className="bg-white shadow-sm sticky top-0 z-50">
            <div className="container mx-auto px-4 py-4 flex justify-between items-center">
                <Link href="/" className="text-2xl font-bold text-primary">
                    Turismo Adventures
                </Link>
                
                <nav className="hidden md:flex space-x-8">
                    <Link href="/" className="text-gray-700 hover:text-primary transition">Inicio</Link>
                    <Link href="/tours" className="text-gray-700 hover:text-primary transition">Tours</Link>
                    <Link href="/about" className="text-gray-700 hover:text-primary transition">Nosotros</Link>
                    <Link href="/contact" className="text-gray-700 hover:text-primary transition">Contacto</Link>
                </nav>
                
                <div className="flex items-center space-x-4">
                    <Link 
                        href="/login" 
                        className="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary-dark transition"
                    >
                        Sistema de Gestión
                    </Link>
                </div>
            </div>
        </header>
    );
}