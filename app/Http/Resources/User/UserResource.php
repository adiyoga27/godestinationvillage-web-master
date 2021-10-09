<?php

namespace App\Http\Resources\User;

use App\Http\Resources\Village\VillageResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'country' => $this->country,
            'address' => $this->address,
            'avatar' => url('storage/users/')."/".$this->avatar,
            'village_name' => $this->village_detail->village_name,
            'village_address' => $this->village_detail->village_address,
            'lat' => $this->village_detail->lat,
            'lng' => $this->village_detail->lng,
            'contact_person' => $this->village_detail->contact_person,
            'desc' => $this->village_detail->desc,
            'bank_name' => $this->village_detail->bank_name,
            'bank_acc_name' => $this->village_detail->bank_acc_name,
            'bank_acc_no' => $this->village_detail->bank_acc_no,
        ];
    }
}
