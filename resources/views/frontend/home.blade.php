@extends('layouts.frontend')

@section('title', 'Yazmak — Written & Built')
@section('meta_description', 'Yazmak — A premium interactive portfolio. Crafting immersive digital experiences through thoughtful design, clean code, and meaningful interactions.')

@section('content')

@php
    $displayName = $about?->name ?? 'Yazmak Consultancy';
    $profession  = $about?->profession ?? 'Psychiatry & Mental Wellness Consultancy';
    $description = $about?->description ?? 'A gentle, supportive sanctuary offering professional guidance and remedies for exhaustion, anxiety, and emotional distress.';
    $location    = $about?->location ?? null;

    $stages = [
        [
            'mark'  => 'Listen',
            'icon'  => '01',
            'title' => 'Compassionate Listening',
            'body'  => 'Every story matters. We offer a safe, confidential space to hear and understand your unique experiences.',
        ],
        [
            'mark'  => 'Heal',
            'icon'  => '02',
            'title' => 'Tailored Remedies',
            'body'  => 'Personalized psychiatric support and evidence-based guidance to help navigate exhaustion and anxiety.',
        ],
        [
            'mark'  => 'Grow',
            'icon'  => '03',
            'title' => 'Emotional Resilience',
            'body'  => 'Reclaim peace and vitality with the tools and support needed for long-term mental well-being.',
        ],
    ];
@endphp


{{-- ═══════════════════════════════════════════════════════════════════
     § CINEMATIC JOURNEY — 6-Scene Scroll-Driven WebGL Intro
     Journey arc: Water → Underwater → Pool → Forest → Flowers → Sunrise
     Each scene renders a photographic keyframe through GLSL shaders.
     ═══════════════════════════════════════════════════════════════════ --}}
<div
    id="home-intro-scroll"
    class="home-intro-scroll relative"
    style="height:1400vh;"
