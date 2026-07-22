@extends('layouts.app')

@section('title', 'FAQ — DomDrills')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-12">
    <h1 class="text-3xl font-bold mb-2">Frequently Asked Questions</h1>
    <p class="text-slate-400 mb-10">Everything you need to know about DomDrills, tutoring, and the trading journal.</p>

    @forelse($faqs as $category => $items)
        <div class="mb-10">
            <h2 class="text-lg font-semibold text-accent2 mb-4">{{ $category }}</h2>
            <div class="space-y-3">
                @foreach($items as $faq)
                    <details class="rounded-lg border border-white/10 bg-panel p-4 group">
                        <summary class="cursor-pointer font-medium list-none flex justify-between items-center">
                            {{ $faq->question }}
                            <span class="text-slate-500 group-open:rotate-45 transition">+</span>
                        </summary>
                        <p class="text-sm text-slate-400 mt-3">{{ $faq->answer }}</p>
                    </details>
                @endforeach
            </div>
        </div>
    @empty
        <p class="text-slate-500">No FAQs published yet.</p>
    @endforelse

    <div class="rounded-lg border border-accent/30 bg-accent/5 p-6 text-center mt-10">
        <p class="text-slate-300 mb-3">Still have a question?</p>
        <a href="{{ route('forum.index') }}" class="text-accent hover:underline font-semibold">Ask it in the forum &rarr;</a>
    </div>
</div>
@endsection
