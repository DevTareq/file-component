<?php

namespace App\FileManagers;

use App\Contracts\DataTransferObjectInterface;
use App\Contracts\FileManagerInterface;
use App\Contracts\FileValidatorInterface;
use App\Exceptions\Files\FileNotFoundException;
use App\Exceptions\Files\FileUploadException;
use App\Validators\Files\CsvFileValidator;
use Illuminate\Support\Facades\App;

class CsvFileManager implements FileManagerInterface
{
    private const FOLDER_PATH = './uploads/csv';

    public const FILE_EXTENSION = 'csv';

    /**
     * @param DataTransferObjectInterface $dataTransferObject
     * @return mixed
     * @throws \Throwable
     */
    public function process(DataTransferObjectInterface $dataTransferObject): mixed
    {
        return $this->validate($dataTransferObject, App::make(CsvFileValidator::class));
    }

    /**
     * @param DataTransferObjectInterface $dataTransferObject
     * @param FileValidatorInterface $fileValidator
     * @return mixed
     * @throws \Throwable
     */
    public function validate(DataTransferObjectInterface $dataTransferObject, FileValidatorInterface $fileValidator): mixed
    {
        throw_if(null == $dataTransferObject->getFileInput(),  new FileNotFoundException());

        $fileValidator->isValidFile($dataTransferObject);

        return $fileValidator->validate($dataTransferObject);
    }

    /**
     * @param string $fileName
     * @return string
     * @deprecated belongs to upload()
     */
    private function getFullPath(string $fileName): string
    {
        return rtrim(app()->basePath('public' . '/uploads/csv/' . $fileName), '/');
    }

    /**
     * @param DataTransferObjectInterface $dataTransferObject
     * @return $this
     * @throws \Throwable
     * @deprecated To be added in later stage.
     */
    public function upload(DataTransferObjectInterface $dataTransferObject): self
    {
        $destinationPath = static::FOLDER_PATH . DIRECTORY_SEPARATOR;

        $fileName = 'U-' . time() . '.' . $dataTransferObject->getExtension();

        throw_if(!$dataTransferObject->getFileInput()->move($destinationPath, $fileName),
            new FileUploadException());

        $this->filePath = $this->getFullPath($fileName);

        return $this;
    }
}
