<!DOCTYPE html>
<html lang="en" class="scroll-smooth {{ !request()->routeIs('home') ? 'intro-complete reveal-ui' : '' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('meta_description', 'Yazmak — A premium interactive portfolio. Crafted with care, written and built.')">
    <title>@yield('title', 'Yazmak — Written & Built')</title>

    {{-- Performance: preconnect to font origin before the stylesheet request --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300..700;1,300..700&family=Manrope:wght@300;400;500;600;700;800&family=Inter:wght@400;500;600;700&family=IBM+Plex+Mono:wght@400;500;600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/webgl-journey.js'])

    @stack('head')

    <style>
        /* ═══════════════════════════════════════════════════════════
           § 1 — Design Tokens — Morning Serenity Palette
           Mental health: Warm Ivory, Sage Green, Ocean Blue, Charcoal.
           Soft, generous, calm, welcoming.
           ═══════════════════════════════════════════════════════════ */
        :root {
            /* ── Neutral Backgrounds ── */
            --ink-950: #F8F7F4;   /* Warm Ivory - Primary Background */
            --ink-900: #F2EEE8;   /* Soft Sand - Secondary Background */
            --ink-850: #FFFFFF;   /* Pure White - Card Background */
            --ink-800: #EEF2F3;   /* Mist Gray - Section Alternate */
            --ink-700: #E8ECEA;   /* Card Border / Soft Gray Divider */
            --ink-600: #C4C9CC;   /* Disabled / Soft Gray */

            /* ── Typography (Neutral Soft Grays & Charcoal) ── */
            --paper:       #2C3436;             /* Charcoal - Main Heading */
            --paper-dim:   #5C666B;             /* Slate Gray - Body Text */
            --paper-muted: #8B9499;             /* Cool Gray - Secondary Text */

            /* ── Accents ── */
            --brass:       #7FAE9B;             /* Sage Green - Primary Accent */
            --brass-light: #6D9C88;             /* Sage Hover */
            --brass-dim:   rgba(127,174,155,.18); /* Sage Dim / Connecting Lines */

            --red:         #5B8FB9;             /* Ocean Blue - Secondary Accent */
            --red-light:   #487AA1;             /* Ocean Blue Hover */
            --red-dim:     rgba(91,143,185,.18);

            /* ── Support Palette ── */
            --sage:        #7FAE9B;             /* Sage Green */
            --sky:         #5B8FB9;             /* Ocean Blue */
            --peach:       #F2C9B6;             /* Soft Peach */
            --coral:       #E8C57A;             /* Golden Sunrise Highlight */

            /* ── Muted text ── */
            --slate:     #8B9499;               /* Cool Gray */
            --slate-dim: rgba(139,148,153,.50);

            /* ── Borders (light mode) ── */
            --line:        #E8ECEA;
            --line-strong: rgba(44,52,54,.10);
            --line-hover:  rgba(127,174,155,.3);

            /* ── Timing (unchanged) ── */
            --ease-out-expo:  cubic-bezier(0.16, 1, 0.3, 1);
            --ease-out-quart: cubic-bezier(0.25, 1, 0.5, 1);
            --duration-fast:   200ms;
            --duration-base:   350ms;
            --duration-slow:   600ms;
            --duration-slower: 900ms;
        }

        /* ═══════════════════════════════════════════════════════════
           § 2 — Base & Reset
           ═══════════════════════════════════════════════════════════ */
        html {
            background: var(--ink-950);
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* Lenis Smooth Scroll resets */
        html.lenis, html.lenis body {
            height: auto;
        }
        .lenis.lenis-smooth {
            scroll-behavior: auto !important;
        }
        .lenis.lenis-smooth [data-lenis-prevent] {
            overscroll-behavior: contain;
        }
        .lenis.lenis-stopped {
            overflow: hidden;
        }

        /* Organimo-Inspired Editorial Badges & Marquee */
        .organimo-badge {
            font-family: 'IBM Plex Mono', monospace;
            font-size: 0.65rem;
            font-weight: 600;
            letter-spacing: 0.22em;
            text-transform: uppercase;
            color: #2C3436;
            background: rgba(127, 174, 155, 0.15);
            border: 1px solid rgba(127, 174, 155, 0.3);
            padding: 0.35rem 0.85rem;
            border-radius: 9999px;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            white-space: nowrap;
        }

        .marquee-track {
            display: flex;
            width: max-content;
            animation: marquee 35s linear infinite;
        }
        .marquee-track:hover {
            animation-play-state: paused;
        }
        @keyframes marquee {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }

        .tracking-editorial {
            letter-spacing: 0.25em;
        }

        body {
            font-family: 'Manrope', ui-sans-serif, system-ui, -apple-system, sans-serif;
            color: var(--paper-dim);
            line-height: 1.8;
            background: var(--ink-950);
        }

        [x-cloak] { display: none !important; }

        /* Selection — mint/sage highlight */
        ::selection {
            background: rgba(127,174,155,.28);
            color: var(--paper);
        }

        /* Scrollbar — soft gray */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: var(--ink-950); }
        ::-webkit-scrollbar-thumb {
            background: var(--ink-700);
            border-radius: 3px;
        }
        ::-webkit-scrollbar-thumb:hover { background: var(--brass); }
        html { scrollbar-color: var(--ink-700) var(--ink-950); scrollbar-width: thin; }

        /* Focus ring */
        :focus-visible {
            outline: 2px solid var(--brass);
            outline-offset: 3px;
            border-radius: 4px;
        }

        /* Smooth image rendering */
        img, video { max-width: 100%; height: auto; display: block; }

        /* ═══════════════════════════════════════════════════════════
           § 3 — Typography
           ═══════════════════════════════════════════════════════════ */
        .font-display { font-family: 'Cormorant Garamond', 'Georgia', serif; }
        .font-mono    { font-family: 'IBM Plex Mono', ui-monospace, 'Courier New', monospace; }

        .eyebrow {
            font-family: 'IBM Plex Mono', monospace;
            font-size: .72rem;
            font-weight: 600;
            letter-spacing: .14em;
            text-transform: uppercase;
            color: var(--brass);
            display: inline-flex;
            align-items: center;
            gap: .5rem;
        }
        .eyebrow::before {
            content: "◆";
            color: var(--coral);
            font-size: 0.7rem;
            line-height: 1;
        }

        .gradient-title {
            font-family: 'Cormorant Garamond', serif;
            color: var(--paper);
        }
        .gradient-title em {
            font-style: italic;
            color: var(--brass);
        }

        /* ═══════════════════════════════════════════════════════════
           § 4 — Layout & Ambient Background
           ═══════════════════════════════════════════════════════════ */
        .site-shell {
            position: relative;
            min-height: 100vh;
            min-height: 100dvh;
            background:
                radial-gradient(ellipse at 10% 12%, rgba(127,174,155,.07), transparent 44rem),
                radial-gradient(ellipse at 90% 18%, rgba(91,143,185,.05), transparent 40rem),
                radial-gradient(ellipse at 50% 90%, rgba(242,201,182,.04), transparent 36rem),
                radial-gradient(ellipse at 72% 55%, rgba(232,197,122,.04), transparent 32rem),
                linear-gradient(180deg, var(--ink-850) 0%, var(--ink-950) 100%);
        }

        .page-section {
            padding-top: clamp(5rem, 10vw, 9rem);
            padding-bottom: clamp(5rem, 10vw, 9rem);
        }

        /* ═══════════════════════════════════════════════════════════
           § 5 — Components
           ═══════════════════════════════════════════════════════════ */

        /* ── Panels ──────────────────────────────────────────────── */
        .soft-panel {
            position: relative;
            background: var(--ink-850);
            border: 1px solid var(--line);
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(44,52,54,.02);
            padding: 2.5rem;
        }
        .soft-panel::before {
            content: "";
            position: absolute;
            top: 0; left: 2rem;
            width: 2rem; height: 3px;
            background: var(--brass);
            border-radius: 0 0 3px 3px;
        }

        /* ── Interactive cards ───────────────────────────────────── */
        /* ── Interactive cards ───────────────────────────────────── */
        .interactive-card {
            position: relative;
            background: #FFFFFF;
            border: 1px solid #E8ECEA;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, .05);
            overflow: hidden;
            transition:
                border-color var(--duration-base) ease,
                transform var(--duration-base) ease,
                box-shadow var(--duration-base) ease;
        }
        .interactive-card:hover {
            border-color: var(--line-hover);
            transform: translateY(-6px);
            box-shadow: 0 30px 60px rgba(0, 0, 0, .08);
        }
        .interactive-card::after {
            content: "";
            position: absolute;
            top: 0; right: 0;
            width: 0; height: 0;
            background: linear-gradient(135deg, transparent 50%, var(--brass-dim) 50%);
            transition: width var(--duration-base) ease, height var(--duration-base) ease;
        }
        .interactive-card:hover::after {
            width: 2.5rem;
            height: 2.5rem;
        }

        /* ── Buttons ─────────────────────────────────────────────── */
        .gradient-button {
            font-family: 'Inter', sans-serif;
            font-weight: 600;
            letter-spacing: .02em;
            background: var(--brass); /* #7FAE9B */
            color: #FFFFFF;
            border: 1px solid var(--brass);
            border-radius: 24px;
            padding: 0.65rem 1.75rem;
            white-space: nowrap;
            transition:
                background var(--duration-base) var(--ease-out-expo),
                color var(--duration-base) var(--ease-out-expo),
                border-color var(--duration-base) var(--ease-out-expo),
                transform var(--duration-fast) ease,
                box-shadow var(--duration-base) ease;
        }
        .gradient-button:hover {
            background: var(--brass-light); /* #6D9C88 */
            border-color: var(--brass-light);
            color: #FFFFFF;
            transform: translateY(-1px);
            box-shadow: 0 8px 20px rgba(127,174,155,.25);
        }

        .ghost-button {
            font-family: 'Inter', sans-serif;
            font-weight: 600;
            letter-spacing: .02em;
            color: var(--paper-dim); /* #5C666B */
            border: 1px solid var(--brass); /* #7FAE9B */
            background: transparent;
            border-radius: 24px;
            padding: 0.65rem 1.75rem;
            white-space: nowrap;
            transition:
                color var(--duration-base) ease,
                border-color var(--duration-base) ease,
                background var(--duration-base) ease;
        }
        .ghost-button:hover {
            color: var(--paper); /* #2C3436 */
            border-color: var(--brass);
            background: #F2EEE8; /* Soft Sand background on hover */
        }

        /* Accent button (Use only for Book Appointment) */
        .accent-button {
            font-family: 'Inter', sans-serif;
            font-weight: 600;
            letter-spacing: .02em;
            background: var(--red); /* #5B8FB9 */
            color: #FFFFFF;
            border: 1px solid var(--red);
            border-radius: 24px;
            padding: 0.65rem 1.75rem;
            white-space: nowrap;
            transition:
                background var(--duration-base) var(--ease-out-expo),
                border-color var(--duration-base) var(--ease-out-expo),
                transform var(--duration-fast) ease,
                box-shadow var(--duration-base) ease;
        }
        .accent-button:hover {
            background: var(--red-light); /* #487AA1 */
            border-color: var(--red-light);
            transform: translateY(-1px);
            box-shadow: 0 8px 20px rgba(91,143,185,.25);
        }

        /* ── Tags ────────────────────────────────────────────────── */
        .tag-note {
            font-family: 'IBM Plex Mono', monospace;
            font-size: .64rem;
            font-weight: 600;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: #FFFFFF;
            background: var(--brass);
            padding: .2rem .6rem;
            border-radius: 4px;
            transform: rotate(-1deg);
            display: inline-block;
        }

        /* ── Links ───────────────────────────────────────────────── */
        .ink-link {
            position: relative;
            color: var(--paper-dim);
            transition: color var(--duration-base) ease;
        }
        .ink-link::after {
            content: "";
            position: absolute;
            left: 0; right: 100%; bottom: -2px;
            height: 1px;
            background: var(--brass);
            transition: right var(--duration-base) var(--ease-out-expo);
        }
        .ink-link:hover { color: var(--paper); }
        .ink-link:hover::after { right: 0; }

        /* ═══════════════════════════════════════════════════════════
           § 6 — Site Header — Morning Serenity Glass
           ═══════════════════════════════════════════════════════════ */
        .site-header {
            position: fixed;
            inset-inline: 0;
            top: 0;
            z-index: 200;
            border-bottom: 1px solid var(--line);
            background: #FFFFFF; /* Pure White background default */
            opacity: 1;
            pointer-events: auto;
            transform: translateY(0);
            transition:
                background var(--duration-slow) var(--ease-out-expo),
                border-color var(--duration-slow) var(--ease-out-expo),
                box-shadow var(--duration-slow) var(--ease-out-expo);
        }
        .site-header.is-scrolled {
            background: rgba(255,255,255,.82); /* Glass effect sticky */
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            border-color: rgba(255,255,255,.35);
            box-shadow: 0 10px 30px rgba(44,52,54,.03);
        }

        /* Logo */
        .logo-mark {
            display: grid;
            place-items: center;
            width: 2.2rem; height: 2.2rem;
            border-radius: 50%;
            border: 1px solid var(--brass);
            background: rgba(127,174,155,.12);
            font-family: 'Cormorant Garamond', serif;
            font-style: italic;
            font-size: 1.0rem;
            color: var(--paper); /* Charcoal logo */
            transition: background var(--duration-base) ease, border-color var(--duration-base) ease;
        }
        .logo-group:hover .logo-mark {
            background: var(--brass-dim);
            border-color: var(--brass);
        }

        /* Nav links */
        .nav-link {
            position: relative;
            font-family: 'Inter', sans-serif;
            font-size: .78rem;
            font-weight: 500;
            letter-spacing: .02em;
            color: var(--paper-dim); /* Slate Gray nav links #5C666B */
            padding: .5rem 1.0rem;
            transition: color var(--duration-base) ease;
        }
        .nav-link:hover { color: var(--brass); } /* Sage hover #7FAE9B */
        .nav-link::after {
            content: "";
            position: absolute;
            bottom: 0; left: 50%; right: 50%;
            height: 2px;
            background: var(--red); /* Ocean active page indicator #5B8FB9 */
            transition: left var(--duration-base) var(--ease-out-expo),
                        right var(--duration-base) var(--ease-out-expo);
        }
        .nav-link:hover::after { left: 1.0rem; right: 1.0rem; }
        .nav-link.is-active { color: var(--red); } /* Ocean active page #5B8FB9 */
        .nav-link.is-active::after { left: 1.0rem; right: 1.0rem; }

        /* Header actions / skip crossfade */
        .site-header-actions {
            opacity: 1;
            pointer-events: auto;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            transition: opacity var(--duration-slow) var(--ease-out-expo);
        }
        .site-header-skip {
            opacity: 0;
            pointer-events: none;
            position: absolute;
            right: 0;
            transition: opacity var(--duration-slow) var(--ease-out-expo);
        }

        html:not(.reveal-ui):not(.intro-complete) .site-header-actions {
            opacity: 0;
            pointer-events: none;
        }
        html:not(.reveal-ui):not(.intro-complete) .site-header-skip {
            opacity: 0.5;
            pointer-events: auto;
        }
        html:not(.reveal-ui):not(.intro-complete) .site-header-skip:hover {
            opacity: 1.0;
        }

        /* Hamburger */
        .nav-toggle-line {
            display: block;
            width: 22px; height: 1.5px;
            background: var(--paper);
            border-radius: 2px;
            transition:
                transform var(--duration-base) var(--ease-out-expo),
                opacity var(--duration-fast) ease,
                width var(--duration-base) var(--ease-out-expo);
        }
        .nav-toggle-line + .nav-toggle-line { margin-top: 5px; }
        .nav-toggle-line.line-short { width: 14px; margin-left: auto; }

        /* ═══════════════════════════════════════════════════════════
           § 7 — Mobile Menu — warm cream full-screen overlay
           ═══════════════════════════════════════════════════════════ */
        .mobile-menu {
            background:
                radial-gradient(ellipse at 25% 18%, rgba(107,191,181,.16), transparent 30rem),
                radial-gradient(ellipse at 75% 82%, rgba(184,160,200,.12), transparent 26rem),
                var(--ink-950);
        }

        .mobile-nav-link {
            font-family: 'Fraunces', serif;
            font-size: 2rem;
            color: var(--paper-dim);
            transition:
                color var(--duration-base) ease,
                transform var(--duration-slow) var(--ease-out-expo),
                opacity var(--duration-slow) var(--ease-out-expo);
        }
        .mobile-nav-link:hover { color: var(--paper); }
        .mobile-nav-link.is-active { color: var(--brass); }

        .mobile-stagger { transition-delay: calc(var(--i, 0) * 80ms + 100ms); }

        /* ═══════════════════════════════════════════════════════════
           § 8 — Site Footer — soft warm cream base
           ═══════════════════════════════════════════════════════════ */
        .site-footer {
            border-top: 1px solid var(--line);
            background:
                radial-gradient(ellipse at 50% 0%, rgba(107,191,181,.08), transparent 32rem),
                var(--ink-900);
        }

        .footer-link {
            font-family: 'IBM Plex Mono', monospace;
            font-size: .78rem;
            letter-spacing: .06em;
            color: var(--slate);
            transition: color var(--duration-base) ease;
        }
        .footer-link:hover { color: var(--paper); }

        .footer-heading {
            font-family: 'IBM Plex Mono', monospace;
            font-size: .66rem;
            font-weight: 600;
            letter-spacing: .16em;
            text-transform: uppercase;
            color: var(--brass);
            margin-bottom: 1.25rem;
        }

        .footer-divider {
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--line-strong) 20%, var(--line-strong) 80%, transparent);
        }

        .back-to-top {
            font-family: 'IBM Plex Mono', monospace;
            font-size: .72rem;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: var(--slate);
            transition: color var(--duration-base) ease;
        }
        .back-to-top:hover { color: var(--brass); }

        /* ═══════════════════════════════════════════════════════════
           § 9 — Cinematic Intro
           ═══════════════════════════════════════════════════════════ */
        .home-intro-scroll { isolation: isolate; }
        .home-intro { background: #A8D8D3; } /* Mint fallback while textures load */
        .home-intro canvas {
            opacity: 0;
            transition: opacity var(--duration-slower) ease;
        }
        .home-intro canvas.is-ready { opacity: 1; }

        /* Desktop nav / mobile toggle during intro */
        /* Staggered header reveal transitions mimicking particle assembly */
        .logo-group, #desktop-nav, .site-header-actions, .nav-mobile-toggle-btn {
            transition: opacity 0.9s var(--ease-out-expo), transform 0.9s var(--ease-out-expo);
        }

        /* Hide elements before reveal-ui */
        html:not(.reveal-ui):not(.intro-complete) .logo-group {
            opacity: 0;
            transform: translateY(-12px) scale(0.96);
            pointer-events: none;
        }
        html:not(.reveal-ui):not(.intro-complete) #desktop-nav {
            opacity: 0;
            transform: translate(-50%, -85%) scale(0.96);
            pointer-events: none;
        }
        html:not(.reveal-ui):not(.intro-complete) .site-header-actions {
            opacity: 0;
            transform: translateY(12px) scale(0.96);
            pointer-events: none;
        }
        html:not(.reveal-ui):not(.intro-complete) .nav-mobile-toggle-btn {
            opacity: 0;
            transform: scale(0.8);
            pointer-events: none;
        }

        /* Smooth transition for skip buttons */
        .site-header-skip {
            transition: opacity var(--duration-slow) var(--ease-out-expo);
        }
        html.reveal-ui .site-header-skip,
        html.intro-complete .site-header-skip {
            opacity: 0 !important;
            pointer-events: none !important;
        }

        /* Stagger navigation link fade-in */
        #desktop-nav .nav-link {
            opacity: 0;
            transform: translateY(-8px);
            transition: opacity 0.8s var(--ease-out-expo), transform 0.8s var(--ease-out-expo);
        }
        html.reveal-ui #desktop-nav .nav-link,
        html.intro-complete #desktop-nav .nav-link {
            opacity: 1;
            transform: translateY(0);
        }
        html.reveal-ui #desktop-nav .nav-link:nth-child(1) { transition-delay: 100ms; }
        html.reveal-ui #desktop-nav .nav-link:nth-child(2) { transition-delay: 180ms; }
        html.reveal-ui #desktop-nav .nav-link:nth-child(3) { transition-delay: 260ms; }
        html.reveal-ui #desktop-nav .nav-link:nth-child(4) { transition-delay: 340ms; }


        /* Scene dot indicators */
        .journey-dot {
            width: 6px; height: 6px;
            border-radius: 50%;
            background: rgba(254,253,251,.35);
            border: 1px solid rgba(254,253,251,.5);
            transition: background 0.4s ease, transform 0.4s ease;
            cursor: pointer;
        }
        .journey-dot.is-active {
            background: rgba(254,253,251,.9);
            transform: scale(1.4);
        }

        /* Final overlay — fades in at end of journey */
        #journey-final-overlay {
            transition: opacity 0.8s var(--ease-out-expo);
        }

        /* ═══════════════════════════════════════════════════════════
           § 10 — Reveal Animations
           ═══════════════════════════════════════════════════════════ */
        .reveal {
            opacity: 0;
            transform: translateY(24px);
            transition:
                opacity var(--duration-slow) var(--ease-out-expo),
                transform var(--duration-slow) var(--ease-out-expo);
        }
        .reveal.is-visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* ═══════════════════════════════════════════════════════════
           § 11 — Page Loader
           ═══════════════════════════════════════════════════════════ */
        .page-loader {
            position: fixed;
            inset: 0;
            z-index: 9999;
            background: var(--ink-950);
            display: grid;
            place-items: center;
            transition:
                opacity 0.8s var(--ease-out-expo),
                visibility 0.8s;
        }
        .page-loader.is-loaded {
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
        }
        .loader-pulse {
            animation: loaderPulse 1.6s ease-in-out infinite;
        }
        @keyframes loaderPulse {
            0%, 100% { opacity: .3; transform: scale(.92); }
            50%      { opacity:  1; transform: scale(1); }
        }

        /* ═══════════════════════════════════════════════════════════
           § 12 — Noise Texture Overlay
           ═══════════════════════════════════════════════════════════ */
        .noise-overlay {
            position: fixed;
            inset: 0;
            z-index: 9990;
            pointer-events: none;
            opacity: .03;
            mix-blend-mode: overlay;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.78' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)'/%3E%3C/svg%3E");
            background-repeat: repeat;
            background-size: 200px 200px;
        }

        /* ═══════════════════════════════════════════════════════════
           § 13 — Utilities
           ═══════════════════════════════════════════════════════════ */
        .text-balance { text-wrap: balance; }

        /* Reduced motion */
        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
            .reveal { opacity: 1; transform: none; }
            .page-loader { display: none; }
        }
    </style>
