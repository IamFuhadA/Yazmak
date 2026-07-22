@extends('layouts.frontend')

@section('title', 'About — Healing & Serenity')
@section('meta_description', 'About Yazmak — A sanctuary for emotional recovery, psychiatric consulting, and remedies for exhaustion.')

@section('content')

@php
    $displayName = $about?->name ?? 'Yazmak';
    $profession  = $about?->profession ?? 'Psychiatry & Mental Wellness Consultancy';
    $description = $about?->description ?? 'A compassionate, professional sanctuary offering guidance and tailored remedies for individuals navigating emotional exhaustion, stress, and anxiety.';
    $location    = $about?->location ?? 'Clinical Consultation Room';
    $email       = $about?->email ?? 'hello@yazmak.com';
    $phone       = $about?->phone ?? '+91 00000 00000';

    $fallbackSkills = collect([
        ['name' => 'Anxiety Support', 'percentage' => 95, 'desc' => 'Professional therapeutic help to navigate acute stress and regain emotional peace.'],
        ['name' => 'Exhaustion Remedy',  'percentage' => 90, 'desc' => 'Structured coping mechanisms and psychiatric guidance to recover from deep burnout.'],
        ['name' => 'Confidential Counsel',   'percentage' => 100, 'desc' => '100% private, patient-first mental health consulting and therapeutic support.'],
    ]);

    $shownSkills = $skills->count()
        ? $skills->map(function ($s) {
            return [
                'name'       => $s->name,
                'percentage' => $s->percentage,
                'desc'       => 'Care capability refined through professional medical practice and patient consulting.',
            ];
        })
        : $fallbackSkills;

    $philosophy = [
        [
            'num'   => 'I',
            'title' => 'Listen with empathy',
            'body'  => 'Every healing process begins by feeling heard. We provide a calm, non-judgmental space to share your struggles and feelings.',
        ],
        [
            'num'   => 'II',
            'title' => 'Remedy with care',
            'body'  => 'We translate medical insights into compassionate guidance, developing personalized strategies to overcome fatigue and restore peace.',
        ],
        [
            'num'   => 'III',
            'title' => 'Nurture resilience',
            'body'  => 'Our ultimate goal is your long-term wellness. We equip you with the emotional tools and support required to grow through challenges.',
        ],
    ];

    $milestones = [
        [
            'period' => 'Consultation',
            'role'   => 'Understanding Symptoms',
            'detail' => 'Active listening to map the root causes of exhaustion, stress, and emotional fatigue.',
        ],
        [
            'period' => 'Tailored Plan',
            'role'   => 'Therapy & Remedies',
            'detail' => 'Creating supportive mental routines and therapeutic plans to restore vitality.',
        ],
        [
            'period' => 'Wellness',
            'role'   => 'Ongoing Resilient Support',
            'detail' => 'Ongoing psychiatric consulting and guidance to lock in permanent well-being.',
        ],
    ];
@endphp

<div class="noise-overlay" aria-hidden="true"></div>