>
    <div
        id="home-intro"
        class="home-intro sticky top-0 z-[100] h-screen w-full overflow-hidden"
        aria-label="A calming nature journey introducing our mental wellness platform"
    >
        {{-- WebGL Canvas --}}
        <div id="home-intro-webgl-root" class="absolute inset-0 h-full w-full" aria-hidden="true"></div>

        {{-- Subtle top vignette (keeps header area clear) --}}
        <div
            class="pointer-events-none absolute inset-x-0 top-0 h-40"
            style="background:linear-gradient(to bottom, rgba(0,0,0,.08), transparent);"
            aria-hidden="true"
        ></div>

        {{-- Logo watermark --}}
        <div class="pointer-events-none absolute top-6 left-6 z-20 select-none" aria-hidden="true">
            <span class="font-display font-semibold tracking-[0.28em] text-xs text-white/40">YAZMAK</span>
        </div>

        {{-- Floating 3D-Projected Text Beats --}}
        <div id="intro-beat-1" class="absolute z-30 pointer-events-none hidden select-none whitespace-nowrap text-center" style="opacity: 0;">
            <p class="font-mono text-[1.1rem] uppercase tracking-[0.35em]" style="color:#7FAE9B;">Sanctuary</p>
            <h2 class="font-display text-[3.6rem] md:text-[5.2rem] font-bold tracking-[0.18em] mt-3" style="color:#2C3436;">YAZMAK</h2>
        </div>

        <div id="intro-beat-2" class="absolute z-30 pointer-events-none hidden select-none whitespace-nowrap text-center" style="opacity: 0;">
            <p class="font-mono text-[1.1rem] uppercase tracking-[0.3em]" style="color:#5B8FB9;">I. Listen</p>
            <h3 class="font-display text-[2.4rem] md:text-[2.8rem] font-medium tracking-wide mt-2" style="color:#2C3436;">Every journey begins with a safe space.</h3>
        </div>

        <div id="intro-beat-3" class="absolute z-30 pointer-events-none hidden select-none whitespace-nowrap text-center" style="opacity: 0;">
            <p class="font-mono text-[1.1rem] uppercase tracking-[0.3em]" style="color:#7FAE9B;">II. Restore</p>
            <h3 class="font-display text-[2.4rem] md:text-[2.8rem] font-medium tracking-wide mt-2" style="color:#2C3436;">Discovering quiet remedies for exhaustion.</h3>
        </div>

        <div id="intro-beat-4" class="absolute z-30 pointer-events-none hidden select-none whitespace-nowrap text-center" style="opacity: 0;">
            <p class="font-mono text-[1.1rem] uppercase tracking-[0.3em]" style="color:#5B8FB9;">III. Heal</p>
            <h3 class="font-display text-[2.4rem] md:text-[2.8rem] font-medium tracking-wide mt-2" style="color:#2C3436;">Restoring balance and emotional resilience.</h3>
        </div>

        <div id="intro-beat-5" class="absolute z-30 pointer-events-none hidden select-none whitespace-nowrap text-center" style="opacity: 0;">
            <p class="font-mono text-[1.1rem] uppercase tracking-[0.3em]" style="color:#7FAE9B;">IV. Live</p>
            <h3 class="font-display text-[2.4rem] md:text-[2.8rem] font-medium tracking-wide mt-2" style="color:#2C3436;">Step back into a life of serenity.</h3>
        </div>

        {{-- Scene dot navigation --}}
        <div class="absolute right-6 top-1/2 -translate-y-1/2 z-30 flex flex-col gap-3" aria-hidden="true">
            @foreach(['Sanctuary', 'Listen', 'Restore', 'Heal', 'Live'] as $i => $label)
                <button
                    class="journey-dot {{ $i === 0 ? 'is-active' : '' }}"
                    title="{{ $label }}"
                    aria-label="Jump to {{ $label }} scene"
                ></button>
            @endforeach
        </div>

        {{-- Scroll invite --}}
        <div id="home-intro-scroll-cta" class="pointer-events-none absolute bottom-16 left-1/2 z-20 -translate-x-1/2 text-center select-none" aria-hidden="true">
            <p class="font-mono text-[0.58rem] uppercase tracking-[0.22em] text-white/50">Scroll to journey</p>
            <div class="mx-auto mt-2 h-7 w-[1px] bg-white/20 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1/2 bg-white/70 animate-[bounce_2.0s_ease-in-out_infinite]"></div>
            </div>
        </div>

        {{-- Hairline journey progress bar --}}
        <div class="absolute bottom-0 left-0 right-0 z-20 h-[2px] w-full bg-white/10 select-none" aria-hidden="true">
            <div id="home-intro-progress" class="h-full w-0 transition-all duration-100 ease-out" style="background: linear-gradient(90deg, rgba(107,191,181,.9), rgba(242,196,168,.9));"></div>
        </div>

        {{-- Skip button --}}
        <div class="absolute top-6 right-16 z-30 select-none">
            <button
                id="canvas-intro-skip"
                class="js-skip-intro font-mono text-[0.60rem] uppercase tracking-[0.18em] border border-white/15 rounded-full px-5 py-2 hover:bg-white/10 transition-all cursor-pointer opacity-80 text-white/70 hover:text-white hover:opacity-100"
                aria-label="Skip the intro"
            >
                Skip intro
            </button>
        </div>

        {{-- Mobile skip --}}
        <div class="absolute bottom-20 right-4 z-30 select-none md:hidden">
            <button
                id="canvas-intro-skip-mobile"
                class="js-skip-intro font-mono text-[0.58rem] uppercase tracking-[0.15em] text-white/50 py-2 px-3"
                aria-label="Skip intro"
            >Skip ›</button>
        </div>

        {{-- Final scene overlay — fades in with sunrise reveal --}}
        <div
            id="journey-final-overlay"
            class="absolute inset-0 z-40 flex flex-col items-center justify-center text-center px-6 pointer-events-none"
            style="opacity: 0; background: linear-gradient(to top, rgba(254,253,251,.72) 0%, rgba(254,253,251,.22) 60%, transparent 100%);"
            aria-live="polite"
        >
            <p class="eyebrow mb-5 text-[0.68rem]" style="color:rgba(107,191,181,0.9);">A New Day</p>
            <h2 class="gradient-title text-[2.4rem] md:text-[3.5rem] leading-tight mb-4 text-balance" style="color:#2D3B3A;">
                You don't have to carry it <em>alone.</em>
            </h2>
            <p class="text-[1.05rem] max-w-md mx-auto mb-8 text-balance" style="color:rgba(45,59,58,.72);">
                Calm, confidential guidance for those navigating exhaustion, anxiety, and emotional overwhelm.
            </p>
            <a
                href="#hero"
                class="gradient-button rounded-full px-8 py-3 text-sm pointer-events-auto"
                id="journey-begin-cta"
                aria-label="Begin your journey to wellness"
            >
                Find Your Support
            </a>
        </div>
    </div>
