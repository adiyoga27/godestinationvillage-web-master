<?php

namespace App\Http\Resources\V2\Homestay;

use Illuminate\Http\Resources\Json\JsonResource;

class HomestayResource extends JsonResource
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
            'category_id' => $this->category_id,
            'category_name' => $this->category->name,
            'name' => $this->name,
            'description' => $this->description,
            'location' => $this->location,
            'price' => $this->price,
            'disc' => $this->disc,
            'facilities' => $this->facilities,
            'is_breakfast' => $this->is_breakfast,
            'additional_activities' => $this->additional_activities,
            'owner_name' => $this->owner_name,
            'check_in_time' => $this->check_in_time,
            'check_out_time' => $this->check_out_time,
            'additional_notes' => $this->additional_notes,
            'default_img' => url('storage/homestay')."/".$this->default_img,
            'check_out_time' => $this->check_out_time,
            'slug' => $this->slug,
            'created_at' => $this->created_at
        ];
    }
}
