@extends('layouts.app')

@section('content')

@php
    $projectsCount = \App\Models\Project::count();
    $skillsCount   = \App\Models\Skill::count();
    $contactsCount = \App\Models\Contact::count();
    $unreadCount   = \App\Models\Contact::where('is_read', false)->count();

    $recentContacts = \App\Models\Contact::latest()->take(3)->get();
    $hasAbout = \App\Models\About::first() !== null;
@endphp

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

        {{-- Welcome Header Panel --}}
        <div class="soft-panel overflow-hidden p-1.5">
            <div class="rounded-lg p-6 md:p-8" style="background:var(--ink-950);">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                    <div>
                        <p class="font-mono text-[.68rem] uppercase tracking-[.14em]" style="color:var(--brass);">
                            System Dashboard
                        </p>
                        <h1 class="font-display text-3xl md:text-4xl mt-1.5" style="color:var(--paper);">
                            Welcome back, {{ Auth::user()->name }}
                        </h1>
                        <p class="mt-2 text-sm" style="color:var(--paper-dim);">
                            Manage your creative assets, modify your story profile, and read incoming messages.
                        </p>
                    </div>
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('home') }}" target="_blank" class="ghost-button rounded px-5 py-2.5 text-xs">
                            View Website &nearr;
                        </a>
                        <a href="{{ route('admin.projects.create') }}" class="gradient-button rounded px-5 py-2.5 text-xs">
                            Add New Project
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Metrics Ledger Row --}}
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            {{-- Projects Stat --}}
            <div class="soft-panel p-6">
                <span class="font-mono text-[.65rem] uppercase tracking-[.1em]" style="color:var(--slate);">Total Projects</span>
                <div class="flex items-baseline gap-2 mt-2">
                    <strong class="font-display text-4xl" style="color:var(--paper);">{{ $projectsCount }}</strong>
                    <span class="font-mono text-xs" style="color:var(--brass);">Published</span>
                </div>
                <a href="{{ route('admin.projects.index') }}" class="ink-link font-mono text-[.65rem] uppercase tracking-[.08em] mt-4 block">
                    Manage archive &rarr;
                </a>
            </div>

            {{-- Skills Stat --}}
            <div class="soft-panel p-6">
                <span class="font-mono text-[.65rem] uppercase tracking-[.1em]" style="color:var(--slate);">Skill Ledger</span>
                <div class="flex items-baseline gap-2 mt-2">
                    <strong class="font-display text-4xl" style="color:var(--paper);">{{ $skillsCount }}</strong>
                    <span class="font-mono text-xs" style="color:var(--slate);">Capabilities</span>
                </div>
                <a href="{{ route('admin.skills.index') }}" class="ink-link font-mono text-[.65rem] uppercase tracking-[.08em] mt-4 block">
                    Edit skills &rarr;
                </a>
            </div>

            {{-- Total Contacts Stat --}}
            <div class="soft-panel p-6">
                <span class="font-mono text-[.65rem] uppercase tracking-[.1em]" style="color:var(--slate);">Messages Received</span>
                <div class="flex items-baseline gap-2 mt-2">
                    <strong class="font-display text-4xl" style="color:var(--paper);">{{ $contactsCount }}</strong>
                    @if($unreadCount > 0)
                        <span class="tag-note" style="transform: rotate(0deg); font-size: .58rem; padding: .1rem .4rem;">
                            {{ $unreadCount }} Unread
                        </span>
                    @else
                        <span class="font-mono text-xs" style="color:var(--slate);">Clear</span>
                    @endif
                </div>
                <span class="font-mono text-[.65rem] uppercase tracking-[.08em] mt-4 block" style="color:var(--slate);">
                    Via contact form
                </span>
            </div>

            {{-- Profile Status Stat --}}
            <div class="soft-panel p-6">
                <span class="font-mono text-[.65rem] uppercase tracking-[.1em]" style="color:var(--slate);">Profile Status</span>
                <div class="mt-2 flex items-baseline gap-2">
                    <strong class="font-display text-2xl" style="color:var(--paper);">
                        {{ $hasAbout ? 'Active' : 'Missing' }}
                    </strong>
                </div>
                <a href="{{ route('admin.about.index') }}" class="ink-link font-mono text-[.65rem] uppercase tracking-[.08em] mt-6 block">
                    {{ $hasAbout ? 'Edit Biography' : 'Create Biography' }} &rarr;
                </a>
            </div>
        </div>

        {{-- Main split screen grid --}}
        <div class="grid gap-8 lg:grid-cols-[1.1fr_0.9fr]">

            {{-- Left column: Recent Inbox Messages --}}
            <div class="space-y-6">
                <div>
                    <h3 class="font-display text-xl" style="color:var(--paper);">Inquiries Inbox</h3>
                    <p class="text-xs mt-1" style="color:var(--slate);">Recent entries submitted via the public contact screen.</p>
                </div>

                <div class="space-y-4">
                    @forelse($recentContacts as $contact)
                        <div class="soft-panel p-5 space-y-3">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <h4 class="font-display text-lg" style="color:var(--paper);">
                                        {{ $contact->name }}
                                    </h4>
                                    <p class="font-mono text-[.68rem] tracking-wide mt-0.5" style="color:var(--slate);">
                                        {{ $contact->email }}
                                    </p>
                                </div>
                                <span class="font-mono text-[.65rem] uppercase" style="color:var(--brass);">
                                    {{ $contact->created_at->format('M d, Y') }}
                                </span>
                            </div>

                            @if($contact->subject)
                                <p class="font-mono text-xs uppercase" style="color:var(--brass);">
                                    Subject: {{ $contact->subject }}
                                </p>
                            @endif

                            <p class="text-sm leading-6 border-l-2 pl-4 py-1" style="border-color:var(--brass); color:var(--paper-dim);">
                                &ldquo;{{ $contact->message }}&rdquo;
                            </p>
                        </div>
                    @empty
                        <div class="soft-panel p-8 text-center">
                            <span class="tag-note">Empty</span>
                            <p class="mt-4 text-sm" style="color:var(--paper-dim);">No inquiries have been received yet.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Right column: Quick management indexes --}}
            <div class="space-y-6">
                <div>
                    <h3 class="font-display text-xl" style="color:var(--paper);">Quick Actions</h3>
                    <p class="text-xs mt-1" style="color:var(--slate);">Primary shortcuts to add, remove, and rewrite resources.</p>
                </div>

                <div class="soft-panel p-6 space-y-4">
                    <div class="flex items-start gap-4">
                        <span class="font-mono text-xs text-[var(--brass)] mt-1">01</span>
                        <div>
                            <h4 class="font-display text-lg" style="color:var(--paper);">Projects Archive</h4>
                            <p class="text-xs text-gray-500 mt-1">Manage project records, technology list strings, and preview cards.</p>
                            <div class="mt-3 flex gap-3">
                                <a href="{{ route('admin.projects.index') }}" class="ghost-button rounded px-4 py-2 text-[.68rem]">View Index</a>
                                <a href="{{ route('admin.projects.create') }}" class="gradient-button rounded px-4 py-2 text-[.68rem]">Add New</a>
                            </div>
                        </div>
                    </div>

                    <div class="h-px bg-gradient-to-r from-transparent via-[var(--line-strong)] to-transparent"></div>

                    <div class="flex items-start gap-4">
                        <span class="font-mono text-xs text-[var(--brass)] mt-1">02</span>
                        <div>
                            <h4 class="font-display text-lg" style="color:var(--paper);">Capabilities Ledger</h4>
                            <p class="text-xs text-gray-500 mt-1">Configure capability records, display order listings, and percentages.</p>
                            <div class="mt-3 flex gap-3">
                                <a href="{{ route('admin.skills.index') }}" class="ghost-button rounded px-4 py-2 text-[.68rem]">View Index</a>
                                <a href="{{ route('admin.skills.create') }}" class="gradient-button rounded px-4 py-2 text-[.68rem]">Add New</a>
                            </div>
                        </div>
                    </div>

                    <div class="h-px bg-gradient-to-r from-transparent via-[var(--line-strong)] to-transparent"></div>

                    <div class="flex items-start gap-4">
                        <span class="font-mono text-xs text-[var(--brass)] mt-1">03</span>
                        <div>
                            <h4 class="font-display text-lg" style="color:var(--paper);">Biography Profile</h4>
                            <p class="text-xs text-gray-500 mt-1">Set biography description blocks, details, resume files, and location taglines.</p>
                            <div class="mt-3">
                                <a href="{{ route('admin.about.index') }}" class="ghost-button block w-full text-center rounded py-2 text-[.68rem]">
                                    {{ $hasAbout ? 'Edit Biography' : 'Create Biography' }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>
@endsection