<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

trait UploadTrait
{
    public function uploadFile(UploadedFile $file, $folder = 'uploads', $filename = null)
    {
        if (!$filename) {
            $filename = Str::random(20);
        }
        
        $extension = $file->getClientOriginalExtension();
        $filename = $filename . '.' . $extension;
        
        $file->storeAs($folder, $filename, 'public');
        
        return "storage/{$folder}/{$filename}";
    }

    public function deleteFile($path)
    {
        if ($path && file_exists(public_path($path))) {
            unlink(public_path($path));
        }
    }
} 