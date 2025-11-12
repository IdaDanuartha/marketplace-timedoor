<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class WebSetting extends BaseModel
{
    protected $guarded = [];

    public static function get(string $key, $default = null)
    {
        return Cache::rememberForever("web_setting_{$key}", function () use ($key, $default) {
            $setting = static::where('key', $key)->first();
            return $setting ? $setting->castedValue() : $default;
        });
    }

    public static function set(string $key, $value): self
    {
        Cache::forget("web_setting_{$key}");
        return static::updateOrCreate(['key' => $key], ['value' => is_array($value) ? json_encode($value) : $value]);
    }

    public function castedValue()
    {
        return match ($this->type) {
            'boolean' => (bool) $this->value,
            'json' => json_decode($this->value, true),
            'integer' => (int) $this->value,
            default => $this->value,
        };
    }

    public static function grouped(): array
    {
        return Cache::rememberForever('web_settings_grouped', function () {
            return static::all()->groupBy('group')->toArray();
        });
    }

    public static function flushCache(): void
    {
        Cache::flush();
    }
}
