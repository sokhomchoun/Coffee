<?php

namespace App\Http\Requests;

use App\Rules\IniAmount;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
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
            'category_id' => 'required|exists:item_categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'branch_id' => 'nullable|exists:branches,id',
            'unit_id' => 'nullable|exists:units,id',
            'product_cost' => 'nullable|numeric',
            'stock_alert' => 'nullable|integer',
        ];

    }

    public function attributes()
    {
        return [
            'id' => strtolower(trans('all.label.id')),
        ];
    }
}
