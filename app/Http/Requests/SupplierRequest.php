<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SupplierRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name'        => [
                'required',
                'string',
                'max:190',
                Rule::unique('suppliers', 'name')->ignore($this->id)
            ],
            'email'        => [
                'required',
                'email',
                'max:190',
                Rule::unique('suppliers', 'email')->ignore($this->id)
            ],
            'phone_number' => [
                'required',
                'regex:/^0[0-9]{8,9}$/',
                Rule::unique('suppliers', 'phone_number')->ignore($this->id)
            ],
            'country' => ['required', 'string', 'max:190'],
            'city'    => ['required', 'string', 'max:190'],
            'address' => ['required', 'string', 'max:190'],
        ];
    }
}
