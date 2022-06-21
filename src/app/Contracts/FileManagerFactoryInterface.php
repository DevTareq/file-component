<?php

namespace App\Contracts;

use Illuminate\Http\Request;

interface FileManagerFactoryInterface
{
    /**
     * @param DataTransferObjectInterface $dataTransferObject
     * @return mixed
     */
    public static function getFileManager(DataTransferObjectInterface $dataTransferObject): mixed;
}
