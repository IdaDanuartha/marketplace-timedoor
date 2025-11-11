<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

class HandleFileService
{
    /**
     * Upload file ke storage/app/public/uploads/products
     */
    public function uploadImage(UploadedFile $file, string $image_path): string
    {
        try {
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs("uploads/$image_path", $filename, 'public');
            return $path;
        } catch (Throwable $e) {
            throw new \RuntimeException('Failed to upload image: ' . $e->getMessage());
        }
    }

    /**
     * Hapus file lama dari storage
     */
    public function deleteFile(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}