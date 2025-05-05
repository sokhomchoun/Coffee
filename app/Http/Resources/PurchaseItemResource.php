<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id'         => $this->id,
            'qty'        => $this->qty,
            'product_id' => $this->product_id,
            'product'    => [
                'id'   => $this->product->id ?? null,
                'name' => $this->product->name ?? null,
            ],
            'quantity'=> $this->unit,
            'unit'       => [
                'id'   => $this->unit->id ?? null,
                'name' => $this->unit->name ?? null,
            ],
        ];
    }
}
