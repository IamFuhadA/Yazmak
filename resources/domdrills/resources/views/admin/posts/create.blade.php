@extends('layouts.app')

@section('title', 'New Post — Admin — DomDrills')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-12">
    <a href="{{ route('admin.posts.index') }}" class="text-sm text-accent hover:underline">&larr; Back to posts</a>
    <h1 class="text-2xl font-bold mt-4 mb-6">New Post</h1>

    @if($errors->any())
        <div class="mb-4 rounded-md bg-red-500/10 border border-red-500/30 text-red-300 px-4 py-3 text-sm">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.posts.store') }}" class="space-y-4">
        @csrf
        <div>
            <label class="block text-sm text-slate-400 mb-1">Title</label>
            <input type="text" name="title" value="{{ old('title') }}" required
                   class="w-full rounded-md bg-panel border border-white/10 px-3 py-2 focus:border-accent outline-none">
        </div>
        <div>
            <label class="block text-sm text-slate-400 mb-1">Category</label>
            <select name="category_id" class="w-full rounded-md bg-panel border border-white/10 px-3 py-2 focus:border-accent outline-none">
                <option value="">None</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" @selected(old('category_id') == $cat->id)>{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm text-slate-400 mb-1">Excerpt (optional, auto-generated if blank)</label>
            <input type="text" name="excerpt" value="{{ old('excerpt') }}"
                   class="w-full rounded-md bg-panel border border-white/10 px-3 py-2 focus:border-accent outline-none">
        </div>
        <div>
            <label class="block text-sm text-slate-400 mb-1">Body</label>
            <textarea name="body" rows="12" required
                      class="w-full rounded-md bg-panel border border-white/10 px-3 py-2 focus:border-accent outline-none">{{ old('body') }}</textarea>
        </div>
        <label class="flex items-center gap-2 text-sm text-slate-400">
            <input type="checkbox" name="publish" value="1" checked class="rounded border-white/20 bg-panel">
            Publish immediately
        </label>
        <button class="px-5 py-2.5 rounded-md bg-accent text-ink font-semibold">Save Post</button>
    </form>
</div>
@endsection
