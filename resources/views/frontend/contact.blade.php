@extends('layouts.frontend')

@section('title', 'Book Appointment — Find Serenity')
@section('meta_description', 'Contact Yazmak Clinic — Reach out for compassionate, confidential consultations and emotional recovery support.')

@section('content')

@php
    $email    = $about?->email ?? 'hello@yazmak.test';
    $phone    = $about?->phone ?? '+91 00000 00000';
    $location = $about?->location ?? 'Clinical Consultation Room';
@endphp

<div class="noise-overlay" aria-hidden="true"></div>

<section
    x-data="{
        copied: false,
        copy(value) {
            navigator.clipboard?.writeText(value);
            this.copied = true;
            setTimeout(() => this.copied = false, 2500);
        }
    }"
    class="page-section mx-auto grid max-w-7xl gap-12 px-5 lg:grid-cols-[0.9fr_1.1fr] lg:items-start lg:gap-20 lg:px-8"
>
    {{-- ─── LEFT: Editorial Copy & Metadata Ledger ────────────────── --}}
    <div class="space-y-10">
        <div class="reveal">
            <p class="eyebrow">Book Appointment</p>
            <h1 class="gradient-title mt-4 text-balance text-4xl font-semibold leading-[1.08] md:text-5xl lg:text-6xl">
                Begin your journey to <em>serenity</em>.
            </h1>
            <p class="mt-6 text-base leading-8 md:text-lg" style="color:var(--paper-dim);">
                If you are navigating exhaustion, anxiety, or emotional fatigue, take a gentle first step and reach out for a confidential session.
            </p>
        </div>

        {{-- Interactive contact cards --}}
        <div class="grid gap-4">
            {{-- Email Copy Card --}}
            <button
                type="button"
                @click="copy('{{ $email }}')"
                class="reveal soft-panel interactive-card group w-full p-5 text-left transition-all duration-300"
                style="border-color:var(--line);"
            >
                <span class="font-mono text-[.68rem] font-bold uppercase tracking-[.14em]" style="color:var(--slate);">
                    Email Address
                </span>
                <span class="font-display mt-2 block text-xl group-hover:text-[var(--brass)] transition-colors duration-300" style="color:var(--paper);">
                    {{ $email }}
                </span>
                <span class="font-mono mt-3 block text-[.62rem] uppercase tracking-wider" style="color:var(--slate);">
                    Click to copy address &copy;
                </span>
            </button>

            {{-- Phone Card --}}
            <a
                href="tel:{{ $phone }}"
                class="reveal soft-panel interactive-card group block p-5 transition-all duration-300"
                style="border-color:var(--line);"
            >
                <span class="font-mono text-[.68rem] font-bold uppercase tracking-[.14em]" style="color:var(--slate);">
                    Direct Telephone
                </span>
                <span class="font-display mt-2 block text-xl group-hover:text-[var(--brass)] transition-colors duration-300" style="color:var(--paper);">
                    {{ $phone }}
                </span>
                <span class="font-mono mt-3 block text-[.62rem] uppercase tracking-wider" style="color:var(--slate);">
                    Click to place a call &nearr;
                </span>
            </a>

            {{-- Location Card --}}
            <div
                class="reveal soft-panel p-5 border"
                style="border-color:var(--line);"
            >
                <span class="font-mono text-[.68rem] font-bold uppercase tracking-[.14em]" style="color:var(--slate);">
                    Consultation Room
                </span>
                <span class="font-display mt-2 block text-xl" style="color:var(--paper);">
                    {{ $location }}
                </span>
                <span class="font-mono mt-3 block text-[.62rem] uppercase tracking-wider" style="color:var(--brass);">
                    Private and compassionate clinical support
                </span>
            </div>
        </div>

        {{-- Toast alert notification --}}
        <div
            x-show="copied"
            x-transition:enter="transition-all duration-300 ease-out"
            x-transition:enter-start="opacity-0 translate-y-2"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition-all duration-200 ease-in"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 translate-y-2"
            class="rounded border p-4 text-center"
            style="border-color:var(--brass); background:var(--brass-dim);"
        >
            <p class="font-mono text-xs font-semibold uppercase tracking-wider" style="color:var(--brass);">
                Success: Address copied to clipboard.
            </p>
        </div>
    </div>

    {{-- ─── RIGHT: The Ledger Mail Form ───────────────────────────── --}}
    <div class="reveal soft-panel interactive-card overflow-hidden p-1.5">
        <div class="rounded-lg p-6 md:p-8" style="background:var(--ink-950);">
            <form action="mailto:{{ $email }}" method="get" enctype="text/plain" class="relative space-y-6">
                <span class="tag-note absolute -top-11 right-0 md:-top-13">Inquiry</span>

                <div>
                    <h2 class="font-display text-2xl" style="color:var(--paper);">Send a Message</h2>
                    <p class="mt-1 text-sm" style="color:var(--slate);">Fill out details to draft an email automatically.</p>
                </div>

                <div class="h-px bg-gradient-to-r from-transparent via-[var(--line-strong)] to-transparent"></div>

                <div class="grid gap-6 sm:grid-cols-2">
                    {{-- Name --}}
                    <div>
                        <label for="name" class="font-mono text-[.68rem] font-bold uppercase tracking-[.12em]" style="color:var(--slate);">
                            Your Name
                        </label>
                        <input
                            id="name"
                            name="name"
                            type="text"
                            required
                            placeholder="e.g. John Doe"
                            class="mt-2 w-full rounded border px-4 py-3 text-sm focus:outline-none transition-all duration-300"
                            style="border-color:var(--line-strong); background:var(--ink-900); color:var(--paper);"
                        >
                    </div>

                    {{-- Email --}}
                    <div>
                        <label for="email" class="font-mono text-[.68rem] font-bold uppercase tracking-[.12em]" style="color:var(--slate);">
                            Email Address
                        </label>
                        <input
                            id="email"
                            name="email"
                            type="email"
                            required
                            placeholder="e.g. you@example.com"
                            class="mt-2 w-full rounded border px-4 py-3 text-sm focus:outline-none transition-all duration-300"
                            style="border-color:var(--line-strong); background:var(--ink-900); color:var(--paper);"
                        >
                    </div>
                </div>

                {{-- Message --}}
                <div>
                    <label for="message" class="font-mono text-[.68rem] font-bold uppercase tracking-[.12em]" style="color:var(--slate);">
                        Consultation Inquiry Details
                    </label>
                    <textarea
                        id="message"
                        name="message"
                        rows="7"
                        required
                        placeholder="Please share briefly what you are seeking help with (exhaustion, anxiety, recovery guides)..."
                        class="mt-2 w-full rounded border px-4 py-3 text-sm focus:outline-none transition-all duration-300"
                        style="border-color:var(--line-strong); background:var(--ink-900); color:var(--paper);"
                    ></textarea>
                </div>

                <div class="pt-2">
                    <button
                        type="submit"
                        class="accent-button w-full rounded py-4 text-xs font-semibold cursor-pointer"
                    >
                        Submit Appointment Inquiry &rarr;
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

@endsection