@extends('layouts.app')

@section('title', 'Manage Posts — Admin — DomDrills')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-12">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-2xl font-bold">Manage Posts</h1>
        <a href="{{ route('admin.posts.create') }}" class="px-4 py-2 rounded-md bg-accent text-ink font-semibold">New Post</a>
    </div>

    <div class="overflow-x-auto rounded-lg border border-white/10">
        <table class="w-full text-sm">
            <thead class="bg-panel text-slate-400 text-left">
                <tr>
                    <th class="px-4 py-3">Title</th>
                    <th class="px-4 py-3">Category</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Created</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @forelse($posts as $post)
                    <tr>
                        <td class="px-4 py-3">{{ $post->title }}</td>
                        <td class="px-4 py-3 text-slate-400">{{ $post->category?->name ?? '—' }}</td>
                        <td class="px-4 py-3">
                            @if($post->published_at)
                                <span class="text-xs px-2 py-0.5 rounded-full bg-accent/10 text-accent">Published</span>
                            @else
                                <span class="text-xs px-2 py-0.5 rounded-full bg-white/5 text-slate-400">Draft</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-slate-400">{{ $post->created_at->format('M j, Y') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="px-4 py-8 text-center text-slate-500">No posts yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-8">{{ $posts->links() }}</div>
</div>
@endsection
