@extends('layouts.app')

@section('title', 'DomDrills — Learn to Trade the Right Way')

@section('content')
<section class="max-w-6xl mx-auto px-4 pt-16 pb-20">
    <div class="max-w-2xl">
        <p class="text-accent font-semibold tracking-wide text-sm uppercase mb-3">Trading education, mentorship &amp; tools</p>
        <h1 class="text-4xl sm:text-5xl font-bold leading-tight mb-6">Master the markets with <span class="text-accent">DomDrills</span>.</h1>
        <p class="text-slate-400 text-lg mb-8">Articles from real traders, a doubts forum, live 1-on-1 tutoring, and a built-in trading journal to track every trade you take.</p>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('posts.index') }}" class="px-5 py-3 rounded-md bg-accent text-ink font-semibold hover:opacity-90 transition">Start Learning</a>
            <a href="{{ route('tutoring.index') }}" class="px-5 py-3 rounded-md border border-white/15 hover:border-white/40 transition">Book 1-on-1 Tutoring</a>
        </div>
    </div>
</section>

<section class="max-w-6xl mx-auto px-4 pb-20">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold">Latest from the blog</h2>
        <a href="{{ route('posts.index') }}" class="text-accent text-sm hover:underline">View all &rarr;</a>
    </div>
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($latestPosts as $post)
            <a href="{{ route('posts.show', $post) }}" class="block rounded-lg border border-white/10 bg-panel p-5 hover:border-accent/50 transition">
                @if($post->category)
                    <span class="text-xs text-accent2 font-semibold">{{ $post->category->name }}</span>
                @endif
                <h3 class="font-semibold text-lg mt-2 mb-2">{{ $post->title }}</h3>
                <p class="text-sm text-slate-400 line-clamp-3">{{ $post->excerpt }}</p>
                <p class="text-xs text-slate-500 mt-4">by {{ $post->user->name }} &middot; {{ $post->published_at->format('M j, Y') }}</p>
            </a>
        @empty
            <p class="text-slate-500 col-span-3">No articles published yet — check back soon.</p>
        @endforelse
    </div>
</section>

<section class="max-w-6xl mx-auto px-4 pb-20 grid sm:grid-cols-3 gap-6">
    <div class="rounded-lg border border-white/10 bg-panel p-6">
        <h3 class="font-semibold text-lg mb-2">Doubts Forum</h3>
        <p class="text-slate-400 text-sm mb-4">Ask trading questions and get answers from mentors and the community.</p>
        <a href="{{ route('forum.index') }}" class="text-accent text-sm hover:underline">Browse the forum &rarr;</a>
    </div>
    <div class="rounded-lg border border-white/10 bg-panel p-6">
        <h3 class="font-semibold text-lg mb-2">Live Chat</h3>
        <p class="text-slate-400 text-sm mb-4">Jump into real-time chat during tutoring sessions and live market hours.</p>
        <a href="{{ route('chat.index') }}" class="text-accent text-sm hover:underline">Open live chat &rarr;</a>
    </div>
    <div class="rounded-lg border border-white/10 bg-panel p-6">
        <h3 class="font-semibold text-lg mb-2">Trading Journal</h3>
        <p class="text-slate-400 text-sm mb-4">Log every trade, track win rate and P&amp;L, and spot your patterns.</p>
        <a href="{{ route('journal.index') }}" class="text-accent text-sm hover:underline">Open your journal &rarr;</a>
    </div>
</section>

@if($faqHighlights->isNotEmpty())
<section class="max-w-6xl mx-auto px-4 pb-24">
    <h2 class="text-2xl font-bold mb-6">Frequently asked questions</h2>
    <div class="grid sm:grid-cols-2 gap-4">
        @foreach($faqHighlights as $faq)
            <div class="rounded-lg border border-white/10 bg-panel p-5">
                <h3 class="font-semibold mb-1">{{ $faq->question }}</h3>
                <p class="text-sm text-slate-400">{{ Str::limit($faq->answer, 140) }}</p>
            </div>
        @endforeach
    </div>
    <a href="{{ route('faq') }}" class="inline-block mt-6 text-accent text-sm hover:underline">See all FAQs &rarr;</a>
</section>
@endif
@endsection
