<?php

namespace App\Factories;

use App\Contracts\DataTransferObjectInterface;
use App\Contracts\FileManagerFactoryInterface;
use App\Exceptions\Files\FileNotFoundException;
use App\Exceptions\Files\UnsupportedFileException;

class FileManagerFactory implements FileManagerFactoryInterface
{
    private const FILE_MANAGER_CLASS_POSTFIX = 'FileManager';

    /**
     * @param DataTransferObjectInterface $dataTransferObject
     * @return mixed
     * @throws \Throwable
     */
    public static function getFileManager(DataTransferObjectInterface $dataTransferObject): mixed
    {
        // Get the file extension
        throw_if(!$dataTransferObject->getFileInput(), new FileNotFoundException());

        $extension = $dataTransferObject->getFileInput()->getClientOriginalExtension();

        $factoryClassName = ucfirst($extension) . static::FILE_MANAGER_CLASS_POSTFIX;
        $factoryClassNamespace = '\App\FileManagers\\' . $factoryClassName;

        // return the type of file not supported exception
        throw_if(!class_exists($factoryClassNamespace), new UnsupportedFileException());

        return new $factoryClassNamespace;
    }

    /**
     * @return string
     */
    public static function getPostFixName(): string
    {
        return static::FILE_MANAGER_CLASS_POSTFIX;
    }
}
