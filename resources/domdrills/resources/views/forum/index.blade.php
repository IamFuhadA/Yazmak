@extends('layouts.app')

@section('title', 'Forum — DomDrills')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-12">
    <div class="flex flex-wrap items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold mb-2">Doubts Forum</h1>
            <p class="text-slate-400">Ask a trading question, or help answer someone else's.</p>
        </div>
        @auth
            <a href="{{ route('forum.create') }}" class="px-4 py-2 rounded-md bg-accent text-ink font-semibold whitespace-nowrap">Ask a question</a>
        @else
            <a href="{{ route('login') }}" class="px-4 py-2 rounded-md border border-white/15 whitespace-nowrap">Log in to ask</a>
        @endauth
    </div>

    <form method="GET" class="mb-8">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search threads..."
               class="w-full rounded-md bg-panel border border-white/10 px-3 py-2 focus:border-accent outline-none">
    </form>

    <div class="space-y-3">
        @forelse($threads as $thread)
            <a href="{{ route('forum.show', $thread) }}" class="block rounded-lg border border-white/10 bg-panel p-5 hover:border-accent/50 transition">
                <div class="flex justify-between items-start gap-4">
                    <div>
                        <h3 class="font-semibold">{{ $thread->title }}</h3>
                        <p class="text-xs text-slate-500 mt-1">by {{ $thread->user->name }} &middot; {{ $thread->created_at->diffForHumans() }}</p>
                    </div>
                    <span class="text-xs shrink-0 px-2 py-1 rounded-full bg-white/5 text-slate-400">{{ $thread->replies_count }} replies</span>
                </div>
            </a>
        @empty
            <p class="text-slate-500">No questions yet — be the first to ask!</p>
        @endforelse
    </div>

    <div class="mt-10">
        {{ $threads->links() }}
    </div>
</div>
@endsection
