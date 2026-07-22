import * as THREE from 'three';
import { getProject } from '@theatre/core';
import studio from '@theatre/studio';
import gsap from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import { CONFIG, BG_TIMELINE, RIBBON_TIMELINE, FOG_TIMELINE, interpolateTimeline } from './Config.js';
import Time from './core/Time.js';
import Mouse from './core/Mouse.js';
import Camera from './core/Camera.js';
import Renderer from './core/Renderer.js';
import Particles from './world/Particles.js';
import Typography from './world/Typography.js';

gsap.registerPlugin(ScrollTrigger);

if (typeof window !== 'undefined' && import.meta.env.DEV) {
    studio.initialize();
}

export default class Experience {
    constructor(canvas, spacer) {
        if (Experience.instance) {
            return Experience.instance;
        }
        Experience.instance = this;

        this.canvas = canvas;
        this.spacer = spacer || document.getElementById('home-intro-scroll');
        this.disposed = false;

        // UI references
        this.scrollCta = document.getElementById('home-intro-scroll-cta');
        this.progressBar = document.getElementById('home-intro-progress');
        this.skipBtn = document.getElementById('home-intro-skip');
        this.skipBtnMobile = document.getElementById('home-intro-skip-mobile');
        this.heroSection = document.getElementById('hero');

        // Quality detection
        this.isMobile = window.innerWidth < 768;

        // Scroll state
        this.rawProgress = 0;
        this.smoothProgress = 0;
        this.dampFactor = 0.06;

        // Interactive mouse tracking
        this.raycaster = new THREE.Raycaster();
        this.mouse3D = new THREE.Vector3(0, 0, -999);

        this.initEngine();
        this.initWorld();
        this.initEvents();

        // Mark canvas visible immediately
        requestAnimationFrame(() => {
            this.canvas.classList.add('is-ready');
        });
        
        this.tick();
    }

    // ── 2. ENGINE SETUP ──
    initEngine() {
        this.scene = new THREE.Scene();
        this.scene.background = CONFIG.colors.ink950.clone();
        this.scene.fog = new THREE.FogExp2(CONFIG.colors.ink950.clone(), 0.02);

        this.time = new Time();
        this.mouse = new Mouse();
        this.camera = new Camera();
        this.renderer = new Renderer(this.canvas, this.isMobile);

        this.scene.add(this.camera.rig);

        // Initialize Theatre.js project & sheet
        this.project = getProject('Yazmak Cinematic Journey');
        this.sheet = this.project.sheet('Intro Sequence');
        
        // Define animatable object
        this.introObj = this.sheet.object('Intro', {
            uProgress: 0.0,
            fogDensity: 0.02,
            ribbonOpacity: 0.70,
            echoOpacity: 0.10,
            cameraOffsetMag: 0.8
        });

        // Soft, sunlit lights
        this.ambientLight = new THREE.AmbientLight('#ffffff', 0.65);
        this.scene.add(this.ambientLight);

        this.dirLight = new THREE.DirectionalLight('#ffffff', 0.85);
        this.dirLight.position.set(5, 10, 7);
        this.scene.add(this.dirLight);

        this.rimLight = new THREE.DirectionalLight('#7FAE9B', 0.3);
        this.rimLight.position.set(-5, 3, -5);
        this.scene.add(this.rimLight);
    }

    // ── 3. WORLD SYSTEMS SETUP ──
    initWorld() {
        this.curve = this.camera.curve;

        // Primary solid ink-ribbon
        this.ribbonGeometry = new THREE.TubeGeometry(this.curve, 100, 0.12, 8, false);
        this.ribbonMaterial = new THREE.MeshStandardMaterial({
            color: CONFIG.colors.sage.clone().multiplyScalar(0.7),
            roughness: 0.85,
            metalness: 0.05,
            transparent: true,
            opacity: 0.70,
            side: THREE.DoubleSide
        });
        this.ribbonMesh = new THREE.Mesh(this.ribbonGeometry, this.ribbonMaterial);
        this.scene.add(this.ribbonMesh);

        // Secondary wireframe echo ribbon
        this.echoGeometry = new THREE.TubeGeometry(this.curve, 80, 0.35, 4, false);
        this.echoMaterial = new THREE.MeshStandardMaterial({
            color: CONFIG.colors.sage.clone().multiplyScalar(0.7),
            transparent: true,
            opacity: 0.10,
            wireframe: true,
            side: THREE.DoubleSide
        });
        this.echoMesh = new THREE.Mesh(this.echoGeometry, this.echoMaterial);
        this.scene.add(this.echoMesh);

        // Particles
        this.particles = new Particles(this.scene, this.curve, this.isMobile);

        // Typography
        this.typography = new Typography(this.curve);
    }

