<?php

namespace App\Contracts\Abstracts;

use App\Contracts\DataTransferObjectInterface;
use App\Contracts\FileReaderInterface;
use App\Contracts\FileValidatorInterface;
use App\Exceptions\Logics\EmptyLogicalValidationException;
use Illuminate\Support\Facades\Validator;

abstract class AbstractFileValidator implements FileValidatorInterface
{
    /** @var array $errors */
    protected array $errors = [];

    /** @var array $rules */
    protected array $rules = [];

    protected ?array $logicalValidators = null;

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
        $validatedRecords = [];

        foreach ($fileRecords as $offset => $record) {

            $validator = Validator::make($record, $this->getRules());

            if (!$validator->fails()) {
                $validatedRecords[] = $record;
                continue;
            }

            $this->errors[] = [
                'record' => $offset,
                'errors' => $validator->errors()->all(),
            ];
        }

        return $this->errors ?? $validatedRecords;
    }

    /**
     * @param $fileRecords
     * @return array|null
     */
    protected function validateOnce($fileRecords): ?array
    {
        $validatedRecords = [];

        foreach ($fileRecords as $offset => $record) {
            $validator = Validator::make($record, $this->getRules());

            $validatedRecords[] = $record;

            if ($validator->fails()) {
                $this->errors[] = [
                    'record' => $offset,
                    'errors' => $validator->errors()->all(),
                ];

                return $this->errors;
            }
        }

        return $this->errors ?? $validatedRecords;
    }

    /**
     * @param array $data
     * @return bool
     */
    protected function hasErrors(array $data): bool
    {
        return array_key_exists('errors', $data) || !empty($data);
    }

    /**
     * @param DataTransferObjectInterface $dataTransferObject
     * @return mixed
     * @throws \Throwable
     */
    protected function validateLogicalRules(DataTransferObjectInterface $dataTransferObject): mixed
    {
        throw_if(empty($this->getLogicalValidators()), new EmptyLogicalValidationException());

        foreach ($this->getLogicalValidators() as $logicalValidator) {
            $logicalValidator = new $logicalValidator();
            $validatedData = $logicalValidator->validate($dataTransferObject);

            if ($this->hasErrors($validatedData)) {
                return $validatedData;
            }
        }

        return true;
    }

    /**
     * @return array|null
     */
    public function getLogicalValidators(): ?array
    {
        return $this->logicalValidators;
    }

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
}
