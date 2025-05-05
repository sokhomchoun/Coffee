<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VariationResource extends JsonResource
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
        // Sort the 'type' array by 'name' or 'id'
        $sortedTypes = collect($this->type)->sortBy('name')->values()->all(); // Change 'name' to 'id' if needed
        return [
            'id' => $this->id,
            'name' => $this->name,
            // 'type' => VariationTypeResource::collection($this->whenLoaded('type')), // Ensure the related types are loaded
            'type' => $sortedTypes,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
