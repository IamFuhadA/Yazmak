@extends('layouts.app')

@section('content')

<div class="max-w-6xl mx-auto py-8 px-4 sm:px-6 lg:px-8 space-y-6">

    {{-- Top bar --}}
    <div class="flex justify-between items-center pb-4 border-b animate-fade-in" style="border-color:var(--line);">
        <div>
            <p class="font-mono text-[.68rem] uppercase tracking-[.14em]" style="color:var(--brass);">Capabilities index</p>
            <h1 class="font-display text-3xl" style="color:var(--paper);">Manage Skills</h1>
        </div>

        <a href="{{ route('admin.skills.create') }}" class="gradient-button rounded px-4 py-2 text-xs">
            + Add Skill
        </a>
    </div>

    {{-- Success Toast --}}
    @if(session('success'))
        <div class="rounded border p-4 text-center animate-fade-in" style="border-color:var(--brass); background:var(--brass-dim);">
            <p class="font-mono text-xs font-semibold uppercase tracking-wider" style="color:var(--brass);">
                {{ session('success') }}
            </p>
        </div>
    @endif

    {{-- Skills list table --}}
    <div class="soft-panel overflow-hidden p-1.5">
        <div class="rounded-lg overflow-x-auto" style="background:var(--ink-950);">
            <table class="min-w-full divide-y" style="divide-color:var(--line);">
                <thead>
                    <tr class="font-mono text-[.68rem] uppercase tracking-wider text-left" style="color:var(--slate); background:var(--ink-900);">
                        <th class="px-6 py-4">Skill Name</th>
                        <th class="px-6 py-4">Proficiency</th>
                        <th class="px-6 py-4">Display Order</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y text-sm" style="divide-color:var(--line);">
                    @forelse($skills as $skill)
                        <tr class="transition-colors duration-200 hover:bg-white/[0.02]">
                            {{-- Name --}}
                            <td class="px-6 py-4 font-display font-medium text-base" style="color:var(--paper);">
                                {{ $skill->name }}
                            </td>

                            {{-- Percentage bar --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <span class="font-mono text-xs" style="color:var(--brass); min-width: 2.2rem;">
                                        {{ $skill->percentage }}%
                                    </span>
                                    <div class="h-1.5 w-32 overflow-hidden rounded-full bg-zinc-800">
                                        <div
                                            class="h-full rounded-full"
                                            style="width: {{ $skill->percentage }}%; background: linear-gradient(90deg, var(--red), var(--brass));"
                                        ></div>
                                    </div>
                                </div>
                            </td>

                            {{-- Display order --}}
                            <td class="px-6 py-4 whitespace-nowrap font-mono text-xs" style="color:var(--slate);">
                                {{ $skill->display_order ?? '0' }}
                            </td>

                            {{-- Actions --}}
                            <td class="px-6 py-4 whitespace-nowrap text-right text-xs font-mono">
                                <div class="flex items-center justify-end gap-3">
                                    <a href="{{ route('admin.skills.edit', $skill) }}" class="ink-link" style="color:var(--paper-dim);">
                                        Edit
                                    </a>

                                    <form action="{{ route('admin.skills.destroy', $skill) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            type="submit"
                                            onclick="return confirm('Delete this capability record?')"
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
                            <td colspan="4" class="px-6 py-12 text-center">
                                <span class="tag-note">No Skills</span>
                                <p class="mt-4 text-sm" style="color:var(--paper-dim);">No skill records have been created yet.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination --}}
    @if($skills->hasPages())
        <div class="pt-4 font-mono text-xs">
            {{ $skills->links() }}
        </div>
    @endif

</div>

@endsection