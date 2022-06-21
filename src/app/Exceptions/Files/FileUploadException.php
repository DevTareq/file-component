<?php

namespace App\Exceptions\Files;

class FileUploadException extends \Exception
{
    public const CANNOT_UPLOAD_FILE = 'Cannot upload file!';
}
