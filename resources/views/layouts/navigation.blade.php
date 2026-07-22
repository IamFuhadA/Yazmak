<nav x-data="{ open: false }" class="border-b transition-colors duration-300" style="border-color:var(--line); background:var(--ink-900);">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('admin.dashboard') }}" class="group flex items-center gap-2.5">
                        <span class="grid h-8.5 w-8.5 place-items-center rounded-full border text-sm font-semibold italic" style="border-color:var(--brass); background:var(--ink-950); color:var(--brass); width: 2.2rem; height: 2.2rem;">
                            Y
                        </span>
                        <span class="font-display font-semibold tracking-wide text-md" style="color:var(--paper);">Yazmak Admin</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-1 sm:-my-px sm:ms-10 sm:flex items-center">
                    @php
                        $adminLinks = [
                            ['label' => 'Dashboard', 'route' => 'admin.dashboard'],
                            ['label' => 'Projects',  'route' => 'admin.projects.index'],
                            ['label' => 'About',     'route' => 'admin.about.index'],
                            ['label' => 'Skills',    'route' => 'admin.skills.index'],
                        ];
                    @endphp

                    @foreach($adminLinks as $link)
                        @php
                            $isActive = false;
                            if ($link['route'] === 'admin.dashboard') {
                                $isActive = request()->routeIs('admin.dashboard');
                            } else {
                                $resourceName = str_replace('.index', '', $link['route']);
                                $isActive = request()->is('admin/' . str_replace('admin.', '', $resourceName) . '*');
                            }
                        @endphp
                        <a
                            href="{{ route($link['route']) }}"
                            class="font-mono rounded px-3.5 py-1.5 text-xs font-semibold uppercase tracking-[.08em] transition-all duration-300"
                            style="{{ $isActive
                                ? 'color:var(--paper); background:var(--ink-800); box-shadow: inset 0 -2px 0 var(--red);'
                                : 'color:var(--slate);' }}"
                        >
                            {{ $link['label'] }}
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Right Actions & Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6 gap-3">
                <a
                    href="{{ route('home') }}"
                    target="_blank"
                    class="font-mono text-xs uppercase tracking-[.08em] rounded px-3 py-1.5 transition-all"
                    style="border:1px solid var(--line-strong); color:var(--paper-dim);"
                >
                    View Site &nearr;
                </a>

                <!-- Settings Dropdown -->
                <div class="ms-3 relative">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                type="button"
                                class="inline-flex items-center px-3.5 py-2 border text-xs font-semibold uppercase tracking-[.06em] rounded-md transition duration-150 ease-in-out focus:outline-none"
                                style="border-color:var(--line-strong); background:var(--ink-950); color:var(--paper-dim);"
                            >
                                <div>{{ Auth::user()->name }}</div>
                                <div class="ms-1">
                                    <svg class="fill-current h-3.5 w-3.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')" style="background:var(--ink-900); color:var(--paper-dim); border-bottom:1px solid var(--line);">
                                {{ __('Profile Settings') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}" style="background:var(--ink-900);">
                                @csrf
                                <x-dropdown-link
                                    :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();"
                                    style="color:var(--red);"
                                >
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button
                    @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded border transition duration-150 ease-in-out"
                    style="border-color:var(--line-strong); color:var(--paper-dim);"
                    aria-label="Toggle Dashboard Menu"
                >
                    <svg class="h-5 w-5" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden" style="border-t:1px solid var(--line); background:var(--ink-950);">
        <div class="pt-2 pb-3 space-y-1 px-4">
            @foreach($adminLinks as $link)
                @php
                    $isActive = false;
                    if ($link['route'] === 'admin.dashboard') {
                        $isActive = request()->routeIs('admin.dashboard');
                    } else {
                        $resourceName = str_replace('.index', '', $link['route']);
                        $isActive = request()->is('admin/' . str_replace('admin.', '', $resourceName) . '*');
                    }
                @endphp
                <a
                    href="{{ route($link['route']) }}"
                    class="block font-mono rounded px-4 py-2.5 text-xs font-semibold uppercase tracking-[.08em]"
                    style="{{ $isActive
                        ? 'color:var(--paper); background:var(--ink-800); border-left:3px solid var(--red);'
                        : 'color:var(--slate);' }}"
                >
                    {{ $link['label'] }}
                </a>
            @endforeach
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-4 border-t" style="border-color:var(--line);">
            <div class="px-8">
                <div class="font-display text-md" style="color:var(--paper);">{{ Auth::user()->name }}</div>
                <div class="font-mono text-xs" style="color:var(--slate);">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1 px-4">
                <a
                    href="{{ route('profile.edit') }}"
                    class="block font-mono rounded px-4 py-2 text-xs uppercase tracking-[.08em]"
                    style="color:var(--slate);"
                >
                    {{ __('Profile Settings') }}
                </a>

                <a
                    href="{{ route('home') }}"
                    target="_blank"
                    class="block font-mono rounded px-4 py-2 text-xs uppercase tracking-[.08em]"
                    style="color:var(--brass);"
                >
                    View Public Site
                </a>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button
                        type="submit"
                        class="w-full text-left font-mono rounded px-4 py-2 text-xs uppercase tracking-[.08em]"
                        style="color:var(--red);"
                    >
                        {{ __('Log Out') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
