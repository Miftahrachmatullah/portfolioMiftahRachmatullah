<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Project;
use App\Models\Technology;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Vite;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class AdminPortfolioTest extends TestCase
{
    use RefreshDatabase;

    public function test_owner_can_login_and_logout(): void
    {
        $admin = User::factory()->create(['is_admin' => true, 'password' => 'Test-owner-password!']);
        $this->post('/login', ['email' => $admin->email, 'password' => 'Test-owner-password!'])->assertRedirect('/admin/dashboard');
        $this->assertAuthenticatedAs($admin);
        $this->post('/logout')->assertRedirect('/');
        $this->assertGuest();
    }

    public function test_non_admin_cannot_login_to_admin_portal(): void
    {
        $user = User::factory()->create(['password' => 'Test-owner-password!']);
        $this->from('/login')->post('/login', ['email' => $user->email, 'password' => 'Test-owner-password!'])
            ->assertSessionHasErrors(['email' => 'Email atau password salah.']);
        $this->assertGuest();
    }

    public function test_malformed_login_returns_422_instead_of_server_error(): void
    {
        $this->postJson('/login', ['email' => ['unexpected'], 'password' => 'invalid'])
            ->assertUnprocessable()->assertJsonValidationErrors('email');
        $this->assertGuest();
    }

    public function test_maximum_length_title_keeps_slug_within_database_limit(): void
    {
        $this->actingAs(User::factory()->create(['is_admin' => true]), 'sanctum')
            ->postJson('/api/admin/projects', ['title' => str_repeat('a', 255), 'status' => 'draft'])
            ->assertCreated();
        $this->assertLessThanOrEqual(255, strlen(Project::firstOrFail()->slug));
    }

    public function test_login_is_rate_limited_after_five_attempts(): void
    {
        for ($attempt = 0; $attempt < 5; $attempt++) {
            $this->post('/login', ['email' => 'rate-limit@example.test', 'password' => 'wrong'])->assertSessionHasErrors('email');
        }
        $this->post('/login', ['email' => 'rate-limit@example.test', 'password' => 'wrong'])->assertStatus(429);
    }

    public function test_guests_are_redirected_and_non_admins_get_403(): void
    {
        $project = Project::factory()->create();
        $this->get('/admin/dashboard')->assertRedirect('/login');
        $this->post('/admin/projects', ['title' => 'Forbidden'])->assertRedirect('/login');
        $this->actingAs(User::factory()->create());
        $this->get('/admin/dashboard')->assertForbidden();
        $this->get("/admin/projects/{$project->id}")->assertForbidden();
        $this->put("/admin/projects/{$project->id}", ['title' => 'Forbidden'])->assertForbidden();
        $this->delete("/admin/projects/{$project->id}")->assertForbidden();
        $this->post("/admin/projects/{$project->id}/restore")->assertForbidden();
        $this->postJson('/api/admin/projects', ['title' => 'Forbidden'])->assertForbidden();
        $this->patchJson("/api/admin/projects/{$project->id}", ['title' => 'Forbidden'])->assertForbidden();
        $this->deleteJson("/api/admin/projects/{$project->id}")->assertForbidden();
        $this->postJson("/api/admin/projects/{$project->id}/publish")->assertForbidden();
        $this->assertDatabaseMissing('projects', ['title' => 'Forbidden']);
        $this->assertNotSoftDeleted($project);
    }

    public function test_policy_allows_only_admin_and_disallows_permanent_delete(): void
    {
        $project = Project::factory()->make();
        foreach ([false, true] as $admin) {
            $user = User::factory()->make(['is_admin' => $admin]);
            foreach (['view', 'update', 'delete', 'restore'] as $ability) {
                $this->assertSame($admin, Gate::forUser($user)->allows($ability, $project));
            }
            foreach (['viewAny', 'create'] as $ability) {
                $this->assertSame($admin, Gate::forUser($user)->allows($ability, Project::class));
            }
            $this->assertFalse(Gate::forUser($user)->allows('forceDelete', $project));
        }
    }

    public function test_admin_list_is_paginated_and_preserves_filters(): void
    {
        Project::factory()->count(12)->create(['status' => 'draft', 'published_at' => null]);
        $this->actingAs(User::factory()->create(['is_admin' => true]))
            ->get('/admin/dashboard?status=draft&page=2')->assertOk()
            ->assertViewHas('projects', fn ($projects) => $projects->count() === 2 && $projects->total() === 12)
            ->assertSee('status=draft', false)->assertSee('Detail');
    }

    public function test_admin_can_create_edit_publish_and_unpublish_with_cover(): void
    {
        Storage::fake('public');
        $this->actingAs(User::factory()->create(['is_admin' => true]));
        $this->post('/admin/projects', [
            'title' => 'New portfolio work', 'status' => 'draft', 'summary' => 'My work',
            'cover_image' => UploadedFile::fake()->image('cover.jpg'),
            'cover_alt' => 'Preview dashboard', 'categories' => 'Frontend, UI/UX',
            'technologies' => 'Laravel, PostgreSQL', 'flow_text' => "Research\nBuild",
            'featured' => '1', 'sort_order' => 4, 'is_admin' => true,
        ])->assertSessionHasNoErrors()->assertRedirect();
        $project = Project::where('title', 'New portfolio work')->firstOrFail();
        $slug = $project->slug;
        Storage::disk('public')->assertExists($project->cover_image);
        $this->assertSame(['Research', 'Build'], $project->flow_steps);
        $this->assertCount(2, $project->categories);
        $this->assertNull($project->published_at);
        $this->get('/')->assertDontSee('New portfolio work');
        $this->get("/admin/projects/{$project->id}")->assertSee('Preview dashboard')->assertSee('Research');
        $this->get("/admin/projects/{$project->id}/edit")->assertSee('New portfolio work');
        $this->put("/admin/projects/{$project->id}", [
            'title' => 'Updated portfolio work', 'status' => 'published',
            'categories' => '', 'technologies' => '', 'sort_order' => 2,
        ])->assertSessionHasNoErrors()->assertRedirect();
        $project->refresh();
        $this->assertSame($slug, $project->slug);
        $this->assertFalse($project->featured);
        $this->assertCount(0, $project->categories);
        $this->assertNotNull($project->published_at);
        $this->get('/')->assertSee('Updated portfolio work');
        $this->get('/projects/fragment')->assertSee('Updated portfolio work');
        $this->put("/admin/projects/{$project->id}", ['title' => $project->title, 'status' => 'draft'])->assertRedirect();
        $this->get('/')->assertDontSee('Updated portfolio work');
        $this->assertNull($project->fresh()->published_at);
    }

    public function test_delete_retains_cover_and_restore_recovers_project(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('projects/keep.jpg', 'image contents');
        $project = Project::factory()->create(['cover_image' => 'projects/keep.jpg']);
        $this->actingAs(User::factory()->create(['is_admin' => true]));
        $this->delete("/admin/projects/{$project->id}")->assertRedirect('/admin/dashboard');
        $this->assertSoftDeleted($project);
        Storage::disk('public')->assertExists('projects/keep.jpg');
        $this->get('/admin/dashboard?status=trash')->assertSee($project->title)->assertSee('Pulihkan');
        $this->getJson("/api/projects/{$project->slug}")->assertNotFound();
        $this->post("/admin/projects/{$project->id}/restore")->assertRedirect();
        $this->assertNotSoftDeleted($project);
        $this->getJson("/api/projects/{$project->slug}")->assertOk();
    }

    public function test_replacing_cover_removes_only_old_uploaded_file(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('projects/old.jpg', 'old image');
        $project = Project::factory()->create(['cover_image' => 'projects/old.jpg']);
        $this->actingAs(User::factory()->create(['is_admin' => true]))
            ->put("/admin/projects/{$project->id}", [
                'title' => 'Updated cover', 'status' => 'published',
                'cover_image' => UploadedFile::fake()->image('new.jpg'), 'cover_alt' => 'New cover',
            ])->assertSessionHasNoErrors();
        Storage::disk('public')->assertMissing('projects/old.jpg');
        Storage::disk('public')->assertExists($project->fresh()->cover_image);
    }

    public function test_public_list_and_detail_hide_drafts_future_and_deleted_projects(): void
    {
        $this->freezeTime();
        $draft = Project::factory()->create(['title' => 'Secret draft', 'status' => 'draft']);
        $future = Project::factory()->create(['title' => 'Future work', 'published_at' => now()->addDay()]);
        $deleted = Project::factory()->create();
        $deleted->delete();
        Project::factory()->count(10)->create();
        $this->getJson('/api/projects?status=draft')->assertJsonCount(9, 'data')->assertJsonPath('meta.total', 10)->assertDontSee('Secret draft');
        $this->getJson('/api/projects?page=2')->assertJsonCount(1, 'data');
        foreach ([$draft, $future, $deleted] as $hidden) {
            $this->getJson("/api/projects/{$hidden->slug}")->assertNotFound();
            $this->get("/projects/{$hidden->slug}")->assertNotFound();
        }
        $this->get('/')->assertViewHas('projects', fn ($projects) => $projects->count() === 9);
    }

    public function test_category_and_technology_filters_use_same_source_on_home_and_api(): void
    {
        $category = Category::create(['name' => 'Backend', 'slug' => 'backend']);
        $technology = Technology::create(['name' => 'Laravel', 'slug' => 'laravel']);
        $project = Project::factory()->create(['title' => 'Filtered work']);
        $project->categories()->attach($category);
        $project->technologies()->attach($technology);
        Project::factory()->create(['title' => 'Other work']);
        $this->get('/?category=backend&technology=laravel')->assertSee('Filtered work')->assertDontSee('Other work');
        $this->getJson('/api/projects?category=backend&technology=laravel')->assertJsonCount(1, 'data')->assertJsonPath('data.0.title', 'Filtered work');
    }

    public function test_free_text_is_escaped_in_public_and_admin_views(): void
    {
        $payload = '<script>alert("xss")</script>';
        $project = Project::factory()->create(array_fill_keys(['title', 'summary', 'description', 'problem', 'goal', 'role', 'result', 'cover_alt'], $payload) + ['flow_steps' => [$payload], 'demo_url' => 'javascript:alert(1)']);
        $category = Category::create(['name' => $payload, 'slug' => 'xss']);
        $project->categories()->attach($category);
        $this->get('/')->assertSee($payload)->assertDontSee($payload, false);
        $this->get("/projects/{$project->slug}")->assertSee($payload)->assertDontSee($payload, false)->assertDontSee('href="javascript:', false);
        $this->actingAs(User::factory()->create(['is_admin' => true]));
        $this->get("/admin/projects/{$project->id}")->assertSee($payload)->assertDontSee($payload, false);
        $this->get("/admin/projects/{$project->id}/edit")->assertSee($payload)->assertDontSee($payload, false);
    }

    public static function invalidFields(): array
    {
        return [
            'missing title' => ['title', ''],
            'oversized title' => ['title', str_repeat('a', 256)],
            'invalid status' => ['status', 'public'],
            'negative order' => ['sort_order', -1],
            'script demo' => ['demo_url', 'javascript:alert(1)'],
            'data repository' => ['repository_url', 'data:text/html,test'],
            'invalid category' => ['categories', [['name' => 'invalid']]],
            'oversized summary' => ['summary', str_repeat('a', 501)],
            'object flow' => ['flow_steps', [['html' => 'not a string']]],
        ];
    }

    #[DataProvider('invalidFields')]
    public function test_invalid_project_input_returns_422_and_writes_nothing(string $field, mixed $value): void
    {
        $this->actingAs(User::factory()->create(['is_admin' => true]), 'sanctum');
        $this->postJson('/api/admin/projects', array_replace(['title' => 'Valid title', 'status' => 'draft'], [$field => $value]))
            ->assertUnprocessable()->assertJsonValidationErrors(str_contains($field, 'categories') ? 'categories.0' : ($field === 'flow_steps' ? 'flow_steps.0' : $field));
        $this->assertDatabaseCount('projects', 0);
    }

    public function test_upload_rejects_svg_oversized_files_and_missing_alt(): void
    {
        Storage::fake('public');
        $this->actingAs(User::factory()->create(['is_admin' => true]));
        foreach ([
            UploadedFile::fake()->createWithContent('evil.svg', '<svg xmlns="http://www.w3.org/2000/svg"><script>alert(1)</script></svg>'),
            UploadedFile::fake()->image('large.jpg')->size(3073),
            UploadedFile::fake()->create('evil.php', 1, 'application/x-php'),
        ] as $file) {
            $this->post('/admin/projects', ['title' => 'Unsafe upload', 'status' => 'draft', 'cover_image' => $file, 'cover_alt' => 'test'])->assertSessionHasErrors('cover_image');
        }
        $this->post('/admin/projects', ['title' => 'No alt', 'status' => 'draft', 'cover_image' => UploadedFile::fake()->image('safe.jpg')])
            ->assertSessionHasErrors(['cover_alt' => 'Deskripsi gambar wajib diisi saat mengunggah cover.']);
        $this->assertDatabaseCount('projects', 0);
        $this->assertSame([], Storage::disk('public')->allFiles());
    }

    public function test_invalid_sort_and_pagination_cannot_change_query_structure(): void
    {
        $this->getJson('/api/projects?per_page=100000')->assertUnprocessable();
        $this->getJson('/api/projects?page=-1')->assertUnprocessable();
        $this->actingAs(User::factory()->create(['is_admin' => true]))->get('/admin/dashboard?sort=title;DROP%20TABLE%20projects')->assertSessionHasErrors('sort');
        $this->assertDatabaseCount('projects', 0);
    }

    public function test_missing_csrf_token_is_rejected_on_login_and_admin_mutation(): void
    {
        $this->app->instance('env', 'local');
        $this->post('/login', ['email' => 'test@example.test', 'password' => 'test'])->assertStatus(419);
        $this->actingAs(User::factory()->create(['is_admin' => true]))
            ->post('/admin/projects', ['title' => 'No CSRF', 'status' => 'draft'])->assertStatus(419);
        $this->assertDatabaseCount('projects', 0);
    }

    public function test_security_headers_disable_framing_and_admin_caching(): void
    {
        $login = $this->get('/login')->assertHeader('X-Frame-Options', 'DENY')->assertHeader('X-Content-Type-Options', 'nosniff');
        $nonce = Vite::cspNonce();
        $this->assertStringContainsString("'nonce-".$nonce."'", $login->headers->get('Content-Security-Policy'));
        $login->assertSee('nonce="'.$nonce.'"', false)->assertDontSee('onclick=', false);
        $response = $this->actingAs(User::factory()->create(['is_admin' => true]))->get('/admin/dashboard');
        $this->assertStringContainsString('no-store', $response->headers->get('Cache-Control'));
    }

    public function test_admin_provisioning_hashes_password_and_grants_admin_without_source_credentials(): void
    {
        $this->artisan('portfolio:admin', ['email' => 'owner@example.test', '--name' => 'Owner'])
            ->expectsQuestion('Password', 'Test-provision-password!')
            ->expectsOutput('Akun admin siap; password tersimpan sebagai hash dan berhasil diverifikasi.')
            ->assertSuccessful();
        $owner = User::where('email', 'owner@example.test')->firstOrFail();
        $this->assertTrue($owner->is_admin);
        $this->assertTrue(Hash::check('Test-provision-password!', $owner->password));
        $this->assertNotSame('Test-provision-password!', $owner->password);
    }
}
