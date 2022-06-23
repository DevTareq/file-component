<?php

namespace App\Contracts\Abstracts;

use App\Contracts\DataTransferObjectInterface;
use App\Contracts\FileReaderInterface;
use App\Contracts\FileValidatorInterface;
use App\Exceptions\Files\FileNotFoundException;
use Illuminate\Support\Facades\Validator;

abstract class AbstractFileValidator implements FileValidatorInterface
{
    /** @var array $errors */
    protected array $errors = [];

    /** @var array $rules */
    protected array $rules = [];

    /**
     * @param array $array
     * @return void
     */
    public function setRules(array $array): void
    {
        $this->rules = $array;
    }

    /**
     * @return array
     */
    public function getRules(): array
    {
        return $this->rules;
    }

    /**
     * @param DataTransferObjectInterface $dataTransferObject
     * @param FileReaderInterface $fileReader
     * @return array|null
     */
    abstract public function validate(DataTransferObjectInterface $dataTransferObject, FileReaderInterface $fileReader): ?array;

    /**
     * @param $fileRecords
     * @return array|null
     */
    protected function validateMultiple($fileRecords): ?array
    {
        foreach ($fileRecords as $offset => $record) {

            $validator = Validator::make($record, $this->getRules());

            if (!$validator->fails()) {
                continue;
            }

            $this->errors[] = [
                'record' => $offset,
                'errors' => $validator->errors()->all(),
            ];
        }

        return $this->errors ?? [];
    }

    /**
     * @param $fileRecords
     * @return array|null
     */
    protected function validateOnce($fileRecords): ?array
    {
        foreach ($fileRecords as $offset => $record) {
            $validator = Validator::make($record, $this->getRules());

            if ($validator->fails()) {
                $this->errors[] = [
                    'record' => $offset,
                    'errors' => $validator->errors()->all(),
                ];

                return $this->errors;
            }
        }

        return [];
    }

    /**
     * @param DataTransferObjectInterface $dataTransferObject
     * @return mixed
     * @throws \Throwable
     */
    public function isValidFile(DataTransferObjectInterface $dataTransferObject): mixed
    {
        throw_if(null == $dataTransferObject->getFileInput(), new FileNotFoundException());

//        throw_if($dataTransferObject->getExtension() !== CsvFileManager::FILE_EXTENSION, new UnsupportedFileException());

        return true;
    }
}
