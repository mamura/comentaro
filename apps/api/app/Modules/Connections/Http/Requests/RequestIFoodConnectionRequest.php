<?php

namespace App\Modules\Connections\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class RequestIFoodConnectionRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        if ($this->input('identifier_type') === 'cnpj') {
            $this->merge(['identifier' => preg_replace('/\D/', '', (string) $this->input('identifier'))]);
        }
    }

    public function authorize(): bool
    {
        return true;
    }

    /** @return array<string, mixed> */
    public function rules(): array
    {
        return [
            'identifier_type' => ['required', Rule::in(['merchant_id', 'cnpj'])],
            'identifier' => [
                'required',
                'string',
                'max:64',
                Rule::when($this->input('identifier_type') === 'cnpj', ['digits:14']),
            ],
            'location_id' => ['prohibited'],
            'organization_id' => ['prohibited'],
        ];
    }
}