</div>



{{-- ═══════════════════════════════════════════════════════════════════
     § HERO
     Primary introduction with name, profession, description,
     and an interactive "creative process" panel.
     
     NOTE: margin-top: -100vh and z-[110] pull the hero up so it overlaps 
     the end of the intro, allowing it to slide up as a premium overlay curtain
     and preventing any black blank screen gaps.
     ═══════════════════════════════════════════════════════════════════ --}}

<section
    id="hero"
    x-data="{ mode: 'Draft' }"
    class="page-section relative z-[110] overflow-hidden border-b"
    style="border-color:var(--line); background: var(--ink-950); margin-top: -100vh;"
>
    <div class="mx-auto max-w-7xl px-5 lg:px-8">
        <div class="grid items-center gap-14 lg:grid-cols-[1.1fr_0.9fr] lg:gap-20">

            {{-- Left — headline --}}
            <div>
                <p class="eyebrow reveal">Psychiatry &amp; Consultancy</p>

                <h1 class="gradient-title reveal mt-6 text-balance text-4xl font-semibold leading-[1.08] md:text-5xl lg:text-7xl">
                    Find your way back to <em>serenity.</em>
                </h1>

                <p class="reveal mt-6 text-xl font-medium md:text-2xl" style="color:var(--brass);">
                    {{ $profession }}
                </p>

                <p class="reveal mt-6 max-w-xl text-base leading-8 md:text-lg" style="color:var(--paper-dim);">
                    {{ $description }}
                </p>

                @if($location)
                    <p class="reveal mt-4 font-mono text-xs uppercase tracking-[.12em]" style="color:var(--slate);">
                        &#9679; Based in {{ $location }}
                    </p>
                @endif

                <div class="reveal mt-10 flex flex-wrap gap-4">
                    <a href="{{ route('contact') }}" class="accent-button rounded px-7 py-3.5 text-sm">
                        Book Appointment
                    </a>
                    <a href="{{ route('contact') }}" class="ghost-button rounded px-7 py-3.5 text-sm">
                        Contact Us
                    </a>
                </div>
            </div>

            {{-- Right — Creative process interactive panel --}}
            <div class="reveal">
                <div class="soft-panel interactive-card overflow-hidden p-1.5">
                    <div class="rounded-lg p-6 md:p-8" style="background:var(--ink-950);">

                        <div class="flex items-center justify-between gap-4">
                            <div>
                                <p class="font-mono text-[.68rem] uppercase tracking-[.14em]" style="color:var(--brass);">
                                    How We Guide You
                                </p>
                                <h3 class="font-display mt-1.5 text-2xl md:text-3xl" style="color:var(--paper);">
                                    Therapy Approach
                                </h3>
                            </div>
                            <span class="tag-note">Support</span>
                        </div>

                        <div class="mt-8 space-y-3">
                            @foreach($stages as $stage)
                                <button
                                    type="button"
                                    @click="mode = '{{ $stage['mark'] }}'"
                                    class="group w-full rounded-lg p-4 text-left transition-all duration-300 md:p-5"
                                    :style="mode === '{{ $stage['mark'] }}'
                                        ? 'background:var(--ink-850); border:1px solid var(--brass-dim);'
                                        : 'background:transparent; border:1px solid var(--line);'"
                                >
                                    <div class="flex items-start gap-4">
                                        <span
                                            class="font-mono mt-0.5 text-[.65rem] font-semibold tracking-[.12em]"
                                            :style="mode === '{{ $stage['mark'] }}' ? 'color:var(--brass);' : 'color:var(--slate);'"
                                        >
                                            {{ $stage['icon'] }}
                                        </span>
                                        <div>
                                            <h4 class="font-display text-lg transition-colors duration-300" style="color:var(--paper);">
                                                {{ $stage['mark'] }} <span class="text-sm" style="color:var(--paper-muted);">&mdash; {{ $stage['title'] }}</span>
                                            </h4>
                                            <p
                                                x-show="mode === '{{ $stage['mark'] }}'"
                                                x-transition:enter="transition-all duration-300 ease-out"
                                                x-transition:enter-start="opacity-0 -translate-y-1"
                                                x-transition:enter-end="opacity-100 translate-y-0"
                                                class="mt-2 text-sm leading-6"
                                                style="color:var(--paper-dim);"
                                            >
                                                {{ $stage['body'] }}
                                            </p>
                                        </div>
                                    </div>
                                </button>
                            @endforeach
                        </div>

                        {{-- Stats row --}}
                        <div class="mt-6 grid grid-cols-3 gap-3">
                            <div class="rounded-lg p-3 text-center" style="background:var(--ink-850); border: 1px solid var(--line);">
                                <strong class="font-display block text-2xl" style="color:var(--paper);">12+</strong>
                                <span class="font-mono text-[.6rem] uppercase tracking-[.1em]" style="color:var(--slate);">Yrs Exp</span>
                            </div>
                            <div class="rounded-lg p-3 text-center" style="background:var(--ink-850); border: 1px solid var(--line);">
                                <strong class="font-display block text-2xl" style="color:var(--paper);">98%</strong>
                                <span class="font-mono text-[.6rem] uppercase tracking-[.1em]" style="color:var(--slate);">Recovery</span>
                            </div>
                            <div class="rounded-lg p-3 text-center" style="background:var(--ink-850); border: 1px solid var(--line);">
                                <strong class="font-display block text-2xl" style="color:var(--paper);">100%</strong>
                                <span class="font-mono text-[.6rem] uppercase tracking-[.1em]" style="color:var(--slate);">Private</span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════════
     § ORGANIMO-STYLE INFINITE BADGES MARQUEE
     Continuous ticker featuring key sanctuary credentials.
     ═══════════════════════════════════════════════════════════════════ --}}
