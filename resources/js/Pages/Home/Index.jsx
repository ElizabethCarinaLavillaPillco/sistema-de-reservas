import React, { useState, useEffect } from 'react';
import { Head, Link } from '@inertiajs/react';
import Layout from '../../Components/Layout/Layout';
import { useCarousel } from '../../hooks/useCarousel';

// Componente para el contador animado
const Counter = ({ end, duration = 3, suffix = '' }) => {
    const [count, setCount] = useState(0);
    
    useEffect(() => {
        let startTime;
        let animationId;
        
        const animateCount = (timestamp) => {
            if (!startTime) startTime = timestamp;
            const progress = Math.min((timestamp - startTime) / (duration * 1000), 1);
            setCount(Math.floor(progress * end));
            
            if (progress < 1) {
                animationId = requestAnimationFrame(animateCount);
            }
        };
        
        animationId = requestAnimationFrame(animateCount);
        
        return () => cancelAnimationFrame(animationId);
    }, [end, duration]);
    
    return <span>{count}{suffix}</span>;
};
const TourCard = ({ tour, index }) => {
    return (
        <div className={`bg-white rounded-2xl shadow-lg overflow-hidden transform transition-all duration-500 hover:scale-105 hover:shadow-2xl border-2 border-primary-100 animate-fade-in animation-delay-${index * 100}`}>
            {/* Imagen del tour */}
            <div className="relative h-48 overflow-hidden">
                <img 
                    src={tour.image} 
                    alt={tour.title} 
                    className="w-full h-full object-cover transition-transform duration-700 hover:scale-110"
                />
                <div className="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
                <div className="absolute bottom-4 left-4 right-4">
                    <span className="inline-block bg-primary-500 text-white text-xs px-2 py-1 rounded-full mb-2">
                        {tour.category}
                    </span>
                    <h3 className="text-white text-xl font-bold">{tour.title}</h3>
                </div>
            </div>
            
            {/* Contenido de la tarjeta */}
            <div className="p-6">
                <p className="text-gray-600 mb-4 line-clamp-2">{tour.description}</p>
                
                {/* Características del tour */}
                <div className="flex items-center justify-between mb-4 text-sm text-gray-500">
                    <div className="flex items-center">
                        <svg className="w-4 h-4 mr-1 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{tour.duration}</span>
                    </div>
                    <div className="flex items-center">
                        <svg className="w-4 h-4 mr-1 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span>{tour.location}</span>
                    </div>
                </div>
                
                {/* Precio y botón */}
                <div className="flex items-center justify-between">
                    <div>
                        <span className="text-sm text-gray-500">Desde</span>
                        <div className="text-xl font-bold text-primary-600">{tour.price}</div>
                    </div>
                    <a 
                        href={tour.bookingLink}
                        className="bg-gradient-to-r from-primary-500 to-primary-600 text-white px-4 py-2 rounded-full text-sm font-medium transition transform hover:scale-105 hover:shadow-lg relative overflow-hidden group"
                    >
                        <span className="relative z-10">Reservar</span>
                        <div className="absolute inset-0 bg-gradient-to-r from-secondary-500 to-secondary-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </a>
                </div>
            </div>
        </div>
    );
};
const TrekkingCard = ({ tour, index }) => {
    return (
        <div className={`bg-white rounded-2xl shadow-lg overflow-hidden transform transition-all duration-500 hover:scale-105 hover:shadow-2xl border-2 border-primary-100 animate-fade-in animation-delay-${index * 100}`}>
            {/* Imagen del tour */}
            <div className="relative h-56 overflow-hidden">
                <img 
                    src={tour.image} 
                    alt={tour.title} 
                    className="w-full h-full object-cover transition-transform duration-700 hover:scale-110"
                />
                <div className="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
                <div className="absolute top-4 right-4">
                    <span className={`inline-block px-3 py-1 rounded-full text-xs font-bold ${
                        tour.difficulty === 'Fácil' ? 'bg-green-500' : 
                        tour.difficulty === 'Moderado' ? 'bg-yellow-500' : 'bg-red-500'
                    } text-white`}>
                        {tour.difficulty}
                    </span>
                </div>
                <div className="absolute bottom-4 left-4 right-4">
                    <h3 className="text-white text-xl font-bold">{tour.title}</h3>
                </div>
            </div>
            
            {/* Contenido de la tarjeta */}
            <div className="p-6">
                <p className="text-gray-600 mb-4 line-clamp-2">{tour.description}</p>
                
                {/* Características del trekking */}
                <div className="space-y-2 mb-4">
                    <div className="flex items-center text-sm text-gray-500">
                        <svg className="w-4 h-4 mr-2 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Duración: {tour.duration}</span>
                    </div>
                    <div className="flex items-center text-sm text-gray-500">
                        <svg className="w-4 h-4 mr-2 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                        <span>Distancia: {tour.distance}</span>
                    </div>
                    <div className="flex items-center text-sm text-gray-500">
                        <svg className="w-4 h-4 mr-2 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span>Altitud máxima: {tour.altitude}</span>
                    </div>
                </div>
                
                {/* Precio y botón */}
                <div className="flex items-center justify-between">
                    <div>
                        <span className="text-sm text-gray-500">Desde</span>
                        <div className="text-xl font-bold text-primary-600">{tour.price}</div>
                    </div>
                    <a 
                        href={tour.bookingLink}
                        className="bg-gradient-to-r from-primary-500 to-primary-600 text-white px-4 py-2 rounded-full text-sm font-medium transition transform hover:scale-105 hover:shadow-lg relative overflow-hidden group"
                    >
                        <span className="relative z-10">Reservar</span>
                        <div className="absolute inset-0 bg-gradient-to-r from-secondary-500 to-secondary-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </a>
                </div>
            </div>
        </div>
    );
};
const ExperienceCard = ({ experience, index }) => {
    return (
        <div className={`group relative overflow-hidden rounded-2xl shadow-xl transform transition-all duration-500 hover:scale-105 hover:shadow-2xl animate-fade-in animation-delay-${index * 100}`}>
            {/* Imagen de fondo */}
            <div className="relative h-80 overflow-hidden">
                <img 
                    src={experience.image} 
                    alt={experience.title} 
                    className="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                />
                <div className="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
                
                {/* Contenido superpuesto */}
                <div className="absolute inset-0 flex flex-col justify-between p-6">
                    {/* Título */}
                    <div>
                        <div className="inline-block bg-white/20 backdrop-blur-sm px-3 py-1 rounded-full mb-3">
                            <span className="text-white text-sm font-medium">{experience.category}</span>
                        </div>
                        <h3 className="text-2xl md:text-3xl font-bold text-white">{experience.title}</h3>
                    </div>
                    
                    {/* Descripción y botón */}
                    <div className="transform transition-transform duration-500 translate-y-4 group-hover:translate-y-0 opacity-0 group-hover:opacity-100">
                        <p className="text-white/90 mb-4 line-clamp-2">{experience.description}</p>
                        <Link 
                            href={experience.link}
                            className="inline-flex items-center bg-white text-primary-700 px-4 py-2 rounded-full font-medium transition transform hover:scale-105 hover:shadow-lg"
                        >
                            <span>Explorar</span>
                            <svg className="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    );
};
const DestinationCard = ({ destination, index }) => {
    return (
        <div className={`group relative overflow-hidden rounded-2xl shadow-xl transform transition-all duration-700 hover:scale-105 hover:shadow-2xl animate-fade-in animation-delay-${index * 150}`}>
            {/* Imagen de fondo con efecto parallax */}
            <div className="relative h-80 overflow-hidden">
                <div className="absolute inset-0 bg-gradient-to-br from-primary-900/50 to-secondary-900/50 z-10"></div>
                <img 
                    src={destination.image} 
                    alt={destination.title} 
                    className="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110"
                />
                
                {/* Partículas animadas */}
                <div className="absolute inset-0 z-0">
                    {[...Array(6)].map((_, i) => (
                        <div 
                            key={i}
                            className="absolute w-2 h-2 bg-white/20 rounded-full animate-pulse"
                            style={{
                                top: `${Math.random() * 100}%`,
                                left: `${Math.random() * 100}%`,
                                animationDelay: `${Math.random() * 2}s`,
                                animationDuration: `${2 + Math.random() * 2}s`
                            }}
                        ></div>
                    ))}
                </div>
                
                {/* Contenido superpuesto */}
                <div className="absolute inset-0 flex flex-col justify-between p-6 z-20">
                    {/* Título e icono */}
                    <div className="flex items-start justify-between">
                        <div>
                            <div className="inline-flex items-center bg-white/20 backdrop-blur-sm px-3 py-1 rounded-full mb-3">
                                <destination.icon className="w-4 h-4 mr-2 text-secondary-300" />
                                <span className="text-white text-sm font-medium">{destination.region}</span>
                            </div>
                            <h3 className="text-2xl md:text-3xl font-bold text-white">{destination.title}</h3>
                        </div>
                        <div className="transform transition-transform duration-500 group-hover:rotate-12">
                            <svg className="w-8 h-8 text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                    </div>
                    
                    {/* Descripción y estadísticas */}
                    <div className="transform transition-all duration-500 translate-y-8 group-hover:translate-y-0 opacity-80 group-hover:opacity-100">
                        <p className="text-white/90 mb-4 line-clamp-2">{destination.description}</p>
                        
                        {/* Estadísticas */}
                        <div className="grid grid-cols-3 gap-2 mb-4">
                            <div className="text-center">
                                <div className="text-lg font-bold text-secondary-300">{destination.tours}</div>
                                <div className="text-xs text-white/70">Tours</div>
                            </div>
                            <div className="text-center">
                                <div className="text-lg font-bold text-secondary-300">{destination.days}</div>
                                <div className="text-xs text-white/70">Días</div>
                            </div>
                            <div className="text-center">
                                <div className="text-lg font-bold text-secondary-300">{destination.rating}</div>
                                <div className="text-xs text-white/70">Rating</div>
                            </div>
                        </div>
                        
                        {/* Botón */}
                        <Link 
                            href={destination.link}
                            className="w-full bg-gradient-to-r from-secondary-500 to-secondary-600 text-white px-4 py-2 rounded-full text-center font-medium transition transform hover:scale-105 hover:shadow-lg relative overflow-hidden group"
                        >
                            <span className="relative z-10">Descubrir {destination.title}</span>
                            <div className="absolute inset-0 bg-gradient-to-r from-primary-500 to-primary-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        </Link>
                    </div>
                </div>
            </div>
            
            {/* Efecto de brillo en los bordes */}
            <div className="absolute inset-0 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none">
                <div className="absolute inset-0 rounded-2xl bg-gradient-to-r from-secondary-400/20 to-primary-400/20 blur-sm"></div>
            </div>
        </div>
    );
};
const AdvantageCard = ({ advantage, index }) => {
    return (
        <div className={`group relative bg-white rounded-2xl shadow-lg p-6 transform transition-all duration-500 hover:scale-105 hover:shadow-2xl border-2 border-primary-100 animate-fade-in animation-delay-${index * 100}`}>
            {/* Icono animado */}
            <div className="relative inline-block mb-4">
                <div className="absolute -inset-2 bg-gradient-to-r from-primary-400 to-secondary-400 rounded-full blur opacity-0 group-hover:opacity-75 transition-opacity duration-300"></div>
                <div className="relative bg-gradient-to-br from-primary-50 to-secondary-50 rounded-full w-16 h-16 flex items-center justify-center">
                    <advantage.icon className="w-8 h-8 text-primary-600" />
                </div>
            </div>
            
            {/* Título */}
            <h3 className="text-xl font-bold text-primary-800 mb-3 group-hover:text-primary-600 transition-colors">
                {advantage.title}
            </h3>
            
            {/* Descripción */}
            <p className="text-gray-600 mb-4 line-clamp-3">
                {advantage.description}
            </p>
            
            {/* Características adicionales */}
            <div className="space-y-2">
                {advantage.features.map((feature, idx) => (
                    <div key={idx} className="flex items-center text-sm text-gray-500 group-hover:text-gray-600 transition-colors">
                        <svg className="w-4 h-4 mr-2 text-secondary-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M5 13l4 4L19 7" />
                        </svg>
                        <span>{feature}</span>
                    </div>
                ))}
            </div>
            
            {/* Efecto decorativo */}
            <div className="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-primary-100 to-secondary-100 rounded-bl-full opacity-50"></div>
        </div>
    );
};

// Iconos SVG para los destinos
const LocationIcon = () => (
    <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
    </svg>
);
const MountainIcon = () => (
    <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M20.24 12.24a6 6 0 00-8.49-8.49L5 10.5V9a6 6 0 006 6h1.5l6.75 6.75a6 6 0 008.48-8.48l-4.49-4.53zM15 5a1 1 0 100 2 1 1 0 000-2z" />
    </svg>
);
const SunIcon = () => (
    <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
    </svg>
);
const CityIcon = () => (
    <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
    </svg>
);
const SecurityIcon = () => (
    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
    </svg>
);
const SupportIcon = () => (
    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M12 2.25v4.5m0 15.75v-4.5M2.25 12h4.5m15.75 0h-4.5" />
    </svg>
);
const GuideIcon = () => (
    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
    </svg>
);
const TransportIcon = () => (
    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 01-2 2z" />
    </svg>
);
const ClockIcon = () => (
    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
    </svg>
);
const PriceIcon = () => (
    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
    </svg>
);


export default function Home() {
    // Datos de testimonios
    const testimonials = [
        {
            name: "María García",
            location: "España",
            avatar: "https://images.unsplash.com/photo-1494790108755-2616b612b642?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80",
            video: "/images/videos/videoRecomendado2.mp4",
            comment: "La experiencia del Camino Inca fue increíble. Los guías son muy profesionales y conocedores de la historia. Sin duda, una aventura inolvidable."
        },
        {
            name: "Carlos Rodríguez",
            location: "México",
            avatar: "https://images.unsplash.com/photo-1507003211169-0a1dd7228f2?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80",
            video: "/images/videos/videoRecomendado1.mp4",
            comment: "El tour a Machu Picchu superó todas mis expectativas. La organización fue perfecta y la atención al cliente excepcional."
        },
        {
            name: "Ana Silva",
            location: "Brasil",
            avatar: "https://images.unsplash.com/photo-1438761681033-6461ffad8d80?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80",
            video: "/images/videos/videoRecomendado3.mp4",
            comment: "Viajar con Expediciones Allinkay fue la mejor decisión. Me cuidaron en cada detalle y me hicieron sentir como en familia."
        }
    ];
    // Datos de mensajes de WhatsApp
    const whatsappMessages = [
        {
            name: "Juan Pérez",
            text: "¡Gracias por el increíble tour a Machu Picchu! La experiencia fue inolvidable y los guías fueron excelentes. Definitivamente los recomendaré.",
            date: "15/05/2023"
        },
        {
            name: "Laura Fernández",
            text: "El tour al Valle Sagrado estuvo perfecto. Todo muy bien organizado y los paisajes espectaculares. Volveré a viajar con ustedes.",
            date: "22/05/2023"
        },
        {
            name: "Roberto Gómez",
            text: "Quiero agradecer por la atención personalizada durante mi viaje. El Salkantay Trek fue un desafío, pero valió cada paso. ¡Gracias!",
            date: "30/05/2023"
        }
    ];
    const { 
        currentIndex: videoIndex,
        moveNext: moveVideoNext,
        movePrev: moveVideoPrev,
        goToSlide: goToVideoSlide,
        toggleVideo,
        updateVideoDuration
    } = useCarousel(testimonials);

    const { 
        currentIndex: whatsappIndex,
        moveNext: moveWhatsappNext,
        movePrev: moveWhatsappPrev,
        goToSlide: goToWhatsappSlide
    } = useCarousel(whatsappMessages);
    
    // Datos de los tours populares
    const popularTours = [
        {
            id: 1,
            title: "Machu Picchu Clásico",
            description: "Experimenta la maravilla del mundo en todo su esplendor con nuestro tour completo a Machu Picchu, incluyendo guía profesional y transporte.",
            image: "https://images.unsplash.com/photo-1587595431973-160d0d94add1?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80",
            category: "Más Popular",
            duration: "1 día",
            location: "Cusco",
            price: "$120",
            bookingLink: "https://wa.me/51995669380?text=Hola,%20me%20interesa%20el%20tour%20Machu%20Picchu%20Clásico"
        },
        {
            id: 2,
            title: "Camino Inca 4 Días",
            description: "Aventura inolvidable por la ruta ancestral que los incas utilizaban para llegar a Machu Picchu, con campamentos y comida incluida.",
            image: "https://images.unsplash.com/photo-1526392060635-9d6019884377?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80",
            category: "Aventura",
            duration: "4 días",
            location: "Cusco",
            price: "$450",
            bookingLink: "https://wa.me/51995669380?text=Hola,%20me%20interesa%20el%20Camino%20Inca%204%20Días"
        },
        {
            id: 3,
            title: "Lago Titicaca Full Day",
            description: "Explora las islas flotantes de los Uros y la isla de Taquile en el lago navegable más alto del mundo.",
            image: "https://images.unsplash.com/photo-1544735716-392fe2489ffa?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80",
            category: "Cultural",
            duration: "1 día",
            location: "Puno",
            price: "$85",
            bookingLink: "https://wa.me/51995669380?text=Hola,%20me%20interesa%20el%20tour%20Lago%20Titicaca%20Full%20Day"
        },
        {
            id: 4,
            title: "Montaña 7 Colores",
            description: "Descubre la espectacular montaña de Vinicunca con sus impresionantes colores naturales y paisajes andinos.",
            image: "https://images.unsplash.com/photo-1558979158-65a1eaa08691?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80",
            category: "Trekking",
            duration: "1 día",
            location: "Cusco",
            price: "$65",
            bookingLink: "https://wa.me/51995669380?text=Hola,%20me%20interesa%20el%20tour%20Montaña%207%20Colores"
        },
        {
            id: 5,
            title: "Valle Sagrado Completo",
            description: "Recorre los sitios más importantes del Valle Sagrado de los Incas: Pisac, Ollantaytambo y Chinchero.",
            image: "https://images.unsplash.com/photo-1578662996442-48f60103fc96?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80",
            category: "Cultural",
            duration: "1 día",
            location: "Cusco",
            price: "$75",
            bookingLink: "https://wa.me/51995669380?text=Hola,%20me%20interesa%20el%20tour%20Valle%20Sagrado%20Completo"
        },
        {
            id: 6,
            title: "Límites de Ica y Paracas",
            description: "Disfruta de las hermosas playas de Paracas, las Líneas de Nazca y la bodega de Pisco en un tour completo.",
            image: "https://images.unsplash.com/photo-1544735716-392fe2489ffa?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80",
            category: "Costa",
            duration: "2 días",
            location: "Ica",
            price: "$150",
            bookingLink: "https://wa.me/51995669380?text=Hola,%20me%20interesa%20el%20tour%20Límites%20de%20Ica%20y%20Paracas"
        },
        {
            id: 7,
            title: "Cañón del Colca",
            description: "Admira el vuelo de los cóndores en uno de los cañones más profundos del mundo, cerca de Arequipa.",
            image: "https://images.unsplash.com/photo-1587595431973-160d0d94add1?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80",
            category: "Naturaleza",
            duration: "2 días",
            location: "Arequipa",
            price: "$120",
            bookingLink: "https://wa.me/51995669380?text=Hola,%20me%20interesa%20el%20tour%20Cañón%20del%20Colca"
        },
        {
            id: 8,
            title: "City Tour Lima",
            description: "Descubre la capital del Perú visitando el Centro Histórico, Larcomar y los mejores restaurantes de la ciudad.",
            image: "https://images.unsplash.com/photo-1564564321837-a57b7070ac4f?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80",
            category: "Urbano",
            duration: "1 día",
            location: "Lima",
            price: "$55",
            bookingLink: "https://wa.me/51995669380?text=Hola,%20me%20interesa%20el%20City%20Tour%20Lima"
        }
    ];
    // Datos de los trekking tours a Machu Picchu
    const trekkingTours = [
        {
            id: 1,
            title: "Camino Inca Clásico 4D/3N",
            description: "La ruta más famosa hacia Machu Picchu, recorriendo antiguos caminos incas con paisajes espectaculares y campamentos en la montaña.",
            image: "https://images.unsplash.com/photo-1526392060635-9d6019884377?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80",
            difficulty: "Difícil",
            duration: "4 días / 3 noches",
            distance: "45 km",
            altitude: "4,215 msnm",
            price: "$650",
            bookingLink: "https://wa.me/51995669380?text=Hola,%20me%20interesa%20el%20Camino%20Inca%20Clásico"
        },
        {
            id: 2,
            title: "Salkantay Trek 5D/4N",
            description: "Alternativa espectacular al Camino Inca, con vistas impresionantes del nevado Salkantay y paisajes diversos de la selva alta.",
            image: "https://images.unsplash.com/photo-1551632436-cbf8dd35adfa?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80",
            difficulty: "Difícil",
            duration: "5 días / 4 noches",
            distance: "74 km",
            altitude: "4,650 msnm",
            price: "$550",
            bookingLink: "https://wa.me/51995669380?text=Hola,%20me%20interesa%20el%20Salkantay%20Trek"
        },
        {
            id: 3,
            title: "Inca Jungle 4D/3N",
            description: "Aventura única que combina trekking con mountain bike y zip line, descendiendo desde la montaña hasta la selva alta.",
            image: "https://images.unsplash.com/photo-1544735716-392fe2489ffa?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80",
            difficulty: "Moderado",
            duration: "4 días / 3 noches",
            distance: "50 km",
            altitude: "4,350 msnm",
            price: "$450",
            bookingLink: "https://wa.me/51995669380?text=Hola,%20me%20interesa%20el%20Inca%20Jungle"
        },
        {
            id: 4,
            title: "Camino Inca Corto 2D/1N",
            description: "Opción perfecta para quienes tienen poco tiempo, recorriendo el último tramo del Camino Inca y llegando a Machu Picchu por la Puerta del Sol.",
            image: "https://images.unsplash.com/photo-1578662996442-48f60103fc96?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80",
            difficulty: "Moderado",
            duration: "2 días / 1 noche",
            distance: "12 km",
            altitude: "2,720 msnm",
            price: "$350",
            bookingLink: "https://wa.me/51995669380?text=Hola,%20me%20interesa%20el%20Camino%20Inca%20Corto"
        },
        {
            id: 5,
            title: "Huchuy Qosqo 3D/2N",
            description: "Trekking poco conocido pero espectacular, que combina paisajes andinos con el lago Piuray y el sitio arqueológico de Huchuy Qosqo.",
            image: "https://images.unsplash.com/photo-1587595431973-160d0d94add1?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80",
            difficulty: "Fácil",
            duration: "3 días / 2 noches",
            distance: "20 km",
            altitude: "4,450 msnm",
            price: "$280",
            bookingLink: "https://wa.me/51995669380?text=Hola,%20me%20interesa%20el%20Huchuy%20Qosqo"
        },
        {
            id: 6,
            title: "Choquequirao Trek 5D/4N",
            description: "Aventura exigente hacia la 'hermana sagrada' de Machu Picchu, con impresionantes vistas del cañón del Apurímac.",
            image: "https://images.unsplash.com/photo-1558979158-65a1eaa08691?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80",
            difficulty: "Muy Difícil",
            duration: "5 días / 4 noches",
            distance: "64 km",
            altitude: "3,050 msnm",
            price: "$480",
            bookingLink: "https://wa.me/51995669380?text=Hola,%20me%20interesa%20el%20Choquequirao%20Trek"
        }
    ];
    // Datos de los destinos
    const destinations = [
        {
            id: 1,
            title: "Puno",
            region: "Sur Andino",
            description: "Descubre el lago navegable más alto del mundo y las culturas vivientes que habitan sus islas.",
            image: "https://images.unsplash.com/photo-1544735716-392fe2489ffa?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80",
            icon: LocationIcon,
            tours: "12+",
            days: "2-4",
            rating: "4.8",
            link: "/destinos/puno"
        },
        {
            id: 2,
            title: "Lima",
            region: "Costa Central",
            description: "La capital del Perú te espera con su gastronomía mundialmente reconocida y su rico patrimonio histórico.",
            image: "https://images.unsplash.com/photo-1564564321837-a57b7070ac4f?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80",
            icon: CityIcon,
            tours: "15+",
            days: "1-3",
            rating: "4.7",
            link: "/destinos/lima"
        },
        {
            id: 3,
            title: "Ica-Paracas",
            region: "Desierto Costa",
            description: "Disfruta del desierto, las Líneas de Nazca y las hermosas playas de la costa sur del Perú.",
            image: "https://images.unsplash.com/photo-1587595431973-160d0d94add1?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80",
            icon: SunIcon,
            tours: "8+",
            days: "2-3",
            rating: "4.6",
            link: "/destinos/ica-paracas"
        },
        {
            id: 4,
            title: "Arequipa",
            region: "Sur Peruano",
            description: "La 'Ciudad Blanca' te sorprenderá con su arquitectura colonial, el volcán Misti y el Cañón del Colca.",
            image: "https://images.unsplash.com/photo-1558979158-65a1eaa08691?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80",
            icon: MountainIcon,
            tours: "10+",
            days: "2-4",
            rating: "4.9",
            link: "/destinos/arequipa"
        }
    ];
    // Datos de las experiencias
    const experiences = [
        {
            id: 1,
            title: "Aventura y Trekking",
            category: "Para los intrépidos",
            description: "Rutas desafiantes, caminos ancestrales y paisajes de montaña que pondrán a prueba tus límites.",
            image: "https://images.unsplash.com/photo-1551632436-cbf8dd35adfa?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80",
            link: "/tours/aventura"
        },
        {
            id: 2,
            title: "Tours Culturales",
            category: "Para los curiosos",
            description: "Sumérgete en la rica historia y cultura del Perú, visitando sitios arqueológicos y comunidades tradicionales.",
            image: "https://images.unsplash.com/photo-1578662996442-48f60103fc96?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80",
            link: "/tours/culturales"
        },
        {
            id: 3,
            title: "Experiencias Únicas",
            category: "Para los soñadores",
            description: "Vivencias especiales que van más allá del turismo convencional, conectando con la esencia del Perú.",
            image: "https://images.unsplash.com/photo-1544735716-392fe2489ffa?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80",
            link: "/tours/experiencias"
        }
    ];
    // Datos de las ventajas
    const advantages = [
        {
            id: 1,
            title: "Seguridad y Seguimiento",
            description: "Tu seguridad es nuestra prioridad. Monitoreamos cada etapa de tu viaje para garantizar una experiencia sin preocupaciones.",
            icon: SecurityIcon,
            features: [
                "Monitoreo 24/7 durante tu viaje",
                "Seguro de viaje incluido",
                "Protocolos de emergencia",
                "Seguimiento en tiempo real"
            ]
        },
        {
            id: 2,
            title: "Atención Personalizada",
            description: "Tratamos a cada cliente como único. Adaptamos nuestros servicios a tus necesidades y preferencias.",
            icon: SupportIcon,
            features: [
                "Asignación de coordinador personal",
                "Itinerarios flexibles",
                "Atención antes, durante y después del viaje",
                "Soporte multilingüe"
            ]
        },
        {
            id: 3,
            title: "Guías Certificados",
            description: "Nuestros guías son profesionales certificados con profundo conocimiento de la cultura e historia local.",
            icon: GuideIcon,
            features: [
                "Guías locales expertos",
                "Certificación oficial",
                "Conocimiento histórico y cultural",
                "Primeros auxilios certificados"
            ]
        },
        {
            id: 4,
            title: "Recojo de Aeropuerto",
            description: "Olvida las preocupaciones de transporte. Te recogemos del aeropuerto y te llevamos a tu hotel sin costo adicional.",
            icon: TransportIcon,
            features: [
                "Traslados incluidos",
                "Vehículos cómodos y seguros",
                "Conductor profesional",
                "Disponible 24 horas"
            ]
        },
        {
            id: 5,
            title: "Horarios Flexibles",
            description: "Adaptamos nuestros horarios a tu conveniencia. Ofrecemos salidas diarias y horarios personalizados.",
            icon: ClockIcon,
            features: [
                "Salidas diarias garantizadas",
                "Horarios personalizables",
                "Flexibilidad en cambios",
                "Opciones privadas y grupales"
            ]
        },
        {
            id: 6,
            title: "Buenos Precios",
            description: "Ofrecemos la mejor relación calidad-precio. Sin costos ocultos y opciones para todos los presupuestos.",
            icon: PriceIcon,
            features: [
                "Precios transparentes",
                "Descuentos por grupo",
                "Opciones para todos los presupuestos",
                "Promociones especiales"
            ]
        }
    ];

    // Datos de fotos de Instagram
    const instagramPhotos = [
        {
            image: "images/maras1.jpg",
            likes: "245",
            comments: "32"
        },
        {
            image: "images/insta1.jpg",
            likes: "189",
            comments: "28"
        },
        {
            image: "images/insta2.jpg",
            likes: "312",
            comments: "45"
        },
        {
            image: "images/insta3.jpg",
            likes: "278",
            comments: "36"
        },
        {
            image: "images/insta4.jpg",
            likes: "421",
            comments: "52"
        },
        {
            image: "images/machupicchu-1.jpg",
            likes: "356",
            comments: "41"
        }
    ];
    
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

            {/* Sección 1: Frase de confianza y estadísticas */}
            <section className="py-16 bg-gradient-to-b from-white to-primary-50 relative overflow-hidden">
                {/* Elementos decorativos de fondo */}
                <div className="absolute top-0 left-0 w-full h-full overflow-hidden z-0">
                    <div className="absolute -top-40 -right-40 w-80 h-80 bg-primary-200 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob"></div>
                    <div className="absolute -bottom-40 -left-40 w-80 h-80 bg-secondary-200 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-2000"></div>
                    <div className="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-80 h-80 bg-primary-300 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-4000"></div>
                </div>
                
                <div className="container mx-auto px-4 relative z-10">
                    {/* Frase de confianza */}
                    <div className="text-center mb-16 animate-fade-in">
                        <h2 className="text-3xl md:text-4xl font-bold text-primary-800 mb-6">
                            Más de una década creando <span className="text-primary-500">experiencias inolvidables</span>
                        </h2>
                        <p className="text-lg text-gray-700 max-w-3xl mx-auto">
                            En Expediciones Allinkay, no solo ofrecemos tours, creamos recuerdos que durarán toda la vida. 
                            Nuestra pasión por el turismo y la atención personalizada nos han convertido en la elección preferida 
                            de viajeros de todo el mundo.
                        </p>
                    </div>
                    
                    {/* Estadísticas animadas */}
                    <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                        {/* Clientes atendidos */}
                        <div className="bg-white rounded-2xl shadow-lg p-6 text-center transform transition-transform hover:scale-105 hover:shadow-xl border-2 border-primary-100">
                            <div className="relative inline-block mb-4">
                                <div className="absolute -inset-1 bg-gradient-to-r from-primary-400 to-primary-600 rounded-full blur opacity-75"></div>
                                <div className="relative bg-primary-500 rounded-full w-16 h-16 flex items-center justify-center mx-auto">
                                    <svg className="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656-.126-1.283-.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </div>
                            </div>
                            <h3 className="text-3xl font-bold text-primary-800 mb-2">
                                <Counter end={5000} suffix="+" />
                            </h3>
                            <p className="text-gray-600">Clientes atendidos</p>
                        </div>
                        
                        {/* Años de experiencia */}
                        <div className="bg-white rounded-2xl shadow-lg p-6 text-center transform transition-transform hover:scale-105 hover:shadow-xl border-2 border-primary-100">
                            <div className="relative inline-block mb-4">
                                <div className="absolute -inset-1 bg-gradient-to-r from-secondary-400 to-secondary-600 rounded-full blur opacity-75"></div>
                                <div className="relative bg-secondary-500 rounded-full w-16 h-16 flex items-center justify-center mx-auto">
                                    <svg className="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            </div>
                            <h3 className="text-3xl font-bold text-primary-800 mb-2">
                                <Counter end={10} suffix="+" />
                            </h3>
                            <p className="text-gray-600">Años de experiencia</p>
                        </div>
                        
                        {/* Tours ofrecidos */}
                        <div className="bg-white rounded-2xl shadow-lg p-6 text-center transform transition-transform hover:scale-105 hover:shadow-xl border-2 border-primary-100">
                            <div className="relative inline-block mb-4">
                                <div className="absolute -inset-1 bg-gradient-to-r from-accent-400 to-accent-600 rounded-full blur opacity-75"></div>
                                <div className="relative bg-accent-500 rounded-full w-16 h-16 flex items-center justify-center mx-auto">
                                    <svg className="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            </div>
                            <h3 className="text-3xl font-bold text-primary-800 mb-2">
                                <Counter end={50} suffix="+" />
                            </h3>
                            <p className="text-gray-600">Tours ofrecidos</p>
                        </div>
                        
                        {/* Clientes satisfechos */}
                        <div className="bg-white rounded-2xl shadow-lg p-6 text-center transform transition-transform hover:scale-105 hover:shadow-xl border-2 border-primary-100">
                            <div className="relative inline-block mb-4">
                                <div className="absolute -inset-1 bg-gradient-to-r from-green-400 to-green-600 rounded-full blur opacity-75"></div>
                                <div className="relative bg-green-500 rounded-full w-16 h-16 flex items-center justify-center mx-auto">
                                    <svg className="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            </div>
                            <h3 className="text-3xl font-bold text-primary-800 mb-2">
                                <Counter end={98} suffix="%" />
                            </h3>
                            <p className="text-gray-600">Clientes satisfechos</p>
                        </div>
                    </div>
                </div>
            </section>

            {/* Sección 2: Top tours más populares */}
            <section className="py-16 bg-white relative overflow-hidden">
                {/* Elementos decorativos de fondo */}
                <div className="absolute top-0 left-0 w-full h-full overflow-hidden z-0">
                    <div className="absolute top-0 right-0 w-64 h-64 bg-primary-100 rounded-full mix-blend-multiply filter blur-xl opacity-30"></div>
                    <div className="absolute bottom-0 left-0 w-64 h-64 bg-secondary-100 rounded-full mix-blend-multiply filter blur-xl opacity-30"></div>
                </div>
                
                <div className="container mx-auto px-4 relative z-10">
                    {/* Título de la sección */}
                    <div className="text-center mb-12 animate-fade-in">
                        <h2 className="text-3xl md:text-4xl font-bold text-primary-800 mb-4">
                            Top Tours <span className="text-primary-500">Más Populares</span>
                        </h2>
                        <p className="text-lg text-gray-600 max-w-3xl mx-auto">
                            Descubre nuestras experiencias más solicitadas por viajeros de todo el mundo. 
                            Cada tour está cuidadosamente diseñado para ofrecerte lo mejor del Perú.
                        </p>
                    </div>
                    
                    {/* Grid de tours populares */}
                    <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                        {popularTours.map((tour, index) => (
                            <TourCard key={tour.id} tour={tour} index={index} />
                        ))}
                    </div>
                    
                    {/* Botón para ver todos los tours */}
                    <div className="text-center mt-12 animate-fade-in animation-delay-800">
                        <Link 
                            href="/tours" 
                            className="inline-flex items-center bg-gradient-to-r from-primary-500 to-primary-600 text-white px-6 py-3 rounded-full font-medium transition transform hover:scale-105 hover:shadow-lg relative overflow-hidden group"
                        >
                            <span className="relative z-10">Ver Todos los Tours</span>
                            <svg className="w-5 h-5 ml-2 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                            <div className="absolute inset-0 bg-gradient-to-r from-secondary-500 to-secondary-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        </Link>
                    </div>
                </div>
            </section>

            {/* Sección 3: Top trekking tours a Machupicchu*/}
            <section className="py-16 bg-gradient-to-b from-white to-primary-50 relative overflow-hidden">
                {/* Elementos decorativos de fondo */}
                <div className="absolute top-0 left-0 w-full h-full overflow-hidden z-0">
                    <div className="absolute top-1/3 right-0 w-64 h-64 bg-primary-200 rounded-full mix-blend-multiply filter blur-xl opacity-30"></div>
                    <div className="absolute bottom-1/3 left-0 w-64 h-64 bg-secondary-200 rounded-full mix-blend-multiply filter blur-xl opacity-30"></div>
                </div>
                
                <div className="container mx-auto px-4 relative z-10">
                    {/* Título de la sección */}
                    <div className="text-center mb-12 animate-fade-in">
                        <h2 className="text-3xl md:text-4xl font-bold text-primary-800 mb-4">
                            Top Trekking Tours a <span className="text-primary-500">Machu Picchu</span>
                        </h2>
                        <p className="text-lg text-gray-600 max-w-3xl mx-auto">
                            Vive la experiencia inolvidable de llegar a la ciudadela inca por las rutas más espectaculares. 
                            Cada trekking ofrece paisajes únicos y una conexión profunda con la naturaleza y la historia.
                        </p>
                    </div>
                    
                    {/* Grid de trekking tours */}
                    <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        {trekkingTours.map((tour, index) => (
                            <TrekkingCard key={tour.id} tour={tour} index={index} />
                        ))}
                    </div>
                    
                    {/* Botón para ver todos los trekking tours */}
                    <div className="text-center mt-12 animate-fade-in animation-delay-800">
                        <Link 
                            href="/trekking" 
                            className="inline-flex items-center bg-gradient-to-r from-primary-500 to-primary-600 text-white px-6 py-3 rounded-full font-medium transition transform hover:scale-105 hover:shadow-lg relative overflow-hidden group"
                        >
                            <span className="relative z-10">Ver Todos los Trekking Tours</span>
                            <svg className="w-5 h-5 ml-2 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                            <div className="absolute inset-0 bg-gradient-to-r from-secondary-500 to-secondary-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        </Link>
                    </div>
                </div>
            </section>

            {/* Sección 4: Elige tu propia experiencia*/}
            <section className="py-16 bg-gradient-to-br from-primary-900 to-primary-700 text-white relative overflow-hidden">
                {/* Elementos decorativos de fondo */}
                <div className="absolute top-0 left-0 w-full h-full overflow-hidden z-0">
                    <div className="absolute top-20 left-10 w-32 h-32 bg-secondary-400/20 rounded-full mix-blend-multiply filter blur-xl"></div>
                    <div className="absolute bottom-20 right-10 w-40 h-40 bg-accent-400/20 rounded-full mix-blend-multiply filter blur-xl"></div>
                    <div className="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-64 h-64 bg-primary-500/20 rounded-full mix-blend-multiply filter blur-xl"></div>
                </div>
                
                <div className="container mx-auto px-4 relative z-10">
                    {/* Título de la sección */}
                    <div className="text-center mb-12 animate-fade-in">
                        <h2 className="text-3xl md:text-4xl font-bold mb-4">
                            Elige tu Propia <span className="text-secondary-300">Experiencia</span>
                        </h2>
                        <p className="text-lg text-primary-100 max-w-3xl mx-auto">
                            Cada viaje es único. Descubre diferentes tipos de experiencias adaptadas a tus intereses y estilo de aventura.
                        </p>
                    </div>
                    
                    {/* Grid de experiencias */}
                    <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
                        {experiences.map((experience, index) => (
                            <ExperienceCard key={experience.id} experience={experience} index={index} />
                        ))}
                    </div>
                    
                    {/* Texto adicional */}
                    <div className="text-center mt-12 animate-fade-in animation-delay-600">
                        <p className="text-primary-200 max-w-2xl mx-auto">
                            ¿No encuentras lo que buscas? <Link href="/contact" className="text-secondary-300 hover:text-white underline transition">Contáctanos</Link> y crearemos una experiencia personalizada para ti.
                        </p>
                    </div>
                </div>
            </section>

            {/*  Sección 5: Descubre otros destinos*/}
            <section className="py-16 bg-gradient-to-b from-primary-50 to-white relative overflow-hidden">
                {/* Elementos decorativos animados */}
                <div className="absolute top-0 left-0 w-full h-full overflow-hidden z-0">
                    {/* Círculos animados */}
                    <div className="absolute top-20 left-10 w-32 h-32 bg-primary-200 rounded-full mix-blend-multiply filter blur-xl opacity-50 animate-blob"></div>
                    <div className="absolute bottom-20 right-10 w-40 h-40 bg-secondary-200 rounded-full mix-blend-multiply filter blur-xl opacity-50 animate-blob animation-delay-2000"></div>
                    <div className="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-64 h-64 bg-accent-200 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-blob animation-delay-4000"></div>
                    
                    {/* Líneas decorativas */}
                    <div className="absolute top-0 left-1/4 w-px h-full bg-gradient-to-b from-transparent via-primary-300 to-transparent opacity-20"></div>
                    <div className="absolute top-0 left-2/4 w-px h-full bg-gradient-to-b from-transparent via-secondary-300 to-transparent opacity-20"></div>
                    <div className="absolute top-0 left-3/4 w-px h-full bg-gradient-to-b from-transparent via-accent-300 to-transparent opacity-20"></div>
                </div>
                
                <div className="container mx-auto px-4 relative z-10">
                    {/* Título de la sección con animación */}
                    <div className="text-center mb-12 animate-fade-in">
                        <div className="inline-block relative mb-4">
                            <h2 className="text-3xl md:text-4xl font-bold text-primary-800 relative">
                                Descubre Otros <span className="text-primary-500">Destinos</span>
                                <div className="absolute -bottom-2 left-0 w-full h-1 bg-gradient-to-r from-primary-400 to-secondary-400 rounded-full"></div>
                            </h2>
                        </div>
                        <p className="text-lg text-gray-600 max-w-3xl mx-auto">
                            El Perú tiene mucho más que ofrecer. Explora nuestras experiencias en los destinos más fascinantes del país.
                        </p>
                    </div>
                    
                    {/* Grid de destinos con animación */}
                    <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                        {destinations.map((destination, index) => (
                            <DestinationCard key={destination.id} destination={destination} index={index} />
                        ))}
                    </div>
                    
                    {/* Texto adicional con efecto de aparición */}
                    <div className="text-center mt-12 animate-fade-in animation-delay-800">
                        <p className="text-gray-600 mb-4 max-w-2xl mx-auto">
                            ¿Quieres visitar varios destinos? <span className="font-semibold text-primary-600">Creamos itinerarios personalizados</span> que combinan los mejores lugares del Perú.
                        </p>
                        <Link 
                            href="/contact" 
                            className="inline-flex items-center bg-gradient-to-r from-primary-500 to-primary-600 text-white px-6 py-3 rounded-full font-medium transition transform hover:scale-105 hover:shadow-lg relative overflow-hidden group"
                        >
                            <span className="relative z-10">Planificar Mi Viaje</span>
                            <svg className="w-5 h-5 ml-2 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 5l7 7-7 7" />
                            </svg>
                            <div className="absolute inset-0 bg-gradient-to-r from-secondary-500 to-secondary-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        </Link>
                    </div>
                </div>
            </section>

            {/*  Sección 6: Por qué viajar con Expediciones Allinkay*/}
            <section className="py-16 bg-gradient-to-br from-primary-50 to-white relative overflow-hidden">
                {/* Elementos decorativos animados */}
                <div className="absolute top-0 left-0 w-full h-full overflow-hidden z-0">
                    {/* Patrón de puntos animado */}
                    <div className="absolute inset-0 opacity-20">
                        <div className="absolute top-0 left-0 w-full h-full" style={{
                            backgroundImage: `radial-gradient(circle, ${getComputedStyle(document.documentElement).getPropertyValue('--tw-primary-500')} 1px, transparent 1px)`,
                            backgroundSize: '40px 40px'
                        }}></div>
                    </div>
                    
                    {/* Círculos animados */}
                    <div className="absolute top-20 right-20 w-32 h-32 bg-secondary-200 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-pulse"></div>
                    <div className="absolute bottom-20 left-20 w-40 h-40 bg-primary-200 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-pulse animation-delay-2000"></div>
                </div>
                
                <div className="container mx-auto px-4 relative z-10">
                    {/* Título de la sección con animación */}
                    <div className="text-center mb-12 animate-fade-in">
                        <div className="inline-block relative mb-6">
                            <h2 className="text-3xl md:text-4xl font-bold text-primary-800 relative">
                                ¿Qué nos hace <span className="text-primary-500">Diferente</span>?
                                <div className="absolute -bottom-2 left-0 w-full h-1 bg-gradient-to-r from-primary-400 to-secondary-400 rounded-full"></div>
                            </h2>
                        </div>
                        <p className="text-lg text-gray-600 max-w-3xl mx-auto">
                            En Expediciones Allinkay, nos esforzamos por ofrecer una experiencia superior. Descubre por qué miles de viajeros confían en nosotros.
                        </p>
                    </div>
                    
                    {/* Grid de ventajas con animación */}
                    <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        {advantages.map((advantage, index) => (
                            <AdvantageCard key={advantage.id} advantage={advantage} index={index} />
                        ))}
                    </div>
                    
                    {/* Sección de garantía con efecto especial */}
                    <div className="mt-16 bg-gradient-to-r from-primary-600 to-primary-700 rounded-3xl p-8 md:p-12 text-white relative overflow-hidden animate-fade-in animation-delay-600">
                        {/* Efecto de partículas */}
                        <div className="absolute inset-0">
                            {[...Array(20)].map((_, i) => (
                                <div 
                                    key={i}
                                    className="absolute w-1 h-1 bg-white/30 rounded-full animate-pulse"
                                    style={{
                                        top: `${Math.random() * 100}%`,
                                        left: `${Math.random() * 100}%`,
                                        animationDelay: `${Math.random() * 3}s`,
                                        animationDuration: `${3 + Math.random() * 2}s`
                                    }}
                                ></div>
                            ))}
                        </div>
                        
                        <div className="relative z-10">
                            <div className="flex flex-col md:flex-row items-center justify-between">
                                <div className="mb-6 md:mb-0 md:mr-8">
                                    <h3 className="text-2xl md:text-3xl font-bold mb-4">
                                        Nuestra <span className="text-secondary-300">Garantía de Calidad</span>
                                    </h3>
                                    <p className="text-primary-100 max-w-2xl">
                                        Nos comprometemos a ofrecerte la mejor experiencia de viaje. Si algo no cumple tus expectativas, 
                                        haremos todo lo posible para corregirlo.
                                    </p>
                                </div>
                                
                                <div className="flex-shrink-0">
                                    <Link 
                                        href="/contact" 
                                        className="inline-flex items-center bg-white text-primary-700 px-6 py-3 rounded-full font-bold transition transform hover:scale-105 hover:shadow-lg relative overflow-hidden group"
                                    >
                                        <span className="relative z-10">Habla con un Experto</span>
                                        <svg className="w-5 h-5 ml-2 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                        </svg>
                                        <div className="absolute inset-0 bg-gradient-to-r from-secondary-400 to-secondary-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                    </Link>
                                </div>
                            </div>
                            
                            {/* Sellos de confianza */}
                            <div className="grid grid-cols-2 md:grid-cols-4 gap-4 mt-8">
                                <div className="flex items-center justify-center p-3 bg-white/10 rounded-lg backdrop-blur-sm">
                                    <svg className="w-6 h-6 mr-2 text-secondary-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                    <span className="text-sm">Seguridad Garantizada</span>
                                </div>
                                <div className="flex items-center justify-center p-3 bg-white/10 rounded-lg backdrop-blur-sm">
                                    <svg className="w-6 h-6 mr-2 text-secondary-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span className="text-sm">Mejor Precio</span>
                                </div>
                                <div className="flex items-center justify-center p-3 bg-white/10 rounded-lg backdrop-blur-sm">
                                    <svg className="w-6 h-6 mr-2 text-secondary-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M12 2.25v4.5m0 15.75v-4.5M2.25 12h4.5m15.75 0h-4.5" />
                                    </svg>
                                    <span className="text-sm">Soporte 24/7</span>
                                </div>
                                <div className="flex items-center justify-center p-3 bg-white/10 rounded-lg backdrop-blur-sm">
                                    <svg className="w-6 h-6 mr-2 text-secondary-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                    <span className="text-sm">Satisfacción Garantizada</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {/*  Sección 7: Mira las opiniones de nuestro clientes*/}
            <section className="py-16 bg-gradient-to-br from-primary-900 to-primary-700 text-white relative overflow-hidden">
                {/* Elementos decorativos animados */}
                <div className="absolute top-0 left-0 w-full h-full overflow-hidden z-0">
                    {/* Partículas animadas */}
                    {[...Array(30)].map((_, i) => (
                        <div 
                            key={i}
                            className="absolute w-1 h-1 bg-white/20 rounded-full animate-pulse"
                            style={{
                                top: `${Math.random() * 100}%`,
                                left: `${Math.random() * 100}%`,
                                animationDelay: `${Math.random() * 5}s`,
                                animationDuration: `${3 + Math.random() * 4}s`
                            }}
                        ></div>
                    ))}
                    
                    {/* Círculos de colores */}
                    <div className="absolute top-20 right-20 w-64 h-64 bg-secondary-400/20 rounded-full mix-blend-multiply filter blur-xl animate-blob"></div>
                    <div className="absolute bottom-20 left-20 w-80 h-80 bg-accent-400/20 rounded-full mix-blend-multiply filter blur-xl animate-blob animation-delay-2000"></div>
                </div>
                
                <div className="container mx-auto px-4 relative z-10">
                    {/* Título de la sección */}
                    <div className="text-center mb-12 animate-fade-in">
                        <div className="inline-block relative mb-6">
                            <h2 className="text-3xl md:text-4xl font-bold relative">
                                Mira Nuestros <span className="text-secondary-300">Clientes Satisfechos</span>
                                <div className="absolute -bottom-2 left-0 w-full h-1 bg-gradient-to-r from-secondary-400 to-accent-400 rounded-full"></div>
                            </h2>
                        </div>
                        <p className="text-lg text-primary-100 max-w-3xl mx-auto">
                            Las experiencias de nuestros clientes hablan por sí mismas. Descubre por qué somos la elección preferida de viajeros de todo el mundo.
                        </p>
                    </div>
                    
                    {/* Collage de Instagram */}
                    <div className="mb-16 animate-fade-in animation-delay-200">
                        <div className="flex items-center justify-between mb-6">
                            <h3 className="text-2xl font-bold flex items-center">
                                <svg className="w-6 h-6 mr-2 text-secondary-300" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zM5.838 12a6.162 6.162 0 1112.324 0 6.162 6.162 0 01-12.324 0zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/>
                                </svg>
                                @expediciones_allinkay1
                            </h3>
                            <a 
                                href="https://instagram.com/expediciones_allinkay1" 
                                target="_blank"
                                rel="noopener noreferrer"
                                className="flex items-center bg-gradient-to-r from-pink-500 to-purple-600 text-white px-4 py-2 rounded-full text-sm font-medium transition transform hover:scale-105 hover:shadow-lg"
                            >
                                <span>Seguir en Instagram</span>
                                <svg className="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                </svg>
                            </a>
                        </div>
                        
                        {/* Grid de fotos de Instagram */}
                        <div className="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                            {instagramPhotos.map((photo, index) => (
                                <div key={index} className="relative group overflow-hidden rounded-2xl aspect-square">
                                    <img 
                                        src={photo.image} 
                                        alt={`Instagram ${index + 1}`} 
                                        className="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                                    />
                                    <div className="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                    <div className="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                        <div className="text-white text-center">
                                            <div className="flex items-center justify-center mb-2">
                                                <svg className="w-5 h-5 mr-1" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zM5.838 12a6.162 6.162 0 1112.324 0 6.162 6.162 0 01-12.324 0zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/>
                                                </svg>
                                                <span>{photo.likes}</span>
                                            </div>
                                            <div className="flex items-center justify-center">
                                                <svg className="w-5 h-5 mr-1" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/>
                                                </svg>
                                                <span>{photo.comments}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            ))}
                        </div>
                    </div>
                    
                    {/* Sección de testimonios y WhatsApp */}
                    <div className="grid grid-cols-1 lg:grid-cols-2 gap-12">
                        {/* Testimonios en video */}
                        <div className="animate-fade-in animation-delay-400">
                            <div className="flex items-center justify-between mb-6">
                                <h3 className="text-2xl font-bold flex items-center">
                                    <svg className="w-6 h-6 mr-2 text-secondary-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Testimonios
                                </h3>
                            </div>
                            
                            {/* Carrusel de videos */}
                            <div className="relative">
                                <div className="overflow-hidden rounded-2xl">
                                    <div 
                                        className="flex transition-transform duration-500 ease-in-out"
                                        style={{ transform: `translateX(-${videoIndex * 100}%)` }}
                                    >
                                        {testimonials.map((testimonial, index) => (
                                            <div key={index} className="w-full flex-shrink-0">
                                                <div className="bg-white/10 backdrop-blur-sm rounded-2xl p-6">
                                                    <div className="flex items-center mb-4">
                                                        <img 
                                                            src={testimonial.avatar} 
                                                            alt={testimonial.name} 
                                                            className="w-12 h-12 rounded-full object-cover mr-4"
                                                        />
                                                        <div>
                                                            <h4 className="font-bold text-white">{testimonial.name}</h4>
                                                            <p className="text-sm text-primary-200">{testimonial.location}</p>
                                                        </div>
                                                    </div>
                                                    <div className="aspect-video bg-black/30 rounded-xl overflow-hidden mb-4">
                                                        <video 
                                                            id={`video-${index}`}
                                                            className="w-full h-full object-cover"
                                                            controls
                                                            poster="https://images.unsplash.com/photo-1596178065887-1198b6149b2b?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                                                            onClick={() => toggleVideo(`video-${index}`)}
                                                            onLoadedMetadata={() => updateVideoDuration(`video-${index}`, `duration-${index}`)}
                                                        >
                                                            <source src={testimonial.video} type="video/mp4" />
                                                            Tu navegador no soporta el elemento de video.
                                                        </video>
                                                    </div>
                                                    <div className="flex justify-between items-center">
                                                        <p className="text-white/90 italic">"{testimonial.comment}"</p>
                                                        <span id={`duration-${index}`} className="text-sm text-white/70">0:00</span>
                                                    </div>
                                                </div>
                                            </div>
                                        ))}
                                    </div>
                                </div>
                                
                                {/* Controles del carrusel */}
                                <button 
                                    onClick={moveVideoPrev}
                                    disabled={videoIndex === 0}
                                    className="absolute left-0 top-1/2 transform -translate-y-1/2 bg-white/20 backdrop-blur-sm rounded-full w-10 h-10 flex items-center justify-center ml-2 z-10 hover:bg-white/30 transition disabled:opacity-50 disabled:cursor-not-allowed"
                                >
                                    <svg className="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M15 19l-7-7 7-7" />
                                    </svg>
                                </button>
                                <button 
                                    onClick={moveVideoNext}
                                    disabled={videoIndex === testimonials.length - 1}
                                    className="absolute right-0 top-1/2 transform -translate-y-1/2 bg-white/20 backdrop-blur-sm rounded-full w-10 h-10 flex items-center justify-center mr-2 z-10 hover:bg-white/30 transition disabled:opacity-50 disabled:cursor-not-allowed"
                                >
                                    <svg className="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 5l7 7-7 7" />
                                    </svg>
                                </button>
                                
                                {/* Indicadores */}
                                <div className="flex justify-center mt-4 space-x-2">
                                    {testimonials.map((_, index) => (
                                        <button 
                                            key={index}
                                            onClick={() => goToVideoSlide(index)}
                                            className={`w-3 h-3 rounded-full transition-colors ${
                                                index === videoIndex ? 'bg-secondary-400' : 'bg-white/30 hover:bg-white/50'
                                            }`}
                                        ></button>
                                    ))}
                                </div>
                            </div>
                        </div>
    
                        {/* Capturas de WhatsApp */}
                        <div className="animate-fade-in animation-delay-600">
                            <div className="flex items-center justify-between mb-6">
                                <h3 className="text-2xl font-bold flex items-center">
                                    <svg className="w-6 h-6 mr-2 text-secondary-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                    </svg>
                                    Mensajes de Clientes
                                </h3>
                            </div>
                            
                            {/* Carrusel de WhatsApp */}
                            <div className="relative">
                                <div className="overflow-hidden rounded-2xl">
                                    <div 
                                        className="flex transition-transform duration-500 ease-in-out"
                                        style={{ transform: `translateX(-${whatsappIndex * 100}%)` }}
                                    >
                                        {whatsappMessages.map((message, index) => (
                                            <div key={index} className="w-full flex-shrink-0">
                                                <div className="bg-white/10 backdrop-blur-sm rounded-2xl p-6">
                                                    <div className="flex items-center mb-4">
                                                        <div className="relative">
                                                            <div className="absolute -inset-1 bg-gradient-to-r from-green-400 to-green-600 rounded-full blur opacity-75"></div>
                                                            <div className="relative bg-green-500 rounded-full w-12 h-12 flex items-center justify-center">
                                                                <svg className="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413"/>
                                                                </svg>
                                                            </div>
                                                        </div>
                                                        <div className="ml-4">
                                                            <h4 className="font-bold text-white">{message.name}</h4>
                                                            <p className="text-sm text-primary-200">WhatsApp</p>
                                                        </div>
                                                    </div>
                                                    <div className="bg-white rounded-2xl p-4 mb-4">
                                                        <img 
                                                            src={message.image} 
                                                            alt={`Captura de WhatsApp de ${message.name}`}
                                                            className="w-full h-auto object-cover rounded-xl"
                                                        />
                                                    </div>
                                                    <div className="text-right text-sm text-primary-200">
                                                        {message.date}
                                                    </div>
                                                </div>
                                            </div>
                                        ))}
                                    </div>
                                </div>
                                
                                {/* Controles del carrusel */}
                                <button 
                                    onClick={moveWhatsappPrev}
                                    disabled={whatsappIndex === 0}
                                    className="absolute left-0 top-1/2 transform -translate-y-1/2 bg-white/20 backdrop-blur-sm rounded-full w-10 h-10 flex items-center justify-center ml-2 z-10 hover:bg-white/30 transition disabled:opacity-50 disabled:cursor-not-allowed"
                                >
                                    <svg className="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M15 19l-7-7 7-7" />
                                    </svg>
                                </button>
                                <button 
                                    onClick={moveWhatsappNext}
                                    disabled={whatsappIndex === whatsappMessages.length - 1}
                                    className="absolute right-0 top-1/2 transform -translate-y-1/2 bg-white/20 backdrop-blur-sm rounded-full w-10 h-10 flex items-center justify-center mr-2 z-10 hover:bg-white/30 transition disabled:opacity-50 disabled:cursor-not-allowed"
                                >
                                    <svg className="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 5l7 7-7 7" />
                                    </svg>
                                </button>
                                
                                {/* Indicadores */}
                                <div className="flex justify-center mt-4 space-x-2">
                                    {whatsappMessages.map((_, index) => (
                                        <button 
                                            key={index}
                                            onClick={() => goToWhatsappSlide(index)}
                                            className={`w-3 h-3 rounded-full transition-colors ${
                                                index === whatsappIndex ? 'bg-secondary-400' : 'bg-white/30 hover:bg-white/50'
                                            }`}
                                        ></button>
                                    ))}
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    {/* Botones de redes sociales */}
                    <div className="text-center mt-16 animate-fade-in animation-delay-800">
                        <p className="text-lg text-primary-100 mb-6 max-w-2xl mx-auto">
                            ¿Quieres ver más contenido? Síguenos en nuestras redes sociales para no perderte ninguna de nuestras aventuras.
                        </p>
                        <div className="flex flex-col sm:flex-row justify-center items-center gap-4">
                            <a 
                                href="https://instagram.com/expediciones_allinkay1" 
                                target="_blank"
                                rel="noopener noreferrer"
                                className="flex items-center bg-gradient-to-r from-pink-500 to-purple-600 text-white px-6 py-3 rounded-full font-medium transition transform hover:scale-105 hover:shadow-lg"
                            >
                                <svg className="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zM5.838 12a6.162 6.162 0 1112.324 0 6.162 6.162 0 01-12.324 0zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/>
                                </svg>
                                Mira nuestros últimos registros
                            </a>
                            <a 
                                href="https://www.facebook.com/people/Expediciones-Allinkay/100077454003699/#" 
                                target="_blank"
                                rel="noopener noreferrer"
                                className="flex items-center bg-gradient-to-r from-blue-500 to-blue-700 text-white px-6 py-3 rounded-full font-medium transition transform hover:scale-105 hover:shadow-lg"
                            >
                                <svg className="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                                Síguenos en Facebook
                            </a>
                        </div>
                    </div>
                </div>
            </section>
        </Layout>
    );
}