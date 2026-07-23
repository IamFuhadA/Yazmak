@extends('layouts.frontend')

@section('title', 'Yazmak — A Quiet Place to Begin')
@section('meta_description', 'Begin your journey to serenity. Yazmak is a safe space to begin again, navigating exhaustion, anxiety, and depression.')

@section('content')

{{-- ── Scroll Container: real 400vh height drives the video scrub ── --}}
<div id="cinematic-wrapper" class="relative" style="height:400vh; background-color:#12181A;">

    {{-- Sticky full-screen video — pins while #cinematic-wrapper is in view --}}
    <div class="sticky top-0 w-full h-screen overflow-hidden pointer-events-none">

        <video
            id="scroll-journey-video"
            src="/video/no_in_my_video_thers_no_charac.mp4"
            muted
            playsInline
            preload="auto"
            class="absolute inset-0 w-full h-full object-cover"
        ></video>

        {{-- R3F WebGL Canvas Mount --}}
        <div id="home-intro-webgl-root" class="absolute inset-0 w-full h-full z-10"></div>

        {{-- Single soft scrim for text legibility — no blur, no glass --}}
        <div class="absolute inset-0" style="background: linear-gradient(180deg, rgba(18,24,26,.55) 0%, rgba(18,24,26,.25) 40%, rgba(18,24,26,.7) 100%);"></div>

        {{-- Hero copy --}}
        <div id="scene-landing-hero" class="relative z-20 h-full flex flex-col items-center justify-center text-center px-6">
            <div class="max-w-2xl flex flex-col items-center gap-6">

                <p class="font-mono text-[.68rem] uppercase tracking-[.28em] text-white/60 animate-fade-rise">
                    A Safe Space to Begin Again
                </p>

                <h1 class="font-display text-4xl sm:text-6xl md:text-7xl font-normal leading-[1.05] text-white text-balance animate-fade-rise-delay">
                    When your mind<br>
                    <em class="italic" style="color:var(--brass);">needs a quiet place.</em>
                </h1>

                <p class="max-w-md text-sm md:text-base leading-relaxed text-white/70 text-balance animate-fade-rise-delay-2">
                    Yazmak connects you with compassionate professionals — navigating exhaustion, anxiety &amp; depression through personalized guidance.
                </p>

                <span class="mt-4 font-mono text-[.6rem] uppercase tracking-[.3em] text-white/40 animate-fade-rise-delay-2">
                    Scroll to continue
                </span>

            </div>
        </div>
    </div>
</div>

{{-- ── Continuation: plain, light, matches the rest of the site ── --}}
<section id="landing-follow" class="page-section relative z-[110] transition-all duration-1000 ease-out" style="background:var(--ink-950); opacity: 0; pointer-events: none; transform: translateY(20px);">
    <div class="mx-auto max-w-2xl flex flex-col items-center gap-6 px-5 text-center">

        <p class="eyebrow">The Journey Begins</p>

        <h2 class="gradient-title text-3xl sm:text-4xl md:text-5xl font-semibold leading-[1.1] text-balance">
            Step into a <em>quieter headspace.</em>
        </h2>

        <p class="max-w-lg text-base leading-8" style="color:var(--paper-dim);">
            Explore the sanctuary, consult with wellness specialists, and find your path back to serenity.
        </p>

        <div id="enter-btn-wrapper" class="transition-all duration-1000 delay-500 ease-out transform translate-y-4 opacity-0">
            <a href="{{ route('home') }}" class="accent-button rounded mt-2 px-7 py-3.5 text-sm inline-block">
                Enter Yazmak
            </a>
        </div>

    </div>
</section>

@endsection
