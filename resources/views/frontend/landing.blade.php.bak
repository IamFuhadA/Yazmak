@extends('layouts.frontend')

@section('title', 'Yazmak - A Quiet Place to Begin')
@section('meta_description', 'Begin your journey to serenity. Yazmak is a safe, confidential space for psychiatric guidance, emotional resilience, and mental wellness.')
@section('body_class', 'landing-cinema')

@php
    $displayName = $about?->name ?? 'Yazmak';
    $profession = $about?->profession ?? 'Psychiatry & Mental Wellness Consultancy';
    $description = $about?->description ?? 'A gentle, supportive sanctuary offering professional guidance and remedies for exhaustion, anxiety, and emotional distress.';

    $videos = [
        [
            'label' => 'Golden Hour',
            'src' => 'https://d8j0ntlcm91z4.cloudfront.net/user_38xzZboKViGWJOttwIXH07lWA1P/hf_20260702_081127_0992a171-d3c6-4978-8213-0ec5df8b6d63.mp4',
        ],
        [
            'label' => 'Still Water',
            'src' => 'https://d8j0ntlcm91z4.cloudfront.net/user_38xzZboKViGWJOttwIXH07lWA1P/hf_20260702_092026_dd05b805-ea0f-40b2-8c52-332b88502592.mp4',
        ],
        [
            'label' => 'Deep Woods',
            'src' => 'https://d8j0ntlcm91z4.cloudfront.net/user_38xzZboKViGWJOttwIXH07lWA1P/hf_20260702_081042_df7202bf-bd80-4b2b-bbc6-1f09ba2870e9.mp4',
        ],
        [
            'label' => 'Quiet Dawn',
            'src' => 'https://d8j0ntlcm91z4.cloudfront.net/user_38xzZboKViGWJOttwIXH07lWA1P/hf_20260702_080959_4cac5234-3573-464e-a5b7-76b94b8a7d61.mp4',
        ],
    ];

    $mainSiteLabel = 'Home';
    $act1Video = asset('video/journey-act1.mp4');
    $act2Video = asset('video/journey-act2.mp4');
    $act3Video = asset('video/journey-act3.mp4');

    $act1Poster = asset('images/landing/journey-act1-poster.jpg');
    $act2Poster = asset('images/landing/journey-act2-poster.jpg');
    $act3Poster = asset('images/landing/journey-act3-poster.jpg');
@endphp

