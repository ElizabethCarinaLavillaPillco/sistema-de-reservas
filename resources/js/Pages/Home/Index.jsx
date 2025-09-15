import React from 'react';
import { Head, Link } from '@inertiajs/react';
import Layout from '../../Components/Layout/Layout';
import Hero from '../../Components/Sections/Hero';
import TourGrid from '../../Components/Sections/TourGrid';

export default function Home({ tours }) {
    return (
        <Layout>
            <Head title="Inicio - Turismo Adventures" />
            
            <Hero />
            
            <section className="py-16 bg-gray-50">
                <div className="container mx-auto px-4">
                    <div className="text-center mb-12">
                        <h2 className="text-3xl font-bold text-gray-800 mb-4">
                            Tours Populares
                        </h2>
                        <p className="text-gray-600 max-w-2xl mx-auto">
                            Descubre nuestros destinos más solicitados por los viajeros
                        </p>
                    </div>
                    
                    <TourGrid tours={tours} />
                    
                    <div className="text-center mt-12">
                        <Link 
                            href="/tours" 
                            className="inline-block bg-primary text-white px-6 py-3 rounded-lg hover:bg-primary-dark transition"
                        >
                            Ver Todos los Tours
                        </Link>
                    </div>
                </div>
            </section>
            
            {/* Más secciones... */}
        </Layout>
    );
}