<div class="relative overflow-hidden py-10 md:py-16">
    <div class="mx-auto max-w-7xl px-5 lg:px-8">

        {{-- ═══════════════════════════════════════════════════════════════
             § SECTION 1: HEADER SPREAD (Editorial Title)
             ═══════════════════════════════════════════════════════════ --}}
        <header class="reveal border-b pb-12 md:pb-16" style="border-color:var(--line);">
            <p class="eyebrow">Our Mission</p>
            <h1 class="gradient-title mt-4 text-balance text-5xl font-semibold leading-[1.05] md:text-7xl lg:text-8xl">
                A sanctuary for <br>
                <em>emotional recovery</em>.
            </h1>
            <p class="mt-6 max-w-3xl font-mono text-xs uppercase tracking-[.18em]" style="color:var(--slate);">
                Compassionate Support &bull; Psychiatric Guidance &bull; Healing &bull; Calm
            </p>
        </header>

        {{-- ═══════════════════════════════════════════════════════════════
             § SECTION 2: GRID LAYOUT
             ═══════════════════════════════════════════════════════════ --}}
        <div class="mt-12 grid gap-12 lg:grid-cols-[0.88fr_1.12fr] lg:gap-20">

            {{-- ── COLUMN LEFT: Sidebar Profile Ledger ──────────────── --}}
            <aside class="lg:sticky lg:top-28 lg:self-start">
                <div class="reveal soft-panel overflow-hidden p-1.5">
                    <div class="rounded-lg p-5 md:p-6" style="background:var(--ink-950);">

                        {{-- Portrait Card --}}
                        <div class="relative aspect-[4/5] overflow-hidden rounded-md border" style="border-color:var(--line); background:var(--ink-900);">
                            @if($about?->profile_image)
                                <img
                                    src="{{ asset('storage/'.$about->profile_image) }}"
                                    alt="{{ $displayName }}"
                                    class="h-full w-full object-cover grayscale transition duration-700 hover:grayscale-0"
                                    loading="lazy"
                                >
                            @else
                                <div class="grid h-full place-items-center" style="background:radial-gradient(circle at 50% 40%, var(--brass-dim), var(--ink-950) 80%);">
                                    <span class="font-display text-9xl italic" style="color:var(--paper-dim);">
                                        {{ \Illuminate\Support\Str::of($displayName)->substr(0, 1) }}
                                    </span>
                                </div>
                            @endif
                            {{-- Ambient brass corner accents --}}
                            <div class="absolute right-0 top-0 h-4 w-4 border-r border-t" style="border-color:var(--brass); margin:6px;"></div>
                            <div class="absolute bottom-0 left-0 h-4 w-4 border-b border-l" style="border-color:var(--brass); margin:6px;"></div>
                        </div>

                        {{-- Biographical Specs --}}
                        <div class="mt-6 space-y-4">
                            <div>
                                <h2 class="font-display text-2xl" style="color:var(--paper);">{{ $displayName }}</h2>
                                <p class="font-mono text-xs uppercase tracking-[.12em] mt-1" style="color:var(--brass);">{{ $profession }}</p>
                            </div>

                            <div class="h-px bg-gradient-to-r from-transparent via-[var(--line-strong)] to-transparent"></div>

                            {{-- Metadata Ledger --}}
                            <div class="space-y-3 font-mono text-[.74rem]">
                                <div class="flex justify-between py-2 border-b" style="border-color:var(--line);">
                                    <span style="color:var(--slate);">Email</span>
                                    <a href="mailto:{{ $email }}" class="ink-link" style="color:var(--paper);">{{ $email }}</a>
                                </div>
                                <div class="flex justify-between py-2 border-b" style="border-color:var(--line);">
                                    <span style="color:var(--slate);">Phone</span>
                                    <a href="tel:{{ $phone }}" class="ink-link" style="color:var(--paper);">{{ $phone }}</a>
                                </div>
                                <div class="flex justify-between py-2 border-b" style="border-color:var(--line);">
                                    <span style="color:var(--slate);">Location</span>
                                    <span style="color:var(--paper);">{{ $location }}</span>
                                </div>
                                <div class="flex justify-between py-2 border-b" style="border-color:var(--line);">
                                    <span style="color:var(--slate);">Status</span>
                                    <span class="flex items-center gap-1.5" style="color:var(--brass);">
                                        <span class="h-1.5 w-1.5 animate-pulse rounded-full bg-emerald-500"></span>
                                        Available
                                    </span>
                                </div>
                            </div>

                            @if($about?->resume)
                                <div class="pt-2">
                                    <a
                                        href="{{ asset('storage/' . $about->resume) }}"
                                        target="_blank"
                                        rel="noopener"
                                        class="gradient-button block w-full rounded py-3 text-center text-xs"
                                    >
                                        Download Resume &darr;
                                    </a>
                                </div>
                            @endif
                        </div>

                    </div>
                </div>
            </aside>

            {{-- ── COLUMN RIGHT: Content & Story ───────────────────── --}}
            <div class="space-y-16">

                {{-- Biography Block --}}
                <article class="reveal space-y-6">
                    <p class="font-mono text-xs uppercase tracking-[.14em]" style="color:var(--brass);">¶ Introduction</p>
                    <p class="font-display text-2xl leading-relaxed italic" style="color:var(--paper);">
                        &ldquo;{{ $description }}&rdquo;
                    </p>
                    <div class="h-1 w-12" style="background:var(--red);"></div>
                </article>

                {{-- Philosophy Section --}}
                <section class="space-y-8">
                    <div class="reveal">
                        <p class="eyebrow">Philosophy</p>
                        <h3 class="font-display mt-2 text-3xl" style="color:var(--paper);">The Core Principles</h3>
                    </div>

                    <div class="grid gap-6">
                        @foreach($philosophy as $index => $item)
                            <div
                                class="reveal soft-panel rounded-lg p-6 transition-all hover:scale-[1.01]"
                                style="border-color:var(--line); transition-delay: {{ $index * 50 }}ms;"
                            >
                                <div class="flex gap-4">
                                    <span class="font-display text-xl font-bold italic" style="color:var(--red);">{{ $item['num'] }}</span>
                                    <div>
                                        <h4 class="font-display text-lg font-medium" style="color:var(--paper);">{{ $item['title'] }}</h4>
                                        <p class="mt-2 text-sm leading-6" style="color:var(--paper-dim);">{{ $item['body'] }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>

                {{-- Capabilities / Skill Ledger --}}
                <section x-data="{ selected: '{{ $shownSkills->first()['name'] }}' }" class="space-y-8">
                    <div class="reveal flex flex-col gap-3 md:flex-row md:items-end md:justify-between">
                        <div>
                            <p class="eyebrow">Capabilities</p>
                            <h3 class="font-display mt-2 text-3xl" style="color:var(--paper);">Skill Ledger</h3>
                        </div>

                        {{-- Skill Tabs --}}
                        <div class="flex gap-1.5 overflow-x-auto pb-1 max-w-full">
                            @foreach($shownSkills as $skill)
                                <button
                                    type="button"
                                    @click="selected = '{{ $skill['name'] }}'"
                                    class="font-mono shrink-0 rounded px-3 py-1.5 text-[.68rem] font-semibold uppercase tracking-wider transition-all duration-300"
                                    :style="selected === '{{ $skill['name'] }}'
                                        ? 'background:var(--brass); color:var(--ink-950); border:1px solid var(--brass);'
                                        : 'background:transparent; border:1px solid var(--line); color:var(--slate);'"
                                >
                                    {{ $skill['name'] }}
                                </button>
                            @endforeach
                        </div>
                    </div>

                    {{-- Skill Pane --}}
                    <div class="reveal relative min-h-[140px]">
                        @foreach($shownSkills as $skill)
                            <div
                                x-show="selected === '{{ $skill['name'] }}'"
                                x-transition:enter="transition-all duration-300 ease-out"
                                x-transition:enter-start="opacity-0 translate-y-2"
                                x-transition:enter-end="opacity-100 translate-y-0"
                                class="soft-panel rounded-lg p-6"
                            >
                                <div class="flex items-center justify-between gap-4">
                                    <div>
                                        <h4 class="font-display text-xl font-medium" style="color:var(--paper);">{{ $skill['name'] }}</h4>
                                        <p class="mt-2 text-sm leading-6" style="color:var(--paper-dim);">{{ $skill['desc'] }}</p>
                                    </div>
                                    <div class="shrink-0 text-right">
                                        <span class="font-mono text-3xl font-semibold italic" style="color:var(--brass);">
                                            {{ $skill['percentage'] }}<span class="text-sm">%</span>
                                        </span>
                                    </div>
                                </div>

                                {{-- Progress bar --}}
                                <div class="mt-6 h-1 overflow-hidden rounded-full" style="background:var(--ink-800);">
                                    <div
                                        class="h-full rounded-full transition-all duration-1000 ease-[cubic-bezier(0.16,1,0.3,1)]"
                                        style="background:linear-gradient(90deg, var(--red), var(--brass));"
                                        :style="selected === '{{ $skill['name'] }}' ? 'width:{{ $skill['percentage'] }}%' : 'width:0%'"
                                    ></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>

                {{-- Milestones Timeline --}}
                <section class="space-y-8">
                    <div class="reveal">
                        <p class="eyebrow">Timeline</p>
                        <h3 class="font-display mt-2 text-3xl" style="color:var(--paper);">Chronology</h3>
                    </div>

                    <div class="relative border-l pl-6 md:pl-8" style="border-color:var(--line-strong);">
                        <div class="space-y-10">
                            @foreach($milestones as $index => $milestone)
                                <div
                                    class="reveal relative"
                                    style="transition-delay: {{ $index * 80 }}ms;"
                                >
                                    {{-- Bullet dot --}}
                                    <span
                                        class="absolute -left-[31px] md:-left-[39px] top-1.5 grid h-4 w-4 place-items-center rounded-full border bg-zinc-900"
                                        style="border-color:var(--brass);"
                                    >
                                        <span class="h-1.5 w-1.5 rounded-full" style="background:var(--brass);"></span>
                                    </span>

                                    <div>
                                        <span class="font-mono text-[.68rem] font-semibold uppercase tracking-[.12em]" style="color:var(--brass);">
                                            {{ $milestone['period'] }}
                                        </span>
                                        <h4 class="font-display mt-1 text-lg font-medium" style="color:var(--paper);">
                                            {{ $milestone['role'] }}
                                        </h4>
                                        <p class="mt-2 text-sm leading-6" style="color:var(--paper-dim);">
                                            {{ $milestone['detail'] }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </section>

                {{-- Contact links / Actions --}}
                <div class="reveal pt-4 flex flex-wrap gap-4">
                    <a href="{{ route('projects') }}" class="gradient-button rounded px-8 py-3.5 text-sm">
                        View Projects Archive
                    </a>
                    <a href="{{ route('contact') }}" class="ghost-button rounded px-8 py-3.5 text-sm">
                        Contact Me
                    </a>
                </div>

            </div>

        </div>
    </div>
</div>

@endsection