<?php

namespace App\Http\Controllers;

use App\Events\ChatMessageSent;
use App\Models\ChatRoom;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index()
    {
        $room = ChatRoom::firstOrCreate(
            ["slug" => "live-help"],
            ["name" => "Live Help - Ask a Doubt", "type" => "live_help"]
        );

        $messages = $room->messages()->with("user")->get()->reverse()->values();

        return view("chat.index", compact("room", "messages"));
    }

    public function store(Request $request, ChatRoom $room)
    {
        $validated = $request->validate([
            "message" => ["required", "string", "max:2000"],
        ]);

        $message = $room->messages()->create([
            "user_id" => $request->user()->id,
            "message" => $validated["message"],
        ]);

        broadcast(new ChatMessageSent($message))->toOthers();

        return response()->json(["status" => "sent"]);
    }
}
