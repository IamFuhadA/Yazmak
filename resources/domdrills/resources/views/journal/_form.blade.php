@if($errors->any())
    <div class="mb-4 rounded-md bg-red-500/10 border border-red-500/30 text-red-300 px-4 py-3 text-sm">
        <ul class="list-disc list-inside">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="grid sm:grid-cols-2 gap-4">
    <div>
        <label class="block text-sm text-slate-400 mb-1">Symbol</label>
        <input type="text" name="symbol" value="{{ old('symbol', $trade->symbol ?? '') }}" required
               class="w-full rounded-md bg-panel border border-white/10 px-3 py-2 focus:border-accent outline-none uppercase"
               placeholder="e.g. AAPL, EURUSD, BTCUSD">
    </div>
    <div>
        <label class="block text-sm text-slate-400 mb-1">Direction</label>
        <select name="direction" class="w-full rounded-md bg-panel border border-white/10 px-3 py-2 focus:border-accent outline-none">
            <option value="long" @selected(old('direction', $trade->direction ?? 'long') === 'long')>Long</option>
            <option value="short" @selected(old('direction', $trade->direction ?? '') === 'short')>Short</option>
        </select>
    </div>
    <div>
        <label class="block text-sm text-slate-400 mb-1">Entry Price</label>
        <input type="number" step="0.0001" name="entry_price" value="{{ old('entry_price', $trade->entry_price ?? '') }}" required
               class="w-full rounded-md bg-panel border border-white/10 px-3 py-2 focus:border-accent outline-none">
    </div>
    <div>
        <label class="block text-sm text-slate-400 mb-1">Exit Price (leave blank if still open)</label>
        <input type="number" step="0.0001" name="exit_price" value="{{ old('exit_price', $trade->exit_price ?? '') }}"
               class="w-full rounded-md bg-panel border border-white/10 px-3 py-2 focus:border-accent outline-none">
    </div>
    <div>
        <label class="block text-sm text-slate-400 mb-1">Quantity / Size</label>
        <input type="number" step="0.0001" name="quantity" value="{{ old('quantity', $trade->quantity ?? '') }}" required
               class="w-full rounded-md bg-panel border border-white/10 px-3 py-2 focus:border-accent outline-none">
    </div>
    <div>
        <label class="block text-sm text-slate-400 mb-1">Setup / Strategy (optional)</label>
        <input type="text" name="setup" value="{{ old('setup', $trade->setup ?? '') }}"
               class="w-full rounded-md bg-panel border border-white/10 px-3 py-2 focus:border-accent outline-none"
               placeholder="e.g. Breakout, Pullback, Reversal">
    </div>
    <div>
        <label class="block text-sm text-slate-400 mb-1">Entry Date</label>
        <input type="date" name="entry_date" value="{{ old('entry_date', isset($trade) ? $trade->entry_date->format('Y-m-d') : '') }}" required
               class="w-full rounded-md bg-panel border border-white/10 px-3 py-2 focus:border-accent outline-none">
    </div>
    <div>
        <label class="block text-sm text-slate-400 mb-1">Exit Date (optional)</label>
        <input type="date" name="exit_date" value="{{ old('exit_date', isset($trade) && $trade->exit_date ? $trade->exit_date->format('Y-m-d') : '') }}"
               class="w-full rounded-md bg-panel border border-white/10 px-3 py-2 focus:border-accent outline-none">
    </div>
</div>
<div class="mt-4">
    <label class="block text-sm text-slate-400 mb-1">Notes</label>
    <textarea name="notes" rows="5" class="w-full rounded-md bg-panel border border-white/10 px-3 py-2 focus:border-accent outline-none"
              placeholder="What was your thesis? What went right or wrong?">{{ old('notes', $trade->notes ?? '') }}</textarea>
</div>
