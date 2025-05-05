<?php
namespace App\Http\Resources;

use App\Libraries\AppLibrary;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\PurchaseItemResource;


class PurchaseOrdersResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // $sortedPurchaseItems = collect($this->purchaseItems)->sortBy('id')->values()->all(); // Change 'name' to 'id' if needed
        return [
            'id'          => $this->id,
            'date'        => AppLibrary::datetime($this->date),
            'supplier_id' => $this->supplier_id,
            'supplier'    => [
                'id'   => $this->supplier->id ?? null,
                'name' => $this->supplier->name ?? null,
            ],
            'branch_id'   => $this->branch_id,
            'branch'      => [
                'id'   => $this->branch->id ?? null,
                'name' => $this->branch->name ?? null,
            ],
            'created_at'  => $this->created_at,
            'updated_at'  => $this->updated_at,
            // 'items' => $sortedPurchaseItems,
            'items'       => PurchaseItemResource::collection(
                $this->purchaseItems->sortBy('id')->values()
            ),

        ];
    }
}
