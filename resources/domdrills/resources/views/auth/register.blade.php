@extends('layouts.app')

@section('title', 'Sign up — DomDrills')

@section('content')
<div class="max-w-md mx-auto px-4 py-16">
    <h1 class="text-2xl font-bold mb-6">Create your account</h1>

    @if($errors->any())
        <div class="mb-4 rounded-md bg-red-500/10 border border-red-500/30 text-red-300 px-4 py-3 text-sm">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf
        <div>
            <label class="block text-sm text-slate-400 mb-1">Name</label>
            <input type="text" name="name" value="{{ old('name') }}" required autofocus
                   class="w-full rounded-md bg-panel border border-white/10 px-3 py-2 focus:border-accent outline-none">
        </div>
        <div>
            <label class="block text-sm text-slate-400 mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required
                   class="w-full rounded-md bg-panel border border-white/10 px-3 py-2 focus:border-accent outline-none">
        </div>
        <div>
            <label class="block text-sm text-slate-400 mb-1">Password</label>
            <input type="password" name="password" required
                   class="w-full rounded-md bg-panel border border-white/10 px-3 py-2 focus:border-accent outline-none">
        </div>
        <div>
            <label class="block text-sm text-slate-400 mb-1">Confirm password</label>
            <input type="password" name="password_confirmation" required
                   class="w-full rounded-md bg-panel border border-white/10 px-3 py-2 focus:border-accent outline-none">
        </div>
        <button class="w-full py-2.5 rounded-md bg-accent text-ink font-semibold hover:opacity-90 transition">Sign up</button>
    </form>

    <p class="text-sm text-slate-500 mt-6">Already have an account? <a href="{{ route('login') }}" class="text-accent hover:underline">Log in</a></p>
</div>
@endsection
