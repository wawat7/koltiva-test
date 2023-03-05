<?php

namespace App\Helper;

use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Str;
class Utility
{
    public function base64ToFile(string $base64): UploadedFile
    {
        $fileData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64));
        $tmpFilePath = sys_get_temp_dir() . '/temporary-' . rand() . '.' . $this->getExtFromBase64($base64);
        file_put_contents($tmpFilePath, $fileData);
        $tmpFile = new File($tmpFilePath);

        return new UploadedFile($tmpFile->getPathname(), $tmpFile->getFilename(), $tmpFile->getMimeType(), 0, true);
    }

    public function getExtFromBase64(string $base64): string
    {
        return explode('/', mime_content_type($base64))[1];
    }
}
