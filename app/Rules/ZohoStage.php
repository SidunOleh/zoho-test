<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ZohoStage implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $bool = in_array( $value, [
            'Qualification',
            'Needs Analysis',
            'Value Proposition',
            'Identify Decision Makers',
            'Proposal/Price Quote',
            'Negotiation/Review',
            'Closed Won',
            'Closed Lost',
            'Closed-Lost to Competition',
        ]);

        if (! $bool) {
            $fail('The :attribute is inavalid.');
        }
    }
}
