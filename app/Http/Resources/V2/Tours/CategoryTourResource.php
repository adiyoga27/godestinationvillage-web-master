<?php

namespace App\Http\Resources\V2\Tours;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryTourResource extends JsonResource
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
            'name' => $this->village_name
        ];
    }
}
