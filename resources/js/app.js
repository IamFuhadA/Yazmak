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

        // Surface load failures (bad codec, 404, etc.) instead of failing silently
        video.addEventListener('error', () => {
            console.error('[scroll-journey-video] failed to load:', video.error);
        });

        const scrub = () => {
            const wrapper = document.getElementById('cinematic-wrapper');
            if (!wrapper) return;

            // Read the real scroll position directly rather than trusting the
            // shape of whatever Lenis passes to its 'scroll' callback — that
            // payload has changed shape across Lenis versions, and destructuring
            // a missing `scroll` key here previously produced NaN, which throws
            // when assigned to video.currentTime (silently, on every scroll
            // tick) and left the video stuck on its first frame forever.
            const scrollY = window.scrollY ?? window.pageYOffset ?? 0;

            const start = wrapper.offsetTop;
            const height = wrapper.offsetHeight - window.innerHeight;
            const progress = Math.max(0, Math.min(1, (scrollY - start) / Math.max(height, 1)));

            // Broadcast to React camera spline
            window.dispatchEvent(new CustomEvent('cinematic-scroll', { detail: { progress } }));

            // Set video frame — only if we land on a real, finite time
            if (!isNaN(video.duration) && video.duration > 0) {
                const t = progress * video.duration;
                if (Number.isFinite(t)) {
                    video.currentTime = t;
                }
            }
        };

        // When metadata loads, show the first frame and sync to current scroll
        video.addEventListener('loadedmetadata', () => {
            video.currentTime = 0;
            scrub();
        }, { once: true });

        // Trigger on every Lenis scroll tick (ignore its event payload — see above)
        lenis.on('scroll', scrub);

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
