<?php

namespace App\Http\Resources\Tag;

use Illuminate\Http\Resources\Json\JsonResource;

class TagPackageResource extends JsonResource
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
            "id"=>$this->id,
            "category_id"=>$this->category_id,
            "user_id"=>$this->user_id,
            "name"=>$this->name,
            "desc"=>$this->desc,
            "review"=>$this->review,
            "itenaries"=>$this->itenaries,
            "inclusion"=>$this->inclusion,
            "exclusion"=>$this->exclusion,
            "term"=>$this->term,
            "price"=>$this->price,
            "default_img"=>url('storage/packages/')."/".$this->default_img,
            "is_active"=>$this->is_active,
          
        ];
    }
}

