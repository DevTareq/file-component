<?php

namespace App\DataTransferObjects;

use App\Contracts\DataTransferObjectInterface;
use Illuminate\Http\Request;

class FileDTO implements DataTransferObjectInterface
{
    /** @var ?string $path */
    protected ?string $path = null;

    /** @var ?string $extension */
    protected ?string $extension = null;

    /** @var ?object $fileInput */
    protected ?object $fileInput = null;

    /**
     * @param Request $request
     * @return $this
     */
    public function createFromRequest(Request $request): self
    {
        $this->fileInput = $request->file('file');
        $this->extension = $request->file('file')->getClientOriginalExtension();

        return $this;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @param string $path
     */
    public function setPath(string $path): void
    {
        $this->path = $path;
    }

    /**
     * @return string
     */
    public function getExtension(): string
    {
        return $this->extension;
    }

    /**
     * @param string $extension
     */
    public function setExtension(string $extension): void
    {
        $this->extension = $extension;
    }

    /**
     * @return object
     */
    public function getFileInput(): object
    {
        return $this->fileInput;
    }

    /**
     * @param object $fileInput
     */
    public function setFileInput(object $fileInput): void
    {
        $this->fileInput = $fileInput;
    }
}
