@extends('layouts.app')

@section('content')

<div class="max-w-6xl mx-auto py-8 px-4 sm:px-6 lg:px-8 space-y-6">

    <div class="flex justify-between items-center pb-4 border-b animate-fade-in" style="border-color:var(--line);">
        <div>
            <p class="font-mono text-[.68rem] uppercase tracking-[.14em]" style="color:var(--brass);">Biography profile</p>
            <h1 class="font-display text-3xl" style="color:var(--paper);">About Section</h1>
        </div>

        @if(!$about)
            <a href="{{ route('admin.about.create') }}" class="gradient-button rounded px-5 py-2.5 text-xs">
                Add Biography &rarr;
            </a>
        @endif
    </div>

    @if($about)
        <div class="soft-panel overflow-hidden p-1.5">
            <div class="rounded-lg p-6 md:p-8" style="background:var(--ink-950);">
                <div class="grid gap-8 md:grid-cols-[160px_1fr] items-start">
                    
                    {{-- Profile image frame --}}
                    <div class="relative aspect-square w-40 h-40 overflow-hidden rounded-md border mx-auto md:mx-0" style="border-color:var(--line); background:var(--ink-900);">
                        @if($about->profile_image)
                            <img
                                src="{{ asset('storage/'.$about->profile_image) }}"
                                alt="{{ $about->name }}"
                                class="h-full w-full object-cover grayscale transition duration-300 hover:grayscale-0"
                            >
                        @else
                            <div class="grid h-full place-items-center bg-zinc-900">
                                <span class="font-display text-5xl italic" style="color:var(--paper-dim);">
                                    {{ \Illuminate\Support\Str::of($about->name)->substr(0, 1) }}
                                </span>
                            </div>
                        @endif
                    </div>

                    {{-- Data specs --}}
                    <div class="space-y-6">
                        <div>
                            <span class="tag-note">Active Biography</span>
                            <h2 class="font-display text-2xl mt-3" style="color:var(--paper);">{{ $about->name }}</h2>
                            <p class="font-mono text-xs uppercase tracking-[.12em] mt-1" style="color:var(--brass);">{{ $about->profession }}</p>
                        </div>

                        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3 font-mono text-xs">
                            <div class="rounded border p-3.5" style="border-color:var(--line); background:var(--ink-900);">
                                <span style="color:var(--slate);">Email Address</span>
                                <p class="mt-1 font-semibold" style="color:var(--paper);">{{ $about->email }}</p>
                            </div>
                            <div class="rounded border p-3.5" style="border-color:var(--line); background:var(--ink-900);">
                                <span style="color:var(--slate);">Contact Number</span>
                                <p class="mt-1 font-semibold" style="color:var(--paper);">{{ $about->phone }}</p>
                            </div>
                            <div class="rounded border p-3.5" style="border-color:var(--line); background:var(--ink-900);">
                                <span style="color:var(--slate);">Location</span>
                                <p class="mt-1 font-semibold" style="color:var(--paper);">{{ $about->location }}</p>
                            </div>
                        </div>

                        <div>
                            <span class="font-mono text-[.68rem] uppercase tracking-[.14em]" style="color:var(--slate);">Biographical Brief</span>
                            <p class="mt-2 text-sm leading-7" style="color:var(--paper-dim);">
                                {{ $about->description }}
                            </p>
                        </div>

                        @if($about->resume)
                            <div>
                                <span class="font-mono text-[.68rem] uppercase tracking-[.14em] block" style="color:var(--slate);">Attached Resume</span>
                                <a href="{{ asset('storage/'.$about->resume) }}" target="_blank" class="ink-link font-mono text-xs mt-1.5 inline-block">
                                    View Resume Document &nearr;
                                </a>
                            </div>
                        @endif

                        <div class="pt-4 border-t" style="border-color:var(--line);">
                            <a href="{{ route('admin.about.edit', $about) }}" class="gradient-button rounded px-6 py-3 text-xs">
                                Edit Biography Settings
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    @else
        <div class="soft-panel p-12 text-center">
            <span class="tag-note">No Data Found</span>
            <h3 class="font-display mt-5 text-2xl" style="color:var(--paper);">Biography Not Configured</h3>
            <p class="mx-auto mt-2 max-w-md text-sm leading-6" style="color:var(--paper-dim);">
                Add your biographical details, email, location taglines, profile portrait, and resume to populate your public about screen.
            </p>
            <div class="mt-6">
                <a href="{{ route('admin.about.create') }}" class="gradient-button rounded px-5 py-3 text-xs">
                    Create Biography Card
                </a>
            </div>
        </div>
    @endif

</div>

@endsection