@push('head')
<style>
    body.landing-cinema {
        overflow-x: hidden;
        font-family: 'Instrument Serif', serif;
        background: #000;
    }

    body.landing-cinema .site-header,
    body.landing-cinema .page-loader {
        display: none;
    }

    body.landing-cinema .site-shell {
        min-height: 100vh;
        min-height: 100dvh;
        background: #000;
    }

    .landing-body-font {
        font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
    }

    .landing-liquid-glass {
        background: rgba(255, 255, 255, 0.01);
        background-blend-mode: luminosity;
        backdrop-filter: blur(4px);
        -webkit-backdrop-filter: blur(4px);
        border: none;
        box-shadow: inset 0 1px 1px rgba(255, 255, 255, 0.1);
        position: relative;
        overflow: hidden;
    }

    .landing-liquid-glass::before {
        content: '';
        position: absolute;
        inset: 0;
        border-radius: inherit;
        padding: 1.4px;
        background: linear-gradient(180deg,
            rgba(255,255,255,0.45) 0%, rgba(255,255,255,0.15) 20%,
            rgba(255,255,255,0) 40%, rgba(255,255,255,0) 60%,
            rgba(255,255,255,0.15) 80%, rgba(255,255,255,0.45) 100%);
        -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
        -webkit-mask-composite: xor;
        mask-composite: exclude;
        pointer-events: none;
    }

    @keyframes landing-train-bob {
        0%, 100% { transform: translateY(0) scale(1.03); }
        50% { transform: translateY(-6px) scale(1.03); }
    }

    .landing-train-bob {
        animation: landing-train-bob 3s ease-in-out infinite;
    }

    .landing-content-dark {
        color: #182C41;
    }

    .landing-content-dark .landing-muted {
        color: rgba(24, 44, 65, 0.78);
    }

    .landing-content-dark .landing-input {
        color: #182C41;
    }

    .landing-content-dark .landing-input::placeholder {
        color: rgba(24, 44, 65, 0.64);
    }

    .landing-scroll-progress {
        transform: scaleY(var(--landing-scroll-progress, 0));
        transform-origin: top;
    }

    /* Poster shows the instant the section mounts; once the scrubbed video
       reports a real frame it fades away so there's never a blank/black gap. */
    .scroll-act-video {
        background: #000 center / cover no-repeat;
        transition: opacity var(--duration-base) ease;
    }

    #journey-act1 {
        background-image: url('{{ $act1Poster }}');
    }

    #journey-act2 {
        background-image: url('{{ $act2Poster }}');
    }

    #journey-act3 {
        background-image: url('{{ $act3Poster }}');
    }

    .scroll-act-video.is-ready {
        background-image: none;
    }

    /* Quiet scroll cue on the hero — the only signal that a second act
       exists below the fold. Hidden once the visitor has scrolled. */
    .landing-scroll-cue {
        opacity: 1;
        transition: opacity .4s ease;
    }

    .landing-scroll-cue.is-hidden {
        opacity: 0;
        pointer-events: none;
    }

    @keyframes landing-scroll-cue-drift {
        0%, 100% { transform: translateY(0); opacity: .55; }
        50% { transform: translateY(6px); opacity: 1; }
    }

    .landing-scroll-cue-icon {
        animation: landing-scroll-cue-drift 2.2s ease-in-out infinite;
    }

    @media (prefers-reduced-motion: reduce) {
        .landing-train-bob,
        .landing-scroll-cue-icon {
            animation: none !important;
        }

        .landing-scroll-progress {
            transition: none !important;
        }
    }

    .landing-sr-only {
        position: absolute;
        width: 1px;
        height: 1px;
        padding: 0;
        margin: -1px;
        overflow: hidden;
        clip: rect(0, 0, 0, 0);
        white-space: nowrap;
        border: 0;
    }
</style>
@endpush

@section('content')
<section
    x-data="{
        activeVideo: 0,
        videoCount: {{ count($videos) }},
        scrolled: false,
        init() {
            setInterval(() => {
                this.activeVideo = (this.activeVideo + 1) % this.videoCount;
            }, 5000);
            window.addEventListener('scroll', () => {
                this.scrolled = window.scrollY > 40;
            }, { passive: true });
        }
    }"
    class="relative h-screen w-full overflow-hidden bg-black"
