<?php

namespace App\Modules\Locations\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class StoreLocationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /** @return array<string, mixed> */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:160'],
            'organization_id' => ['prohibited'],
        ];
    }
}
