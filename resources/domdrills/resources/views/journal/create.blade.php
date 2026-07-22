@extends('layouts.app')

@section('title', 'Log a Trade — DomDrills')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-12">
    <a href="{{ route('journal.index') }}" class="text-sm text-accent hover:underline">&larr; Back to journal</a>
    <h1 class="text-2xl font-bold mt-4 mb-6">Log a Trade</h1>

    <form method="POST" action="{{ route('journal.store') }}">
        @csrf
        @include('journal._form')
        <button class="mt-6 px-5 py-2.5 rounded-md bg-accent text-ink font-semibold">Save Trade</button>
    </form>
</div>
@endsection