<section class="relative z-[115] overflow-hidden py-8 border-b" style="border-color:var(--line); background:var(--ink-900);">
    <div class="pointer-events-none absolute left-0 top-0 bottom-0 z-10 w-24 bg-gradient-to-r from-[var(--ink-900)] to-transparent"></div>
    <div class="pointer-events-none absolute right-0 top-0 bottom-0 z-10 w-24 bg-gradient-to-l from-[var(--ink-900)] to-transparent"></div>
    
    <div class="marquee-track flex items-center gap-6">
        @foreach(range(1, 2) as $loop)
            <div class="flex items-center gap-6">
                <span class="organimo-badge">
                    <span class="w-1.5 h-1.5 rounded-full bg-[var(--brass)]"></span>
                    100% Confidential Sanctuary
                </span>
                <span class="organimo-badge">
                    <span class="w-1.5 h-1.5 rounded-full bg-[var(--red)]"></span>
                    Certified Psychiatric Guidance
                </span>
                <span class="organimo-badge">
                    <span class="w-1.5 h-1.5 rounded-full bg-[var(--brass)]"></span>
                    Evidence-Based Remedies
                </span>
                <span class="organimo-badge">
                    <span class="w-1.5 h-1.5 rounded-full bg-[var(--red)]"></span>
                    Tailored Wellness Care
                </span>
                <span class="organimo-badge">
                    <span class="w-1.5 h-1.5 rounded-full bg-[var(--brass)]"></span>
                    Non-Judgmental Listening
                </span>
                <span class="organimo-badge">
                    <span class="w-1.5 h-1.5 rounded-full bg-[var(--red)]"></span>
                    Long-Term Resilience
                </span>
            </div>
        @endforeach
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════════
     § STACKED CARE & REMEDY CARDS (ORGANIMO-STYLE SCROLL STACK)
     Sequential scroll-pinned cards detailing consultation remedies.
     ═══════════════════════════════════════════════════════════════════ --}}