>
    <div class="absolute inset-0 z-0">
        @foreach($videos as $index => $video)
            <video
                src="{{ $video['src'] }}"
                autoplay
                muted
                loop
                playsinline
                disablePictureInPicture
                disableRemotePlayback
                preload="{{ $index === 0 ? 'auto' : 'metadata' }}"
                aria-hidden="true"
                class="absolute inset-0 h-full w-full object-cover transition-opacity duration-1000 ease-in-out"
                :class="activeVideo === {{ $index }} ? 'opacity-100' : 'opacity-0'"
            ></video>
        @endforeach
        <div class="absolute inset-0 bg-black/25"></div>
        <p class="landing-sr-only" role="status" x-text="'Ambient background: ' + {{ json_encode(array_column($videos, 'label')) }}[activeVideo]"></p>
    </div>

    <img
        src="https://soft-zoom-63098134.figma.site/_assets/v11/0b4a435b2df2747593c43d7a1c9b4578f7d8d90c.png"
        alt=""
        aria-hidden="true"
        class="landing-train-bob pointer-events-none absolute inset-0 z-[1] h-full w-full object-cover opacity-95"
    >

    <div class="relative z-[2] flex h-full flex-col px-5 py-5 text-white sm:px-8 sm:py-7 lg:px-10">
        <nav class="flex items-center justify-between">
            <a href="{{ route('home') }}" class="text-xl italic leading-none text-white sm:text-2xl" aria-label="{{ $displayName }} home">
                {{ $displayName }}
            </a>

            <a
                href="{{ route('home') }}"
                class="landing-liquid-glass landing-body-font rounded-full px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-white/10"
                aria-label="Go to main site"
            >
                {{ $mainSiteLabel }}
            </a>
        </nav>

        <div
            class="flex flex-1 flex-col items-center justify-center text-center transition-colors duration-700"
            :class="activeVideo === 2 ? 'landing-content-dark' : 'text-white'"
        >
            <div class="mt-4 flex max-w-4xl flex-col items-center">
                <p class="landing-liquid-glass landing-body-font rounded-full px-4 py-2 text-xs font-medium tracking-wide landing-muted text-white/85 sm:text-sm">
                    {{ $profession }}
                </p>

                <h1 class="mt-6 max-w-4xl text-balance text-4xl font-normal leading-[1.1] sm:text-5xl md:text-7xl lg:text-[5.5rem]">
                    Find your way back to<br>
                    <em class="italic">serenity.</em>
                </h1>

                <p class="landing-body-font landing-muted mt-6 max-w-xl text-sm leading-relaxed text-white/78 sm:text-base">
                    {{ $description }}
                </p>

                <div class="landing-liquid-glass landing-body-font mt-8 flex w-full max-w-[320px] items-center gap-2 rounded-full p-1.5 sm:max-w-sm">
                    <input
                        type="email"
                        class="landing-input min-w-0 flex-1 border-0 bg-transparent px-4 py-2 text-sm text-white placeholder:text-white/60 focus:border-0 focus:ring-0"
                        placeholder="Your Best Email"
                        aria-label="Your best email"
                    >
                    <a href="{{ route('contact') }}" class="shrink-0 rounded-full bg-white px-4 py-2.5 text-xs font-semibold text-[#182C41] transition hover:bg-white/90 sm:px-5 sm:text-sm">
                        Book
                    </a>
                </div>

            </div>
        </div>

        <a
            href="#cinematic-wrapper"
            class="landing-scroll-cue absolute bottom-6 left-1/2 z-[2] flex -translate-x-1/2 flex-col items-center gap-2 text-white/70 sm:bottom-8"
            :class="scrolled ? 'is-hidden' : ''"
            aria-label="Scroll to continue"
        >
            <span class="landing-body-font text-[0.62rem] font-semibold uppercase tracking-[0.25em]">Scroll</span>
            <svg class="landing-scroll-cue-icon h-4 w-4" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path d="M3 6L8 11L13 6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </a>
    </div>
</section>

