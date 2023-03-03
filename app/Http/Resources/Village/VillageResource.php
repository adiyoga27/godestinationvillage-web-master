<?php

namespace App\Http\Resources\Village;

use App\Http\Resources\User\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class VillageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'village_name' => $this->village_name,
            'village_address' => $this->village_address,
            'lat' => $this->lat,
            'lng' => $this->lng,
            'contact_person' => $this->contact_person,
            'desc' => $this->desc,
            'bank_name' => $this->bank_name,
            'bank_acc_name' => $this->bank_acc_name,
            'bank_acc_no' => $this->bank_acc_no,
        ];
    }
}
