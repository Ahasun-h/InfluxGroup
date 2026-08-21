<?php
namespace App\helpers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class helpers{
    public static function fileUpload($file, $folder, $name)
    {
        \Log::info('fileUpload called', [
            'file' => $file,
            'folder' => $folder,
            'name' => $name,
            'file_valid' => $file ? $file->isValid() : null,
            'file_size' => $file ? $file->getSize() : null,
        ]);

        // Generate a slugged file name
        $imageName = Str::slug($name) . '.' . $file->getClientOriginalExtension();

        \Log::info('Generated image name', ['imageName' => $imageName]);

        // Store the file in the specified folder and return the path
        $path = $file->storeAs($folder, $imageName, 'public');

        $publicPath = '/storage/' . $path;

        \Log::info('File stored', ['path' => $publicPath]);

        return $publicPath;
    }


    static public function updatedFileUpload($pre_file, $file, $folder, $name)
    {
        // Clean relative path for Storage disk
        $relativePath = ltrim(str_replace('/storage/', '', $pre_file), '/');

        // Check if the file exists before attempting to delete it
        if (!empty($relativePath) && Storage::disk('public')->exists($relativePath)) {
            // Delete the file
            Storage::disk('public')->delete($relativePath);
        }

        return self::fileUpload($file, $folder, $name);
    }
}
