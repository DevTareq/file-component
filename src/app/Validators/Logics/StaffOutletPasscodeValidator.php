<?php

namespace App\Validators\Logics;

use App\Contracts\DataTransferObjectInterface;
use App\Contracts\LogicalValidatorInterface;
use App\Exceptions\Logics\LogicalValidationException;
use Illuminate\Validation\ValidationException;

class StaffOutletPasscodeValidator implements LogicalValidatorInterface
{
    /**
     * @param DataTransferObjectInterface $dataTransferObject
     * @return mixed
     * @throws \Exception
     */
    public function validate(DataTransferObjectInterface $dataTransferObject): mixed
    {
        // TODO: Enter the logical rule here
//        return ['anything' => 'something'];

        throw new LogicalValidationException('did not pass the additional validation', 400);

        // @todo: for errors: throw new exceptions, similar to validation
    }
}
