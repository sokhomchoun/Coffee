<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
// use Illuminate\Validation\Rule;
use Illuminate\Validation\Rule;

class PurchaseOrdersRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [

            'date'               => ['required', 'date'],
            'supplier_id'        => ['required', 'exists:suppliers,id'],
            'branch_id'          => ['required', 'exists:branches,id'],
            'items'              => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'exists:products,id'],
            'items.*.unit'       => ['required', 'exists:units,id'],
            'items.*.qty'        => ['required', 'numeric', 'min:1'],
        ];
    }
}
