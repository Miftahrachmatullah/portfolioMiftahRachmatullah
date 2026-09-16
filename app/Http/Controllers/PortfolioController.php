<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Project;
use App\Models\Technology;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PortfolioController extends Controller
{
    public function index(Request $request): View
    {
        return view('pages.home', $this->data($request));
    }

    public function fragment(Request $request): View
    {
        return view('components.project-results', $this->data($request));
    }

    public function show(string $slug): View
    {
        $project = Project::published()->where('slug', $slug)->with(['categories', 'technologies'])->firstOrFail();

        return view('pages.project', compact('project'));
    }

    private function data(Request $request): array
    {
        $filters = $request->validate([
            'category' => ['nullable', 'string', 'max:100'],
            'technology' => ['nullable', 'string', 'max:100'],
            'q' => ['nullable', 'string', 'max:100'],
            'page' => ['nullable', 'integer', 'min:1'],
        ]);
        $projects = Project::published()->with(['categories', 'technologies'])->filter($filters)
            ->orderBy('sort_order')->orderByDesc('id')->paginate(9)->withQueryString();
        $projects->withPath(route('home'))->fragment('projects');

        return [
            'projects' => $projects,
            'categories' => Category::orderBy('name')->get(),
            'technologies' => Technology::orderBy('name')->get(),
        ];
    }
}
