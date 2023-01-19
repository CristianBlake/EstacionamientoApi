<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ParkingResource extends JsonResource
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
            'id'            => $this->id,
            'license_plate' => $this->license_plate,
            'category_id'   => $this->category_id,
            'entry'         => $this->entry,
            'exit'          => $this->exit,
            'amount'        => $this->amount
        ];
    }
}
