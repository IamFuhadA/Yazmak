import './bootstrap';

import Alpine from 'alpinejs';
import Lenis from '@studio-freight/lenis';
import gsap from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);

window.Alpine = Alpine;
Alpine.start();

// ─── Smooth Scroll Engine ───────────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', () => {
    const lenis = new Lenis({
        duration: 1.6,
        easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)),
        orientation: 'vertical',
        gestureOrientation: 'vertical',
        smoothWheel: true,
        wheelMultiplier: 1.0,
        smoothTouch: false,
    });

    window.lenis = lenis;

    // Sync Lenis → GSAP ticker
    lenis.on('scroll', ScrollTrigger.update);
    gsap.ticker.add((time) => { lenis.raf(time * 1000); });
    gsap.ticker.lagSmoothing(0);

    // ─── Video Scroll Scrubber ──────────────────────────────────────────────
    // Initialize video: force load then enable scrubbing once metadata is ready.
    const initVideo = () => {
        const video = document.getElementById('scroll-journey-video');
        if (!video) return;

        // Pause immediately — we scrub manually via currentTime
        video.pause();

        const scrub = (scrollY) => {
            const wrapper = document.getElementById('cinematic-wrapper');
            if (!wrapper) return;
            const start = wrapper.offsetTop;
            const height = wrapper.offsetHeight - window.innerHeight;
            const progress = Math.max(0, Math.min(1, (scrollY - start) / Math.max(height, 1)));

            // Broadcast to React camera spline
            window.dispatchEvent(new CustomEvent('cinematic-scroll', { detail: { progress } }));

            // Set video frame
            if (!isNaN(video.duration) && video.duration > 0) {
                video.currentTime = progress * video.duration;
            }
        };

        // When metadata loads, show the first frame
        video.addEventListener('loadedmetadata', () => {
            video.currentTime = 0;
        }, { once: true });

        // Also trigger on Lenis scroll
        lenis.on('scroll', ({ scroll }) => scrub(scroll));

        // Force load the video file
        video.load();
    };

    initVideo();

    // ─── Scroll Reveal ──────────────────────────────────────────────────────
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