</head>

<body
    x-data="{
        mobileOpen: false,
        scrolled: false,
        init() {
            this.scrolled = window.scrollY > 40;
            window.addEventListener('scroll', () => {
                this.scrolled = window.scrollY > 40;
            }, { passive: true });
        }
    }"
    :class="{ 'overflow-hidden': mobileOpen }"
    class="antialiased @yield('body_class')"
>

    {{-- ─── Page Loader ──────────────────────────────────────────── --}}
    <div id="page-loader" class="page-loader" aria-hidden="true">
        <div class="loader-pulse">
            <span class="font-display text-4xl italic" style="color:var(--brass);">Y</span>
        </div>
    </div>

    {{-- ─── Noise Texture ────────────────────────────────────────── --}}
    <div class="noise-overlay" aria-hidden="true"></div>

    {{-- ─── Site Shell ───────────────────────────────────────────── --}}
    <div class="site-shell">

        {{-- ═══════════════════════════════════════════════════════════
             HEADER (Slimmer, centered layout preventing middle shift wiggles)
             ═══════════════════════════════════════════════════════════ --}}
        <header
            :class="{ 'is-scrolled': scrolled }"
            class="site-header"
        >
            <nav class="mx-auto flex max-w-7xl items-center justify-between px-5 py-2.5 lg:px-8 relative">

                {{-- Left Logo --}}
                <a href="{{ route('home') }}" class="logo-group flex items-center gap-3" aria-label="Yazmak — go to homepage">
                    <span class="logo-mark">Y</span>
                    <span>
                        <span class="block text-[.90rem] font-semibold leading-none tracking-wide" style="color:var(--paper);">Yazmak</span>
                        <span class="font-mono mt-0.5 block text-[.58rem] uppercase tracking-[.16em]" style="color:var(--slate);">Written &amp; Built</span>
                    </span>
                </a>

                {{-- Desktop Navigation (Strictly Centered Absolute Position to prevent OCD wiggles) --}}
                @php
                    $navLinks = [
                        ['label' => 'Home',     'route' => 'home'],
                        ['label' => 'About',    'route' => 'about'],
                        ['label' => 'Projects', 'route' => 'projects'],
                        ['label' => 'Contact',  'route' => 'contact'],
                    ];
                @endphp

                <div id="desktop-nav" class="hidden items-center gap-1 lg:flex absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2">
                    @foreach($navLinks as $link)
                        <a
                            href="{{ route($link['route']) }}"
                            class="nav-link {{ request()->routeIs($link['route']) ? 'is-active' : '' }}"
                        >
                            {{ $link['label'] }}
                        </a>
                    @endforeach
                </div>

                {{-- Desktop Actions & Dynamic Skip Button (Fades seamlessly over each other) --}}
                <div class="hidden items-center lg:flex relative h-10 w-64 justify-end">
                    <div class="site-header-actions">
                        @auth
                            <a href="{{ route('admin.dashboard') }}" class="ghost-button rounded px-4 py-2 text-xs">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="ghost-button rounded px-4 py-2 text-xs">Login</a>
                        @endauth
                        <a href="{{ route('contact') }}" class="accent-button rounded px-5 py-2.5 text-xs">Book Appointment</a>
                    </div>

                    @if(request()->routeIs('home'))
                    <button
                        type="button"
                        id="header-intro-skip"
                        class="js-skip-intro site-header-skip ghost-button rounded px-4 py-2 text-[.68rem]"
                    >
                        Skip intro
                    </button>
                    @endif
                </div>

                {{-- Mobile Skip & Toggle --}}
                <div class="flex items-center lg:hidden relative h-10 w-24 justify-end">
                    @if(request()->routeIs('home'))
                    <button
                        type="button"
                        id="header-intro-skip-mobile"
                        class="js-skip-intro site-header-skip ghost-button mr-2 rounded px-3 py-1.5 text-[.6rem]"
                    >
                        Skip
                    </button>
                    @endif

                    <button
                        type="button"
                        @click="mobileOpen = !mobileOpen"
                        class="nav-mobile-toggle-btn relative z-[210] flex h-10 w-10 flex-col items-center justify-center gap-0 rounded"
                        style="border:1px solid var(--line-strong);"
                        aria-label="Toggle navigation menu"
                        :aria-expanded="mobileOpen"
                    >
                        <span
                            class="nav-toggle-line"
                            :class="mobileOpen ? 'translate-y-[3.25px] rotate-45' : ''"
                        ></span>
                        <span
                            class="nav-toggle-line line-short"
                            :class="mobileOpen ? 'opacity-0 scale-x-0' : ''"
                        ></span>
                        <span
                            class="nav-toggle-line"
                            :class="mobileOpen ? '-translate-y-[3.25px] -rotate-45' : ''"
                        ></span>
                    </button>
                </div>

            </nav>
        </header>


        {{-- ═══════════════════════════════════════════════════════════
             MOBILE MENU — full-screen overlay
             ═══════════════════════════════════════════════════════════ --}}
        <div
            x-show="mobileOpen"
            x-transition:enter="transition-all duration-500 ease-[cubic-bezier(0.16,1,0.3,1)]"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-all duration-400 ease-[cubic-bezier(0.16,1,0.3,1)]"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            x-cloak
            class="mobile-menu fixed inset-0 z-[200] flex flex-col lg:hidden"
        >
            <div class="flex flex-1 flex-col items-center justify-center gap-6 px-8">
                @foreach($navLinks as $i => $link)
                    <a
                        href="{{ route($link['route']) }}"
                        class="mobile-nav-link mobile-stagger {{ request()->routeIs($link['route']) ? 'is-active' : '' }}"
                        style="--i:{{ $i }}"
                        :class="mobileOpen ? 'translate-y-0 opacity-100' : 'translate-y-4 opacity-0'"
                    >
                        {{ $link['label'] }}
                    </a>
                @endforeach

                <div class="mobile-stagger mt-4 h-px w-16" style="background:var(--line-strong); --i:4"></div>

                <div
                    class="mobile-stagger flex flex-col items-center gap-4"
                    style="--i:5"
                    :class="mobileOpen ? 'translate-y-0 opacity-100' : 'translate-y-4 opacity-0'"
                >
                    @auth
                        <a href="{{ route('admin.dashboard') }}" class="ghost-button rounded px-6 py-3 text-sm">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="ghost-button rounded px-6 py-3 text-sm">Login</a>
                    @endauth
                    <a href="{{ route('contact') }}" class="accent-button rounded px-8 py-3 text-sm">Book Appointment</a>
                </div>
            </div>

            <div class="mobile-stagger px-8 pb-8 text-center" style="--i:6"
                 :class="mobileOpen ? 'translate-y-0 opacity-100' : 'translate-y-4 opacity-0'">
                <p class="font-mono text-[.65rem] uppercase tracking-[.14em]" style="color:var(--slate);">
                    &copy; {{ date('Y') }} Yazmak
                </p>
            </div>
        </div>


        {{-- ═══════════════════════════════════════════════════════════
             MAIN CONTENT
             ═══════════════════════════════════════════════════════════ --}}
        <main>
            @yield('content')
        </main>


        {{-- ═══════════════════════════════════════════════════════════
             FOOTER
             ═══════════════════════════════════════════════════════════ --}}
        <footer class="site-footer">

            {{-- Footer main --}}
            <div class="mx-auto max-w-7xl px-5 lg:px-8">

                <div class="grid gap-12 py-16 md:grid-cols-[1.4fr_1fr_1fr] lg:gap-16 lg:py-20">

                    {{-- Brand column --}}
                    <div>
                        <div class="flex items-center gap-3">
                            <span class="logo-mark">Y</span>
                            <span class="font-display text-xl" style="color:var(--paper);">Yazmak</span>
                        </div>
                        <p class="mt-5 max-w-sm text-sm leading-7" style="color:var(--paper-muted);">
                            Every project starts as a draft. This portfolio is where design meets code — 
                            written with intention, built with craft.
                        </p>
                        <div class="mt-6 flex gap-4">
                            <a href="{{ route('projects') }}" class="gradient-button rounded px-5 py-2.5 text-xs">View Work</a>
                            <a href="{{ route('contact') }}" class="ghost-button rounded px-5 py-2.5 text-xs">Get in Touch</a>
                        </div>
                    </div>

                    {{-- Navigation column --}}
                    <div>
                        <h4 class="footer-heading">Navigate</h4>
                        <nav class="flex flex-col gap-3" aria-label="Footer navigation">
                            @foreach($navLinks as $link)
                                <a href="{{ route($link['route']) }}" class="footer-link">{{ $link['label'] }}</a>
                            @endforeach
                        </nav>
                    </div>

                    {{-- Connect column --}}
                    <div>
                        <h4 class="footer-heading">Connect</h4>
                        <div class="flex flex-col gap-3">
                            <a href="{{ route('contact') }}" class="footer-link">Send a Message</a>
                            @auth
                                <a href="{{ route('admin.dashboard') }}" class="footer-link">Dashboard</a>
                            @endauth
                        </div>

                        <div class="mt-8 rounded-lg p-4" style="background:var(--ink-800); border:1px solid var(--line);">
                            <p class="font-mono text-[.65rem] uppercase tracking-[.12em]" style="color:var(--brass);">Status</p>
                            <p class="mt-1.5 text-sm" style="color:var(--paper-dim);">Available for freelance &amp; collaboration</p>
                        </div>
                    </div>

                </div>

                {{-- Footer divider --}}
                <div class="footer-divider"></div>

                {{-- Footer bottom --}}
                <div class="flex flex-col items-center justify-between gap-4 py-6 sm:flex-row">
                    <p class="font-mono text-[.65rem] tracking-[.08em]" style="color:var(--slate-dim);">
                        &copy; {{ date('Y') }} Yazmak &mdash; Crafted with care.
                    </p>
                    <button
                        type="button"
                        onclick="window.scrollTo({ top: 0, behavior: 'smooth' })"
                        class="back-to-top"
                        aria-label="Scroll back to top"
                    >
                        Back to top &uarr;
                    </button>
                </div>

            </div>
        </footer>

    </div>{{-- /.site-shell --}}


    {{-- ─── Initialization ───────────────────────────────────────── --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            /* Page loader — fade out after assets are ready */
            var loader = document.getElementById('page-loader');
            if (loader) {
                window.addEventListener('load', function () {
                    setTimeout(function () { loader.classList.add('is-loaded'); }, 200);
                });
                /* Safety: force-dismiss after 4s even if load event is delayed */
                setTimeout(function () { loader.classList.add('is-loaded'); }, 4000);
            }

            /* Basic scroll reveal (CSS-only version; GSAP replaces this later) */
            var reveals = document.querySelectorAll('.reveal');
            if (reveals.length && 'IntersectionObserver' in window) {
                var observer = new IntersectionObserver(function (entries) {
                    entries.forEach(function (entry) {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('is-visible');
                            observer.unobserve(entry.target);
                        }
                    });
                }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });
                reveals.forEach(function (el) { observer.observe(el); });
            }
        });
    </script>

    @stack('scripts')

</body>
</html>