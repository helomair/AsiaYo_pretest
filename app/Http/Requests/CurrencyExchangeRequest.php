<?php

namespace App\Http\Requests;

use Closure;
use Illuminate\Foundation\Http\FormRequest;

class CurrencyExchangeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'source' => 'string|required',
            'target' => 'string|required',
            'amount' => [
                'required',
                'string',
                function (string $attribute, mixed $value, Closure $fail) {
                    $checkingRegex = "/(\d)+([\.](\d)+)*/";
                    if ( strpos($value, ',') !== false ) {
                        $checkingRegex = "/(\d){1,3}([\,](\d){1,3})*([\.](\d)+)*/";
                    }

                    $matches = [];
                    preg_match($checkingRegex, $value, $matches);

                    if (empty($matches) || (strlen($matches[0]) !== strlen($value)))
                        $fail("Amount not valid");
                }
            ]
        ];
    }
}
