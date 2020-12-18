<?php

namespace App\User\Rule;

use Illuminate\Contracts\Validation\Rule;

class PasswordRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $pattern = "/^[A-Za-z0-9()#\\/ \;\.\:\(\)]{7,25}$/";

        return preg_match($pattern, $value);

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Length must be between 7 and 25 chars,
        Allowed chars are: uppercase letters, downcase letters,
        numbers, (,), \, /, #, -';
    }
}
