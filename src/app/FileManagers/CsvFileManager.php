<?php

namespace App\FileManagers;

use App\Contracts\DataTransferObjectInterface;
use App\Contracts\FileManagerInterface;
use App\Contracts\FileReaderInterface;
use App\Contracts\FileValidatorInterface;
use App\Factories\ValidatorFactory;
use App\FileReaders\CsvReader;

class CsvFileManager implements FileManagerInterface
{
    public FileReaderInterface $fileReader;

    public FileValidatorInterface $fileValidator;

    /**
     * @param DataTransferObjectInterface $dataTransferObject
     * @return mixed
     * @throws \Throwable
     */
    public function process(DataTransferObjectInterface $dataTransferObject): mixed
    {
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
        return $this->fileValidator = ValidatorFactory::make($dataTransferObject);
    }
}