<section id="stacked-care" class="page-section relative z-[115] border-b" style="border-color:var(--line); background:var(--ink-950);">
    <div class="mx-auto max-w-7xl px-5 lg:px-8">
        <div class="reveal text-center max-w-3xl mx-auto mb-16 md:mb-24">
            <p class="organimo-badge mx-auto mb-4">
                <span class="w-1.5 h-1.5 rounded-full bg-[var(--brass)]"></span>
                The Healing Journey
            </p>
            <h2 class="gradient-title text-4xl md:text-5xl lg:text-6xl font-semibold tracking-tight text-balance">
                Tailored care for <em>mind &amp; spirit.</em>
            </h2>
            <p class="mt-4 text-base md:text-lg" style="color:var(--paper-dim);">
                A structured, compassionate approach engineered to guide you from exhaustion back into serene vitality.
            </p>
        </div>

        {{-- Stacked Card Sequence Container --}}
        <div class="relative space-y-8 md:space-y-12 max-w-5xl mx-auto pb-12">

            {{-- Card 01 --}}
            <div class="sticky top-28 z-[10] transition-all duration-500">
                <div class="soft-panel interactive-card p-8 md:p-12 rounded-2xl border bg-white shadow-xl" style="border-color:var(--line);">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                        <div class="space-y-3 max-w-2xl">
                            <div class="flex items-center gap-3">
                                <span class="font-mono text-xs uppercase tracking-[0.2em] font-bold text-[var(--brass)]">01 / Listen</span>
                                <span class="h-px w-8 bg-[var(--brass-dim)]"></span>
                            </div>
                            <h3 class="font-display text-2xl md:text-3xl font-semibold text-[var(--paper)]">
                                Compassionate Listening
                            </h3>
                            <p class="text-base leading-7 text-[var(--paper-dim)]">
                                Every story matters. We offer a safe, confidential sanctuary to hear and understand your unique experiences without judgment or pressure.
                            </p>
                        </div>
                        <div class="flex-shrink-0">
                            <span class="w-16 h-16 rounded-full flex items-center justify-center font-display text-2xl font-bold bg-[var(--brass-dim)] text-[var(--brass)]">
                                01
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Card 02 --}}
            <div class="sticky top-32 z-[20] transition-all duration-500">
                <div class="soft-panel interactive-card p-8 md:p-12 rounded-2xl border bg-white shadow-2xl" style="border-color:var(--line);">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                        <div class="space-y-3 max-w-2xl">
                            <div class="flex items-center gap-3">
                                <span class="font-mono text-xs uppercase tracking-[0.2em] font-bold text-[var(--red)]">02 / Restore</span>
                                <span class="h-px w-8 bg-[var(--red-dim)]"></span>
                            </div>
                            <h3 class="font-display text-2xl md:text-3xl font-semibold text-[var(--paper)]">
                                Tailored Psychiatric Remedies
                            </h3>
                            <p class="text-base leading-7 text-[var(--paper-dim)]">
                                Personalized psychiatric support and evidence-based remedies carefully designed to navigate exhaustion, anxiety, and emotional distress.
                            </p>
                        </div>
                        <div class="flex-shrink-0">
                            <span class="w-16 h-16 rounded-full flex items-center justify-center font-display text-2xl font-bold bg-[var(--red-dim)] text-[var(--red)]">
                                02
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Card 03 --}}
            <div class="sticky top-36 z-[30] transition-all duration-500">
                <div class="soft-panel interactive-card p-8 md:p-12 rounded-2xl border bg-white shadow-2xl" style="border-color:var(--line);">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                        <div class="space-y-3 max-w-2xl">
                            <div class="flex items-center gap-3">
                                <span class="font-mono text-xs uppercase tracking-[0.2em] font-bold text-[var(--brass)]">03 / Heal</span>
                                <span class="h-px w-8 bg-[var(--brass-dim)]"></span>
                            </div>
                            <h3 class="font-display text-2xl md:text-3xl font-semibold text-[var(--paper)]">
                                Emotional Resilience
                            </h3>
                            <p class="text-base leading-7 text-[var(--paper-dim)]">
                                Reclaim inner peace and vitality with practical tools and cognitive strategies needed for sustainable, long-term mental well-being.
                            </p>
                        </div>
                        <div class="flex-shrink-0">
                            <span class="w-16 h-16 rounded-full flex items-center justify-center font-display text-2xl font-bold bg-[var(--brass-dim)] text-[var(--brass)]">
                                03
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Card 04 --}}
            <div class="sticky top-40 z-[40] transition-all duration-500">
                <div class="soft-panel interactive-card p-8 md:p-12 rounded-2xl border bg-[var(--paper)] text-white shadow-2xl" style="border-color:var(--paper);">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                        <div class="space-y-3 max-w-2xl">
                            <div class="flex items-center gap-3">
                                <span class="font-mono text-xs uppercase tracking-[0.2em] font-bold text-[var(--peach)]">04 / Live</span>
                                <span class="h-px w-8 bg-white/20"></span>
                            </div>
                            <h3 class="font-display text-2xl md:text-3xl font-semibold text-white">
                                Sustained Sanctuary &amp; Serenity
                            </h3>
                            <p class="text-base leading-7 text-white/80">
                                Step back into a restored, balanced life backed by compassionate professional consultation and ongoing support every step of the way.
                            </p>
                        </div>
                        <div class="flex-shrink-0">
                            <a href="{{ route('contact') }}" class="accent-button rounded-full px-8 py-3.5 text-sm inline-block">
                                Book Consultation &rarr;
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>


