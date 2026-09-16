<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaveProjectRequest;
use App\Models\Category;
use App\Models\Project;
use App\Models\Technology;
use App\Services\ProjectWriter;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class ProjectAdminController extends Controller
{
    public function index(Request $request): View
    {
        Gate::authorize('viewAny', Project::class);
        $filters = $request->validate([
            'q' => ['nullable', 'string', 'max:100'],
            'status' => ['nullable', 'in:draft,published,trash'],
            'category' => ['nullable', 'string', 'max:100'],
            'sort' => ['nullable', 'in:order,newest,title'],
            'page' => ['nullable', 'integer', 'min:1'],
        ]);
        $query = Project::with(['categories', 'technologies']);
        if (($filters['status'] ?? '') === 'trash') {
            $query->onlyTrashed();
        } elseif (! empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }
        $query->filter($filters);
        match ($filters['sort'] ?? 'order') {
            'newest' => $query->orderByDesc('created_at'),
            'title' => $query->orderBy('title'),
            default => $query->orderBy('sort_order'),
        };
        $projects = $query->orderByDesc('id')->paginate(10)->withQueryString();
        $categories = Category::orderBy('name')->get();
        $counts = ['all' => Project::count(), 'published' => Project::published()->count(), 'draft' => Project::where('status', 'draft')->count()];

        return view('admin.dashboard', compact('projects', 'categories', 'counts'));
    }

    public function create(): View
    {
        Gate::authorize('create', Project::class);

        return $this->form(new Project(['status' => 'draft', 'sort_order' => 0]));
    }

    public function show(Project $project): View
    {
        Gate::authorize('view', $project);

        return view('admin.show', ['project' => $project->load(['categories', 'technologies'])]);
    }

    public function edit(Project $project): View
    {
        Gate::authorize('update', $project);

        return $this->form($project->load(['categories', 'technologies']));
    }

    private function form(Project $project): View
    {
        return view('admin.form', [
            'project' => $project,
            'categories' => Category::orderBy('name')->get(),
            'technologies' => Technology::orderBy('name')->get(),
        ]);
    }

    public function store(SaveProjectRequest $request, ProjectWriter $writer): RedirectResponse
    {
        Gate::authorize('create', Project::class);
        $project = $writer->save(new Project, $request->validated());

        return to_route('admin.projects.show', $project)->with('success', 'Project berhasil dibuat.');
    }

    public function update(SaveProjectRequest $request, Project $project, ProjectWriter $writer): RedirectResponse
    {
        Gate::authorize('update', $project);
        $writer->save($project, $request->validated());

        return to_route('admin.projects.show', $project)->with('success', 'Project diperbarui. Perubahan published langsung tersedia di landing page.');
    }

    public function destroy(Project $project): RedirectResponse
    {
        Gate::authorize('delete', $project);
        $project->delete();

        return to_route('admin.dashboard')->with('success', 'Project dipindahkan ke sampah dan dapat dipulihkan.');
    }

    public function restore(Project $project): RedirectResponse
    {
        Gate::authorize('restore', $project);
        $project->restore();

        return to_route('admin.projects.show', $project)->with('success', 'Project berhasil dipulihkan.');
    }
}
