<?php

namespace App\Http\Resources;
use App\Libraries\AppLibrary;
use Illuminate\Http\Resources\Json\JsonResource;

class SupplierResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'country' => $this->country,
            'city' => $this->city,
            'address' => $this->address,
            'created_at' => $this->created_at,
            'datetime' => AppLibrary::datetime($this->created_at),
            'updated_at' => $this->updated_at,
        ];
    }
}
