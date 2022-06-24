<?php

namespace App\FileManagers;

use App\Contracts\DataTransferObjectInterface;
use App\Contracts\FileManagerInterface;
use App\Contracts\FileReaderInterface;
use App\Contracts\FileValidatorInterface;
use App\Exceptions\Files\UnsupportedFileException;
use App\Factories\FileValidatorFactory;
use App\FileReaders\CsvReader;

class CsvFileManager implements FileManagerInterface
{
    public const FILE_EXTENSION = 'csv';

    public FileReaderInterface $fileReader;

    public FileValidatorInterface $fileValidator;

    /**
     * @param DataTransferObjectInterface $dataTransferObject
     * @return mixed
     * @throws \Throwable
     */
    public function process(DataTransferObjectInterface $dataTransferObject): mixed
    {
        throw_if($dataTransferObject->getExtension() !== static::FILE_EXTENSION, new UnsupportedFileException());

        $fileValidator = $this->getFileValidator($dataTransferObject);

        return $fileValidator->validate($dataTransferObject, $this->getFileReader());
    }

    /**
     * @return FileReaderInterface
     */
    public function getFileReader(): FileReaderInterface
    {
        return $this->fileReader = new CsvReader();
    }

    /**
     * @param DataTransferObjectInterface $dataTransferObject
     * @return FileValidatorInterface
     */
    public function getFileValidator(DataTransferObjectInterface $dataTransferObject): FileValidatorInterface
    {
        return $this->fileValidator = FileValidatorFactory::make($dataTransferObject);
    }
}
