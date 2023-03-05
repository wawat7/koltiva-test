<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidBase64Rule implements Rule
{
    public function passes($attribute, $value)
    {
        return base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $value), true) !== false;
    }

    public function message()
    {
        return 'The :attribute must be a valid base64 encoded string.';
    }
}
