@extends('layouts.app')

@section('title', $post->title.' — DomDrills')

@section('content')
<article class="max-w-3xl mx-auto px-4 py-12">
    <a href="{{ route('posts.index') }}" class="text-sm text-accent hover:underline">&larr; All articles</a>

    @if($post->category)
        <p class="text-accent2 text-sm font-semibold mt-4">{{ $post->category->name }}</p>
    @endif
    <h1 class="text-3xl sm:text-4xl font-bold mt-2 mb-3">{{ $post->title }}</h1>
    <p class="text-sm text-slate-500 mb-8">by {{ $post->user->name }} &middot; {{ $post->published_at->format('F j, Y') }}</p>

    <div class="prose prose-invert max-w-none text-slate-300 leading-relaxed whitespace-pre-line">
        {{ $post->body }}
    </div>
</article>

@if($related->isNotEmpty())
<section class="max-w-3xl mx-auto px-4 pb-16">
    <h2 class="text-xl font-bold mb-4">Related articles</h2>
    <div class="grid sm:grid-cols-3 gap-4">
        @foreach($related as $r)
            <a href="{{ route('posts.show', $r) }}" class="block rounded-lg border border-white/10 bg-panel p-4 hover:border-accent/50 transition">
                <h3 class="font-semibold text-sm">{{ $r->title }}</h3>
            </a>
        @endforeach
    </div>
</section>
@endif
@endsection
