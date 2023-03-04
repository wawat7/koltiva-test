<?php

namespace App\Service;

use App\Helper\Utility;
use Illuminate\Http\UploadedFile;

class ImageService
{

    public const PATH_IMAGE= 'public/images';
    public $utils;

    public function __construct()
    {
        $this->utils = new Utility;
    }

    public function saveImage(UploadedFile $image)
    {
        $filename = uniqid() . '.' . $image->getClientOriginalExtension();
        $image->storeAs(self::PATH_IMAGE, $filename);
        return $filename;
    }

    public function removeImage(string $path)
    {
        if (file_exists($path)) {
            unlink($path);
            return true;
        }

        return false;
    }
}
