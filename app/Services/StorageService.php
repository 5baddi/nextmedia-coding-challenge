<?php

namespace App\Services;

use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Filesystem\Filesystem;

class StorageService
{
    /**
     * Filesystem service
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $storage;

    /**
     * Constructor
     *
     * @param \Illuminate\Filesystem\Filesystem $storage
     */
    public function __construct(Filesystem $storage)
    {
        $this->storage = $storage;
    }

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

        return $uploadedFile->storeAs($folder, $name . '.' . $uploadedFile->getClientOriginalExtension(), $disk);
    }

    /**
     * Get public URL of file
     *
     * @param string $fileName
     * @return string|null
     */
    public function url(string $fileName): ?string
    {
        if($this->storage->exists($fileName)){
            return $this->storage->url($fileName);
        }

        return null;
    }
}