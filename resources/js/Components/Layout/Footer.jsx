import React from 'react';
import { Link } from '@inertiajs/react';

export default function Footer() {
    return (
        <>
            {/* Línea divisoria con efecto neon estático */}
            <div className="relative h-1 bg-gradient-to-r from-transparent via-primary-400 to-transparent overflow-hidden">
                <div className="absolute inset-0 bg-gradient-to-r from-transparent via-primary-500 to-transparent opacity-70 blur-sm"></div>
            </div>
            
            <footer className="bg-gradient-to-b from-primary-700 to-primary-900 text-white pt-12 pb-8 relative overflow-hidden">
                {/* Efecto de fondo sutil */}
                <div className="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiPjxkZWZzPjxwYXR0ZXJuIGlkPSJwYXR0ZXJuIiB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHBhdHRlcm5Vbml0cz0idXNlclNwYWNlT25Vc2UiIHBhdHRlcm5UcmFuc2Zvcm09InJvdGF0ZSg0NSkiPjxyZWN0IHg9IjAiIHk9IjAiIHdpZHRoPSIyMCIgaGVpZ2h0PSIyMCIgZmlsbD0icmdiYSgyMCwgMTY1LCAxODEsIDAuMDUpIi8+PC9wYXR0ZXJuPjwvZGVmcz48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSJ1cmwoI3BhdHRlcm4pIi8+PC9zdmc+')] opacity-10"></div>
                
                <div className="container mx-auto px-4 relative z-10">
                    <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                        {/* Logo y descripción */}
                        <div className="flex flex-col items-start space-y-4">
                            <Link href="/" className="flex items-center group">
                                <div className="relative">
                                    <div className="absolute -inset-1 bg-gradient-to-r from-primary-400 to-secondary-400 rounded-lg blur opacity-75 group-hover:opacity-100 transition duration-1000"></div>
                                    <div className="relative bg-white/95 backdrop-blur-sm rounded-xl p-4 h-16 md:h-20 object-contain transition-transform group-hover:scale-105">
                                        <img 
                                            src="/images/logo.png" 
                                            alt="Expediciones Allinkay" 
                                            className="h-full w-auto object-contain"
                                            onError={(e) => {
                                                e.target.src = 'https://via.placeholder.com/150x50/14b8a6/white?text=Turismo+Adventures';
                                            }}
                                        />
                                    </div>
                                </div>
                            </Link>
                            <p className="text-sm text-primary-200 leading-relaxed">
                                Descubre la magia del Perú con nuestros tours personalizados. Vive experiencias únicas en los destinos más impresionantes.
                            </p>
                            <div className="flex space-x-4 mt-2">
                                <a href="#" className="relative group">
                                    <div className="absolute -inset-0.5 bg-gradient-to-r from-blue-500 to-blue-600 rounded-full blur opacity-75 group-hover:opacity-100 transition duration-300"></div>
                                    <div className="relative bg-primary-700/50 backdrop-blur-sm rounded-full w-10 h-10 flex items-center justify-center transition-transform group-hover:scale-110">
                                        <img src="/images/facebook-logo.png" alt="Facebook" className="w-5 h-5" />
                                    </div>
                                </a>
                                <a href="#" className="relative group">
                                    <div className="absolute -inset-0.5 bg-gradient-to-r from-pink-500 to-purple-600 rounded-full blur opacity-75 group-hover:opacity-100 transition duration-300"></div>
                                    <div className="relative bg-primary-700/50 backdrop-blur-sm rounded-full w-10 h-10 flex items-center justify-center transition-transform group-hover:scale-110">
                                        <img src="/images/instagram-logo.webp" alt="Instagram" className="w-5 h-5" />
                                    </div>
                                </a>
                                <a href="#" className="relative group">
                                    <div className="absolute -inset-0.5 bg-gradient-to-r from-green-500 to-green-600 rounded-full blur opacity-75 group-hover:opacity-100 transition duration-300"></div>
                                    <div className="relative bg-primary-700/50 backdrop-blur-sm rounded-full w-10 h-10 flex items-center justify-center transition-transform group-hover:scale-110">
                                        <img src="/images/tiktok-logo.png" alt="WhatsApp" className="w-5 h-5" />
                                    </div>
                                </a>
                                <a href="#" className="relative group">
                                    <div className="absolute -inset-0.5 bg-gradient-to-r from-green-500 to-green-600 rounded-full blur opacity-75 group-hover:opacity-100 transition duration-300"></div>
                                    <div className="relative bg-primary-700/50 backdrop-blur-sm rounded-full w-10 h-10 flex items-center justify-center transition-transform group-hover:scale-110">
                                        <img src="/images/WhatsApp.webp" alt="WhatsApp" className="w-5 h-5" />
                                    </div>
                                </a>
                            </div>
                        </div>

                        {/* Enlaces importantes */}
                        <div className="flex flex-col space-y-3">
                            <h3 className="text-lg font-semibold text-primary-100 mb-2 flex items-center">
                                <span className="w-2 h-2 bg-primary-500 rounded-full mr-2 animate-pulse"></span>
                                Enlaces Importantes
                            </h3>
                            <ul className="space-y-2">
                                <li>
                                    <Link href="/" className="text-primary-200 hover:text-white transition flex items-center group py-1">
                                        <span className="w-1 h-1 bg-primary-400 rounded-full mr-2 group-hover:bg-primary-300 transition-colors"></span>
                                        <span className="relative after:content-[''] after:absolute after:bottom-0 after:left-0 after:w-0 after:h-px after:bg-primary-300 after:transition-all after:duration-300 group-hover:after:w-full">Inicio</span>
                                    </Link>
                                </li>
                                <li>
                                    <Link href="/about" className="text-primary-200 hover:text-white transition flex items-center group py-1">
                                        <span className="w-1 h-1 bg-primary-400 rounded-full mr-2 group-hover:bg-primary-300 transition-colors"></span>
                                        <span className="relative after:content-[''] after:absolute after:bottom-0 after:left-0 after:w-0 after:h-px after:bg-primary-300 after:transition-all after:duration-300 group-hover:after:w-full">Nosotros</span>
                                    </Link>
                                </li>
                                <li>
                                    <Link href="/contact" className="text-primary-200 hover:text-white transition flex items-center group py-1">
                                        <span className="w-1 h-1 bg-primary-400 rounded-full mr-2 group-hover:bg-primary-300 transition-colors"></span>
                                        <span className="relative after:content-[''] after:absolute after:bottom-0 after:left-0 after:w-0 after:h-px after:bg-primary-300 after:transition-all after:duration-300 group-hover:after:w-full">Contacto</span>
                                    </Link>
                                </li>
                                <li>
                                    <Link href="/tourMachu" className="text-primary-200 hover:text-white transition flex items-center group py-1">
                                        <span className="w-1 h-1 bg-primary-400 rounded-full mr-2 group-hover:bg-primary-300 transition-colors"></span>
                                        <span className="relative after:content-[''] after:absolute after:bottom-0 after:left-0 after:w-0 after:h-px after:bg-primary-300 after:transition-all after:duration-300 group-hover:after:w-full">Tours a Machupicchu</span>
                                    </Link>
                                </li>
                                <li>
                                    <Link href="/tourCusco" className="text-primary-200 hover:text-white transition flex items-center group py-1">
                                        <span className="w-1 h-1 bg-primary-400 rounded-full mr-2 group-hover:bg-primary-300 transition-colors"></span>
                                        <span className="relative after:content-[''] after:absolute after:bottom-0 after:left-0 after:w-0 after:h-px after:bg-primary-300 after:transition-all after:duration-300 group-hover:after:w-full">Tours en Cusco</span>
                                    </Link>
                                </li>
                                <li>
                                    <Link href="/toursOtros" className="text-primary-200 hover:text-white transition flex items-center group py-1">
                                        <span className="w-1 h-1 bg-primary-400 rounded-full mr-2 group-hover:bg-primary-300 transition-colors"></span>
                                        <span className="relative after:content-[''] after:absolute after:bottom-0 after:left-0 after:w-0 after:h-px after:bg-primary-300 after:transition-all after:duration-300 group-hover:after:w-full">Otros Destinos</span>
                                    </Link>
                                </li>
                            </ul>
                        </div>

                        {/* Contacto */}
                        <div className="flex flex-col space-y-3">
                            <h3 className="text-lg font-semibold text-primary-100 mb-2 flex items-center">
                                <span className="w-2 h-2 bg-primary-500 rounded-full mr-2 animate-pulse"></span>
                                Contacto
                            </h3>
                            <ul className="space-y-3">
                                <li className="flex items-start group">
                                    <div className="relative">
                                        <div className="absolute -inset-1 bg-gradient-to-r from-primary-500 to-secondary-500 rounded-full blur opacity-0 group-hover:opacity-75 transition duration-300"></div>
                                        <div className="relative bg-primary-700/50 backdrop-blur-sm rounded-full w-8 h-8 flex items-center justify-center mt-0.5">
                                            <span className="text-primary-300">✉️</span>
                                        </div>
                                    </div>
                                    <span className="text-primary-200 ml-3 group-hover:text-white transition-colors">RUC: 20608596861</span>
                                </li>
                                <li className="flex items-start group">
                                    <div className="relative">
                                        <div className="absolute -inset-1 bg-gradient-to-r from-primary-500 to-secondary-500 rounded-full blur opacity-0 group-hover:opacity-75 transition duration-300"></div>
                                        <div className="relative bg-primary-700/50 backdrop-blur-sm rounded-full w-8 h-8 flex items-center justify-center mt-0.5">
                                            <span className="text-primary-300">📞</span>
                                        </div>
                                    </div>
                                    <span className="text-primary-200 ml-3 group-hover:text-white transition-colors">+51 995 669 380</span>
                                </li>
                                <li className="flex items-start group">
                                    <div className="relative">
                                        <div className="absolute -inset-1 bg-gradient-to-r from-primary-500 to-secondary-500 rounded-full blur opacity-0 group-hover:opacity-75 transition duration-300"></div>
                                        <div className="relative bg-primary-700/50 backdrop-blur-sm rounded-full w-8 h-8 flex items-center justify-center mt-0.5">
                                            <span className="text-primary-300">✉️</span>
                                        </div>
                                    </div>
                                    <span className="text-primary-200 ml-3 group-hover:text-white transition-colors">expedicionesallinkay158@gmail.com</span>
                                </li>
                                <li className="flex items-start group">
                                    <div className="relative">
                                        <div className="absolute -inset-1 bg-gradient-to-r from-primary-500 to-secondary-500 rounded-full blur opacity-0 group-hover:opacity-75 transition duration-300"></div>
                                        <div className="relative bg-primary-700/50 backdrop-blur-sm rounded-full w-8 h-8 flex items-center justify-center mt-0.5">
                                            <span className="text-primary-300">📍</span>
                                        </div>
                                    </div>
                                    <span className="text-primary-200 ml-3 group-hover:text-white transition-colors">Cusco, Perú</span>
                                </li>
                            </ul>
                        </div>

                        {/* Seguridad */}
                        <div className="flex flex-col space-y-3">
                            <h3 className="text-lg font-semibold text-primary-100 mb-2 flex items-center">
                                <span className="w-2 h-2 bg-primary-500 rounded-full mr-2 animate-pulse"></span>
                                Seguridad
                            </h3>
                            <ul className="space-y-2">
                                <li>
                                    <Link href="/certificada" className="text-primary-200 hover:text-white transition flex items-center group py-1">
                                        <span className="w-1 h-1 bg-primary-400 rounded-full mr-2 group-hover:bg-primary-300 transition-colors"></span>
                                        <span className="relative after:content-[''] after:absolute after:bottom-0 after:left-0 after:w-0 after:h-px after:bg-primary-300 after:transition-all after:duration-300 group-hover:after:w-full">Agencia Certificada</span>
                                    </Link>
                                </li>
                                <li>
                                    <Link href="/terms" className="text-primary-200 hover:text-white transition flex items-center group py-1">
                                        <span className="w-1 h-1 bg-primary-400 rounded-full mr-2 group-hover:bg-primary-300 transition-colors"></span>
                                        <span className="relative after:content-[''] after:absolute after:bottom-0 after:left-0 after:w-0 after:h-px after:bg-primary-300 after:transition-all after:duration-300 group-hover:after:w-full">Términos y condiciones</span>
                                    </Link>
                                </li>
                                <li>
                                    <Link href="/privacy" className="text-primary-200 hover:text-white transition flex items-center group py-1">
                                        <span className="w-1 h-1 bg-primary-400 rounded-full mr-2 group-hover:bg-primary-300 transition-colors"></span>
                                        <span className="relative after:content-[''] after:absolute after:bottom-0 after:left-0 after:w-0 after:h-px after:bg-primary-300 after:transition-all after:duration-300 group-hover:after:w-full">Política de privacidad</span>
                                    </Link>
                                </li>
                                <li>
                                    <Link href="/payment" className="text-primary-200 hover:text-white transition flex items-center group py-1">
                                        <span className="w-1 h-1 bg-primary-400 rounded-full mr-2 group-hover:bg-primary-300 transition-colors"></span>
                                        <span className="relative after:content-[''] after:absolute after:bottom-0 after:left-0 after:w-0 after:h-px after:bg-primary-300 after:transition-all after:duration-300 group-hover:after:w-full">Formas de pago</span>
                                    </Link>
                                </li>
                                <li>
                                    <Link href="/esnna" className="text-primary-200 hover:text-white transition flex items-center group py-1">
                                        <span className="w-1 h-1 bg-primary-400 rounded-full mr-2 group-hover:bg-primary-300 transition-colors"></span>
                                        <span className="relative after:content-[''] after:absolute after:bottom-0 after:left-0 after:w-0 after:h-px after:bg-primary-300 after:transition-all after:duration-300 group-hover:after:w-full">Código ESNNA</span>
                                    </Link>
                                </li>
                                <li>
                                    <Link href="/datos" className="text-primary-200 hover:text-white transition flex items-center group py-1">
                                        <span className="w-1 h-1 bg-primary-400 rounded-full mr-2 group-hover:bg-primary-300 transition-colors"></span>
                                        <span className="relative after:content-[''] after:absolute after:bottom-0 after:left-0 after:w-0 after:h-px after:bg-primary-300 after:transition-all after:duration-300 group-hover:after:w-full">Protección de datos</span>
                                    </Link>
                                </li>
                            </ul>
                        </div>
                    </div>

                    {/* Copyright */}
                    <div className="border-t border-primary-700 mt-8 pt-6 text-center relative">
                        <div className="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-primary-500 to-transparent"></div>
                        <p className="text-sm text-primary-300">
                            Created by Expediciones Allinkay | Todos los derechos reservados © {new Date().getFullYear()}
                        </p>
                    </div>
                </div>
            </footer>
        </>
    );
}