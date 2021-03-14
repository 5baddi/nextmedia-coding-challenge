<?php

namespace App\Traits;

use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;

trait UploadTrait
{
    /**
     * Upload one file to storage
     * 
     * @param \Illuminate\Http\UploadedFile $uploadedFile
     * @param string $folder
     * @param string|null $fileName
     * @param string $disk
     * @return string|bool
     */
    public function upload(UploadedFile $uploadedFile, $folder, $fileName = null, $disk = 'public')
    {
        // Use file name or generate new one
        $name = !is_null($fileName) ? $fileName : Str::random(25) . '_' . time();

        // Upload file and save path
        $file = $uploadedFile->storeAs($folder, $name . '.' . $uploadedFile->getClientOriginalExtension(), $disk);

        return $file;
    }
}