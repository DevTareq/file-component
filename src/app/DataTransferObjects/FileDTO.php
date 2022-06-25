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

    /** @var ?string $fileCategory */
    protected ?string $fileCategory;

    /** @var array|null $validatedRecords */
    protected ?array $validatedRecords;

    /**
     * @param Request $request
     * @return $this
     */
    public function createFromRequest(Request $request): self
    {
        $this->fileInput = $request->file('file');
        $this->fileCategory = $request->get('category');
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
     * @return $this
     */
    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
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
     * @return $this
     */
    public function setExtension(string $extension): self
    {
        $this->extension = $extension;

        return $this;
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
     * @return $this
     */
    public function setFileInput(object $fileInput): self
    {
        $this->fileInput = $fileInput;

        return $this;
    }

    /**
     * @return ?string
     */
    public function getFileCategory(): ?string
    {
        return $this->fileCategory;
    }

    /**
     * @param ?string $fileCategory
     * @return $this
     */
    public function setFileCategory(?string $fileCategory): self
    {
        $this->fileCategory = $fileCategory;

        return $this;
    }

    /**
     * @return ?array
     */
    public function getValidatedRecords(): ?array
    {
        return $this->validatedRecords;
    }

    /**
     * @param ?array $data
     * @return $this
     */
    public function setValidatedRecords(?array $data): self
    {
        $this->validatedRecords = $data;

        return $this;
    }
}
