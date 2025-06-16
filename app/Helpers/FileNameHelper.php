<?php

namespace App\Helpers;

use Illuminate\Support\Str;

class FileNameHelper
{
    public static function fileName($file, $folder, $prefix)
    {
        $timestamp = time();
        $slug = Str::slug($prefix);
        $ext = $file->getClientOriginalExtension();
        $filename = "{$slug}.{$ext}";

        return $file->storeAs($folder, $filename, 'public');
    }
}
