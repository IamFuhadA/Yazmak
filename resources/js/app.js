import './bootstrap';

import Alpine from 'alpinejs';
import Lenis from '@studio-freight/lenis';
import gsap from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);

window.Alpine = Alpine;
Alpine.start();

// Initialize Lenis Smooth Scroll Engine & GSAP ScrollTrigger Synchronization
document.addEventListener('DOMContentLoaded', () => {
    const lenis = new Lenis({
        duration: 1.2,
        easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)),
        orientation: 'vertical',
        gestureOrientation: 'vertical',
        smoothWheel: true,
        wheelMultiplier: 1.0,
        smoothTouch: false,
    });

    window.lenis = lenis;

    // Sync Lenis scroll with GSAP ScrollTrigger
    lenis.on('scroll', ScrollTrigger.update);

    // Add Lenis RAF to GSAP Ticker for frame-perfect sync
    gsap.ticker.add((time) => {
        lenis.raf(time * 1000);
    });

    // Disable lag smoothing in GSAP to prevent visual jumps during smooth scroll
    gsap.ticker.lagSmoothing(0);

    // Global Scroll Reveal animations powered by GSAP & ScrollTrigger
    gsap.utils.toArray('.reveal').forEach((el) => {
        gsap.fromTo(el, 
            { opacity: 0, y: 35 },
            {
                opacity: 1,
                y: 0,
                duration: 0.9,
                ease: 'power3.out',
                scrollTrigger: {
                    trigger: el,
                    start: 'top 88%',
                    toggleActions: 'play none none none'
                }
            }
        );
    });
});

