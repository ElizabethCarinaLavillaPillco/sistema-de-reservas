import React from 'react';
import Header from './Header';
import Footer from './Footer';

export default function Layout({ children }) {
    return (
        <div className="min-h-screen flex flex-col">
            <Header />
            <main className="flex-grow">
                <div className="container mx-auto px-4 py-8">
                    {children}
                </div>
            </main>
        </div>
    );
}