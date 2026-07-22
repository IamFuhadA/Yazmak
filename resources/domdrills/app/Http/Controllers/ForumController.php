<?php

namespace App\Http\Controllers;

use App\Models\ForumThread;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ForumController extends Controller
{
    public function index(Request $request)
    {
        $threads = ForumThread::with(["user", "replies"])
            ->when($request->search, fn ($q) => $q->where("title", "like", "%{$request->search}%"))
            ->withCount("replies")
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view("forum.index", compact("threads"));
    }

    public function create()
    {
        return view("forum.create");
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            "title" => ["required", "string", "max:255"],
            "body" => ["required", "string", "min:10"],
        ]);

        $thread = $request->user()->threads()->create([
            "title" => $validated["title"],
            "slug" => Str::slug($validated["title"])."-".Str::random(6),
            "body" => $validated["body"],
        ]);

        return redirect()->route("forum.show", $thread)->with("status", "Your question has been posted!");
    }

    public function show(ForumThread $thread)
    {
        $thread->load(["user", "replies.user"]);

        return view("forum.show", compact("thread"));
    }

    public function reply(Request $request, ForumThread $thread)
    {
        $validated = $request->validate([
            "body" => ["required", "string", "min:2"],
        ]);

        $thread->replies()->create([
            "user_id" => $request->user()->id,
            "body" => $validated["body"],
        ]);

        return back()->with("status", "Reply posted.");
    }
}
