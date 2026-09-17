<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_profiles', function (Blueprint $table): void {
            $table->id();
            $table->string('hero_name')->nullable();
            $table->json('hero_roles')->nullable();
            $table->text('hero_description')->nullable();
            $table->string('cv_label')->nullable();
            $table->string('cv_url', 1000)->nullable();
            $table->string('portfolio_label')->nullable();
            $table->string('portfolio_url', 1000)->nullable();
            $table->string('hero_photo')->nullable();
            $table->string('hero_photo_alt')->nullable();
            $table->string('hero_photo_style')->nullable();
            $table->boolean('hero_visible')->default(true);
            $table->string('about_name')->nullable();
            $table->string('about_role')->nullable();
            $table->text('about_description')->nullable();
            $table->string('about_photo')->nullable();
            $table->string('about_photo_alt')->nullable();
            $table->unsignedInteger('years_experience')->default(0);
            $table->unsignedInteger('projects_completed')->default(0);
            $table->unsignedInteger('happy_clients')->default(0);
            $table->text('quote')->nullable();
            $table->boolean('about_visible')->default(true);
            $table->timestamps();
        });
        Schema::create('marquee_items', function (Blueprint $table): void {
            $table->id();
            $table->string('name', 100);
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_visible')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('skill_groups', function (Blueprint $table): void {
            $table->id();
            $table->string('name', 100);
            $table->string('accent', 20)->default('yellow');
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_visible')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('skills', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('skill_group_id')->constrained()->restrictOnDelete();
            $table->string('name', 100);
            $table->string('icon_url', 1000)->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_visible')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('skills');
        Schema::dropIfExists('skill_groups');
        Schema::dropIfExists('marquee_items');
        Schema::dropIfExists('site_profiles');
    }
};
