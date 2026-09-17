<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveSiteProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return (bool) $this->user()?->can('admin');
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('hero_roles_text') && ($this->input('hero_roles_text') === null || is_string($this->input('hero_roles_text')))) {
            $roles = array_map('trim', explode("\n", $this->input('hero_roles_text') ?? ''));
            $this->merge(['hero_roles' => array_values(array_filter($roles, fn (string $role): bool => $role !== ''))]);
        }
        $this->merge([
            'hero_visible' => $this->boolean('hero_visible'),
            'about_visible' => $this->boolean('about_visible'),
            'remove_hero_photo' => $this->boolean('remove_hero_photo'),
            'remove_about_photo' => $this->boolean('remove_about_photo'),
        ]);
    }

    public function rules(): array
    {
        $image = ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'extensions:jpg,jpeg,png,webp', 'max:3072', 'dimensions:max_width=6000,max_height=6000'];

        return [
            'hero_name' => ['required', 'string', 'max:120'],
            'hero_roles' => ['nullable', 'array', 'list', 'max:10'],
            'hero_roles_text' => ['nullable', 'string', 'max:1000'],
            'hero_roles.*' => ['required', 'string', 'max:80'],
            'hero_description' => ['nullable', 'string', 'max:8000'],
            'cv_label' => ['nullable', 'required_with:cv_url', 'string', 'max:50'],
            'cv_url' => ['nullable', 'url:http,https', 'max:1000'],
            'portfolio_label' => ['nullable', 'required_with:portfolio_url', 'string', 'max:50'],
            'portfolio_url' => ['nullable', 'url:http,https', 'max:1000'],
            'hero_photo' => $image,
            'hero_photo_alt' => ['nullable', 'required_with:hero_photo', 'string', 'max:255'],
            'hero_photo_style' => ['required', 'in:rounded,arch,cutout'],
            'hero_visible' => ['required', 'boolean'],
            'remove_hero_photo' => ['boolean'],
            'about_name' => ['required', 'string', 'max:120'],
            'about_role' => ['nullable', 'string', 'max:255'],
            'about_description' => ['nullable', 'string', 'max:10000'],
            'about_photo' => $image,
            'about_photo_alt' => ['nullable', 'required_with:about_photo', 'string', 'max:255'],
            'remove_about_photo' => ['boolean'],
            'years_experience' => ['required', 'integer', 'min:0', 'max:100'],
            'projects_completed' => ['required', 'integer', 'min:0', 'max:1000000'],
            'happy_clients' => ['required', 'integer', 'min:0', 'max:1000000'],
            'quote' => ['nullable', 'string', 'max:2000'],
            'about_visible' => ['required', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'hero_name.required' => 'Nama di Hero wajib diisi.',
            'hero_photo_alt.required_with' => 'Isi deskripsi foto Hero.',
            'about_photo_alt.required_with' => 'Isi deskripsi foto About.',
            'hero_photo.max' => 'Foto Hero maksimal 3 MB.',
            'about_photo.max' => 'Foto About maksimal 3 MB.',
            'portfolio_url.url' => 'Link portfolio harus menggunakan http atau https.',
        ];
    }
}
