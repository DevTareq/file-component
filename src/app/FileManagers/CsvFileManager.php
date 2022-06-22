<?php

namespace App\FileManagers;

use App\Contracts\DataTransferObjectInterface;
use App\Contracts\FileManagerInterface;
use App\Contracts\FileValidatorInterface;
use App\Exceptions\Files\FileNotFoundException;
use App\Exceptions\Files\FileUploadException;
use App\Exceptions\Files\UnsupportedFileException;
use App\Validators\Files\CsvFileValidator;
use Illuminate\Support\Facades\App;

class CsvFileManager implements FileManagerInterface
{
    private const FOLDER_PATH = './uploads/csv';

    private const FILE_EXTENSION = 'csv';

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

        return $fileValidator->validate($dataTransferObject->getFileInput());
    }

    /**
     * @param string $fileName
     * @return string
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
        throw_if(null == $dataTransferObject->getFileInput(), new FileNotFoundException());

        $fileExt = $dataTransferObject->getExtension();

        throw_if($fileExt !== static::FILE_EXTENSION, new UnsupportedFileException());

        $destinationPath = static::FOLDER_PATH . DIRECTORY_SEPARATOR;

        $fileName = 'U-' . time() . '.' . $fileExt;

        throw_if(!$dataTransferObject->getFileInput()->move($destinationPath, $fileName),
            new FileUploadException());

        $this->filePath = $this->getFullPath($fileName);

        return $this;
    }
}
