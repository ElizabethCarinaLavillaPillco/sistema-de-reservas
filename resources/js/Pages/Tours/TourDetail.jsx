import React, { useState, useEffect } from 'react';
import { Head, Link } from '@inertiajs/react';
import Layout from '../../Components/Layout/Layout';
import { Swiper, SwiperSlide } from 'swiper/react';
import { Navigation, Pagination, Autoplay } from 'swiper/modules';

// Importar estilos de Swiper
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';

export default function TourDetail({ tour, toursRecomendados, googleMapsApiKey }) {
    const [activeTab, setActiveTab] = useState('itinerario');
    const [email, setEmail] = useState('');
    const [isMapLoaded, setIsMapLoaded] = useState(false);

    // Función para manejar el envío del formulario de suscripción
    const handleSubscribe = (e) => {
        e.preventDefault();
        // Aquí iría la lógica para enviar el email
        alert(`Gracias por suscribirte con el email: ${email}`);
        setEmail('');
    };

    // Cargar el script de Google Maps cuando el componente se monte
    useEffect(() => {
        if (googleMapsApiKey && !isMapLoaded) {
            const script = document.createElement('script');
            script.src = `https://maps.googleapis.com/maps/api/js?key=${googleMapsApiKey}&callback=initMap`;
            script.async = true;
            script.defer = true;
            document.head.appendChild(script);
            
            window.initMap = () => {
                setIsMapLoaded(true);
                // Inicializar el mapa aquí si es necesario
            };
        }
    }, [googleMapsApiKey, isMapLoaded]);

    return (
        <Layout>
            {/* Todo el contenido de la página de tours */}
            {/* Sección 1: Imagen principal con efecto parallax y nombre del tour */}
            <div className="relative h-96 md:h-[500px] overflow-hidden">
                <div 
                    className="absolute inset-0 bg-cover bg-center bg-fixed transform scale-110" 
                    style={{ backgroundImage: `url(${tour.imagenPrincipal})` }}
                ></div>
                <div className="absolute inset-0 bg-gradient-to-b from-black/70 to-black/40 flex items-center justify-center">
                    <div className="text-center px-4 animate-fade-in">
                        <h1 className="text-4xl md:text-6xl font-bold text-white mb-4">{tour.nombre}</h1>
                        <div className="flex justify-center space-x-2">
                            {[...Array(5)].map((_, i) => (
                                <span key={i} className="text-yellow-400 text-2xl">★</span>
                            ))}
                            <span className="text-white ml-2">({tour.calificacion})</span>
                        </div>
                    </div>
                </div>
            </div>

            {/* Sección 2: Iconos de información */}
            <div className="container mx-auto px-4 py-8 -mt-16 relative z-10">
                <div className="bg-white/90 backdrop-blur-sm rounded-xl shadow-xl p-6 grid grid-cols-2 md:grid-cols-3 lg:grid-cols-7 gap-4">
                    <div className="flex flex-col items-center p-3 rounded-lg hover:bg-primary-50 transition-colors">
                        <span className="text-3xl text-primary-600 mb-2">📍</span>
                        <span className="text-sm font-medium text-gray-700">{tour.ubicacion}</span>
                    </div>
                    <div className="flex flex-col items-center p-3 rounded-lg hover:bg-primary-50 transition-colors">
                        <span className="text-3xl text-primary-600 mb-2">🏞️</span>
                        <span className="text-sm font-medium text-gray-700">{tour.tipo}</span>
                    </div>
                    <div className="flex flex-col items-center p-3 rounded-lg hover:bg-primary-50 transition-colors">
                        <span className="text-3xl text-primary-600 mb-2">⛰️</span>
                        <span className="text-sm font-medium text-gray-700">{tour.altitud}</span>
                    </div>
                    <div className="flex flex-col items-center p-3 rounded-lg hover:bg-primary-50 transition-colors">
                        <span className="text-3xl text-primary-600 mb-2">⏱️</span>
                        <span className="text-sm font-medium text-gray-700">{tour.tiempo}</span>
                    </div>
                    <div className="flex flex-col items-center p-3 rounded-lg hover:bg-primary-50 transition-colors">
                        <span className="text-3xl text-primary-600 mb-2">📅</span>
                        <span className="text-sm font-medium text-gray-700">{tour.duracion}</span>
                    </div>
                    <div className="flex flex-col items-center p-3 rounded-lg hover:bg-primary-50 transition-colors">
                        <span className="text-3xl text-primary-600 mb-2">🌐</span>
                        <span className="text-sm font-medium text-gray-700">{tour.idioma}</span>
                    </div>
                    <div className="flex flex-col items-center p-3 rounded-lg hover:bg-primary-50 transition-colors">
                        <span className="text-3xl text-primary-600 mb-2">👥</span>
                        <span className="text-sm font-medium text-gray-700">{tour.tamanoGrupo}</span>
                    </div>
                </div>
            </div>

            {/* Sección 3: Galería de imágenes */}
            <div className="container mx-auto px-4 py-12">
                <h2 className="text-3xl font-bold text-center mb-8 text-primary-800">Galería</h2>
                <Swiper
                    modules={[Navigation, Pagination, Autoplay]}
                    spaceBetween={10}
                    slidesPerView={1}
                    navigation
                    pagination={{ clickable: true }}
                    autoplay={{ delay: 3000 }}
                    breakpoints={{
                        640: {
                            slidesPerView: 2,
                        },
                        768: {
                            slidesPerView: 3,
                        },
                        1024: {
                            slidesPerView: 4,
                        },
                    }}
                    className="rounded-xl overflow-hidden shadow-lg"
                >
                    {tour.galeria.map((imagen, index) => (
                        <SwiperSlide key={index}>
                            <div className="relative group">
                                <img src={imagen} alt={`Imagen ${index + 1} del tour ${tour.nombre}`} className="w-full h-64 object-cover" />
                                <div className="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-40 transition-all duration-300 flex items-center justify-center">
                                    <span className="text-white opacity-0 group-hover:opacity-100 transform translate-y-4 group-hover:translate-y-0 transition-all duration-300 font-bold">
                                        Ver imagen
                                    </span>
                                </div>
                            </div>
                        </SwiperSlide>
                    ))}
                </Swiper>
            </div>

            {/* Sección 4: Resumen del tour */}
            <div className="container mx-auto px-4 py-8">
                <h2 className="text-3xl font-bold text-center mb-8 text-primary-800">Resumen del Tour</h2>
                <div className="bg-white rounded-xl shadow-lg p-6 max-w-4xl mx-auto">
                    <p className="text-gray-700 leading-relaxed">{tour.resumen}</p>
                </div>
            </div>

            {/* Sección 5: Itinerario, Incluye, No incluye, Recomendaciones, Qué llevar */}
            <div className="container mx-auto px-4 py-8">
                <div className="flex flex-wrap justify-center mb-8 gap-2">
                    {[
                        { id: 'itinerario', label: 'Itinerario' },
                        { id: 'incluye', label: 'Incluye' },
                        { id: 'noIncluye', label: 'No Incluye' },
                        { id: 'recomendaciones', label: 'Recomendaciones' },
                        { id: 'queLlevar', label: 'Qué Llevar' }
                    ].map((tab) => (
                        <button
                            key={tab.id}
                            className={`px-6 py-3 rounded-full font-medium transition-all duration-300 ${
                                activeTab === tab.id 
                                    ? 'bg-primary-600 text-white shadow-lg' 
                                    : 'bg-white text-gray-700 hover:bg-primary-100'
                            }`}
                            onClick={() => setActiveTab(tab.id)}
                        >
                            {tab.label}
                        </button>
                    ))}
                </div>

                <div className="bg-white rounded-xl shadow-lg p-6 max-w-4xl mx-auto">
                    {activeTab === 'itinerario' && (
                        <div className="space-y-6">
                            <h3 className="text-2xl font-bold text-primary-700 mb-4">Itinerario Detallado</h3>
                            <div className="space-y-6">
                                {tour.itinerario.map((dia, index) => (
                                    <div key={index} className="flex">
                                        <div className="flex flex-col items-center mr-4">
                                            <div className="w-10 h-10 rounded-full bg-primary-500 flex items-center justify-center text-white font-bold">
                                                {dia.dia}
                                            </div>
                                            {index < tour.itinerario.length - 1 && (
                                                <div className="h-full w-1 bg-primary-200 mt-2"></div>
                                            )}
                                        </div>
                                        <div className="pb-8">
                                            <h4 className="text-xl font-bold text-gray-800 mb-2">{dia.titulo}</h4>
                                            <p className="text-gray-600">{dia.descripcion}</p>
                                        </div>
                                    </div>
                                ))}
                            </div>
                        </div>
                    )}
                    {activeTab === 'incluye' && (
                        <div>
                            <h3 className="text-2xl font-bold text-primary-700 mb-4">Qué Incluye</h3>
                            <ul className="grid grid-cols-1 md:grid-cols-2 gap-3">
                                {tour.incluye.map((item, index) => (
                                    <li key={index} className="flex items-start">
                                        <span className="text-green-500 mr-2 mt-1">✓</span>
                                        <span className="text-gray-700">{item}</span>
                                    </li>
                                ))}
                            </ul>
                        </div>
                    )}
                    {activeTab === 'noIncluye' && (
                        <div>
                            <h3 className="text-2xl font-bold text-primary-700 mb-4">Qué No Incluye</h3>
                            <ul className="grid grid-cols-1 md:grid-cols-2 gap-3">
                                {tour.noIncluye.map((item, index) => (
                                    <li key={index} className="flex items-start">
                                        <span className="text-red-500 mr-2 mt-1">✗</span>
                                        <span className="text-gray-700">{item}</span>
                                    </li>
                                ))}
                            </ul>
                        </div>
                    )}
                    {activeTab === 'recomendaciones' && (
                        <div>
                            <h3 className="text-2xl font-bold text-primary-700 mb-4">Recomendaciones</h3>
                            <ul className="space-y-2">
                                {tour.recomendaciones.map((item, index) => (
                                    <li key={index} className="flex items-start">
                                        <span className="text-primary-500 mr-2 mt-1">•</span>
                                        <span className="text-gray-700">{item}</span>
                                    </li>
                                ))}
                            </ul>
                        </div>
                    )}
                    {activeTab === 'queLlevar' && (
                        <div>
                            <h3 className="text-2xl font-bold text-primary-700 mb-4">Qué Llevar</h3>
                            <ul className="space-y-2">
                                {tour.queLlevar.map((item, index) => (
                                    <li key={index} className="flex items-start">
                                        <span className="text-primary-500 mr-2 mt-1">•</span>
                                        <span className="text-gray-700">{item}</span>
                                    </li>
                                ))}
                            </ul>
                        </div>
                    )}
                </div>
            </div>

            {/* Sección 6: Ubicación y ruta (Google Maps) */}
            <div className="container mx-auto px-4 py-8">
                <h2 className="text-3xl font-bold text-center mb-8 text-primary-800">Ubicación y Ruta</h2>
                <div className="bg-white rounded-xl shadow-lg p-6 max-w-4xl mx-auto">
                    <div className="h-96 rounded-lg overflow-hidden">
                        {isMapLoaded ? (
                            <iframe
                                title="Mapa de la ruta"
                                width="100%"
                                height="100%"
                                frameBorder="0"
                                style={{ border: 0 }}
                                referrerPolicy="no-referrer-when-downgrade"
                                src={`https://www.google.com/maps/embed/v1/directions?key=${googleMapsApiKey}&origin=Plaza+de+Armas+Cusco&destination=${tour.ubicacionMaps}&mode=driving`}
                                allowFullScreen
                            ></iframe>
                        ) : (
                            <div className="w-full h-full flex items-center justify-center bg-gray-100">
                                <p>Cargando mapa...</p>
                            </div>
                        )}
                    </div>
                    <div className="mt-4 text-center">
                        <p className="text-gray-600">Ruta desde la Plaza de Armas de Cusco hasta {tour.nombre}</p>
                    </div>
                </div>
            </div>

            {/* Sección 7: Preguntas frecuentes */}
            <div className="container mx-auto px-4 py-8">
                <h2 className="text-3xl font-bold text-center mb-8 text-primary-800">Preguntas Frecuentes</h2>
                <div className="max-w-3xl mx-auto space-y-4">
                    {tour.preguntasFrecuentes.map((pregunta, index) => (
                        <div key={index} className="bg-white rounded-xl shadow-md overflow-hidden">
                            <button 
                                className="w-full p-6 text-left font-bold text-lg text-gray-800 hover:bg-primary-50 transition-colors flex justify-between items-center"
                                onClick={() => {
                                    const element = document.getElementById(`respuesta-${index}`);
                                    element.classList.toggle('hidden');
                                }}
                            >
                                {pregunta.pregunta}
                                <span className="text-primary-600">+</span>
                            </button>
                            <div id={`respuesta-${index}`} className="hidden p-6 pt-0 text-gray-600">
                                {pregunta.respuesta}
                            </div>
                        </div>
                    ))}
                </div>
            </div>

            {/* Sección 8: Tours recomendados */}
            <div className="container mx-auto px-4 py-8">
                <h2 className="text-3xl font-bold text-center mb-8 text-primary-800">Tours Recomendados</h2>
                <Swiper
                    modules={[Navigation, Pagination, Autoplay]}
                    spaceBetween={20}
                    slidesPerView={1}
                    navigation
                    pagination={{ clickable: true }}
                    autoplay={{ delay: 3000 }}
                    breakpoints={{
                        640: {
                            slidesPerView: 2,
                        },
                        768: {
                            slidesPerView: 3,
                        },
                        1024: {
                            slidesPerView: 4,
                        },
                    }}
                    className="pb-12"
                >
                    {toursRecomendados.map((tourRec, index) => (
                        <SwiperSlide key={index}>
                            <div className="bg-white rounded-xl shadow-md overflow-hidden hover-lift h-full flex flex-col">
                                <div className="relative">
                                    <img src={tourRec.imagen} alt={tourRec.nombre} className="w-full h-48 object-cover" />
                                    <div className="absolute top-3 right-3 bg-primary-600 text-white px-2 py-1 rounded-full text-sm font-bold">
                                        {tourRec.precio}
                                    </div>
                                </div>
                                <div className="p-5 flex-grow flex flex-col">
                                    <h3 className="font-bold text-lg mb-2 text-gray-800">{tourRec.nombre}</h3>
                                    <p className="text-gray-600 text-sm mb-4 flex-grow">{tourRec.resumen}</p>
                                    <div className="flex justify-between items-center mt-auto">
                                        <div className="flex text-yellow-400">
                                            {'★'.repeat(tourRec.calificacion)}
                                            {'☆'.repeat(5 - tourRec.calificacion)}
                                        </div>
                                        <Link 
                                            href={`/tours/${tourRec.slug}`} 
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
                        </SwiperSlide>
                    ))}
                </Swiper>
            </div>

            {/* Sección 9: Formulario de suscripción */}
            <div className="container mx-auto px-4 py-8">
                <div className="bg-gradient-to-r from-primary-600 to-primary-800 rounded-2xl shadow-xl p-8 md:p-12 text-white max-w-4xl mx-auto">
                    <div className="text-center mb-8">
                        <h2 className="text-3xl font-bold mb-4">¿Quieres recibir más información y ofertas?</h2>
                        <p className="text-primary-100 max-w-2xl mx-auto">
                            Suscríbete a nuestro boletín y recibe las mejores ofertas en tu correo electrónico.
                        </p>
                    </div>
                    <form onSubmit={handleSubscribe} className="max-w-md mx-auto flex flex-col sm:flex-row gap-3">
                        <input
                            type="email"
                            value={email}
                            onChange={(e) => setEmail(e.target.value)}
                            placeholder="Tu correo electrónico"
                            className="flex-grow px-4 py-3 rounded-lg text-gray-800 focus:outline-none focus:ring-2 focus:ring-primary-300"
                            required
                        />
                        <button 
                            type="submit" 
                            className="bg-secondary-500 hover:bg-secondary-600 px-6 py-3 rounded-lg font-bold transition-all duration-300 transform hover:scale-105 shadow-lg"
                        >
                            Suscribirse
                        </button>
                    </form>
                </div>
            </div>

            {/* Sección 10: Opiniones de clientes */}
            <div className="container mx-auto px-4 py-8">
                <h2 className="text-3xl font-bold text-center mb-8 text-primary-800">Opiniones de Nuestros Clientes</h2>
                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 max-w-6xl mx-auto">
                    {tour.opiniones.map((opinion, index) => (
                        <div key={index} className="bg-white rounded-xl shadow-md p-6 hover-lift">
                            <div className="flex items-center mb-4">
                                <img src={opinion.foto} alt={opinion.nombre} className="w-12 h-12 rounded-full object-cover mr-4" />
                                <div>
                                    <h3 className="font-bold text-gray-800">{opinion.nombre}</h3>
                                    <div className="flex text-yellow-400">
                                        {'★'.repeat(opinion.calificacion)}
                                        {'☆'.repeat(5 - opinion.calificacion)}
                                    </div>
                                </div>
                            </div>
                            <p className="text-gray-600 italic">"{opinion.comentario}"</p>
                            <div className="mt-4 text-sm text-gray-500">
                                {opinion.fecha}
                            </div>
                        </div>
                    ))}
                </div>
            </div>
        </Layout>
    );
}