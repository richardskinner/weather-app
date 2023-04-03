<?php

namespace App\Rules;

use App\Models\City;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CityShouldNotExist implements ValidationRule
{

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (City::where('city', $value)->exists()) {
            $fail('The city already exists.');
        }
    }
}
