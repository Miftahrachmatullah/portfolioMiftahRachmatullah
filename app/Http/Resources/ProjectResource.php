<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'summary' => $this->summary,
            'description' => $this->description,
            'problem' => $this->problem,
            'goal' => $this->goal,
            'role' => $this->role,
            'flow_steps' => $this->flow_steps,
            'result' => $this->result,
            'cover_image' => $this->cover_url,
            'cover_alt' => $this->cover_alt ?: $this->title,
            'demo_url' => $this->demo_url,
            'repository_url' => $this->repository_url,
            'published_at' => $this->published_at,
            'status' => $this->status,
            'featured' => $this->featured,
            'sort_order' => $this->sort_order,
            'categories' => $this->whenLoaded('categories'),
            'technologies' => $this->whenLoaded('technologies'),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
