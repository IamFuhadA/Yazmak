<?php

namespace App\Http\Controllers;

use App\Models\About;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AboutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $about = About::first();

        return view('admin.about.index', compact('about'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (About::exists()) {
            return redirect()->route('admin.about.index');
        }

        return view('admin.about.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'profession' => 'required|max:255',
            'email' => 'required|email',
            'phone' => 'required|max:20',
            'location' => 'required|max:255',
            'description' => 'required',

            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

            'resume' => 'nullable|mimes:pdf|max:5120',
        ]);

        if ($request->hasFile('profile_image')) {

            $validated['profile_image'] = $request
                ->file('profile_image')
                ->store('about', 'public');
        }

        if ($request->hasFile('resume')) {

            $validated['resume'] = $request
                ->file('resume')
                ->store('resume', 'public');
        }

        About::create($validated);

        return redirect()
            ->route('admin.about.index')
            ->with('success', 'About information created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(About $about)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(About $about)
    {
        return view('admin.about.edit', compact('about'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, About $about)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'profession' => 'required|max:255',
            'email' => 'required|email',
            'phone' => 'required|max:20',
            'location' => 'required|max:255',
            'description' => 'required',

            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

            'resume' => 'nullable|mimes:pdf|max:5120',
        ]);

        if ($request->hasFile('profile_image')) {

            if ($about->profile_image) {
                Storage::disk('public')->delete($about->profile_image);
            }

            $validated['profile_image'] = $request
                ->file('profile_image')
                ->store('about', 'public');
        }

        if ($request->hasFile('resume')) {

            if ($about->resume) {
                Storage::disk('public')->delete($about->resume);
            }

            $validated['resume'] = $request
                ->file('resume')
                ->store('resume', 'public');
        }

        $about->update($validated);

        return redirect()
            ->route('admin.about.index')
            ->with('success', 'About information updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(About $about)
    {
        abort(404);
    }
}
