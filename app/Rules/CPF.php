<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CPF implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (strlen($value) != 11) {
            $fail('The cpf field must be 11 digits.');
            return;
        }

        if (preg_match('/(\d)\1{10}/', $value)) {
            $fail('Invalid CPF.');
            return;
        }

        for ($digitIndex = 9; $digitIndex < 11; $digitIndex++) {
            for ($sum = 0, $position = 0; $position < $digitIndex; $position++) {
                $sum += $value[$position] * (($digitIndex + 1) - $position);
            }
            $validatedDigit = ((10 * $sum) % 11) % 10;
            if ($value[$position] != $validatedDigit) {
                $fail('Invalid CPF.');
                return;
            }
        }
        
    }
}
