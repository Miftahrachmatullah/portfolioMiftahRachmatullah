<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use App\Services\ProjectWriter;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Gate;

class ProjectController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $filters = $request->validate([
            'category' => ['nullable', 'string', 'max:100'],
            'technology' => ['nullable', 'string', 'max:100'],
            'q' => ['nullable', 'string', 'max:100'],
            'page' => ['nullable', 'integer', 'min:1'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:50'],
        ]);

        return ProjectResource::collection(
            Project::published()->with(['categories', 'technologies'])->filter($filters)
                ->orderBy('sort_order')->orderByDesc('id')->paginate($filters['per_page'] ?? 9)->withQueryString()
        );
    }

    public function show(string $slug): ProjectResource
    {
        return new ProjectResource(Project::published()->with(['categories', 'technologies'])->where('slug', $slug)->firstOrFail());
    }

    public function store(SaveProjectRequest $request, ProjectWriter $writer): ProjectResource
    {
        Gate::authorize('create', Project::class);

        return new ProjectResource($writer->save(new Project, $request->validated()));
    }

    public function update(SaveProjectRequest $request, Project $project, ProjectWriter $writer): ProjectResource
    {
        Gate::authorize('update', $project);

        return new ProjectResource($writer->save($project, $request->validated()));
    }

    public function destroy(Project $project): JsonResponse
    {
        Gate::authorize('delete', $project);
        $project->delete();

        return response()->json(['message' => 'Project dipindahkan ke sampah.']);
    }

    public function publish(Project $project): ProjectResource
    {
        Gate::authorize('update', $project);
        $project->update(['status' => 'published', 'published_at' => now()]);

        return new ProjectResource($project->load(['categories', 'technologies']));
    }
}
