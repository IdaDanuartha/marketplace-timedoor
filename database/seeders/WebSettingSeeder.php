<?php

namespace Database\Seeders;

use App\Models\WebSetting;
use Illuminate\Database\Seeder;

class WebSettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // GENERAL
            ['group' => 'general', 'key' => 'site_name', 'value' => 'Marketplace Timedoor', 'type' => 'string'],
            ['group' => 'general', 'key' => 'site_description', 'value' => 'A trusted digital marketplace for tech and creative products.', 'type' => 'string'],
            ['group' => 'general', 'key' => 'site_logo', 'value' => null, 'type' => 'file'],
            ['group' => 'general', 'key' => 'logo_icon', 'value' => null, 'type' => 'file'],
            ['group' => 'general', 'key' => 'favicon', 'value' => null, 'type' => 'file'],

            // CONTACT
            ['group' => 'contact', 'key' => 'email_contact', 'value' => 'support@timedoor-marketplace.com', 'type' => 'string'],
            ['group' => 'contact', 'key' => 'phone_contact', 'value' => '+62 813 7777 5555', 'type' => 'string'],
            ['group' => 'contact', 'key' => 'address', 'value' => 'Jl. Sunset Road No. 45, Kuta, Bali', 'type' => 'string'],

            // SOCIAL
            ['group' => 'social', 'key' => 'instagram_url', 'value' => 'https://instagram.com/timedoor.marketplace', 'type' => 'string'],
            ['group' => 'social', 'key' => 'tiktok_url', 'value' => 'https://tiktok.com/@timedoor.marketplace', 'type' => 'string'],
            ['group' => 'social', 'key' => 'linkedin_url', 'value' => 'https://linkedin.com/company/timedoor', 'type' => 'string'],
            ['group' => 'social', 'key' => 'github_url', 'value' => 'https://github.com/timedoor-marketplace', 'type' => 'string'],

            // SEO
            ['group' => 'seo', 'key' => 'meta_keywords', 'value' => 'marketplace, timedoor, ecommerce, digital goods, bali tech', 'type' => 'string'],
            ['group' => 'seo', 'key' => 'meta_description', 'value' => 'Marketplace Timedoor — connecting creators and consumers through technology.', 'type' => 'string'],
            ['group' => 'seo', 'key' => 'og_image', 'value' => null, 'type' => 'file'],

            // SYSTEM
            ['group' => 'system', 'key' => 'maintenance_mode', 'value' => '0', 'type' => 'boolean'],
            ['group' => 'system', 'key' => 'timezone', 'value' => 'Asia/Makassar', 'type' => 'string'],
        ];

        foreach ($settings as $setting) {
            WebSetting::firstOrCreate(['key' => $setting['key']], $setting);
        }
    }
}