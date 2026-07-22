@extends('layouts.app')

@section('title', 'Trading Journal — DomDrills')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-12">
    <div class="flex flex-wrap items-center justify-between gap-4 mb-8">
        <h1 class="text-3xl font-bold">Trading Journal</h1>
        <a href="{{ route('journal.create') }}" class="px-4 py-2 rounded-md bg-accent text-ink font-semibold">Log a Trade</a>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-10">
        <div class="rounded-lg border border-white/10 bg-panel p-4">
            <p class="text-xs text-slate-500 mb-1">Total Trades</p>
            <p class="text-2xl font-bold">{{ $stats['total_trades'] }}</p>
        </div>
        <div class="rounded-lg border border-white/10 bg-panel p-4">
            <p class="text-xs text-slate-500 mb-1">Wins</p>
            <p class="text-2xl font-bold text-accent">{{ $stats['wins'] }}</p>
        </div>
        <div class="rounded-lg border border-white/10 bg-panel p-4">
            <p class="text-xs text-slate-500 mb-1">Losses</p>
            <p class="text-2xl font-bold text-red-400">{{ $stats['losses'] }}</p>
        </div>
        <div class="rounded-lg border border-white/10 bg-panel p-4">
            <p class="text-xs text-slate-500 mb-1">Net P&amp;L</p>
            <p class="text-2xl font-bold {{ $stats['net_pnl'] >= 0 ? 'text-accent' : 'text-red-400' }}">
                {{ $stats['net_pnl'] >= 0 ? '+' : '' }}{{ number_format($stats['net_pnl'], 2) }}
            </p>
        </div>
    </div>

    <div class="overflow-x-auto rounded-lg border border-white/10">
        <table class="w-full text-sm">
            <thead class="bg-panel text-slate-400 text-left">
                <tr>
                    <th class="px-4 py-3">Symbol</th>
                    <th class="px-4 py-3">Dir</th>
                    <th class="px-4 py-3">Entry</th>
                    <th class="px-4 py-3">Exit</th>
                    <th class="px-4 py-3">Qty</th>
                    <th class="px-4 py-3">P&amp;L</th>
                    <th class="px-4 py-3">Entry Date</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @forelse($trades as $trade)
                    <tr class="hover:bg-white/[0.02]">
                        <td class="px-4 py-3 font-semibold">{{ $trade->symbol }}</td>
                        <td class="px-4 py-3">
                            <span class="text-xs px-2 py-0.5 rounded-full {{ $trade->direction === 'long' ? 'bg-accent/10 text-accent' : 'bg-red-400/10 text-red-400' }}">
                                {{ ucfirst($trade->direction) }}
                            </span>
                        </td>
                        <td class="px-4 py-3">{{ number_format($trade->entry_price, 2) }}</td>
                        <td class="px-4 py-3">{{ $trade->exit_price ? number_format($trade->exit_price, 2) : '—' }}</td>
                        <td class="px-4 py-3">{{ number_format($trade->quantity, 2) }}</td>
                        <td class="px-4 py-3 {{ $trade->pnl === null ? 'text-slate-500' : ($trade->pnl >= 0 ? 'text-accent' : 'text-red-400') }}">
                            {{ $trade->pnl === null ? 'Open' : number_format($trade->pnl, 2) }}
                        </td>
                        <td class="px-4 py-3 text-slate-400">{{ $trade->entry_date->format('M j, Y') }}</td>
                        <td class="px-4 py-3 text-right space-x-2 whitespace-nowrap">
                            <a href="{{ route('journal.edit', $trade) }}" class="text-accent2 hover:underline">Edit</a>
                            <form method="POST" action="{{ route('journal.destroy', $trade) }}" class="inline" onsubmit="return confirm('Delete this trade?')">
                                @csrf @method('DELETE')
                                <button class="text-red-400 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="px-4 py-8 text-center text-slate-500">No trades logged yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-8">
        {{ $trades->links() }}
    </div>
</div>
@endsection