{{-- ═══════════════════════════════════════════════════════════════════
     § SKILLS
     Animated skill bars with percentages.
     ═══════════════════════════════════════════════════════════════════ --}}

@if($skills->count())
<section
    id="skills"
    class="page-section border-b"
    style="border-color:var(--line);"
>
    <div class="mx-auto max-w-7xl px-5 lg:px-8">

        <div class="reveal flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
            <div>
                <p class="eyebrow">Focus Areas</p>
                <h2 class="gradient-title mt-3 text-3xl font-semibold md:text-4xl lg:text-5xl">
                    Specialties &amp; <em>Treatments</em>
                </h2>
            </div>
            <a href="{{ route('about') }}" class="ink-link font-mono text-xs uppercase tracking-[.12em]">
                Learn more &rarr;
            </a>
        </div>

        <div
            x-data="{ revealed: false }"
            x-intersect.once="revealed = true"
            class="mt-12 grid gap-5 md:grid-cols-2 lg:grid-cols-3 lg:mt-16"
        >
            @foreach($skills as $index => $skill)
                <div
                    class="reveal soft-panel interactive-card p-6"
                    style="transition-delay: {{ $index * 60 }}ms;"
                >
                    <div class="flex items-center justify-between gap-4">
                        <h3 class="font-display text-lg md:text-xl" style="color:var(--paper);">
                            {{ $skill->name }}
                        </h3>
                        <span
                            class="font-mono rounded px-2 py-0.5 text-sm font-semibold"
                            style="background:var(--brass-dim); color:var(--brass);"
                        >
                            {{ $skill->percentage }}%
                        </span>
                    </div>

                    <div class="mt-5 h-1.5 overflow-hidden rounded-full" style="background:var(--ink-700);">
                        <div
                            class="h-full rounded-full transition-all duration-1000 ease-out"
                            style="background:linear-gradient(90deg, var(--red), var(--brass));"
                            :style="revealed ? 'width:{{ $skill->percentage }}%' : 'width:0%'"
                        ></div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</section>
@endif


{{-- ═══════════════════════════════════════════════════════════════════
     § FEATURED PROJECTS
     Project cards with images, tech badges, and hover effects.
     ═══════════════════════════════════════════════════════════════════ --}}

