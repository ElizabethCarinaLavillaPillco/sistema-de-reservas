// resources/js/hooks/useCarousel.js
import { useState, useEffect } from 'react';

export const useCarousel = (items) => {
    const [currentIndex, setCurrentIndex] = useState(0);

    const moveNext = () => {
        setCurrentIndex(prev => 
            prev < items.length - 1 ? prev + 1 : prev
        );
    };

    const movePrev = () => {
        setCurrentIndex(prev => 
            prev > 0 ? prev - 1 : prev
        );
    };

    const goToSlide = (index) => {
        if (index >= 0 && index < items.length) {
            setCurrentIndex(index);
        }
    };

    // Función para reproducir/pausar video
    const toggleVideo = (videoId) => {
        const video = document.getElementById(videoId);
        if (video) {
            if (video.paused) {
                video.play();
            } else {
                video.pause();
            }
        }
    };

    // Función para actualizar duración del video
    const updateVideoDuration = (videoId, durationId) => {
        const video = document.getElementById(videoId);
        const durationElement = document.getElementById(durationId);
        
        if (video && durationElement) {
            const updateDuration = () => {
                const duration = video.duration;
                if (!isNaN(duration)) {
                    const minutes = Math.floor(duration / 60);
                    const seconds = Math.floor(duration % 60);
                    durationElement.textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;
                }
            };
            
            if (video.readyState >= 1) {
                updateDuration();
            } else {
                video.addEventListener('loadedmetadata', updateDuration, { once: true });
            }
        }
    };

    return { 
        currentIndex,
        moveNext, 
        movePrev,
        goToSlide,
        toggleVideo,
        updateVideoDuration
    };
};