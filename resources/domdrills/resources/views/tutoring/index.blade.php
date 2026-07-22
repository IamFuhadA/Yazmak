@extends('layouts.app')

@section('title', '1-on-1 Tutoring — DomDrills')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-12">
    <h1 class="text-3xl font-bold mb-2">1-on-1 Trading Tutoring</h1>
    <p class="text-slate-400 mb-10 max-w-2xl">Work directly with a mentor to build your strategy, review your trades, and fix the habits that are costing you money. Pick a plan below and send us your details — we'll follow up within 24 hours.</p>

    <div class="grid md:grid-cols-3 gap-6 mb-14">
        <div class="rounded-lg border border-white/10 bg-panel p-6 flex flex-col">
            <h3 class="font-semibold text-lg mb-1">Starter Session</h3>
            <p class="text-3xl font-bold mb-4">$49<span class="text-sm text-slate-500 font-normal">/session</span></p>
            <ul class="text-sm text-slate-400 space-y-2 mb-6 flex-1">
                <li>&bull; Single 60-minute 1-on-1 call</li>
                <li>&bull; Strategy or trade review</li>
                <li>&bull; Follow-up notes</li>
            </ul>
            <button data-plan="Starter Session" class="plan-btn w-full py-2.5 rounded-md border border-white/15 hover:border-accent transition">Choose Plan</button>
        </div>
        <div class="rounded-lg border-2 border-accent bg-panel p-6 flex flex-col relative">
            <span class="absolute -top-3 left-6 text-xs bg-accent text-ink px-2 py-1 rounded-full font-semibold">Most Popular</span>
            <h3 class="font-semibold text-lg mb-1">Monthly Mentorship</h3>
            <p class="text-3xl font-bold mb-4">$179<span class="text-sm text-slate-500 font-normal">/month</span></p>
            <ul class="text-sm text-slate-400 space-y-2 mb-6 flex-1">
                <li>&bull; 4 x 60-minute sessions</li>
                <li>&bull; Trading journal review</li>
                <li>&bull; Direct chat access to mentor</li>
            </ul>
            <button data-plan="Monthly Mentorship" class="plan-btn w-full py-2.5 rounded-md bg-accent text-ink font-semibold hover:opacity-90 transition">Choose Plan</button>
        </div>
        <div class="rounded-lg border border-white/10 bg-panel p-6 flex flex-col">
            <h3 class="font-semibold text-lg mb-1">Intensive (3 Months)</h3>
            <p class="text-3xl font-bold mb-4">$449<span class="text-sm text-slate-500 font-normal">/3 mo</span></p>
            <ul class="text-sm text-slate-400 space-y-2 mb-6 flex-1">
                <li>&bull; Weekly sessions for 12 weeks</li>
                <li>&bull; Full journal + risk audit</li>
                <li>&bull; Priority live chat support</li>
            </ul>
            <button data-plan="Intensive (3 Months)" class="plan-btn w-full py-2.5 rounded-md border border-white/15 hover:border-accent transition">Choose Plan</button>
        </div>
    </div>

    <div class="max-w-xl mx-auto rounded-lg border border-white/10 bg-panel p-8" id="signup-form">
        <h2 class="text-xl font-bold mb-6">Request Tutoring</h2>

        @if($errors->any())
            <div class="mb-4 rounded-md bg-red-500/10 border border-red-500/30 text-red-300 px-4 py-3 text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('tutoring.store') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm text-slate-400 mb-1">Name</label>
                <input type="text" name="name" value="{{ old('name', auth()->user()->name ?? '') }}" required
                       class="w-full rounded-md bg-ink border border-white/10 px-3 py-2 focus:border-accent outline-none">
            </div>
            <div>
                <label class="block text-sm text-slate-400 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email', auth()->user()->email ?? '') }}" required
                       class="w-full rounded-md bg-ink border border-white/10 px-3 py-2 focus:border-accent outline-none">
            </div>
            <div>
                <label class="block text-sm text-slate-400 mb-1">Phone (optional)</label>
                <input type="text" name="phone" value="{{ old('phone') }}"
                       class="w-full rounded-md bg-ink border border-white/10 px-3 py-2 focus:border-accent outline-none">
            </div>
            <div>
                <label class="block text-sm text-slate-400 mb-1">Plan</label>
                <select name="plan" id="plan-select" class="w-full rounded-md bg-ink border border-white/10 px-3 py-2 focus:border-accent outline-none">
                    <option value="Starter Session" @selected(old('plan') === 'Starter Session')>Starter Session — $49</option>
                    <option value="Monthly Mentorship" @selected(old('plan', 'Monthly Mentorship') === 'Monthly Mentorship')>Monthly Mentorship — $179</option>
                    <option value="Intensive (3 Months)" @selected(old('plan') === 'Intensive (3 Months)')>Intensive (3 Months) — $449</option>
                    <option value="General Enquiry" @selected(old('plan') === 'General Enquiry')>Just have a question</option>
                </select>
            </div>
            <div>
                <label class="block text-sm text-slate-400 mb-1">Message (optional)</label>
                <textarea name="message" rows="4"
                          class="w-full rounded-md bg-ink border border-white/10 px-3 py-2 focus:border-accent outline-none">{{ old('message') }}</textarea>
            </div>
            <button class="w-full py-2.5 rounded-md bg-accent text-ink font-semibold hover:opacity-90 transition">Send Request</button>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.querySelectorAll('.plan-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            document.getElementById('plan-select').value = btn.dataset.plan;
            document.getElementById('signup-form').scrollIntoView({ behavior: 'smooth' });
        });
    });
</script>
@endpush
@endsection
