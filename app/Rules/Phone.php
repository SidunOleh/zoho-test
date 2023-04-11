<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Phone implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $pattern = '^([\+]?)(?![\.-])(?>(?>[\.-]?[ ]?[\da-zA-Z]+)+|([ ]?\((?![\.-])(?>[ \.-]?[\da-zA-Z]+)+\)(?![\.])([ -]?[\da-zA-Z]+)?)+)+(?>(?>([,]+)?[;]?[\da-zA-Z]+)+)?[;]?$';
        if (! preg_match("/$pattern/", $value)) {
            $fail('The :attribute is inavalid.');
        }
    }
}