    updateChoreography(time) {
        // Map scroll to Theatre.js sheet sequence position
        const duration = 10;
        this.sheet.sequence.position = this.smoothProgress * duration;

        // Get animated values from Theatre.js
        const animValues = this.introObj.value;

        // 1. Active progress
        let activeProgress = animValues.uProgress;
        if (activeProgress === 0.0 && this.smoothProgress > 0.0) {
            activeProgress = this.smoothProgress;
        }

        // 2. Background, Fog, and Ribbon Color mapping
        const currentBg = interpolateTimeline(activeProgress, BG_TIMELINE, true);
        const currentRib = interpolateTimeline(activeProgress, RIBBON_TIMELINE, true);

        // 3. Fog Density (fallback to timeline if unconfigured)
        let activeFogDensity = animValues.fogDensity;
        if (activeFogDensity === 0.02) {
            activeFogDensity = interpolateTimeline(activeProgress, FOG_TIMELINE, false);
        }

        this.renderer.instance.setClearColor(currentBg, 1);
        this.scene.background = currentBg;
        this.scene.fog.color.copy(currentBg);
        this.scene.fog.density = activeFogDensity;

        // 4. Ribbon & Echo Opacities (fallback to shimmer if unconfigured)
        let activeRibbonOpacity = animValues.ribbonOpacity;
        if (activeRibbonOpacity === 0.70) {
            activeRibbonOpacity = 0.55 + Math.sin(time * 1.2) * 0.12;
        }

        let activeEchoOpacity = animValues.echoOpacity;
        if (activeEchoOpacity === 0.10) {
            activeEchoOpacity = 0.06 + Math.cos(time * 0.8) * 0.03;
        }

        this.ribbonMaterial.color.copy(currentRib);
        this.echoMaterial.color.copy(currentRib);

        this.ribbonMaterial.opacity = activeRibbonOpacity;
        this.echoMaterial.opacity = activeEchoOpacity;
    }

    tick() {
        if (this.disposed) return;

        this.time.tick();
        this.mouse.update();

        const time = this.time.elapsed + 50.0;
        const smoothMouse = this.mouse;

        const scrollTop = window.scrollY || document.documentElement.scrollTop;
        const startOffset = this.spacer.offsetTop;
        const scrollRange = this.spacer.offsetHeight - window.innerHeight;

        if (scrollRange > 0) {
            this.rawProgress = Math.max(0, Math.min(1, (scrollTop - startOffset) / scrollRange));
        } else {
            this.rawProgress = 0;
        }

        this.smoothProgress += (this.rawProgress - this.smoothProgress) * this.dampFactor;

        this.camera.update(this.smoothProgress, time, smoothMouse);
        this.updateChoreography(time);

        // Update 3D mouse point
        const lookPoint = this.camera.lookPoint;
        if (lookPoint) {
            const planeNormal = new THREE.Vector3().subVectors(this.camera.instance.position, lookPoint).normalize();
            const plane = new THREE.Plane().setFromNormalAndCoplanarPoint(planeNormal, lookPoint);
            
            const mouse2D = new THREE.Vector2(this.mouse.smoothX, this.mouse.smoothY);
            this.raycaster.setFromCamera(mouse2D, this.camera.instance);
            this.raycaster.ray.intersectPlane(plane, this.mouse3D);
        }

        // Update particles
        const currentRib = interpolateTimeline(this.smoothProgress, RIBBON_TIMELINE, true);
        this.particles.update(time, this.mouse3D, currentRib);

        // Update typography
        this.typography.update(this.camera.instance, this.smoothProgress, window.innerWidth, window.innerHeight);

        // UI progress
        if (this.scrollCta) {
            this.scrollCta.style.opacity = Math.max(0, 1 - this.smoothProgress * 15);
        }
        if (this.progressBar) {
            this.progressBar.style.width = `${this.smoothProgress * 100}%`;
        }

        // Toggle active dot layout states
        let active = 0;
        if (this.smoothProgress >= 0.18) active = 1;
        if (this.smoothProgress >= 0.38) active = 2;
        if (this.smoothProgress >= 0.58) active = 3;
        if (this.smoothProgress >= 0.78) active = 4;
        document.querySelectorAll('.journey-dot').forEach((d, i) =>
            d.classList.toggle('is-active', i === active));

        // Fade hero overlay in at the very end of the journey
        const ov = document.getElementById('journey-final-overlay');
        if (ov) {
            const r = Math.max(0, Math.min(1, (this.smoothProgress - 0.88) / 0.08));
            ov.style.opacity = r.toString();
            ov.style.pointerEvents = r > 0.45 ? 'auto' : 'none';
        }
        const isFinished = this.smoothProgress >= 0.88;
        document.documentElement.classList.toggle('intro-complete', isFinished);
        document.documentElement.classList.toggle('intro-finished', isFinished);
        const shouldRevealNav = this.smoothProgress >= 0.10 || isFinished;
        document.documentElement.classList.toggle('reveal-ui', shouldRevealNav);

        this.renderer.render(this.scene, this.camera.instance);
        this.animationFrameId = requestAnimationFrame(() => this.tick());
    }

