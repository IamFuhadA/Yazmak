<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Models\Project;
use App\Models\Skill;

class FrontendController extends Controller
{
    public function landing()
    {
        $about = About::first();

        return view('frontend.landing', compact('about'));
    }

    public function home()
    {
        $about = About::first();

        $skills = Skill::orderBy('display_order')->get();

        $projects = Project::where('featured', true)
            ->latest()
            ->take(6)
            ->get();

        return view('frontend.home', compact(
            'about',
            'skills',
            'projects'
        ));
    }

    public function projects()
    {
        $projects = Project::latest()->get();

        return view('frontend.projects', compact('projects'));
    }

    public function about()
    {
        $about = About::first();

        $skills = Skill::orderBy('display_order')->get();

        return view('frontend.about', compact('about', 'skills'));
    }

    public function contact()
    {
        $about = About::first();

        return view('frontend.contact', compact('about'));
    }
}