<section id="projects" class="page-section">
    <div class="mx-auto max-w-7xl px-5 lg:px-8">

        <div class="reveal flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
            <div>
                <p class="eyebrow">Client Support</p>
                <h2 class="gradient-title mt-3 text-3xl font-semibold md:text-4xl lg:text-5xl">
                    Guides &amp; <em>Remedies</em>
                </h2>
            </div>
            <a href="{{ route('projects') }}" class="ink-link font-mono text-xs uppercase tracking-[.12em]">
                View all &rarr;
            </a>
        </div>

        <div class="mt-12 grid gap-7 md:grid-cols-2 lg:mt-16 lg:grid-cols-3">
            @forelse($projects as $index => $project)
                <article
                    class="reveal soft-panel interactive-card group overflow-hidden"
                    style="transition-delay: {{ $index * 80 }}ms;"
                >
                    {{-- Image --}}
                    <div class="relative aspect-[16/10] overflow-hidden" style="background:var(--ink-950);">
                        @if($project->image)
                            <img
                                src="{{ asset('storage/' . $project->image) }}"
                                alt="{{ $project->title }}"
                                class="h-full w-full object-cover transition-transform duration-700 ease-out group-hover:scale-105"
                                loading="lazy"
                            >
                        @else
                            <div
                                class="grid h-full place-items-center font-display text-2xl italic"
                                style="color:var(--slate); background:linear-gradient(135deg, var(--ink-900), var(--ink-850));"
                            >
                                {{ $project->title }}
                            </div>
                        @endif

                        {{-- Hover overlay with links --}}
                        @if($project->live_url || $project->github_url)
                            <div class="absolute inset-0 flex items-end justify-end gap-2 bg-gradient-to-t from-black/60 to-transparent p-4 opacity-0 transition-opacity duration-300 group-hover:opacity-100">
                                @if($project->live_url)
                                    <a
                                        href="{{ $project->live_url }}"
                                        target="_blank"
                                        rel="noopener"
                                        class="rounded-full px-3 py-1.5 font-mono text-[.65rem] font-semibold uppercase tracking-[.08em] backdrop-blur-sm"
                                        style="background:rgba(56,189,248,.9); color:var(--ink-950);"
                                    >
                                        Live &nearr;
                                    </a>
                                @endif
                                @if($project->github_url)
                                    <a
                                        href="{{ $project->github_url }}"
                                        target="_blank"
                                        rel="noopener"
                                        class="rounded-full px-3 py-1.5 font-mono text-[.65rem] font-semibold uppercase tracking-[.08em] backdrop-blur-sm"
                                        style="background:rgba(250,247,238,.15); color:var(--paper);"
                                    >
                                        Code &nearr;
                                    </a>
                                @endif
                            </div>
                        @endif
                    </div>

                    {{-- Content --}}
                    <div class="p-6">
                        @if($project->technology)
                            <div class="flex flex-wrap gap-2">
                                @foreach(explode(',', $project->technology) as $tech)
                                    <span
                                        class="font-mono rounded px-2.5 py-0.5 text-[.6rem] uppercase tracking-wider"
                                        style="background:var(--brass-dim); color:var(--brass);"
                                    >
                                        {{ trim($tech) }}
                                    </span>
                                @endforeach
                            </div>
                        @else
                            <span
                                class="font-mono text-[.65rem] uppercase tracking-[.14em]"
                                style="color:var(--brass);"
                            >
                                Creative Project
                            </span>
                        @endif

                        <h3 class="font-display mt-3 text-xl md:text-2xl" style="color:var(--paper);">
                            {{ $project->title }}
                        </h3>

                        <p class="mt-3 text-sm leading-7" style="color:var(--paper-muted);">
                            {{ Illuminate\Support\Str::limit($project->description, 140) }}
                        </p>
                    </div>
                </article>
            @empty
                <div class="col-span-full">
                    <div class="soft-panel p-12 text-center">
                        <span class="tag-note">Coming Soon</span>
                        <h3 class="font-display mt-5 text-2xl md:text-3xl" style="color:var(--paper);">
                            Projects are being crafted
                        </h3>
                        <p class="mx-auto mt-3 max-w-md text-sm leading-7" style="color:var(--paper-muted);">
                            Add real projects from the dashboard and they will appear here with images, descriptions, and technology badges.
                        </p>
                    </div>
                </div>
            @endforelse
        </div>

    </div>
</section>


{{-- ═══════════════════════════════════════════════════════════════════
     § CALL TO ACTION
     Final prompt to get in touch.
     ═══════════════════════════════════════════════════════════════════ --}}

<section class="border-t" style="border-color:var(--line); background: var(--ink-900);">
    <div class="mx-auto max-w-7xl px-5 lg:px-8">
        <div class="reveal py-20 text-center md:py-28 lg:py-32">
            <p class="eyebrow justify-center">Begin Your Healing</p>
            <h2 class="gradient-title mx-auto mt-4 max-w-2xl text-balance text-3xl font-semibold leading-[1.15] md:text-4xl lg:text-5xl">
                Ready to find some <em>relief?</em>
            </h2>
            <p class="mx-auto mt-5 max-w-lg text-base leading-8" style="color:var(--paper-dim);">
                Consultation sessions are open. Take a gentle first step towards recovery and emotional resilience today.
            </p>
            <div class="mt-10 flex flex-wrap items-center justify-center gap-4">
                <a href="{{ route('contact') }}" class="accent-button rounded px-8 py-4 text-sm">
                    Book Appointment
                </a>
                <a href="{{ route('projects') }}" class="ghost-button rounded px-8 py-4 text-sm">
                    Read Wellness Guides
                </a>
            </div>
        </div>
    </div>
</section>

@endsection