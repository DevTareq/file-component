<?php

namespace App\Contracts;

use Illuminate\Http\Request;

interface FileManagerInterface
{
    /**
     * @param DataTransferObjectInterface $dataTransferObject
     * @return mixed
     */
    public function process(DataTransferObjectInterface $dataTransferObject): mixed;

    /**
     * @param DataTransferObjectInterface $dataTransferObject
     * @return FileManagerInterface
     */
    public function upload(DataTransferObjectInterface $dataTransferObject): FileManagerInterface;
}
