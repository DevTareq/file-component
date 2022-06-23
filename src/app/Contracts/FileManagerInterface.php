<?php

namespace App\Contracts;

interface FileManagerInterface
{
    /**
     * @param DataTransferObjectInterface $dataTransferObject
     * @return mixed
     */
    public function process(DataTransferObjectInterface $dataTransferObject): mixed;

    /**
     * @param DataTransferObjectInterface $dataTransferObject
     * @return FileValidatorInterface
     */
    public function getFileValidator(DataTransferObjectInterface $dataTransferObject): FileValidatorInterface;

    /**
     * @return FileReaderInterface
     */
    public function getFileReader(): FileReaderInterface;
}
