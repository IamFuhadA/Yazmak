@extends('layouts.app')

@section('title', $thread->title.' — Forum — DomDrills')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-12">
    <a href="{{ route('forum.index') }}" class="text-sm text-accent hover:underline">&larr; Back to forum</a>

    <div class="rounded-lg border border-white/10 bg-panel p-6 mt-6">
        <h1 class="text-2xl font-bold mb-2">{{ $thread->title }}</h1>
        <p class="text-xs text-slate-500 mb-4">by {{ $thread->user->name }} &middot; {{ $thread->created_at->diffForHumans() }}</p>
        <p class="text-slate-300 whitespace-pre-line">{{ $thread->body }}</p>
    </div>

    <h2 class="text-lg font-semibold mt-10 mb-4">{{ $thread->replies->count() }} {{ Str::plural('Reply', $thread->replies->count()) }}</h2>

    <div class="space-y-4">
        @forelse($thread->replies as $reply)
            <div class="rounded-lg border border-white/10 bg-panel/60 p-4">
                <p class="text-sm text-slate-300 whitespace-pre-line">{{ $reply->body }}</p>
                <p class="text-xs text-slate-500 mt-2">{{ $reply->user->name }} &middot; {{ $reply->created_at->diffForHumans() }}</p>
            </div>
        @empty
            <p class="text-slate-500 text-sm">No replies yet.</p>
        @endforelse
    </div>

    @auth
        <form method="POST" action="{{ route('forum.reply', $thread) }}" class="mt-8 space-y-3">
            @csrf
            <textarea name="body" rows="4" required placeholder="Write a reply..."
                      class="w-full rounded-md bg-panel border border-white/10 px-3 py-2 focus:border-accent outline-none"></textarea>
            <button class="px-5 py-2.5 rounded-md bg-accent text-ink font-semibold">Post Reply</button>
        </form>
    @else
        <p class="mt-8 text-sm text-slate-500"><a href="{{ route('login') }}" class="text-accent hover:underline">Log in</a> to reply.</p>
    @endauth
</div>
@endsection
