<?php

use App\Models\ChatRoom;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel("chat-room.{roomId}", function ($user, $roomId) {
    // Any authenticated user may join the live-help room.
    return ChatRoom::whereKey($roomId)->exists()
        ? ["id" => $user->id, "name" => $user->name]
        : false;
});
