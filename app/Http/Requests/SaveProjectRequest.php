<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return (bool) $this->user()?->is_admin;
    }

    public function rules(): array
    {
        $required = $this->isMethod('patch') ? 'sometimes' : 'required';

        return [
            'title' => [$required, 'required', 'string', 'max:255'],
            'summary' => ['nullable', 'string', 'max:500'],
            'description' => ['nullable', 'string', 'max:20000'],
            'problem' => ['nullable', 'string', 'max:10000'],
            'goal' => ['nullable', 'string', 'max:10000'],
            'role' => ['nullable', 'string', 'max:255'],
            'result' => ['nullable', 'string', 'max:10000'],
            'flow_steps' => ['nullable', 'array', 'max:30'],
            'flow_steps.*' => ['required', 'string', 'max:2000'],
            'cover_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'extensions:jpg,jpeg,png,webp', 'max:3072', 'dimensions:max_width=6000,max_height=6000'],
            'cover_alt' => ['nullable', 'required_with:cover_image', 'string', 'max:255'],
            'demo_url' => ['nullable', 'url:http,https', 'max:255'],
            'repository_url' => ['nullable', 'url:http,https', 'max:255'],
            'status' => [$required, 'in:draft,published'],
            'featured' => ['sometimes', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:1000000'],
            'categories' => ['sometimes', 'array', 'max:20'],
            'technologies' => ['sometimes', 'array', 'max:30'],
            'categories.*' => ['required', 'string', 'max:80'],
            'technologies.*' => ['required', 'string', 'max:80'],
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('flow_text') && is_string($this->input('flow_text'))) {
            $this->merge(['flow_steps' => array_values(array_filter(array_map('trim', explode("\n", $this->input('flow_text')))))]);
        }
        if (! $this->is('api/*')) {
            foreach (['categories', 'technologies'] as $field) {
                if ($this->input($field) === null) {
                    $this->merge([$field => []]);
                }
                if (is_string($this->input($field))) {
                    $this->merge([$field => array_values(array_filter(array_map('trim', explode(',', $this->input($field)))))]);
                }
            }
            $this->merge(['featured' => $this->boolean('featured')]);
        }
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Judul project wajib diisi.',
            'status.required' => 'Pilih status draft atau published.',
            'cover_image.image' => 'Cover harus berupa gambar JPG, PNG, atau WebP.',
            'cover_image.max' => 'Ukuran cover maksimal 3 MB.',
            'cover_alt.required_with' => 'Deskripsi gambar wajib diisi saat mengunggah cover.',
            'demo_url.url' => 'URL demo harus memakai http atau https.',
            'repository_url.url' => 'URL repository harus memakai http atau https.',
        ];
    }
}
