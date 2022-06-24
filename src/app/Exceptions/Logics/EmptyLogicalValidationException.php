<?php

namespace App\Exceptions\Logics;

class EmptyLogicalValidationException extends \Exception
{
    public const MESSAGE = 'Missing logical validation class';
}
