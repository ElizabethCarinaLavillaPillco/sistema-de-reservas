import React from 'react';
import { Head } from '@inertiajs/react';
import Layout from '../../Components/Layout/Layout';

export default function Home() {
    return (
        <Layout>
            <Head title="Inicio - Expediciones Allinkay" />
            
            {/* Hero Section */}
            <section className="bg-gradient-to-r from-primary-500 to-primary-700 text-white py-20">
                <div className="container mx-auto px-4 text-center">
                    <h1 className="text-4xl md:text-6xl font-bold mb-6 animate-fade-in">
                        Descubre la Magia del Perú
                    </h1>
                    <p className="text-xl md:text-2xl mb-8 max-w-3xl mx-auto animate-fade-in animation-delay-200">
                        Experiencias únicas que quedarán para siempre en tu memoria
                    </p>
                    <div className="animate-fade-in animation-delay-400">
                        <a 
                            href="https://wa.me/51995669380?text=Hola,%20me%20interesa%20reservar%20un%20tour" 
                            target="_blank"
                            rel="noopener noreferrer"
                            className="bg-secondary-500 hover:bg-secondary-600 text-white px-8 py-4 rounded-full text-lg font-semibold transition shadow-2xl hover:shadow-3xl inline-block"
                        >
                            🎯 Reserva Tu Aventura Ahora
                        </a>
                    </div>
                </div>
            </section>

            {/* Más secciones irían aquí */}
            
        </Layout>
    );
}