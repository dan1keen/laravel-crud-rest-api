<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ImageService
{
    public function upload(UploadedFile $tmpImage, $basePath)
    {
        $uploadDate = now()->format('Y-m');
        $imageName = uniqid() . ".{$tmpImage->getClientOriginalExtension()}";
        $fullPath = "{$basePath}/{$uploadDate}/{$imageName}";

        if (Storage::disk('public_uploads')->put($fullPath, File::get($tmpImage))) {
            return $fullPath;
        }

        return false;
    }

    public function uploadFromUrl($tmpImageUrl, $basePath)
    {
        $uploadDate = now()->format('Y-m');
        $tmpImage = file_get_contents($tmpImageUrl);
        $extension = pathinfo($tmpImageUrl, PATHINFO_EXTENSION) != ''
            ? pathinfo($tmpImageUrl, PATHINFO_EXTENSION)
            : 'jpg';

        $imageName = uniqid() . ".{$extension}";
        $fullPath = "{$basePath}/{$uploadDate}/{$imageName}";

        if (Storage::disk('public_uploads')->put($fullPath, $tmpImage)) {
            return $fullPath;
        }

        return false;
    }

    public function delete($path)
    {
        return Storage::disk('public_uploads')->delete($path);
    }
}
