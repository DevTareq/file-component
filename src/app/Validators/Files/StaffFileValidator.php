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
        'passcode' => 'integer|required|min:0', //unique
        'is_manager' => 'integer|required|max:1',
        'display_order' => 'integer|required|digits_between:1,4',
        'shareable' => 'integer|required|max:1',
        'is_courier' => 'integer|required|max:1',
        'email' => 'string|email|required|max:255',
        'mobile' => 'string|digits_between:1,255',
        'staff_permissions' => 'string|nullable',
        'staff_image' => 'string|nullable',
        'staff_meta' => 'string|nullable',
        'active' => 'integer|nullable|max:1',
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
