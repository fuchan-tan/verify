<?php

namespace App\Rules;

use Closure;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Contracts\Validation\ValidationRule;

class DNSValidation implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if(($value['type']!='') && ($value['location']!='') && ($value['key']!='')){
            $result = Http::get('https://dns.google/resolve', [
                'name' => $value['location'],
                'type' => 'TXT',
            ]);
            if(!Str::contains($result->body(), $value['key'])){
                $fail('invalid_issuer');

            }
        }
        else {
            $fail('invalid_issuer');
        }
    }
}
