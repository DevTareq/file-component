<?php

namespace App\Validators\Rules;

use Illuminate\Contracts\Validation\Rule;

class DecimalRule implements Rule
{
    /**
     * @param int $digit
     * @param int $scale
     */
    public function __construct(
        public int $digit,
        public int $scale
    ) {}

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $pattern = "/^\d{1,". $this->digit ."}(\.\d". "{1," . $this->scale . "})?$/";

        return preg_match($pattern, $value);
    }

    public function message()
    {
        // TODO: Implement message() method.
    }
}
