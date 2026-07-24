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
    // pinned to #cinematic-wrapper's 500vh scroll range, instead of hand-
    // rolling scroll-position math off window.scrollY.
    const initVideo = () => {
        const wrapper = document.getElementById('cinematic-wrapper');
        const actEls = Array.from(document.querySelectorAll('.scroll-act-video'));
        if (!wrapper || actEls.length === 0) return; // not on the landing page

        const acts = actEls.map((video) => ({
            video,
            start: parseFloat(video.dataset.start),
            end: parseFloat(video.dataset.end),
        }));

        // How much of the scroll range (as a fraction, e.g. 0.03 = 3%) each
        // act spends crossfading into/out of its neighbor at zone edges.
        const CROSSFADE = 0.03;

        // Safari (desktop + iOS) silently ignores currentTime scrubs on a
        // video that has never played. A single muted play/pause primes the
        // decoder so later frame-seeks actually paint. This is a no-op on
        // browsers that don't need it.
        const primeVideo = (video) => {
            const playAttempt = video.play();
            if (playAttempt && typeof playAttempt.then === 'function') {
                playAttempt.then(() => video.pause()).catch(() => {
                    /* autoplay was blocked; scrubbing still works on most browsers */
                });
            } else {
                video.pause();
            }
        };

        acts.forEach(({ video }) => {
            primeVideo(video);

            let hasPaintedFrame = false;
            video.addEventListener('error', () => {
                console.error(`[${video.id}] failed to load:`, video.error);
            });
            video.addEventListener('seeked', () => {
                if (!hasPaintedFrame) {
                    hasPaintedFrame = true;
                    video.classList.add('is-ready'); // swap the poster out for the live frame
                }
            });
        });

        const clamp01 = (n) => Math.min(1, Math.max(0, n));

        // Maps overall scroll progress onto each act: how visible it is
        // (for the crossfade) and where it should be scrubbed to internally.
        const setFrame = (progress) => {
            // Broadcast to React camera spline
            window.dispatchEvent(new CustomEvent('cinematic-scroll', { detail: { progress } }));

            acts.forEach(({ video, start, end }) => {
                let opacity;
                if (progress <= start - CROSSFADE || progress >= end + CROSSFADE) {
                    opacity = 0;
                } else if (progress < start + CROSSFADE) {
                    if (start === 0.0) {
                        opacity = 1;
                    } else {
                        opacity = clamp01((progress - (start - CROSSFADE)) / (CROSSFADE * 2));
                    }
                } else if (progress > end - CROSSFADE) {
                    if (end === 1.0) {
                        opacity = 1;
                    } else {
                        opacity = clamp01(1 - (progress - (end - CROSSFADE)) / (CROSSFADE * 2));
                    }
                } else {
                    opacity = 1;
                }

                video.style.opacity = opacity;

                // Only bother scrubbing a video that's at least partially
                // visible — keeps idle acts from fighting for decode time.
                if (opacity > 0.01 && !isNaN(video.duration) && video.duration > 0) {
                    const localProgress = clamp01((progress - start) / (end - start));
                    const t = Math.min(video.duration, Math.max(0, localProgress * video.duration));
                    if (Number.isFinite(t)) {
                        video.currentTime = t;
                    }
                }
            });
        };

        // Initialize step states
        gsap.set(['#landing-journey-step-1', '#landing-journey-step-2', '#landing-journey-step-3'], {
            y: 30,
            opacity: 0,
        });

        // Create the ScrollTrigger-driven Timeline
        const tl = gsap.timeline({
            scrollTrigger: {
                trigger: wrapper,
                start: 'top top',
                end: 'bottom bottom',
                scrub: true,
                onUpdate: (self) => {
                    setFrame(self.progress);
                    
                    // Update the visual scroll progress bar
                    const progressBar = document.getElementById('landing-scroll-progress');
                    if (progressBar) {
                        progressBar.style.setProperty('--landing-scroll-progress', self.progress);
                    }
                },
            }
        });

        // Step 1: In from 0.05 to 0.15, Out from 0.25 to 0.35
        tl.to('#landing-journey-step-1', { opacity: 1, y: 0, duration: 0.1, ease: 'power2.out' }, 0.05)
          .to('#landing-journey-step-1', { opacity: 0, y: -30, duration: 0.1, ease: 'power2.in' }, 0.25);

        // Step 2: In from 0.38 to 0.48, Out from 0.58 to 0.68
        tl.to('#landing-journey-step-2', { opacity: 1, y: 0, duration: 0.1, ease: 'power2.out' }, 0.38)
          .to('#landing-journey-step-2', { opacity: 0, y: -30, duration: 0.1, ease: 'power2.in' }, 0.58);

        // Step 3: In from 0.72 to 0.82, Out from 0.92 to 1.00
        tl.to('#landing-journey-step-3', { opacity: 1, y: 0, duration: 0.1, ease: 'power2.out' }, 0.72)
          .to('#landing-journey-step-3', { opacity: 0, y: -30, duration: 0.08, ease: 'power2.in' }, 0.92);

        const syncInitialFrame = () => {
            if (tl.scrollTrigger) {
                setFrame(tl.scrollTrigger.progress);
            }
        };

        // Every act needs its own metadata before it can be scrubbed —
        // wait on whichever ones aren't ready yet, and re-sync as each lands.
        acts.forEach(({ video }) => {
            if (video.readyState >= 1) {
                syncInitialFrame();
            } else {
                video.addEventListener('loadedmetadata', syncInitialFrame, { once: true });
            }
            video.addEventListener('durationchange', syncInitialFrame);
        });
    };

    initVideo();

    // ─── Word Pull-Up (single style) ────────────────────────────────────────
    // Splits an element's text into words, wraps each for a clipped slide-up
    // reveal, staggered — the landing hero headline uses this.
    gsap.utils.toArray('[data-pullup]').forEach((el) => {
        const words = el.textContent.trim().split(/\s+/);
        el.innerHTML = words
            .map((w) => `<span class="inline-block overflow-hidden"><span class="inline-block pullup-word">${w}</span></span>`)
            .join(' ');

        gsap.fromTo(el.querySelectorAll('.pullup-word'),
            { y: 24, opacity: 0 },
            {
                y: 0,
                opacity: 1,
                duration: 0.6,
                ease: 'power3.out',
                stagger: 0.08,
                scrollTrigger: { trigger: el, start: 'top 85%', toggleActions: 'play none none none' }
            }
        );
    });

    // ─── Word Pull-Up (multi-style segments) ────────────────────────────────
    // data-segments = JSON array of { text, class?, style? } — each segment
    // keeps its own class/style while all words share one stagger sequence.
    gsap.utils.toArray('[data-segments]').forEach((el) => {
        const segments = JSON.parse(el.dataset.segments);
        let html = '';
        segments.forEach((seg) => {
            seg.text.split(/\s+/).forEach((w) => {
                const cls = seg.class ? ` ${seg.class}` : '';
                const style = seg.style ? ` style="${seg.style}"` : '';
                html += `<span class="inline-block overflow-hidden mr-[0.28em]"><span class="inline-block pullup-word${cls}"${style}>${w}</span></span>`;
            });
        });
        el.innerHTML = html;

        gsap.fromTo(el.querySelectorAll('.pullup-word'),
            { y: 24, opacity: 0 },
            {
                y: 0,
                opacity: 1,
                duration: 0.6,
                ease: 'power3.out',
                stagger: 0.08,
                scrollTrigger: { trigger: el, start: 'top 85%', toggleActions: 'play none none none' }
            }
        );
    });

    // ─── Scroll-linked Letter Reveal ─────────────────────────────────────────
    // Splits text into characters; each fades from 0.2 → 1 opacity as the
    // element crosses its scroll window — a progressive "read as you scroll" effect.
    gsap.utils.toArray('[data-letter-reveal]').forEach((el) => {
        const chars = el.textContent.split('').map((c) => (c === ' ' ? '&nbsp;' : c));
        el.innerHTML = chars.map((c) => `<span class="letter" style="opacity:.2;">${c}</span>`).join('');

        gsap.to(el.querySelectorAll('.letter'), {
            opacity: 1,
            stagger: 0.02,
            ease: 'none',
            scrollTrigger: { trigger: el, start: 'top 80%', end: 'top 20%', scrub: true }
        });
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