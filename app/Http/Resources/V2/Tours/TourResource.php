<?php

namespace App\Http\Resources\V2\Tours;

use Illuminate\Http\Resources\Json\JsonResource;

class TourResource extends JsonResource
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
            'category_name' => $this->villageDetail->village_name,
            'name' => $this->name,
            'description' => $this->desc,
            'review' => $this->review,
            'itenaries' => $this->itenaries,
            'inclusion' => $this->inclusion,
            'exclusion' => $this->exclusion,
            'term' => $this->term,
            'duration' => $this->duration,
            'preparation' => $this->preparation,
            'price' => $this->price,
            'disc' => $this->disc,
            'default_img' => url('storage/event')."/".$this->default_img,
            'slug' => $this->slug,
        ];
    }
}
