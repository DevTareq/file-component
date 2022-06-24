<?php

namespace App\Validators\Files;

use App\Contracts\Abstracts\AbstractFileValidator;
use App\Contracts\DataTransferObjectInterface;
use App\Contracts\FileReaderInterface;

class StaffFileValidator extends AbstractFileValidator
{
    protected array $rules = [
        'staff_name' => 'string|required|max:255',
        'display_name' => 'string|nullable|max:255',
        'passcode' => 'numeric|required|digits_between:0,10',
        'is_manager' => 'numeric|required|max:1|gte:0',
        'display_order' => 'numeric|required|digits_between:1,4',
        'shareable' => 'numeric|required|max:1|gte:0',
        'is_courier' => 'numeric|required|max:1|gte:0',
        'email' => 'string|email|required|max:255',
        'mobile' => 'numeric|digits_between:1,255',
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
        $this->isValidFile($dataTransferObject);

        $fileRecords = $fileReader->fetchAll($dataTransferObject->getFileInput());

        return $this->validateMultiple($fileRecords);
    }
}
