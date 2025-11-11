<?php

use Illuminate\Support\Str;

if (! function_exists('profile_image')) {
    function profile_image(?string $path): string
    {
        if (! $path) {
            return asset('images/user/default-avatar.png');
        }

        if (Str::startsWith($path, ['http://', 'https://'])) {
            return $path;
        }

        return asset('storage/' . ltrim($path, '/'));
    }
}