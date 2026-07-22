<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'DomDrills — Learn to Trade')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        ink: '#0B0F14',
                        panel: '#111823',
                        accent: '#22D3A5',
                        accent2: '#5B8CFF',
                    }
                }
            }
        }
    </script>
    @stack('head')
</head>
<body class="bg-ink text-slate-100 min-h-screen flex flex-col antialiased">

    <nav class="border-b border-white/10 bg-panel/60 backdrop-blur sticky top-0 z-40">
        <div class="max-w-6xl mx-auto px-4 flex items-center justify-between h-16">
            <a href="{{ route('home') }}" class="flex items-center gap-2 font-bold text-xl tracking-tight">
                <span class="text-accent">Dom</span><span class="text-accent2">Drills</span>
            </a>
            <div class="hidden md:flex items-center gap-6 text-sm text-slate-300">
                <a href="{{ route('posts.index') }}" class="hover:text-white transition">Learn</a>
                <a href="{{ route('faq') }}" class="hover:text-white transition">FAQ</a>
                <a href="{{ route('forum.index') }}" class="hover:text-white transition">Forum</a>
                <a href="{{ route('tutoring.index') }}" class="hover:text-white transition">Tutoring</a>
                @auth
                    <a href="{{ route('journal.index') }}" class="hover:text-white transition">Journal</a>
                    <a href="{{ route('chat.index') }}" class="hover:text-white transition">Live Chat</a>
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="hover:text-white transition">Admin</a>
                    @endif
                @endauth
            </div>
            <div class="flex items-center gap-3">
                @auth
                    <span class="text-sm text-slate-400 hidden sm:inline">{{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="text-sm px-3 py-1.5 rounded-md border border-white/10 hover:border-white/30 transition">Log out</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-sm px-3 py-1.5 rounded-md hover:bg-white/5 transition">Log in</a>
                    <a href="{{ route('register') }}" class="text-sm px-3 py-1.5 rounded-md bg-accent text-ink font-semibold hover:opacity-90 transition">Sign up</a>
                @endauth
            </div>
        </div>
    </nav>

    <main class="flex-1">
        @if(session('status'))
            <div class="max-w-6xl mx-auto px-4 mt-4">
                <div class="rounded-md bg-accent/10 border border-accent/30 text-accent px-4 py-3 text-sm">
                    {{ session('status') }}
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="border-t border-white/10 mt-16">
        <div class="max-w-6xl mx-auto px-4 py-10 text-sm text-slate-500 flex flex-col sm:flex-row justify-between gap-4">
            <p>&copy; {{ date('Y') }} DomDrills. All trading involves risk.</p>
            <div class="flex gap-4">
                <a href="{{ route('faq') }}" class="hover:text-slate-300">FAQ</a>
                <a href="{{ route('forum.index') }}" class="hover:text-slate-300">Forum</a>
                <a href="{{ route('tutoring.index') }}" class="hover:text-slate-300">Tutoring</a>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
