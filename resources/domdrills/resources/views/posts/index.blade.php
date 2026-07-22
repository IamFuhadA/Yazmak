@extends('layouts.app')

@section('title', 'Learn — DomDrills')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-12">
    <h1 class="text-3xl font-bold mb-2">Trading Articles</h1>
    <p class="text-slate-400 mb-8">Strategy breakdowns, risk management, psychology, and market structure.</p>

    <form method="GET" class="flex flex-wrap gap-3 mb-8">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search articles..."
               class="flex-1 min-w-[200px] rounded-md bg-panel border border-white/10 px-3 py-2 focus:border-accent outline-none">
        <select name="category" class="rounded-md bg-panel border border-white/10 px-3 py-2">
            <option value="">All categories</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->slug }}" @selected(request('category') === $cat->slug)>{{ $cat->name }}</option>
            @endforeach
        </select>
        <button class="px-4 py-2 rounded-md bg-accent text-ink font-semibold">Filter</button>
    </form>

    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($posts as $post)
            <a href="{{ route('posts.show', $post) }}" class="block rounded-lg border border-white/10 bg-panel p-5 hover:border-accent/50 transition">
                @if($post->category)
                    <span class="text-xs text-accent2 font-semibold">{{ $post->category->name }}</span>
                @endif
                <h3 class="font-semibold text-lg mt-2 mb-2">{{ $post->title }}</h3>
                <p class="text-sm text-slate-400 line-clamp-3">{{ $post->excerpt }}</p>
                <p class="text-xs text-slate-500 mt-4">by {{ $post->user->name }} &middot; {{ $post->published_at->format('M j, Y') }}</p>
            </a>
        @empty
            <p class="text-slate-500 col-span-3">No articles found.</p>
        @endforelse
    </div>

    <div class="mt-10">
        {{ $posts->links() }}
    </div>
</div>
@endsection
