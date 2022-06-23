<?php

namespace App\Factories;

use App\Contracts\DataTransferObjectInterface;
use App\Contracts\ValidatorFactoryInterface;
use App\Exceptions\Files\FileNotFoundException;
use App\Exceptions\Files\UnsupportedFileException;

class ValidatorFactory implements ValidatorFactoryInterface
{
    private const VALIDATOR_CLASS_POSTFIX = 'FileValidator';

    protected DataTransferObjectInterface $dataTransferObject;

    public static function make(DataTransferObjectInterface $dataTransferObject)
    {
        throw_if(!$dataTransferObject->getFileInput(), new FileNotFoundException());

//        $category = $dataTransferObject->getFileCategory();
        $category = 'product';

        $factoryClassName = ucfirst($category) . static::VALIDATOR_CLASS_POSTFIX;
        $factoryClassNamespace = '\App\Validators\Files\\' . $factoryClassName;

        // return the type of file not supported exception
        throw_if(!class_exists($factoryClassNamespace), new UnsupportedFileException());

        return new $factoryClassNamespace;
    }

    /**
     * @return string
     */
    public static function getPostFixName(): string
    {
        return static::VALIDATOR_CLASS_POSTFIX;
    }
}