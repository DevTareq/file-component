<?php

namespace App\Validators\Requests;

use App\Contracts\Abstracts\AbstractRequestValidator;

class FileUploadRequestValidator extends AbstractRequestValidator
{
    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'file' => 'file|required',
            'category' => 'string|required|max:50',
        ];
    }

    /**
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'file.required' => 'File input is required.',
            'category.required' => 'Category is required.',
        ];
    }
}
