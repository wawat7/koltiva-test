<?php

namespace App\Service;

use App\Helper\Utility;
use Illuminate\Http\UploadedFile;

class ImageService
{

    public $utils;

    public function __construct()
    {
        $this->utils = new Utility;
    }

    public function saveImage(UploadedFile $image)
    {
        $filename = uniqid() . '.' . $image->getClientOriginalExtension();
        $image->storeAs('public/images', $filename);
        return $filename;
    }
}
