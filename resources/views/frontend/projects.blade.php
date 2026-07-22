@extends('layouts.frontend')

@section('title', 'Remedies — Guides & Support')
@section('meta_description', 'Remedies by Yazmak Clinic — A gallery of selected wellness guides, anxiety remedies, and mental health support archives.')

@section('content')

@php
    $technologies = $projects
        ->pluck('technology')
        ->filter()
        ->flatMap(fn ($value) => collect(explode(',', $value))->map(fn ($item) => trim($item))->filter())
        ->unique()
        ->values();

    $sampleProjects = collect([
        [
            'title'      => 'Burnout Recovery Guide',
            'technology' => 'Exhaustion, Routine, Coping',
            'description'=> 'A structured routine planner and mindfulness tracker tailored to recover from work-related mental collapse.',
            'live_url'   => '#',
            'github_url' => '#'
        ],
        [
            'title'      => 'Anxiety Relief Practice',
            'technology' => 'Breathing, Math, Physics',
            'description'=> 'A gentle interactive visual breathing guide modeled around physics vectors to help center your thoughts during anxiety.',
            'live_url'   => '#',
            'github_url' => '#'
        ],
        [
            'title'      => 'Cognitive Restructuring',
            'technology' => 'Mindfulness, Thought-Log, Remedy',
            'description'=> 'A step-by-step cognitive diary to trace, identify, and calm intrusive thoughts during mental overload.',
            'live_url'   => '#',
            'github_url' => '#'
        ]
    ]);
@endphp

<div class="noise-overlay" aria-hidden="true"></div>

<section
    x-data="{ filter: 'All', query: '' }"
    class="mx-auto max-w-7xl px-5 py-10 lg:px-8 lg:py-16"
