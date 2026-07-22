@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8 space-y-6">

    {{-- Top bar --}}
    <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-4 pb-4 border-b" style="border-color:var(--line);">
        <div>
            <p class="font-mono text-[.68rem] uppercase tracking-[.14em]" style="color:var(--brass);">Portfolio assets</p>
            <h1 class="font-display text-3xl" style="color:var(--paper);">Projects Archive</h1>
        </div>

        <div class="flex items-center gap-3">
            {{-- Search projects form --}}
            <form action="{{ route('admin.projects.index') }}" method="GET" class="flex gap-2">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search by title..."
                    class="rounded border px-3 py-1.5 text-xs focus:outline-none focus:border-zinc-500"
                    style="border-color:var(--line-strong); background:var(--ink-900); color:var(--paper);"
                >
                <button type="submit" class="ghost-button rounded px-3 py-1.5 text-xs">Search</button>
            </form>

            <a href="{{ route('admin.projects.create') }}" class="gradient-button rounded px-4 py-2 text-xs">
                + Add Project
            </a>
        </div>
    </div>

    {{-- Flash messages --}}
    @if(session('success'))
        <div class="rounded border p-4 text-center animate-fade-in" style="border-color:var(--brass); background:var(--brass-dim);">
            <p class="font-mono text-xs font-semibold uppercase tracking-wider" style="color:var(--brass);">
                {{ session('success') }}
            </p>
        </div>
    @endif

    {{-- Table list --}}
    <div class="soft-panel overflow-hidden p-1.5">
        <div class="rounded-lg overflow-x-auto" style="background:var(--ink-950);">
            <table class="min-w-full divide-y" style="divide-color:var(--line);">
                <thead>
                    <tr class="font-mono text-[.68rem] uppercase tracking-wider text-left" style="color:var(--slate); background:var(--ink-900);">
                        <th class="px-6 py-4">Image</th>
                        <th class="px-6 py-4">Title</th>
                        <th class="px-6 py-4">Technology</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y text-sm" style="divide-color:var(--line);">
                    @forelse($projects as $project)
                        <tr class="transition-colors duration-200 hover:bg-white/[0.02]">
                            {{-- Image column --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="h-10 w-16 overflow-hidden rounded border bg-zinc-900" style="border-color:var(--line-strong);">
                                    @if($project->image)
                                        <img src="{{ asset('storage/'.$project->image) }}" alt="" class="h-full w-full object-cover">
                                    @else
                                        <div class="h-full w-full grid place-items-center font-display text-[0.65rem] italic" style="color:var(--slate);">
                                            Draft
                                        </div>
                                    @endif
                                </div>
                            </td>

                            {{-- Title --}}
                            <td class="px-6 py-4 font-display font-medium text-base" style="color:var(--paper);">
                                {{ $project->title }}
                            </td>

                            {{-- Technology --}}
                            <td class="px-6 py-4 whitespace-nowrap font-mono text-xs" style="color:var(--slate);">
                                {{ $project->technology ?: '—' }}
                            </td>

                            {{-- Featured status --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($project->featured)
                                    <span class="tag-note" style="transform: rotate(0deg); font-size: .55rem; padding: .1rem .45rem;">
                                        Featured
                                    </span>
                                @else
                                    <span class="font-mono text-[0.62rem] uppercase tracking-wider" style="color:var(--slate);">
                                        Standard
                                    </span>
                                @endif
                            </td>

                            {{-- Action controls --}}
                            <td class="px-6 py-4 whitespace-nowrap text-right text-xs font-mono">
                                <div class="flex items-center justify-end gap-3">
                                    <a href="{{ route('admin.projects.edit', $project) }}" class="ink-link" style="color:var(--paper-dim);">
                                        Edit
                                    </a>

                                    <form action="{{ route('admin.projects.destroy', $project) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            type="submit"
                                            onclick="return confirm('Delete this project record?')"
                                            class="text-red-500 hover:text-red-400 font-semibold transition"
                                        >
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <span class="tag-note">No Records</span>
                                <p class="mt-4 text-sm" style="color:var(--paper-dim);">No project records match your parameters.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination links --}}
    @if($projects->hasPages())
        <div class="pt-4 font-mono text-xs">
            {{ $projects->links() }}
        </div>
    @endif

</div>

@endsection