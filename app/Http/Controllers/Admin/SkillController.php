<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaveSkillRequest;
use App\Models\Skill;
use App\Models\SkillGroup;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SkillController extends Controller
{
    public function index(Request $request): View
    {
        $filters = $request->validate([
            'q' => ['nullable', 'string', 'max:100'],
            'status' => ['nullable', 'in:visible,hidden,trash'],
            'page' => ['nullable', 'integer', 'min:1'],
        ]);
        $query = Skill::query()->with('group');
        if (($filters['status'] ?? '') === 'trash') {
            $query->onlyTrashed();
        } elseif (in_array($filters['status'] ?? '', ['visible', 'hidden'], true)) {
            $query->where('is_visible', $filters['status'] === 'visible');
        }
        if (! empty($filters['q'])) {
            $query->where('name', 'like', '%'.$filters['q'].'%');
        }

        return view('admin.content.index', [
            'items' => $query->orderBy('sort_order')->orderBy('id')->paginate(10)->withQueryString(),
            'resource' => 'skills', 'heading' => 'Skills & Tools',
        ]);
    }

    public function show(Skill $item): View
    {
        return view('admin.content.show', [
            'item' => $item, 'resource' => 'skills', 'heading' => 'Skills & Tools',
        ]);
    }

    public function create(): View
    {
        return $this->form(new Skill);
    }

    public function edit(Skill $item): View
    {
        return $this->form($item);
    }

    private function form(Skill $item): View
    {
        return view('admin.content.form', [
            'item' => $item, 'resource' => 'skills', 'heading' => 'Skills & Tools',
            'groups' => SkillGroup::orderBy('sort_order')->get(),
        ]);
    }

    public function store(SaveSkillRequest $request): RedirectResponse
    {
        Skill::create($request->validated());

        return to_route('admin.skills.index')->with('success', 'Skills & Tools berhasil ditambahkan.');
    }

    public function update(SaveSkillRequest $request, Skill $item): RedirectResponse
    {
        $item->update($request->validated());

        return to_route('admin.skills.index')->with('success', 'Skills & Tools berhasil diperbarui.');
    }

    public function destroy(Skill $item): RedirectResponse
    {
        $item->delete();

        return to_route('admin.skills.index')->with('success', 'Skills & Tools dipindahkan ke sampah.');
    }

    public function restore(Skill $item): RedirectResponse
    {
        $item->restore();

        return to_route('admin.skills.index')->with('success', 'Skills & Tools berhasil dipulihkan.');
    }
}
