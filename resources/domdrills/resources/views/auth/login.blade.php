@extends('layouts.app')

@section('title', 'Log in — DomDrills')

@section('content')
<div class="max-w-md mx-auto px-4 py-16">
    <h1 class="text-2xl font-bold mb-6">Log in to DomDrills</h1>

    @if($errors->any())
        <div class="mb-4 rounded-md bg-red-500/10 border border-red-500/30 text-red-300 px-4 py-3 text-sm">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf
        <div>
            <label class="block text-sm text-slate-400 mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required autofocus
                   class="w-full rounded-md bg-panel border border-white/10 px-3 py-2 focus:border-accent outline-none">
        </div>
        <div>
            <label class="block text-sm text-slate-400 mb-1">Password</label>
            <input type="password" name="password" required
                   class="w-full rounded-md bg-panel border border-white/10 px-3 py-2 focus:border-accent outline-none">
        </div>
        <label class="flex items-center gap-2 text-sm text-slate-400">
            <input type="checkbox" name="remember" class="rounded border-white/20 bg-panel">
            Remember me
        </label>
        <button class="w-full py-2.5 rounded-md bg-accent text-ink font-semibold hover:opacity-90 transition">Log in</button>
    </form>

    <p class="text-sm text-slate-500 mt-6">Don't have an account? <a href="{{ route('register') }}" class="text-accent hover:underline">Sign up</a></p>
</div>
@endsection
