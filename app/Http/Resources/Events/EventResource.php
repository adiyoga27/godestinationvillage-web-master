<?php

namespace App\Http\Resources\Events;

use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
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
            'price' => (float) $this->price,
            'disc' =>  $this->disc ?? (float) $this->disc,
            'location' => $this->location,
            'date_event' => $this->date_event,
            'duration' => $this->duration,
            'interary' => $this->interary,
            'inclusion' => $this->inclusion,
            'additional' => $this->additional,
            'default_img' => url('storage/events/') . "/" . $this->default_img,
            'is_active' => $this->is_active,
            'is_paywish' => $this->is_paywish,
            'is_free' => $this->is_free,
            'slug' => $this->slug,
        ];
    }
}
