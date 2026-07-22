@extends('layouts.app')

@section('title', 'Live Chat — DomDrills')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-12">
    <h1 class="text-2xl font-bold mb-1">{{ $room->name }}</h1>
    <p class="text-slate-400 text-sm mb-6">Ask doubts live, or chat during your 1-on-1 tutoring session.</p>

    <div id="chat-window" class="rounded-lg border border-white/10 bg-panel h-[480px] overflow-y-auto p-4 space-y-3 flex flex-col">
        @foreach($messages as $message)
            <div class="max-w-[80%] {{ $message->user_id === auth()->id() ? 'self-end text-right' : 'self-start' }}">
                <p class="text-xs text-slate-500 mb-1">{{ $message->user->name }} &middot; {{ $message->created_at->format('g:i A') }}</p>
                <p class="inline-block rounded-lg px-3 py-2 text-sm {{ $message->user_id === auth()->id() ? 'bg-accent text-ink' : 'bg-white/5 text-slate-200' }}">
                    {{ $message->message }}
                </p>
            </div>
        @endforeach
    </div>

    <form id="chat-form" class="mt-4 flex gap-3">
        <input type="text" id="chat-input" required autocomplete="off" placeholder="Type your message..."
               class="flex-1 rounded-md bg-panel border border-white/10 px-3 py-2 focus:border-accent outline-none">
        <button class="px-5 py-2.5 rounded-md bg-accent text-ink font-semibold">Send</button>
    </form>
    <p class="text-xs text-slate-600 mt-3">Live updates require the Reverb websocket server to be running (<code>php artisan reverb:start</code>) and Laravel Echo configured — see README.</p>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/pusher-js@8.4.0/dist/web/pusher.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.16.1/dist/echo.iife.js"></script>
<script>
    const roomId = {{ $room->id }};
    const currentUserId = {{ auth()->id() }};
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    window.Echo = new Echo({
        broadcaster: 'reverb',
        key: '{{ config("broadcasting.connections.reverb.key") }}',
        wsHost: '{{ config("broadcasting.connections.reverb.options.host") }}',
        wsPort: {{ config('broadcasting.connections.reverb.options.port', 8080) }},
        wssPort: {{ config('broadcasting.connections.reverb.options.port', 8080) }},
        forceTLS: '{{ config("broadcasting.connections.reverb.options.scheme") }}' === 'https',
        enabledTransports: ['ws', 'wss'],
        authEndpoint: '/broadcasting/auth',
        auth: { headers: { 'X-CSRF-TOKEN': csrfToken } },
    });

    const chatWindow = document.getElementById('chat-window');
    chatWindow.scrollTop = chatWindow.scrollHeight;

    function appendMessage(data, isMine) {
        const wrap = document.createElement('div');
        wrap.className = `max-w-[80%] ${isMine ? 'self-end text-right' : 'self-start'}`;
        wrap.innerHTML = `
            <p class="text-xs text-slate-500 mb-1">${data.user.name} &middot; just now</p>
            <p class="inline-block rounded-lg px-3 py-2 text-sm ${isMine ? 'bg-accent text-ink' : 'bg-white/5 text-slate-200'}">${data.message}</p>
        `;
        chatWindow.appendChild(wrap);
        chatWindow.scrollTop = chatWindow.scrollHeight;
    }

    Echo.join(`chat-room.${roomId}`)
        .listen('.message.sent', (data) => appendMessage(data, data.user.id === currentUserId));

    document.getElementById('chat-form').addEventListener('submit', async (e) => {
        e.preventDefault();
        const input = document.getElementById('chat-input');
        const message = input.value.trim();
        if (!message) return;

        const res = await fetch(`/chat/rooms/${roomId}/messages`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            },
            body: JSON.stringify({ message }),
        });

        if (res.ok) {
            appendMessage({ message, user: { id: currentUserId, name: '{{ auth()->user()->name }}' } }, true);
            input.value = '';
        }
    });
</script>
@endpush
@endsection
