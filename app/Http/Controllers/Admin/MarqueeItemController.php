<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaveMarqueeItemRequest;
use App\Models\MarqueeItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MarqueeItemController extends Controller
{
    public function index(Request $request): View
    {
        $filters = $request->validate([
            'q' => ['nullable', 'string', 'max:100'],
            'status' => ['nullable', 'in:visible,hidden,trash'],
            'page' => ['nullable', 'integer', 'min:1'],
        ]);
        $query = MarqueeItem::query();
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
            'resource' => 'marquee', 'heading' => 'Teks berjalan',
        ]);
    }

    public function show(MarqueeItem $item): View
    {
        return view('admin.content.show', [
            'item' => $item, 'resource' => 'marquee', 'heading' => 'Teks berjalan',
        ]);
    }

    public function create(): View
    {
        return $this->form(new MarqueeItem);
    }

    public function edit(MarqueeItem $item): View
    {
        return $this->form($item);
    }

    private function form(MarqueeItem $item): View
    {
        return view('admin.content.form', [
            'item' => $item, 'resource' => 'marquee', 'heading' => 'Teks berjalan',
            'groups' => collect(),
        ]);
    }

    public function store(SaveMarqueeItemRequest $request): RedirectResponse
    {
        MarqueeItem::create($request->validated());

        return to_route('admin.marquee.index')->with('success', 'Teks berjalan berhasil ditambahkan.');
    }

    public function update(SaveMarqueeItemRequest $request, MarqueeItem $item): RedirectResponse
    {
        $item->update($request->validated());

        return to_route('admin.marquee.index')->with('success', 'Teks berjalan berhasil diperbarui.');
    }

    public function destroy(MarqueeItem $item): RedirectResponse
    {
        $item->delete();

        return to_route('admin.marquee.index')->with('success', 'Teks berjalan dipindahkan ke sampah.');
    }

    public function restore(MarqueeItem $item): RedirectResponse
    {
        $item->restore();

        return to_route('admin.marquee.index')->with('success', 'Teks berjalan berhasil dipulihkan.');
    }
}
