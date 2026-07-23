@extends('layouts.frontend')

@section('title', 'Yazmak — Cinematic Journey')
@section('meta_description', 'Begin your journey to serenity. Yazmak is a safe space to begin again, navigating exhaustion, anxiety, and depression.')

@section('content')

{{-- ── Scroll Container: Real height drives Lenis progress ── --}}
<div id="cinematic-wrapper" class="relative" style="height:500vh; margin-top: 0; background-color: #090B10;">

    {{-- ── Sticky Full-screen Backdrop (video + R3F layers) ──
         Uses `sticky`, not `fixed`, so it pins to the viewport only
         while #cinematic-wrapper is in view, then scrolls away with
         it once the wrapper's 500vh is exhausted. --}}
    <div class="sticky top-0 w-full h-screen z-0 overflow-hidden pointer-events-none">

        {{-- Local 10-second scrubbed background video --}}
        <video
            id="scroll-journey-video"
            src="/video/no_in_my_video_thers_no_charac.mp4"
            muted
            playsInline
            preload="auto"
            class="absolute inset-0 w-full h-full object-cover"
            style="opacity:0.75;"
        ></video>

        {{-- Bottom blur mask — blurs bottom 45% of frame --}}
        <div class="absolute inset-0"
             style="
                backdrop-filter: blur(14px);
                -webkit-backdrop-filter: blur(14px);
                mask-image: linear-gradient(to top, black 0%, transparent 45%);
                -webkit-mask-image: linear-gradient(to top, black 0%, transparent 45%);
             ">
        </div>

        {{-- R3F WebGL Canvas Mount --}}
        <div id="home-intro-webgl-root" class="absolute inset-0 w-full h-full z-10"></div>
    </div>

    {{-- ── Sticky Viewport Panel (stays in view while scrolling through the 500vh) ── --}}
    <div class="sticky top-0 h-screen w-full flex items-center justify-center z-20
                pointer-events-none select-none overflow-hidden">

        {{-- SCENE 0: Landing Hero Text (visible at scroll start) --}}
        <div id="scene-landing"
             class="absolute inset-0 flex flex-col justify-center items-center text-center px-6">
            <div class="max-w-4xl flex flex-col items-center gap-5">

                {{-- Liquid glass eyebrow badge --}}
                <div class="inline-flex items-center gap-2 rounded-full px-5 py-2
                            border border-white/20 bg-white/10 backdrop-blur-md
                            text-[#8FD3C7] text-xs font-semibold tracking-widest uppercase
                            shadow-xl animate-fade-rise">
                    A Safe Space to Begin Again
                </div>

                {{-- Large serif headline --}}
                <h1 class="font-heading text-5xl sm:text-7xl md:text-8xl lg:text-[6rem]
                            font-normal leading-[0.9] tracking-tight text-white text-balance
                            animate-fade-rise-delay drop-shadow-2xl">
                    When your mind<br>
                    <em class="italic text-[#8FD3C7]">needs a quiet place.</em>
                </h1>

                {{-- Subtitle --}}
                <p class="max-w-xl text-sm md:text-base leading-relaxed text-white/75
                           text-balance animate-fade-rise-delay-2">
                    YAZMAK connects you with compassionate professionals —
                    navigating exhaustion, anxiety &amp; depression through personalized guidance.
                </p>

                {{-- Scroll indicator --}}
                <div class="pt-4 flex flex-col items-center gap-3 animate-fade-rise-delay-2">
                    <span class="font-mono text-[0.58rem] uppercase tracking-[0.3em] text-white/50">
                        Scroll to explore
                    </span>
                    <div class="relative w-5 h-8 rounded-full border border-white/25 flex justify-center p-1">
                        <div class="w-1 h-2 bg-[#8FD3C7] rounded-full animate-bounce"></div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

{{-- ── Follow-to-Homepage Continuation Section ── --}}
<section id="landing-follow" class="relative z-[110] min-h-screen flex items-center justify-center py-20 px-5" style="background: #090B10; margin-top: -1px;">
    <div class="max-w-3xl text-center flex flex-col items-center gap-8">
        {{-- Organimo-inspired glass panel --}}
        <div class="soft-panel rounded-3xl p-10 md:p-16 shadow-2xl flex flex-col items-center gap-6"
             style="background: rgba(255, 255, 255, 0.03); border: 1px solid rgba(255, 255, 255, 0.08); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px);">
            
            {{-- Liquid glass eyebrow badge --}}
            <div class="inline-flex items-center gap-2 rounded-full px-5 py-2
                        border border-white/10 bg-white/5 backdrop-blur-md
                        text-[#8FD3C7] text-xs font-semibold tracking-widest uppercase
                        shadow-xl">
                The Journey Begins
            </div>

            {{-- Large serif headline --}}
            <h2 class="font-heading text-4xl sm:text-5xl md:text-6xl font-normal leading-[1.1] tracking-tight text-white text-balance">
                Step into a <br>
                <em class="italic text-[#8FD3C7]">quieter headspace.</em>
            </h2>

            {{-- Description --}}
            <p class="max-w-lg text-sm md:text-base leading-relaxed text-white/75 text-balance">
                You have reached the threshold. Explore our sanctuary, consult with wellness specialists, and find your path back to serenity.
            </p>

            {{-- Button (Just an Arrow) --}}
            <div class="pt-6">
                <a href="{{ route('home') }}" 
                   class="inline-flex items-center justify-center rounded-full w-16 h-16 transition-all duration-300 hover:scale-110 hover:shadow-2xl shadow-lg border border-white/20 hover:border-white/40 bg-white/10 hover:bg-white/20 group"
                   style="pointer-events: auto;"
                   aria-label="Go to Homepage"
                >
                    <svg class="w-6 h-6 text-[#8FD3C7] group-hover:text-white transition-transform duration-300 group-hover:translate-x-1" 
                         fill="none" 
                         stroke="currentColor" 
                         stroke-width="2" 
                         viewBox="0 0 24 24" 
                         xmlns="http://www.w3.org/2000/svg"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"></path>
                    </svg>
                </a>
            </div>

        </div>
    </div>
</section>

@endsection
