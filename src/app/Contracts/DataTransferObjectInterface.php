<?php

namespace App\Contracts;

use Illuminate\Http\Request;

interface DataTransferObjectInterface
{
    /**
     * @param Request $request
     * @return DataTransferObjectInterface
     */
    public function createFromRequest(Request $request): DataTransferObjectInterface;
}
