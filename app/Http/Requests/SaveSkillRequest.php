<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaveSkillRequest extends FormRequest
{
    public function authorize(): bool
    {
        return (bool) $this->user()?->can('admin');
    }

    protected function prepareForValidation(): void
    {
        $this->merge(['is_visible' => $this->boolean('is_visible')]);
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:100'],
            'sort_order' => ['required', 'integer', 'min:0', 'max:1000000'],
            'is_visible' => ['required', 'boolean'],
            'skill_group_id' => ['required', 'integer', Rule::exists('skill_groups', 'id')->whereNull('deleted_at')],
            'icon_url' => ['nullable', 'string', 'max:1000', function (string $attribute, mixed $value, \Closure $fail): void {
                if (! is_string($value)) {
                    $fail('URL ikon harus berupa teks.');

                    return;
                }
                $https = filter_var($value, FILTER_VALIDATE_URL) && parse_url($value, PHP_URL_SCHEME) === 'https';
                $local = preg_match('#^/img/[a-zA-Z0-9 _.-]+\.(png|jpe?g|webp|svg)$#i', $value) && ! str_contains($value, '..');
                if (! $https && ! $local) {
                    $fail('Gunakan URL HTTPS atau aset /img/ yang valid.');
                }
            }],
        ];
    }
}
