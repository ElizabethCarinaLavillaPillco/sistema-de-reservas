import React from 'react';
import { Link } from '@inertiajs/react';

export default function TourCard({ tour }) {
    return (
        <div className="bg-white rounded-xl shadow-lg overflow-hidden hover-lift transition-all duration-300">
            <div className="relative">
                <img 
                    src={tour.imagen} 
                    alt={tour.nombre} 
                    className="w-full h-56 object-cover"
                />
                <div className="absolute top-4 right-4 bg-primary-600 text-white px-3 py-1 rounded-full text-sm font-bold">
                    {tour.precio}
                </div>
            </div>
            <div className="p-6">
                <h3 className="font-bold text-xl mb-2 text-gray-800">{tour.nombre}</h3>
                <p className="text-gray-600 mb-4">{tour.descripcion}</p>
                <div className="flex justify-between items-center">
                    <div className="flex text-yellow-400">
                        {'★'.repeat(tour.calificacion)}
                        {'☆'.repeat(5 - tour.calificacion)}
                    </div>
                    <Link 
                        href={`/tours/${tour.id}`} 
                        className="text-primary-600 hover:text-primary-800 font-medium flex items-center"
                    >
                        Ver más
                        <svg className="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 5l7 7-7 7" />
                        </svg>
                    </Link>
                </div>
            </div>
        </div>
    );
}