<section id="cinematic-wrapper" class="relative h-[360vh] bg-black">
    <div class="sticky top-0 h-screen w-full overflow-hidden">
        <video
            id="journey-act1"
            class="scroll-act-video absolute inset-0 h-full w-full object-cover"
            data-start="0.00"
            data-end="0.33"
            src="{{ $act1Video }}"
            poster="{{ $act1Poster }}"
            muted
            playsinline
            disablePictureInPicture
            disableRemotePlayback
            preload="auto"
            aria-hidden="true"
            style="opacity: 0;"
        ></video>
        <video
            id="journey-act2"
            class="scroll-act-video absolute inset-0 h-full w-full object-cover"
            data-start="0.33"
            data-end="0.66"
            src="{{ $act2Video }}"
            poster="{{ $act2Poster }}"
            muted
            playsinline
            disablePictureInPicture
            disableRemotePlayback
            preload="auto"
            aria-hidden="true"
            style="opacity: 0;"
        ></video>
        <video
            id="journey-act3"
            class="scroll-act-video absolute inset-0 h-full w-full object-cover"
            data-start="0.66"
            data-end="1.00"
            src="{{ $act3Video }}"
            poster="{{ $act3Poster }}"
            muted
            playsinline
            disablePictureInPicture
            disableRemotePlayback
            preload="auto"
            aria-hidden="true"
            style="opacity: 0;"
        ></video>

        <div class="absolute inset-0 bg-[radial-gradient(circle_at_center,rgba(0,0,0,0)_0%,rgba(0,0,0,.22)_48%,rgba(0,0,0,.72)_100%)]"></div>
        <div class="absolute inset-0 bg-gradient-to-b from-black/35 via-transparent to-black/70"></div>

        <!-- Narrative Overlays (Animated via GSAP ScrollTrigger) -->
        <div id="landing-journey-step-1" class="absolute inset-0 z-10 flex h-full flex-col items-center justify-center px-5 text-center text-white pointer-events-none opacity-0">
            <p class="landing-body-font text-xs font-semibold uppercase tracking-[0.35em] style-color-muted" style="color: rgba(255,255,255,0.5);">
                01 / The Weight
            </p>
            <h2 class="mt-5 max-w-4xl text-balance text-4xl font-normal leading-[1.05] sm:text-5xl md:text-7xl">
                When daily life feels<br>
                <em class="italic" style="color:#FF5A3C;">exhausting.</em>
            </h2>
            <p class="landing-body-font mt-6 max-w-lg text-sm leading-relaxed text-white/60 sm:text-base">
                Anxiety, depression, and burnout can cloud your vision. Recognizing the burden is the first step toward reclaiming your peace.
            </p>
        </div>

        <div id="landing-journey-step-2" class="absolute inset-0 z-10 flex h-full flex-col items-center justify-center px-5 text-center text-white pointer-events-none opacity-0">
            <p class="landing-body-font text-xs font-semibold uppercase tracking-[0.35em] style-color-muted" style="color: rgba(255,255,255,0.5);">
                02 / The Sanctuary
            </p>
            <h2 class="mt-5 max-w-4xl text-balance text-4xl font-normal leading-[1.05] sm:text-5xl md:text-7xl">
                A quiet place<br>
                <em class="italic" style="color:#B6FF3C;">to begin again.</em>
            </h2>
            <p class="landing-body-font mt-6 max-w-lg text-sm leading-relaxed text-white/60 sm:text-base">
                Yazmak offers a confidential, professional psychiatric sanctuary designed to support you with tailored, evidence-based care.
            </p>
        </div>

        <div id="landing-journey-step-3" class="absolute inset-0 z-10 flex h-full flex-col items-center justify-center px-5 text-center text-white pointer-events-none opacity-0">
            <p class="landing-body-font text-xs font-semibold uppercase tracking-[0.35em] style-color-muted" style="color: rgba(255,255,255,0.5);">
                03 / The Path
            </p>
            <h2 class="mt-5 max-w-4xl text-balance text-4xl font-normal leading-[1.05] sm:text-5xl md:text-7xl">
                Step back into<br>
                <em class="italic text-white">your full vitality.</em>
            </h2>
            <p class="landing-body-font mt-6 max-w-lg text-sm leading-relaxed text-white/60 sm:text-base">
                Build lasting emotional resilience, navigate your challenges, and discover a sustainable balance with expert guidance.
            </p>
        </div>

        <div class="landing-body-font absolute right-5 top-1/2 z-20 hidden -translate-y-1/2 flex-col items-center gap-3 text-white/60 sm:flex">
            <span class="text-[0.62rem] font-semibold uppercase tracking-[0.2em] [writing-mode:vertical-rl]">Scroll</span>
            <div class="h-40 w-px overflow-hidden rounded-full bg-white/25">
                <div
                    id="landing-scroll-progress"
                    class="landing-scroll-progress h-full w-full rounded-full bg-white"
                ></div>
            </div>
        </div>
    </div>
</section>

<section class="landing-body-font flex flex-col items-center gap-5 bg-black px-5 py-20 text-center text-white">
    <div class="h-px w-12" style="background: rgba(255,255,255,0.2);"></div>
    <p class="text-[0.62rem] font-semibold uppercase tracking-[0.3em] text-white/45">The journey continues</p>
    <a
        href="{{ route('home') }}"
        class="inline-flex rounded-full bg-white px-7 py-3 text-sm font-semibold text-[#182C41] transition hover:bg-white/90"
    >
        {{ $mainSiteLabel }}
    </a>
</section>
@endsection
