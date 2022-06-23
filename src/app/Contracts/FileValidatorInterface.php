<?php

namespace App\Contracts;

interface FileValidatorInterface
{
    /**
     * @param array $array
     * @return void
     */
    public function setRules(array $array): void;

    /**
     * @return array
     */
    public function getRules(): array;
}
