<?php

namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class StockAlertResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'         => $this->id,
            'product_id' => $this->product_id,
            'name'       => $this->name,
            'qty'        => $this->qty,
            'unit_id'    => $this->unit_id,
        ];
    }
}
