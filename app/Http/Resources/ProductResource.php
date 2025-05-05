<?php

namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request) : array
    {
        return [
            "id"            => $this->id,
            "name"          => $this->name,
            "category_id"   => $this->category_id,
            "brand_id"      => $this->brand_id,
            "branch_id"     => $this->branch_id,
            "unit_id"       => $this->unit_id,
            "product_cost"  => $this->product_cost,
            "stock_alert"   => $this->stock_alert,
        ];
    }
}
