<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Http;

class RecaptchaV3 implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Send a POST request to Google's reCAPTCHA API
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => config('services.recaptcha.secret_key'),
            'response' => $value,
        ])->json();

        // Check if the verification was successful and the score is adequate
        // Note: A score of 1.0 is very likely a good interaction, 0.0 is very likely a bot
        if (!isset($response['success']) || !$response['success'] || $response['score'] < 0.5) {
            $fail('Google reCAPTCHA verification failed. Please try again.');
        }
    }
}
