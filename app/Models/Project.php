<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Project extends Model
{
    use HasFactory, \Illuminate\Database\Eloquent\SoftDeletes;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'flow_steps' => 'array',
            'published_at' => 'datetime',
            'featured' => 'boolean',
        ];
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'project_category');
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published')->whereNotNull('published_at')->where('published_at', '<=', now());
    }

    public function scopeFilter(Builder $query, array $filters): Builder
    {
        foreach (['category' => 'categories', 'technology' => 'technologies'] as $key => $relation) {
            if (! empty($filters[$key])) {
                $query->whereHas($relation, fn (Builder $related) => $related->where('slug', $filters[$key]));
            }
        }
        if (! empty($filters['q'])) {
            $query->where(function (Builder $search) use ($filters): void {
                $search->where('title', 'like', '%'.$filters['q'].'%')->orWhere('summary', 'like', '%'.$filters['q'].'%');
            });
        }

        return $query;
    }

    public function getCoverUrlAttribute(): ?string
    {
        if (! $this->cover_image) {
            return null;
        }

        return str_starts_with($this->cover_image, 'img/') ? asset($this->cover_image) : Storage::disk('public')->url($this->cover_image);
    }

    public function technologies()
    {
        return $this->belongsToMany(Technology::class, 'project_technology');
    }
}