>
    {{-- ═══════════════════════════════════════════════════════════════
         § PROJECT CONTROLS PANEL
         ═══════════════════════════════════════════════════════════ --}}
    <div class="reveal soft-panel overflow-hidden rounded-xl">
        <div class="grid gap-8 p-6 md:p-8 lg:grid-cols-[1.15fr_0.85fr] lg:items-center lg:p-10">

            {{-- Title Spread --}}
            <div>
                <p class="eyebrow">Remedy Archive</p>
                <h1 class="gradient-title mt-4 text-balance text-4xl font-semibold leading-[1.08] md:text-5xl lg:text-6xl">
                    Comforting guides, <br><em>crafted</em> to restore calm.
                </h1>
                <p class="mt-5 max-w-xl text-base leading-8 md:text-lg" style="color:var(--paper-dim);">
                    Search by keyword or select a therapeutic focus to filter. Each guide is written to assist you on your healing journey.
                </p>
            </div>

            {{-- Control Ledger --}}
            <div class="rounded-lg p-5 border" style="border-color:var(--line); background:var(--ink-950);">
                <div class="space-y-4">
                    {{-- Search Field --}}
                    <div>
                        <label for="project-search" class="font-mono text-[.68rem] font-bold uppercase tracking-[.14em]" style="color:var(--slate);">
                            Filter by keyword query
                        </label>
                        <div class="relative mt-2">
                            <input
                                id="project-search"
                                type="search"
                                x-model="query"
                                placeholder="Type a title or keyword..."
                                class="w-full rounded border px-4 py-3 text-sm focus:outline-none transition-all duration-300"
                                style="border-color:var(--line-strong); background:var(--ink-900); color:var(--paper);"
                            >
                        </div>
                    </div>

                    {{-- Tags horizontal scroll --}}
                    <div>
                        <span class="font-mono text-[.68rem] font-bold uppercase tracking-[.14em]" style="color:var(--slate);">
                            Filter by focus area
                        </span>
                        <div class="mt-2.5 flex gap-1.5 overflow-x-auto pb-1.5 scrollbar-thin">
                            <button
                                type="button"
                                @click="filter = 'All'"
                                class="font-mono shrink-0 rounded px-3 py-1.5 text-[.68rem] font-semibold uppercase tracking-wider transition-all duration-300"
                                :style="filter === 'All'
                                    ? 'background:var(--brass); color:var(--ink-850); border:1px solid var(--brass);'
                                    : 'background:transparent; border:1px solid var(--line); color:var(--slate);'"
                            >
                                All
                            </button>

                            @forelse($technologies as $tech)
                                <button
                                    type="button"
                                    @click="filter = '{{ $tech }}'"
                                    class="font-mono shrink-0 rounded px-3 py-1.5 text-[.68rem] font-semibold uppercase tracking-wider transition-all duration-300"
                                    :style="filter === '{{ $tech }}'
                                        ? 'background:var(--brass); color:var(--ink-950); border:1px solid var(--brass);'
                                        : 'background:transparent; border:1px solid var(--line); color:var(--slate);'"
                                >
                                    {{ $tech }}
                                </button>
                            @empty
                                @foreach(['Laravel', 'Three.js', 'Frontend', 'CSS3'] as $tech)
                                    <button
                                        type="button"
                                        @click="filter = '{{ $tech }}'"
                                        class="font-mono shrink-0 rounded px-3 py-1.5 text-[.68rem] font-semibold uppercase tracking-wider transition-all duration-300"
                                        :style="filter === '{{ $tech }}'
                                            ? 'background:var(--brass); color:var(--ink-950); border:1px solid var(--brass);'
                                            : 'background:transparent; border:1px solid var(--line); color:var(--slate);'"
                                    >
                                        {{ $tech }}
                                    </button>
                                @endforeach
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- Footer Ledger --}}
        <div class="border-t px-6 py-4 md:px-8 lg:px-10 flex items-center justify-between" style="border-color:var(--line); background:var(--ink-950);">
            <p class="font-mono text-[.68rem] uppercase tracking-[.12em]" style="color:var(--slate);">
                Ledger count: <span style="color:var(--brass);">{{ $projects->count() ?: $sampleProjects->count() }}</span> items
            </p>
            <p class="font-mono text-[.68rem] uppercase tracking-[.12em]" style="color:var(--slate);">
                Active Tag: <span style="color:var(--paper);" x-text="filter"></span>
            </p>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════
         § PROJECTS GRID
         ═══════════════════════════════════════════════════════════ --}}
    <div class="mt-12 grid gap-7 md:grid-cols-2 lg:grid-cols-3">
        @forelse($projects as $index => $project)
            @php
                $searchText = strtolower($project->title . ' ' . $project->technology . ' ' . $project->description);
            @endphp
            <article
                x-show="(filter === 'All' || @js(strtolower($project->technology ?? '')) .includes(filter.toLowerCase())) && @js($searchText).includes(query.toLowerCase())"
                x-transition:enter="transition-all duration-400 ease-[cubic-bezier(0.16,1,0.3,1)]"
                x-transition:enter-start="opacity-0 translate-y-4 scale-[0.98]"
                x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                class="reveal soft-panel interactive-card group overflow-hidden"
                style="transition-delay: {{ $index * 50 }}ms;"
            >
                {{-- Media Frame --}}
                <div class="relative aspect-[16/10] overflow-hidden" style="background:var(--ink-950);">
                    @if($project->image)
                        <img
                            src="{{ asset('storage/'.$project->image) }}"
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

                    {{-- Featured Badge overlay --}}
                    @if($project->featured)
                        <div class="absolute left-4 top-4 z-10">
                            <span class="tag-note">Featured</span>
                        </div>
                    @endif
                </div>

                {{-- Metadata Content --}}
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
                        <span class="font-mono text-[.65rem] uppercase tracking-[.12em]" style="color:var(--brass);">
                            Creative Project
                        </span>
                    @endif

                    <h2 class="font-display mt-3.5 text-2xl" style="color:var(--paper);">{{ $project->title }}</h2>

                    <p class="mt-4 text-sm leading-7" style="color:var(--paper-dim);">
                        {{ $project->description }}
                    </p>

                    <div class="mt-8 flex gap-3">
                        @if($project->github_url)
                            <a
                                href="{{ $project->github_url }}"
                                target="_blank"
                                rel="noopener"
                                class="ghost-button flex-1 rounded py-3 text-center text-xs"
                            >
                                Source Code
                            </a>
                        @endif

                        @if($project->live_url)
                            <a
                                href="{{ $project->live_url }}"
                                target="_blank"
                                rel="noopener"
                                class="gradient-button flex-1 rounded py-3 text-center text-xs"
                            >
                                Live Site &nearr;
                            </a>
                        @endif
                    </div>
                </div>
            </article>
        @empty
            {{-- Fallbacks (Sample display when database has no values) --}}
            @foreach($sampleProjects as $index => $project)
                @php
                    $searchText = strtolower($project['title'] . ' ' . $project['technology'] . ' ' . $project['description']);
                @endphp
                <article
                    x-show="(filter === 'All' || @js(strtolower($project['technology'])) .includes(filter.toLowerCase())) && @js($searchText).includes(query.toLowerCase())"
                    x-transition:enter="transition-all duration-400 ease-[cubic-bezier(0.16,1,0.3,1)]"
                    x-transition:enter-start="opacity-0 translate-y-4 scale-[0.98]"
                    x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                    class="reveal soft-panel interactive-card group overflow-hidden p-6"
                    style="transition-delay: {{ $index * 50 }}ms;"
                >
                    <div class="flex items-center justify-between">
                        <span class="font-mono text-[.65rem] uppercase tracking-[.12em]" style="color:var(--brass);">
                            {{ $project['technology'] }}
                        </span>
                        <span class="tag-note">Sample Draft</span>
                    </div>

                    <h2 class="font-display mt-4 text-2xl" style="color:var(--paper);">{{ $project['title'] }}</h2>

                    <p class="mt-4 text-sm leading-7" style="color:var(--paper-dim);">
                        {{ $project['description'] }}
                    </p>

                    <div class="mt-6 border-t pt-4" style="border-color:var(--line);">
                        <p class="font-mono text-[.6rem] uppercase tracking-[.1em]" style="color:var(--slate);">
                            Add authentic database entries to replace sample.
                        </p>
                    </div>
                </article>
            @endforeach
        @endforelse
    </div>
</section>

@endsection