<?php

namespace App\Validators\Logics;

use App\Contracts\DataTransferObjectInterface;
use App\Contracts\LogicalValidatorInterface;
use App\Exceptions\Logics\LogicalValidationException;

class StaffOutletPasscodeValidator implements LogicalValidatorInterface
{
    /**
     * @param DataTransferObjectInterface $dataTransferObject
     * @return mixed
     * @throws \Exception
     */
    public function validate(DataTransferObjectInterface $dataTransferObject): mixed
    {
//        return ['anything' => 'something'];

        throw new LogicalValidationException('did not pass the additional validation', 400);
    }
}
