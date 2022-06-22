<?php

namespace App\Exceptions\Files;

class UnsupportedFileException extends \Exception
{
    public const MESSAGE = 'File format is not supported';
}
