<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\Post;

class HomeController extends Controller
{
    public function index()
    {
        $latestPosts = Post::published()->with(["user", "category"])->latest("published_at")->take(6)->get();
        $faqHighlights = Faq::orderBy("order")->take(4)->get();

        return view("home", compact("latestPosts", "faqHighlights"));
    }
}
