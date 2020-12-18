<?php

namespace App\User\Rule;

use Illuminate\Contracts\Validation\Rule;

class MailRule implements Rule
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
        $pattern = "/^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,4}$/";
        return preg_match($pattern, $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Inserted mail is not properly formatted';
    }
}
