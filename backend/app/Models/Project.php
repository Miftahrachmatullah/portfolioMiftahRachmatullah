<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use \Illuminate\Database\Eloquent\SoftDeletes;

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
        return $this->belongsToMany(Category::class);
    }

    public function technologies()
    {
        return $this->belongsToMany(Technology::class);
    }
}
