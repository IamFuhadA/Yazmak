@extends('layouts.app')

@section('title', 'Admin Dashboard — DomDrills')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-12">
    <h1 class="text-3xl font-bold mb-8">Admin Dashboard</h1>

    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-10">
        <div class="rounded-lg border border-white/10 bg-panel p-4">
            <p class="text-xs text-slate-500 mb-1">Users</p>
            <p class="text-2xl font-bold">{{ $stats['users'] }}</p>
        </div>
        <div class="rounded-lg border border-white/10 bg-panel p-4">
            <p class="text-xs text-slate-500 mb-1">Posts</p>
            <p class="text-2xl font-bold">{{ $stats['posts'] }}</p>
        </div>
        <div class="rounded-lg border border-white/10 bg-panel p-4">
            <p class="text-xs text-slate-500 mb-1">Forum Threads</p>
            <p class="text-2xl font-bold">{{ $stats['threads'] }}</p>
        </div>
        <div class="rounded-lg border border-white/10 bg-panel p-4">
            <p class="text-xs text-slate-500 mb-1">New Leads</p>
            <p class="text-2xl font-bold text-accent">{{ $stats['new_leads'] }}</p>
        </div>
    </div>

    <div class="flex gap-3 mb-10">
        <a href="{{ route('admin.posts.create') }}" class="px-4 py-2 rounded-md bg-accent text-ink font-semibold">New Post</a>
        <a href="{{ route('admin.posts.index') }}" class="px-4 py-2 rounded-md border border-white/15">Manage Posts</a>
        <a href="{{ route('admin.leads.index') }}" class="px-4 py-2 rounded-md border border-white/15">Manage Leads</a>
    </div>

    <h2 class="text-lg font-semibold mb-4">Recent Tutoring Leads</h2>
    <div class="overflow-x-auto rounded-lg border border-white/10">
        <table class="w-full text-sm">
            <thead class="bg-panel text-slate-400 text-left">
                <tr>
                    <th class="px-4 py-3">Name</th>
                    <th class="px-4 py-3">Plan</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Received</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @forelse($leads as $lead)
                    <tr>
                        <td class="px-4 py-3">{{ $lead->name }}<br><span class="text-xs text-slate-500">{{ $lead->email }}</span></td>
                        <td class="px-4 py-3">{{ $lead->plan }}</td>
                        <td class="px-4 py-3"><span class="text-xs px-2 py-0.5 rounded-full bg-white/5">{{ ucfirst($lead->status) }}</span></td>
                        <td class="px-4 py-3 text-slate-400">{{ $lead->created_at->diffForHumans() }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="px-4 py-8 text-center text-slate-500">No leads yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
