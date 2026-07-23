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

    // ─── Video Scroll Scrubber (landing page only) ─────────────────────────
    // Ties the hero video's currentTime directly to a ScrollTrigger instance
    // pinned to #cinematic-wrapper's scroll range.
    const initVideo = () => {
        const video = document.getElementById('scroll-journey-video');
        const wrapper = document.getElementById('cinematic-wrapper');
        if (!video || !wrapper) return; // not on the landing page

        video.pause(); // we scrub manually via currentTime

        video.addEventListener('error', () => {
            console.error('[scroll-journey-video] failed to load:', video.error);
        });

        const setFrame = (progress) => {
            // Broadcast to React camera spline
            window.dispatchEvent(new CustomEvent('cinematic-scroll', { detail: { progress } }));

            if (video && !isNaN(video.duration) && video.duration > 0) {
                const t = progress * video.duration;
                if (Number.isFinite(t)) {
                    video.currentTime = t;
                }
            }
        };

        // Create the ScrollTrigger immediately so it works even if metadata is already loaded
        const scrollTrigger = ScrollTrigger.create({
            trigger: wrapper,
            start: 'top top',
            end: 'bottom bottom',
            scrub: true,
            onUpdate: (self) => setFrame(self.progress),
        });

        const syncInitialFrame = () => {
            setFrame(scrollTrigger.progress);
        };

        if (video.readyState >= 1) {
            syncInitialFrame();
        } else {
            video.addEventListener('loadedmetadata', syncInitialFrame, { once: true });
        }

        // Just in case metadata loaded but readyState is not updated, or to force a check
        video.addEventListener('durationchange', syncInitialFrame);
    };

    initVideo();

    // ─── Landing Hero Copy Scroll Fade (landing page only) ───────────────────
    const heroCopy = document.getElementById('scene-landing-hero');
    if (heroCopy) {
        gsap.to(heroCopy, {
            scrollTrigger: {
                trigger: '#cinematic-wrapper',
                start: 'top top',
                end: 'top -25%',
                scrub: true,
            },
            opacity: 0,
            y: -50,
            pointerEvents: 'none',
        });
    }

    // ─── Cinematic Settle Listeners (landing page only) ──────────────────────
    window.addEventListener('cinematic-settled', () => {
        const followSection = document.getElementById('landing-follow');
        if (followSection) {
            followSection.classList.add('is-visible');
        }
    });

    window.addEventListener('cinematic-unsettled', () => {
        const followSection = document.getElementById('landing-follow');
        if (followSection) {
            followSection.classList.remove('is-visible');
        }
    });

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