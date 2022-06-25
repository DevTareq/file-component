<?php

namespace App\Contracts;

interface FileManagerFactoryInterface
{
    /**
     * @param DataTransferObjectInterface $dataTransferObject
     * @return mixed
     */
    public static function getFileManager(DataTransferObjectInterface $dataTransferObject): mixed;
}
