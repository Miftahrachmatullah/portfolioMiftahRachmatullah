<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_list_published_projects()
    {
        $published = Project::factory()->create(['status' => 'published', 'published_at' => now()]);
        $draft = Project::factory()->create(['status' => 'draft', 'published_at' => null]);

        $response = $this->getJson('/api/projects?status=published');

        $response->assertStatus(200)
            ->assertJsonStructure(['data', 'meta', 'links'])
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.id', $published->id);
    }

    public function test_guest_can_filter_projects_by_category()
    {
        $category = Category::create(['name' => 'Frontend', 'slug' => 'frontend']);
        $project1 = Project::factory()->create(['status' => 'published']);
        $project1->categories()->attach($category->id, [], 'project_category');

        $project2 = Project::factory()->create(['status' => 'published']);

        $response = $this->getJson('/api/projects?category=frontend');

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.id', $project1->id);
    }

    public function test_guest_can_view_single_project_detail()
    {
        $project = Project::factory()->create(['status' => 'published', 'slug' => 'sample-project']);

        $response = $this->getJson('/api/projects/sample-project');

        $response->assertStatus(200)
            ->assertJsonPath('data.title', $project->title);
    }

    public function test_guest_cannot_create_project()
    {
        $response = $this->postJson('/api/admin/projects', [
            'title' => 'Unauthorized Project',
        ]);

        $response->assertStatus(401);
    }

    public function test_admin_can_create_project()
    {
        $user = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($user, 'sanctum')->postJson('/api/admin/projects', [
            'title' => 'New Admin Project',
            'summary' => 'Project summary text',
            'status' => 'draft',
        ]);

        $response->assertStatus(201)
            ->assertJsonPath('data.title', 'New Admin Project');

        $this->assertDatabaseHas('projects', ['title' => 'New Admin Project']);
    }

    public function test_admin_can_publish_project()
    {
        $user = User::factory()->create(['is_admin' => true]);
        $project = Project::factory()->create(['status' => 'draft', 'published_at' => null]);

        $response = $this->actingAs($user, 'sanctum')->postJson("/api/admin/projects/{$project->id}/publish");

        $response->assertStatus(200)
            ->assertJsonPath('data.status', 'published');

        $this->assertDatabaseHas('projects', [
            'id' => $project->id,
            'status' => 'published',
        ]);
    }

    public function test_admin_can_delete_project()
    {
        $user = User::factory()->create(['is_admin' => true]);
        $project = Project::factory()->create();

        $response = $this->actingAs($user, 'sanctum')->deleteJson("/api/admin/projects/{$project->id}");

        $response->assertStatus(200);
        $this->assertSoftDeleted('projects', ['id' => $project->id]);
    }
}
