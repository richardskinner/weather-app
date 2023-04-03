<?php

namespace App\Http\Requests;

use App\Http\Enums\HttpStatusCodes;
use App\Rules\CityShouldNotExist;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'city' => ['required', 'string', new CityShouldNotExist()]
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => 'error',
            'message' => 'Validation Errors',
            'data' => $validator->errors(),
        ], HttpStatusCodes::STATUS_BAD_REQUEST->value));
    }
}
