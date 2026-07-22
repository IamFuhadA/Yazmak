<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with("category")->latest()->paginate(20);

        return view("admin.posts.index", compact("posts"));
    }

    public function create()
    {
        $categories = Category::orderBy("name")->get();

        return view("admin.posts.create", compact("categories"));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            "title" => ["required", "string", "max:255"],
            "category_id" => ["nullable", "exists:categories,id"],
            "excerpt" => ["nullable", "string", "max:255"],
            "body" => ["required", "string"],
            "publish" => ["nullable", "boolean"],
        ]);

        $request->user()->posts()->create([
            "category_id" => $validated["category_id"] ?? null,
            "title" => $validated["title"],
            "slug" => Str::slug($validated["title"])."-".Str::random(6),
            "excerpt" => $validated["excerpt"] ?? Str::limit(strip_tags($validated["body"]), 150),
            "body" => $validated["body"],
            "published_at" => $request->boolean("publish") ? now() : null,
        ]);

        return redirect()->route("admin.posts.index")->with("status", "Post created.");
    }
}
