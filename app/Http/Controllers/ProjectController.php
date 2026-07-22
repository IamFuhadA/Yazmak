<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $projects = Project::when($request->search, function ($query) use ($request) {
            $query->where("title","like","%".$request->search."%");})
        ->latest()->paginate(10);
        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.projects.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'=>'required|max:255',
            'slug'=>'nullable|unique:projects,slug',
            'description'=>'required',
            'technology'=>'nullable|max:255',
            'github_url'=>'nullable|url',
            'live_url'=>'nullable|url',
            'image'=>'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'featured'=>'nullable|boolean',
        ]);

        if(empty($validated['slug'])){
            $validated['slug'] = Str::slug($validated['title']);
        }

        if($request->hasFile('image')){
            $validated['image']=$request->file('image')
            ->store('projects','public');
        }

        $validated['featured']=$request->has('featured');

        Project::create($validated);

        return redirect()
            ->route('admin.projects.index')
            ->with('success', 'Project created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        return view('admin.projects.edit',compact('project'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
         $validated = $request->validate([
            'title' => 'required|max:255',
            'slug' => 'required|unique:projects,slug,' . $project->id,
            'description' => 'required',
            'technology' => 'nullable|max:255',
            'github_url' => 'nullable|url',
            'live_url' => 'nullable|url',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {

            if ($project->image) {
                Storage::disk('public')->delete($project->image);
            }

            $validated['image'] = $request->file('image')
                ->store('projects', 'public');
        }

        $validated['featured'] = $request->has('featured');

        $project->update($validated);

        return redirect()
            ->route('admin.projects.index')
            ->with('success', 'Project updated successfully.');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        if ($project->image) {
            Storage::disk('public')->delete($project->image);
        }

        $project->delete();

        return redirect()
            ->route('admin.projects.index')
            ->with('success', 'Project deleted successfully.');
    }
}
