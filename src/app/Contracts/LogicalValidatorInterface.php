<?php

namespace App\Contracts;

interface LogicalValidatorInterface
{
    /**
     * @param DataTransferObjectInterface $dataTransferObject
     * @return mixed
     */
    public function validate(DataTransferObjectInterface $dataTransferObject): mixed;
}