    initEvents() {
        this.tick = this.tick.bind(this);
        this.handleResize = this.handleResize.bind(this);
        this.handleSkip = this.handleSkip.bind(this);
        this.handleVisibilityChange = this.handleVisibilityChange.bind(this);

        window.addEventListener('resize', this.handleResize);

        document.querySelectorAll('.js-skip-intro, [id*="skip"]').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                this.handleSkip();
            });
        });

        document.getElementById('journey-begin-cta')?.addEventListener('click', e => {
            e.preventDefault();
            this.handleSkip();
        });

        // ScrollTrigger integration for ultra-smooth scroll scrubbing
        this.scrollTrigger = ScrollTrigger.create({
            trigger: this.spacer,
            start: 'top top',
            end: 'bottom bottom',
            scrub: 0.5,
            onUpdate: (self) => {
                this.rawProgress = self.progress;
            }
        });

        // Click dots to scroll to corresponding step segment via Lenis
        const fractions = [0.05, 0.26, 0.46, 0.66, 0.86];
        document.querySelectorAll('.journey-dot').forEach((dot, i) => {
            dot.addEventListener('click', () => {
                const frac = fractions[i];
                const tgt = this.spacer.offsetTop + (this.spacer.offsetHeight - window.innerHeight) * frac;
                if (window.lenis) {
                    window.lenis.scrollTo(tgt, { duration: 1.2 });
                } else {
                    window.scrollTo({ top: tgt, behavior: 'smooth' });
                }
            });
        });

        document.addEventListener('visibilitychange', this.handleVisibilityChange);

        this.observer = new IntersectionObserver(([entry]) => {
            if (entry.isIntersecting && !document.hidden) {
                if (!this.animationFrameId) {
                    this.time.clock.getDelta();
                    this.tick();
                }
            } else {
                if (this.animationFrameId) {
                    cancelAnimationFrame(this.animationFrameId);
                    this.animationFrameId = null;
                }
            }
        }, { threshold: 0 });

        this.observer.observe(this.spacer);
    }

    handleResize() {
        this.isMobile = window.innerWidth < 768;
        this.camera.resize();
        this.renderer.resize();
        this.particles.isMobile = this.isMobile;
        this.particles.material.size = this.isMobile ? 0.06 : 0.10;
    }

    handleSkip() {
        document.documentElement.classList.add('reveal-ui');
        if (this.heroSection) {
            if (window.lenis) {
                window.lenis.scrollTo(this.heroSection, { duration: 1.4 });
            } else {
                this.heroSection.scrollIntoView({ behavior: 'smooth' });
            }
        } else if (this.spacer) {
            const scrollTarget = this.spacer.offsetTop + this.spacer.offsetHeight - window.innerHeight;
            if (window.lenis) {
                window.lenis.scrollTo(scrollTarget, { duration: 1.4 });
            } else {
                window.scrollTo({
                    top: scrollTarget,
                    behavior: 'smooth'
                });
            }
        }
    }

    handleVisibilityChange() {
        if (document.hidden) {
            if (this.animationFrameId) {
                cancelAnimationFrame(this.animationFrameId);
                this.animationFrameId = null;
            }
        } else {
            if (this.spacer.getBoundingClientRect().bottom > 0) {
                if (!this.animationFrameId) {
                    this.time.clock.getDelta();
                    this.tick();
                }
            }
        }
    }

    destroy() {
        if (this.disposed) return;
        this.disposed = true;

        if (this.animationFrameId) {
            cancelAnimationFrame(this.animationFrameId);
            this.animationFrameId = null;
        }

        window.removeEventListener('resize', this.handleResize);
        document.removeEventListener('visibilitychange', this.handleVisibilityChange);

        if (this.skipBtn) this.skipBtn.removeEventListener('click', this.handleSkip);
        if (this.skipBtnMobile) this.skipBtnMobile.removeEventListener('click', this.handleSkip);

        if (this.observer) {
            this.observer.disconnect();
        }

        // Dispose elements
        this.particles.destroy();
        this.mouse.destroy();
        this.renderer.destroy();

        if (this.scrollTrigger) {
            this.scrollTrigger.kill();
        }

        this.scene.remove(this.ribbonMesh);
        this.ribbonGeometry.dispose();
        this.ribbonMaterial.dispose();

        this.scene.remove(this.echoMesh);
        this.echoGeometry.dispose();
        this.echoMaterial.dispose();

        Experience.instance = null;
    }
}
