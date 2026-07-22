@extends('layouts.app')

@section('title', 'Ask a Question — DomDrills')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-12">
    <h1 class="text-2xl font-bold mb-6">Ask a Question</h1>

    @if($errors->any())
        <div class="mb-4 rounded-md bg-red-500/10 border border-red-500/30 text-red-300 px-4 py-3 text-sm">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('forum.store') }}" class="space-y-4">
        @csrf
        <div>
            <label class="block text-sm text-slate-400 mb-1">Title</label>
            <input type="text" name="title" value="{{ old('title') }}" required
                   class="w-full rounded-md bg-panel border border-white/10 px-3 py-2 focus:border-accent outline-none"
                   placeholder="e.g. How do I size positions with a 1% risk rule?">
        </div>
        <div>
            <label class="block text-sm text-slate-400 mb-1">Details</label>
            <textarea name="body" rows="8" required
                      class="w-full rounded-md bg-panel border border-white/10 px-3 py-2 focus:border-accent outline-none">{{ old('body') }}</textarea>
        </div>
        <button class="px-5 py-2.5 rounded-md bg-accent text-ink font-semibold">Post Question</button>
    </form>
</div>
@endsection
