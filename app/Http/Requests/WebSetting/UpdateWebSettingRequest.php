<?php

namespace App\Http\Requests\WebSetting;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWebSettingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // GENERAL
            'site_name' => 'nullable|string|max:255',
            'site_description' => 'nullable|string|max:500',

            // CONTACT
            'email_contact' => 'nullable|email|max:100',
            'phone_contact' => 'nullable|string|max:30',
            'address' => 'nullable|string|max:255',

            // FILE UPLOADS
            'site_logo' => 'nullable|image|mimes:png,jpg,jpeg,webp,svg|max:3000',
            'logo_icon' => 'nullable|image|mimes:png,jpg,jpeg,webp,svg|max:2000',
            'favicon' => 'nullable|image|mimes:png,ico,jpg,jpeg,webp,svg|max:1000',
            'og_image' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:4000',

            // SOCIAL MEDIA
            'instagram_url' => 'nullable|url|max:255',
            'tiktok_url' => 'nullable|url|max:255',
            'linkedin_url' => 'nullable|url|max:255',
            'github_url' => 'nullable|url|max:255',

            // SEO
            'meta_keywords' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:255',

            // SYSTEM
            'maintenance_mode' => 'sometimes|boolean',
            'default_currency' => 'nullable|string|max:10',
            'timezone' => 'nullable|string|max:50',
        ];
    }

    public function messages(): array
    {
        return [
            'site_logo.image' => 'Logo harus berupa file gambar.',
            'favicon.image' => 'Favicon harus berupa file gambar.',
            'og_image.image' => 'Open Graph image harus berupa file gambar.',
            'instagram_url.url' => 'Masukkan URL Instagram yang valid.',
            'tiktok_url.url' => 'Masukkan URL TikTok yang valid.',
            'linkedin_url.url' => 'Masukkan URL LinkedIn yang valid.',
            'github_url.url' => 'Masukkan URL GitHub yang valid.',
        ];
    }
}