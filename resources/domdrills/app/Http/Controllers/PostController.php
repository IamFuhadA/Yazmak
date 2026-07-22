<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::published()
            ->with(["user", "category"])
            ->when($request->category, fn ($q) => $q->whereHas("category", fn ($c) => $c->where("slug", $request->category)))
            ->when($request->search, fn ($q) => $q->where("title", "like", "%{$request->search}%"))
            ->latest("published_at")
            ->paginate(9)
            ->withQueryString();

        $categories = Category::orderBy("name")->get();

        return view("posts.index", compact("posts", "categories"));
    }

    public function show(Post $post)
    {
        abort_unless($post->published_at && $post->published_at->isPast(), 404);

        $related = Post::published()
            ->where("id", "!=", $post->id)
            ->where("category_id", $post->category_id)
            ->take(3)
            ->get();

        return view("posts.show", compact("post", "related"));
    }
}
