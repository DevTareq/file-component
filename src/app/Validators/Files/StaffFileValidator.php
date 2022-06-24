<?php

namespace App\Validators\Files;

use App\Contracts\Abstracts\AbstractFileValidator;
use App\Contracts\DataTransferObjectInterface;
use App\Contracts\FileReaderInterface;
use App\Validators\Logics\StaffOutletPasscodeValidator;

class StaffFileValidator extends AbstractFileValidator
{
    protected ?array $logicalValidators = [
        StaffOutletPasscodeValidator::class,
    ];

    protected array $rules = [
        'staff_name' => 'string|required|max:255',
        'display_name' => 'string|nullable|max:255',
        'passcode' => 'numeric|required|digits_between:0,10',
        'is_manager' => 'numeric|nullable|max:1|gte:0',
        'display_order' => 'numeric|nullable|digits_between:1,4',
        'shareable' => 'numeric|nullable|max:1|gte:0',
        'is_courier' => 'numeric|nullable|max:1|gte:0',
        'email' => 'string|email|nullable|max:255',
        'mobile' => 'numeric|nullable|digits_between:1,255',
        'staff_permissions' => 'string|nullable',
        'staff_image' => 'string|nullable',
        'staff_meta' => 'string|nullable',
        'active' => 'numeric|nullable|max:1|gte:0',
    ];

    /**
     * @param DataTransferObjectInterface $dataTransferObject
     * @param FileReaderInterface $fileReader
     * @return array|null
     * @throws \Throwable
     */
    public function validate(DataTransferObjectInterface $dataTransferObject, FileReaderInterface $fileReader): ?array
    {
        $fileRecords = $fileReader->fetchAll($dataTransferObject->getFileInput());

        $results = $this->validateMultiple($fileRecords);

        if (!$this->hasErrors($results)) {
            $dataTransferObject->setValidatedRecords($results);

            $this->validateLogicalRules($dataTransferObject);
        }

        return $results;
    }
}
