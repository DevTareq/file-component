<?php

namespace App\Exceptions\Files;

class FileNotFoundException extends \Exception
{
    public const MESSAGE = 'Unable to find file';
}
