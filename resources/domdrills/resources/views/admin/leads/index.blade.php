@extends('layouts.app')

@section('title', 'Tutoring Leads — Admin — DomDrills')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-12">
    <h1 class="text-2xl font-bold mb-8">Tutoring Leads</h1>

    <div class="overflow-x-auto rounded-lg border border-white/10">
        <table class="w-full text-sm">
            <thead class="bg-panel text-slate-400 text-left">
                <tr>
                    <th class="px-4 py-3">Name</th>
                    <th class="px-4 py-3">Contact</th>
                    <th class="px-4 py-3">Plan</th>
                    <th class="px-4 py-3">Message</th>
                    <th class="px-4 py-3">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @forelse($leads as $lead)
                    <tr>
                        <td class="px-4 py-3">{{ $lead->name }}</td>
                        <td class="px-4 py-3 text-slate-400">{{ $lead->email }}<br>{{ $lead->phone }}</td>
                        <td class="px-4 py-3">{{ $lead->plan }}</td>
                        <td class="px-4 py-3 text-slate-400 max-w-xs truncate">{{ $lead->message }}</td>
                        <td class="px-4 py-3">
                            <form method="POST" action="{{ route('admin.leads.update', $lead) }}">
                                @csrf @method('PUT')
                                <select name="status" onchange="this.form.submit()"
                                        class="rounded-md bg-panel border border-white/10 px-2 py-1 text-xs">
                                    @foreach(['new', 'contacted', 'scheduled', 'closed'] as $status)
                                        <option value="{{ $status }}" @selected($lead->status === $status)>{{ ucfirst($status) }}</option>
                                    @endforeach
                                </select>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-4 py-8 text-center text-slate-500">No leads yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-8">{{ $leads->links() }}</div>
</div>
@endsection
