<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Project;
use App\Models\Technology;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

class ProjectWriter
{
    public function save(Project $project, array $data): Project
    {
        $newCover = null;
        $oldCover = $project->cover_image;
        if (! empty($data['cover_image'])) {
            $newCover = $data['cover_image']->store('projects', 'public');
            throw_if($newCover === false, \RuntimeException::class, 'Gagal menyimpan cover.');
            $data['cover_image'] = $newCover;
        } else {
            unset($data['cover_image']);
        }

        try {
            DB::transaction(function () use ($project, $data): void {
                $attributes = Arr::except($data, ['categories', 'technologies']);
                if (! $project->exists) {
                    $attributes['slug'] = Str::limit(Str::slug($data['title']) ?: 'project', 240, '').'-'.Str::lower(Str::random(10));
                }
                $status = $attributes['status'] ?? $project->status ?? 'draft';
                $attributes['published_at'] = $status === 'published' ? ($project->published_at ?? now()) : null;
                $attributes['sort_order'] = $attributes['sort_order'] ?? $project->sort_order ?? 0;
                $project->fill($attributes)->save();
                foreach (['categories' => Category::class, 'technologies' => Technology::class] as $relation => $model) {
                    if (array_key_exists($relation, $data)) {
                        $ids = [];
                        foreach ($data[$relation] as $name) {
                            $slug = Str::slug($name) ?: 'tag-'.substr(hash('sha256', $name), 0, 12);
                            $ids[] = $model::firstOrCreate(['slug' => $slug], ['name' => $name])->id;
                        }
                        $project->{$relation}()->sync($ids);
                    }
                }
            });
        } catch (Throwable $exception) {
            if ($newCover) {
                Storage::disk('public')->delete($newCover);
            }
            throw $exception;
        }

        if ($newCover && $oldCover && str_starts_with($oldCover, 'projects/')) {
            Storage::disk('public')->delete($oldCover);
        }

        return $project->load(['categories', 'technologies']);
    }
}
