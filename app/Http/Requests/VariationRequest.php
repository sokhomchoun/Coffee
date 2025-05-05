<?php

namespace App\Http\Requests;

use App\Rules\IniAmount;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VariationRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'type' => 'required|array',
            'type.*.id' => 'nullable|integer', // id is optional and must be an integer if present
            'type.*.name' => 'required|string|max:255', // name must be a string and is required
        ];
    }

    public function attributes()
    {
        return [
            'id' => strtolower(trans('all.label.id')),
        ];
    }
}
