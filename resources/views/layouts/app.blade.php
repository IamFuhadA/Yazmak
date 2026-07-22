<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Yazmak') }} — Admin Panel</title>

    <!-- Preconnect to fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,300;0,9..144,400;0,9..144,500;0,9..144,600;0,9..144,700;1,9..144,400;1,9..144,500&family=Inter:wght@300;400;500;600;700&family=IBM+Plex+Mono:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Scripts and CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            /* Ink spectrum — adjusted brighter & richer */
            --ink-950: #12151c;
            --ink-900: #1c202a;
            --ink-850: #242936;
            --ink-800: #2a303f;
            --ink-700: #333a4c;
            --ink-600: #424b61;

            /* Paper & text — brighter soft tone */
            --paper:       #faf7ee;
            --paper-dim:   rgba(250,247,238,.78);
            --paper-muted: rgba(250,247,238,.50);

            /* Accent — vibrant brass gold */
            --brass:       #dfb66e;
            --brass-light: #f2cf90;
            --brass-dim:   rgba(223,182,110,.18);

            /* Accent — vibrant editorial red */
            --red:         #d35147;
            --red-light:   #e46a61;
            --red-dim:     rgba(211,81,71,.16);

            /* Neutral — slate */
            --slate:     #909eb0;
            --slate-dim: rgba(144,158,176,.6);

            /* Borders */
            --line:        rgba(250,247,238,.10);
            --line-strong: rgba(250,247,238,.20);
            --line-hover:  rgba(250,247,238,.35);
        }

        html {
            background: var(--ink-950);
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        body {
            font-family: 'Inter', ui-sans-serif, system-ui, -apple-system, sans-serif;
            color: var(--paper-dim);
            line-height: 1.7;
        }

        [x-cloak] { display: none !important; }

        /* Custom scrollbar for dashboard */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: var(--ink-950); }
        ::-webkit-scrollbar-thumb {
            background: var(--ink-600);
            border-radius: 3px;
        }
        ::-webkit-scrollbar-thumb:hover { background: var(--brass-dim); }

        .font-display { font-family: 'Fraunces', 'Georgia', serif; }
        .font-mono    { font-family: 'IBM Plex Mono', ui-monospace, monospace; }

        .dashboard-shell {
            position: relative;
            min-height: 100vh;
            min-height: 100dvh;
            background:
                radial-gradient(ellipse at 15% 10%, rgba(223,182,110,.05), transparent 35rem),
                radial-gradient(ellipse at 85% 85%, rgba(211,81,71,.04), transparent 35rem),
                var(--ink-950);
        }

        .noise-overlay {
            position: fixed;
            inset: 0;
            z-index: 9990;
            pointer-events: none;
            opacity: .025;
            mix-blend-mode: overlay;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.78' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)'/%3E%3C/svg%3E");
            background-repeat: repeat;
            background-size: 200px 200px;
        }

        .soft-panel {
            position: relative;
            background: var(--ink-850);
            border: 1px solid var(--line);
            border-radius: 10px;
        }
        .soft-panel::before {
            content: "";
            position: absolute;
            top: 0; left: 1.5rem;
            width: 2rem; height: 3px;
            background: var(--red);
            border-radius: 0 0 3px 3px;
        }

        .gradient-button {
            font-family: 'IBM Plex Mono', monospace;
            font-weight: 600;
            letter-spacing: .04em;
            background: var(--brass);
            color: var(--ink-950);
            border: 1px solid var(--brass);
            transition: all 0.25s ease;
        }
        .gradient-button:hover {
            background: var(--red);
            border-color: var(--red);
            color: var(--paper);
            box-shadow: 0 6px 18px rgba(211,81,71,.25);
        }

        .ghost-button {
            font-family: 'IBM Plex Mono', monospace;
            font-weight: 600;
            letter-spacing: .04em;
            color: var(--paper-dim);
            border: 1px solid var(--line-strong);
            background: transparent;
            transition: all 0.25s ease;
        }
        .ghost-button:hover {
            color: var(--paper);
            border-color: var(--line-hover);
            background: rgba(250,247,238,.04);
        }

        .tag-note {
            font-family: 'IBM Plex Mono', monospace;
            font-size: .64rem;
            font-weight: 600;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: var(--ink-950);
            background: var(--brass);
            padding: .15rem .5rem;
            border-radius: 2px;
            transform: rotate(-1deg);
            display: inline-block;
        }

        .ink-link {
            position: relative;
            color: var(--paper-dim);
            transition: color var(--duration-base) ease;
        }
        .ink-link::after {
            content: "";
            position: absolute;
            left: 0; right: 100%; bottom: -1px;
            height: 1px;
            background: var(--red);
            transition: right 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .ink-link:hover { color: var(--paper); }
        .ink-link:hover::after { right: 0; }
    </style>
</head>
<body class="font-sans antialiased">

    {{-- Noise Overlay --}}
    <div class="noise-overlay" aria-hidden="true"></div>

    <div class="dashboard-shell min-h-screen">
        {{-- Navigation Menu --}}
        @include('layouts.navigation')

        <!-- Page Heading -->
        @isset($header)
            <header class="border-b" style="border-color:var(--line); background:var(--ink-900);">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <h2 class="font-display text-2xl font-semibold leading-tight" style="color:var(--paper);">
                        {{ $header }}
                    </h2>
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main>
            {{ $slot ?? '' }}
            @yield('content')
        </main>
    </div>

</body>
</html>
