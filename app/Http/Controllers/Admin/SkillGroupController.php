<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaveSkillGroupRequest;
use App\Models\SkillGroup;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SkillGroupController extends Controller
{
    public function index(Request $request): View
    {
        $filters = $request->validate([
            'q' => ['nullable', 'string', 'max:100'],
            'status' => ['nullable', 'in:visible,hidden,trash'],
            'page' => ['nullable', 'integer', 'min:1'],
        ]);
        $query = SkillGroup::query();
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
            'resource' => 'skill-groups', 'heading' => 'Kategori skill',
        ]);
    }

    public function show(SkillGroup $item): View
    {
        return view('admin.content.show', [
            'item' => $item, 'resource' => 'skill-groups', 'heading' => 'Kategori skill',
        ]);
    }

    public function create(): View
    {
        return $this->form(new SkillGroup);
    }

    public function edit(SkillGroup $item): View
    {
        return $this->form($item);
    }

    private function form(SkillGroup $item): View
    {
        return view('admin.content.form', [
            'item' => $item, 'resource' => 'skill-groups', 'heading' => 'Kategori skill',
            'groups' => collect(),
        ]);
    }

    public function store(SaveSkillGroupRequest $request): RedirectResponse
    {
        SkillGroup::create($request->validated());

        return to_route('admin.skill-groups.index')->with('success', 'Kategori skill berhasil ditambahkan.');
    }

    public function update(SaveSkillGroupRequest $request, SkillGroup $item): RedirectResponse
    {
        $item->update($request->validated());

        return to_route('admin.skill-groups.index')->with('success', 'Kategori skill berhasil diperbarui.');
    }

    public function destroy(SkillGroup $item): RedirectResponse
    {
        $item->delete();

        return to_route('admin.skill-groups.index')->with('success', 'Kategori skill dipindahkan ke sampah. Skill di dalamnya ikut disembunyikan sampai kategori dipulihkan.');
    }

    public function restore(SkillGroup $item): RedirectResponse
    {
        $item->restore();

        return to_route('admin.skill-groups.index')->with('success', 'Kategori skill berhasil dipulihkan.');
    }
}
