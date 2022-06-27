<?php

namespace App\Contracts\Abstracts;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

abstract class AbstractRequestValidator
{
    protected bool $hasFailed = false;
    protected array $errors;

    /**
     * @return array
     */
    abstract public function rules(): array;

    /**
     * @return array
     */
    abstract public function messages(): array;

    /**
     * @param Request $request
     * @return mixed
     */
    public function validate(Request $request): mixed
    {
        $validator = Validator::make($request->all(), $this->rules(), $this->messages());

        if ($validator->fails()) {
            $this->setHasFailed(true);
            $this->setErrors($validator->errors()->all());
        }

        return $this;
    }

    /**
     * @param bool $hasFailed
     */
    public function setHasFailed(bool $hasFailed): void
    {
        $this->hasFailed = $hasFailed;
    }

    /**
     * @return bool
     */
    public function getHasFailed(): bool
    {
        return $this->hasFailed;
    }

    /**
     * @param array $data
     * @return void
     */
    public function setErrors(array $data): void
    {
        $this->errors = ['errors' => $data];
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
