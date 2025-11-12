<?php

namespace App\Repositories;

use App\Interfaces\WebSettingRepositoryInterface;
use App\Models\WebSetting;
use App\Services\HandleFileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class WebSettingRepository implements WebSettingRepositoryInterface
{
    public function __construct(protected HandleFileService $fileService) {}

    public function allGrouped()
    {
        return WebSetting::all()->groupBy('group');
    }

    public function update(Request $request): void
    {
        foreach ($request->except('_token') as $key => $value) {
            $setting = WebSetting::where('key', $key)->first();

            if (!$setting) continue;

            // handle file uploads
            if ($request->hasFile($key)) {
                $this->fileService->deleteFile($setting->value);
                $path = $this->fileService->uploadImage($request->file($key), 'settings');
                $setting->update(['value' => "/storage/{$path}"]);
            } else {
                // boolean fix for unchecked toggles
                if ($setting->type === 'boolean') {
                    $value = $request->boolean($key);
                }

                $setting->update([
                    'value' => is_array($value) ? json_encode($value) : $value,
                ]);
            }
        }

        Cache::flush();
    }
}