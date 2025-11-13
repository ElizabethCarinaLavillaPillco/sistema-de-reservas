import React from 'react';
import Header from './Header';
import Footer from './Footer';

export default function Layout({ children }) {
    return (
        <div className="min-h-screen flex flex-col">
            <Header />
            <main className="flex-grow">
                {/* Cambiamos el container por un contenedor más ancho con márgenes laterales ligeros */}
                <div className="w-full px-1 md:px-2 lg:px-4 xl:px-6 py-8 max-w-screen-2xl mx-auto">
                    {children}
                </div>
            </main>
            <Footer />
        </div>
    );
}