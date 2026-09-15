<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Category;
use App\Models\Technology;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProjectAdminController extends Controller
{
    public function index()
    {
        $projects = Project::with(['categories', 'technologies'])
            ->orderBy('sort_order', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();

        $categories = Category::orderBy('name')->get();
        $technologies = Technology::orderBy('name')->get();

        return view('admin.dashboard', compact('projects', 'categories', 'technologies'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'          => 'required|string|max:255',
            'summary'        => 'nullable|string',
            'description'    => 'nullable|string',
            'demo_url'       => 'nullable|url|max:500',
            'repository_url' => 'nullable|url|max:500',
            'cover_image'    => 'nullable|image|max:3072',
            'status'         => 'nullable|in:draft,published',
            'featured'       => 'nullable|boolean',
            'sort_order'     => 'nullable|integer',
            'categories'     => 'nullable|array',
            'technologies'   => 'nullable|array',
        ]);

        $validated['slug'] = Str::slug($validated['title']) . '-' . Str::random(5);
        $validated['status'] = $validated['status'] ?? 'published';
        $validated['published_at'] = now();

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('projects', 'public');
        }

        $project = Project::create(\Illuminate\Support\Arr::except($validated, ['categories', 'technologies']));

        if (!empty($validated['categories'])) {
            $project->categories()->sync($this->resolveCategoryIds($validated['categories']));
        }

        if (!empty($validated['technologies'])) {
            $project->technologies()->sync($this->resolveTechIds($validated['technologies']));
        }

        return redirect()->route('admin.dashboard')->with('success', "Project \"{$project->title}\" berhasil ditambahkan.");
    }

    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'title'          => 'required|string|max:255',
            'summary'        => 'nullable|string',
            'description'    => 'nullable|string',
            'demo_url'       => 'nullable|url|max:500',
            'repository_url' => 'nullable|url|max:500',
            'cover_image'    => 'nullable|image|max:3072',
            'status'         => 'nullable|in:draft,published',
            'featured'       => 'nullable|boolean',
            'sort_order'     => 'nullable|integer',
            'categories'     => 'nullable|array',
            'technologies'   => 'nullable|array',
        ]);

        if ($request->hasFile('cover_image')) {
            if ($project->cover_image && Storage::disk('public')->exists($project->cover_image)) {
                Storage::disk('public')->delete($project->cover_image);
            }
            $validated['cover_image'] = $request->file('cover_image')->store('projects', 'public');
        }

        $project->update(\Illuminate\Support\Arr::except($validated, ['categories', 'technologies']));

        $project->categories()->sync($this->resolveCategoryIds($validated['categories'] ?? []));
        $project->technologies()->sync($this->resolveTechIds($validated['technologies'] ?? []));

        return redirect()->route('admin.dashboard')->with('success', "Project \"{$project->title}\" berhasil diperbarui.");
    }

    public function destroy(Project $project)
    {
        $title = $project->title;
        if ($project->cover_image && Storage::disk('public')->exists($project->cover_image)) {
            Storage::disk('public')->delete($project->cover_image);
        }
        $project->delete();
        return redirect()->route('admin.dashboard')->with('success', "Project \"{$title}\" berhasil dihapus.");
    }

    // ── Helpers ──

    private function resolveCategoryIds(array $names): array
    {
        return array_map(function ($name) {
            return Category::firstOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name]
            )->id;
        }, array_filter($names));
    }

    private function resolveTechIds(array $names): array
    {
        return array_map(function ($name) {
            return Technology::firstOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name]
            )->id;
        }, array_filter($names));
    }
}
