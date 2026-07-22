<?php

namespace App\Http\Controllers;

use App\Models\TutoringLead;
use Illuminate\Http\Request;

class TutoringController extends Controller
{
    public function index()
    {
        return view("tutoring.index");
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            "name" => ["required", "string", "max:255"],
            "email" => ["required", "email", "max:255"],
            "phone" => ["nullable", "string", "max:30"],
            "plan" => ["required", "string", "max:100"],
            "message" => ["nullable", "string", "max:2000"],
        ]);

        TutoringLead::create([
            ...$validated,
            "user_id" => $request->user()?->id,
        ]);

        return back()->with("status", "Thanks! We received your request and will reach out within 24 hours.");
    }
}
