<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ForumThread;
use App\Models\Post;
use App\Models\TutoringLead;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            "users" => User::count(),
            "posts" => Post::count(),
            "threads" => ForumThread::count(),
            "new_leads" => TutoringLead::where("status", "new")->count(),
        ];

        $leads = TutoringLead::latest()->take(10)->get();

        return view("admin.dashboard", compact("stats", "leads"));
    }
}
