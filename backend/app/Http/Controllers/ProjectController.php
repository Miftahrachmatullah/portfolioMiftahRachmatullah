<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Http\Resources\ProjectResource;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $query = Project::with(['categories', 'technologies']);

        if ($request->has('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->has('category')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('slug', $request->input('category'));
            });
        }

        $query->orderBy('sort_order', 'asc')->orderBy('created_at', 'desc');

        $perPage = $request->input('per_page', 9);
        $projects = $query->paginate($perPage);

        return ProjectResource::collection($projects);
    }

    public function show($slug)
    {
        $project = Project::with(['categories', 'technologies'])->where('slug', $slug)->firstOrFail();
        return new ProjectResource($project);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'summary' => 'nullable|string',
            'description' => 'nullable|string',
            'problem' => 'nullable|string',
            'goal' => 'nullable|string',
            'role' => 'nullable|string',
            'flow_steps' => 'nullable|array',
            'result' => 'nullable|string',
            'cover_image' => 'nullable|image|max:2048',
            'demo_url' => 'nullable|url',
            'repository_url' => 'nullable|url',
            'status' => 'nullable|in:draft,published',
            'featured' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',
            'technologies' => 'nullable|array',
            'technologies.*' => 'exists:technologies,id',
        ]);

        $validated['slug'] = Str::slug($validated['title']) . '-' . Str::random(5);

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('projects', 'public');
        }

        $project = Project::create(\Illuminate\Support\Arr::except($validated, ['categories', 'technologies']));

        if (isset($validated['categories'])) {
            $project->categories()->attach($validated['categories']);
        }

        if (isset($validated['technologies'])) {
            $project->technologies()->attach($validated['technologies']);
        }

        return new ProjectResource($project->load(['categories', 'technologies']));
    }

    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'summary' => 'nullable|string',
            'description' => 'nullable|string',
            'problem' => 'nullable|string',
            'goal' => 'nullable|string',
            'role' => 'nullable|string',
            'flow_steps' => 'nullable|array',
            'result' => 'nullable|string',
            'cover_image' => 'nullable|image|max:2048',
            'demo_url' => 'nullable|url',
            'repository_url' => 'nullable|url',
            'status' => 'nullable|in:draft,published',
            'featured' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',
            'technologies' => 'nullable|array',
            'technologies.*' => 'exists:technologies,id',
        ]);

        if (isset($validated['title'])) {
            $validated['slug'] = Str::slug($validated['title']) . '-' . Str::random(5);
        }

        if ($request->hasFile('cover_image')) {
            if ($project->cover_image) {
                Storage::disk('public')->delete($project->cover_image);
            }
            $validated['cover_image'] = $request->file('cover_image')->store('projects', 'public');
        }

        $project->update(\Illuminate\Support\Arr::except($validated, ['categories', 'technologies']));

        if (isset($validated['categories'])) {
            $project->categories()->sync($validated['categories']);
        }

        if (isset($validated['technologies'])) {
            $project->technologies()->sync($validated['technologies']);
        }

        return new ProjectResource($project->load(['categories', 'technologies']));
    }

    public function destroy(Project $project)
    {
        $project->delete();
        return response()->json(['message' => 'Project deleted successfully']);
    }

    public function publish(Project $project)
    {
        $project->update([
            'status' => 'published',
            'published_at' => now(),
        ]);
        return new ProjectResource($project);
    }
}
