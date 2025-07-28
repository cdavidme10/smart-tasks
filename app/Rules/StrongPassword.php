<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rules\Password as PasswordRule;

class StrongPassword implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $rule = PasswordRule::min(8)
            ->letters()
            ->mixedCase()
            ->numbers()
            ->symbols()
            ->uncompromised();

        $validator = validator(
            [$attribute => $value],
            [$attribute => $rule]
        );

        if ($validator->fails()) {
            $fail('The :attribute must be at least 8 characters and contain letters, mixed case, numbers, symbols, and not be compromised.');
        }
    }
}
