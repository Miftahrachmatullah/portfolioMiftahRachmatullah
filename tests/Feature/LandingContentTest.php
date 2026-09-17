<?php

namespace Tests\Feature;

use App\Models\MarqueeItem;
use App\Models\SiteProfile;
use App\Models\Skill;
use App\Models\SkillGroup;
use App\Models\User;
use Database\Seeders\LandingContentSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class LandingContentTest extends TestCase
{
    use RefreshDatabase;

    private function profilePayload(array $changes = []): array
    {
        return array_replace(Arr::except(SiteProfile::defaults(), ['hero_photo', 'about_photo']), $changes);
    }

    public function test_default_content_is_seeded_once_without_resetting_admin_edits(): void
    {
        $this->seed(LandingContentSeeder::class);
        $this->assertDatabaseCount('site_profiles', 1);
        $this->assertDatabaseCount('marquee_items', 8);
        $this->assertDatabaseCount('skill_groups', 4);
        $this->assertDatabaseCount('skills', 16);
        $this->get('/')->assertOk()->assertSee('PORTFOLIO FILE')
            ->assertSee(SiteProfile::defaults()['portfolio_url'], false)
            ->assertSee('portrait-rounded', false)->assertDontSee('hero-tag', false);
        SiteProfile::current()->update(['hero_name' => 'Edited owner']);
        $marquee = MarqueeItem::firstOrFail();
        $marquee->delete();
        $skill = Skill::firstOrFail();
        $skill->update(['name' => 'Edited skill']);
        $this->seed(LandingContentSeeder::class);
        $this->assertSame('Edited owner', SiteProfile::current()->hero_name);
        $this->assertSame('Edited skill', $skill->fresh()->name);
        $this->assertSoftDeleted($marquee);
        $this->assertDatabaseCount('skills', 16);
    }

    public function test_profile_updates_all_public_fields_and_allows_hiding_sections_and_buttons(): void
    {
        $this->actingAs(User::factory()->create(['is_admin' => true]));
        $this->get('/admin/profile')->assertOk()->assertSee('Hero & About');
        $this->put('/admin/profile', $this->profilePayload([
            'hero_name' => 'New Owner', 'hero_roles_text' => "Developer\n\n  Researcher  ",
            'hero_description' => 'New hero story', 'portfolio_label' => 'My portfolio',
            'portfolio_url' => 'https://example.test/files', 'hero_photo_style' => 'cutout',
            'about_name' => 'About Owner', 'about_role' => 'New role', 'about_description' => 'New about story',
            'quote' => 'New quote', 'years_experience' => 7, 'projects_completed' => 42, 'happy_clients' => 31,
            'is_admin' => false, 'id' => 88,
        ]))->assertSessionHasNoErrors()->assertRedirect('/admin/profile');
        $profile = SiteProfile::current();
        $this->assertSame(['Developer', 'Researcher'], $profile->hero_roles);
        $this->assertSame(1, $profile->id);
        $this->assertDatabaseCount('site_profiles', 1);
        $this->get('/landing-content')->assertOk()->assertSeeInOrder(['New Owner', 'New hero story', 'My portfolio', 'About Owner', 'New role', 'New about story', 'New quote'])
            ->assertSee('portrait-cutout', false)->assertSee('42')->assertSee('31')->assertDontSee('is_admin');
        $this->put('/admin/profile', $this->profilePayload([
            'hero_roles_text' => '', 'cv_url' => '', 'portfolio_url' => '', 'quote' => '',
        ]))->assertSessionHasNoErrors();
        $this->get('/landing-content')->assertDontSee('hero-typewriter', false)->assertDontSee('DOWNLOAD CV')->assertDontSee('PORTFOLIO FILE')->assertDontSee('about-quote', false);
        $this->put('/admin/profile', $this->profilePayload(['hero_visible' => false, 'about_visible' => false]))->assertSessionHasNoErrors();
        $this->get('/landing-content')->assertDontSee('id="hero"', false)->assertDontSee('id="about"', false)->assertSee('SKILLS & TOOLS.');
    }

    public function test_profile_photos_upload_replace_and_remove_without_deleting_shared_files(): void
    {
        Storage::fake('public');
        $profile = SiteProfile::factory()->create(['id' => 1, 'hero_photo' => 'profiles/shared.png', 'about_photo' => 'profiles/shared.png']);
        Storage::disk('public')->put('profiles/shared.png', 'old shared image');
        $this->actingAs(User::factory()->create(['is_admin' => true]));
        $this->put('/admin/profile', $this->profilePayload(['hero_photo' => UploadedFile::fake()->image('hero.png')]))->assertSessionHasNoErrors();
        $hero = $profile->fresh()->hero_photo;
        $this->assertStringStartsWith('profiles/', $hero);
        Storage::disk('public')->assertExists($hero);
        Storage::disk('public')->assertExists('profiles/shared.png');
        $this->get('/landing-content')->assertSee('/storage/'.$hero, false);
        $this->put('/admin/profile', $this->profilePayload(['about_photo' => UploadedFile::fake()->image('about.jpg')]))->assertSessionHasNoErrors();
        $about = $profile->fresh()->about_photo;
        Storage::disk('public')->assertMissing('profiles/shared.png');
        Storage::disk('public')->assertExists($about);
        $this->put('/admin/profile', $this->profilePayload(['remove_hero_photo' => true, 'remove_about_photo' => true]))->assertSessionHasNoErrors();
        Storage::disk('public')->assertMissing([$hero, $about]);
        $this->assertNull($profile->fresh()->hero_photo);
        $this->assertNull($profile->fresh()->about_photo);
        $this->get('/landing-content')->assertSee('portrait-placeholder', false);
    }

    public function test_invalid_photo_requests_leave_existing_content_and_files_untouched(): void
    {
        Storage::fake('public');
        SiteProfile::factory()->create(['id' => 1, 'hero_photo' => 'profiles/keep.jpg']);
        Storage::disk('public')->put('profiles/keep.jpg', 'original image');
        $this->actingAs(User::factory()->create(['is_admin' => true]));
        foreach ([
            UploadedFile::fake()->createWithContent('evil.svg', '<svg xmlns="http://www.w3.org/2000/svg"><script>alert(1)</script></svg>'),
            UploadedFile::fake()->image('large.jpg')->size(3073),
            UploadedFile::fake()->create('evil.php', 1, 'application/x-php'),
            UploadedFile::fake()->createWithContent('spoof.jpg', '<?php echo "not an image";'),
        ] as $file) {
            $this->put('/admin/profile', $this->profilePayload(['hero_photo' => $file, 'remove_hero_photo' => true]))
                ->assertSessionHasErrors('hero_photo');
        }
        $this->put('/admin/profile', $this->profilePayload(['hero_photo' => UploadedFile::fake()->image('safe.png'), 'hero_photo_alt' => '']))
            ->assertSessionHasErrors('hero_photo_alt');
        $this->assertSame('profiles/keep.jpg', SiteProfile::current()->hero_photo);
        $this->assertSame(['profiles/keep.jpg'], Storage::disk('public')->allFiles());
    }

    public static function invalidProfileFields(): array
    {
        return [
            'missing name' => ['hero_name', '', 'hero_name'],
            'oversized role' => ['hero_roles', [str_repeat('a', 81)], 'hero_roles.0'],
            'nested roles' => ['hero_roles', [['nested']], 'hero_roles.0'],
            'associative roles' => ['hero_roles', ['role' => 'Developer'], 'hero_roles'],
            'malformed textarea' => ['hero_roles_text', ['nested'], 'hero_roles_text'],
            'too many roles' => ['hero_roles', array_fill(0, 11, 'Role'), 'hero_roles'],
            'script URL' => ['portfolio_url', 'javascript:alert(1)', 'portfolio_url'],
            'data URL' => ['cv_url', 'data:text/html,test', 'cv_url'],
            'invalid photo style' => ['hero_photo_style', 'rounded" onclick="alert(1)', 'hero_photo_style'],
            'negative experience' => ['years_experience', -1, 'years_experience'],
            'oversized count' => ['happy_clients', 1000001, 'happy_clients'],
            'photo path injection' => ['about_photo', '../../.env', 'about_photo'],
        ];
    }

    #[DataProvider('invalidProfileFields')]
    public function test_invalid_profile_input_is_rejected_without_writing(string $field, mixed $value, string $error): void
    {
        $this->actingAs(User::factory()->create(['is_admin' => true]))
            ->putJson('/admin/profile', $this->profilePayload([$field => $value]))
            ->assertUnprocessable()->assertJsonValidationErrors($error);
        $this->assertDatabaseCount('site_profiles', 0);
    }

    public static function collections(): array
    {
        return [
            'marquee' => ['marquee', MarqueeItem::class],
            'groups' => ['skill-groups', SkillGroup::class],
            'skills' => ['skills', Skill::class],
        ];
    }

    #[DataProvider('collections')]
    public function test_collections_support_crud_detail_pagination_and_restore(string $resource, string $model): void
    {
        $this->actingAs(User::factory()->create(['is_admin' => true]));
        $group = SkillGroup::factory()->create();
        $payload = ['name' => 'Unique content', 'sort_order' => 5, 'is_visible' => true, 'accent' => 'teal', 'skill_group_id' => $group->id, 'icon_url' => 'https://example.test/icon.png'];
        $this->get("/admin/{$resource}/create")->assertOk();
        $this->post("/admin/{$resource}", $payload)->assertSessionHasNoErrors()->assertRedirect("/admin/{$resource}");
        $item = $model::where('name', 'Unique content')->firstOrFail();
        $this->get("/admin/{$resource}/{$item->id}")->assertOk()->assertSee('Unique content')->assertSee('Edit');
        $this->get("/admin/{$resource}/{$item->id}/edit")->assertOk()->assertSee('Unique content');
        $this->get('/landing-content')->assertSee('Unique content');
        $payload['name'] = 'Updated unique content';
        $this->put("/admin/{$resource}/{$item->id}", $payload)->assertSessionHasNoErrors()->assertRedirect();
        $this->assertSame('Updated unique content', $item->fresh()->name);
        $this->get('/landing-content')->assertSee('Updated unique content');
        $payload['is_visible'] = false;
        $this->put("/admin/{$resource}/{$item->id}", $payload)->assertSessionHasNoErrors();
        $this->get('/landing-content')->assertDontSee('Updated unique content');
        $this->delete("/admin/{$resource}/{$item->id}")->assertRedirect();
        $this->assertSoftDeleted($item);
        $this->get("/admin/{$resource}/{$item->id}/edit")->assertNotFound();
        $this->get("/admin/{$resource}?status=trash")->assertSee('Updated unique content')->assertSee('Pulihkan');
        $this->post("/admin/{$resource}/{$item->id}/restore")->assertRedirect();
        $this->assertNotSoftDeleted($item);
        $model::factory()->count(12)->create(['name' => 'Pagination content', 'is_visible' => true]);
        $this->get("/admin/{$resource}?q=Pagination&status=visible&page=2")->assertOk()
            ->assertViewHas('items', fn ($items) => $items->count() === 2 && $items->total() === 12)
            ->assertSee('q=Pagination', false)->assertSee('status=visible', false)->assertSee('Detail');
        $this->getJson("/admin/{$resource}?status=invalid&page=-1")->assertUnprocessable()->assertJsonValidationErrors(['status', 'page']);
        $this->postJson("/admin/{$resource}", array_replace($payload, ['name' => '', 'sort_order' => -1]))
            ->assertUnprocessable()->assertJsonValidationErrors(['name', 'sort_order']);
    }

    #[DataProvider('collections')]
    public function test_guests_and_non_admins_cannot_read_or_mutate_cms_collections(string $resource, string $model): void
    {
        $item = $model::factory()->create();
        $requests = [
            ['GET', "/admin/{$resource}"], ['GET', "/admin/{$resource}/create"],
            ['GET', "/admin/{$resource}/{$item->id}"], ['GET', "/admin/{$resource}/{$item->id}/edit"],
            ['POST', "/admin/{$resource}"], ['PUT', "/admin/{$resource}/{$item->id}"],
            ['DELETE', "/admin/{$resource}/{$item->id}"], ['POST', "/admin/{$resource}/{$item->id}/restore"],
        ];
        foreach ($requests as [$method, $url]) {
            $this->call($method, $url)->assertRedirect('/login');
        }
        $this->actingAs(User::factory()->create());
        foreach ($requests as [$method, $url]) {
            $this->call($method, $url)->assertForbidden();
        }
        $this->assertNotSoftDeleted($item);
    }

    public function test_profile_requires_admin_and_csrf_is_enforced_for_cms_writes(): void
    {
        $this->get('/admin/profile')->assertRedirect('/login');
        $this->put('/admin/profile', $this->profilePayload())->assertRedirect('/login');
        $this->actingAs(User::factory()->create());
        $this->get('/admin/profile')->assertForbidden();
        $this->put('/admin/profile', $this->profilePayload())->assertForbidden();
        $this->actingAs(User::factory()->create(['is_admin' => true]));
        $this->app->instance('env', 'local');
        $this->put('/admin/profile', $this->profilePayload())->assertStatus(419);
        foreach (['marquee', 'skill-groups', 'skills'] as $resource) {
            $this->post("/admin/{$resource}", ['name' => 'No CSRF'])->assertStatus(419);
        }
        $this->assertDatabaseCount('site_profiles', 0);
    }

    public function test_hidden_and_deleted_groups_hide_skills_without_losing_them(): void
    {
        $group = SkillGroup::factory()->create();
        $skill = Skill::factory()->for($group, 'group')->create(['name' => 'Nested unique skill']);
        $this->actingAs(User::factory()->create(['is_admin' => true]));
        $this->get('/landing-content')->assertSee('Nested unique skill');
        $group->update(['is_visible' => false]);
        $this->get('/landing-content')->assertDontSee('Nested unique skill');
        $group->update(['is_visible' => true]);
        $this->delete("/admin/skill-groups/{$group->id}")->assertRedirect();
        $this->assertNotSoftDeleted($skill);
        $this->get('/landing-content')->assertDontSee('Nested unique skill');
        $this->putJson("/admin/skills/{$skill->id}", ['name' => 'New', 'sort_order' => 0, 'skill_group_id' => $group->id])
            ->assertUnprocessable()->assertJsonValidationErrors('skill_group_id');
        $this->post("/admin/skill-groups/{$group->id}/restore")->assertRedirect();
        $this->get('/landing-content')->assertSee('Nested unique skill');
    }

    public function test_public_content_uses_order_and_escapes_every_free_text_field(): void
    {
        $payload = '<script>alert("xss")</script>';
        SiteProfile::factory()->create(array_fill_keys(['hero_name', 'hero_description', 'hero_photo_alt', 'portfolio_label', 'cv_label', 'about_name', 'about_role', 'about_description', 'about_photo_alt', 'quote'], $payload) + ['id' => 1, 'hero_roles' => [$payload]]);
        MarqueeItem::factory()->create(['name' => 'Last marquee', 'sort_order' => 9]);
        MarqueeItem::factory()->create(['name' => 'First marquee', 'sort_order' => 0]);
        MarqueeItem::factory()->create(['name' => $payload]);
        $group = SkillGroup::factory()->create(['name' => $payload]);
        Skill::factory()->for($group, 'group')->create(['name' => $payload]);
        $this->get('/landing-content')->assertSee($payload)->assertDontSee($payload, false)
            ->assertSeeInOrder(['First marquee', 'Last marquee']);
        $this->actingAs(User::factory()->create(['is_admin' => true]));
        $this->get('/admin/profile')->assertSee($payload)->assertDontSee($payload, false);
        $this->get("/admin/skill-groups/{$group->id}")->assertSee($payload)->assertDontSee($payload, false);
    }

    public function test_dangerous_icon_urls_and_unknown_groups_are_rejected(): void
    {
        $group = SkillGroup::factory()->create();
        $this->actingAs(User::factory()->create(['is_admin' => true]));
        foreach (['javascript:alert(1)', 'data:image/svg+xml,unsafe', '/img/../.env', 'http://example.test/icon.png', ['nested']] as $url) {
            $this->postJson('/admin/skills', ['name' => 'Unsafe', 'sort_order' => 0, 'skill_group_id' => $group->id, 'icon_url' => $url])
                ->assertUnprocessable()->assertJsonValidationErrors('icon_url');
        }
        $this->postJson('/admin/skills', ['name' => 'Invalid parent', 'sort_order' => 0, 'skill_group_id' => 9999])
            ->assertUnprocessable()->assertJsonValidationErrors('skill_group_id');
        $this->postJson('/admin/skill-groups', ['name' => 'Unsafe', 'sort_order' => 0, 'accent' => 'yellow" onclick="bad'])
            ->assertUnprocessable()->assertJsonValidationErrors('accent');
        $this->assertDatabaseCount('skills', 0);
    }

    public function test_public_fragment_is_read_only_and_disables_caching(): void
    {
        $response = $this->get('/landing-content')->assertOk()
            ->assertHeader('X-Content-Type-Options', 'nosniff')->assertHeader('X-Frame-Options', 'DENY');
        $this->assertStringContainsString('no-store', $response->headers->get('Cache-Control'));
        $this->assertDatabaseCount('site_profiles', 0);
    }
}
