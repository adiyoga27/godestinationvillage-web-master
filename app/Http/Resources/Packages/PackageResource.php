<?php

namespace App\Http\Resources\Packages;

use App\Models\CategoryPackage;
use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\Tag\CategoryPackageResource;
use App\Http\Resources\Village\VillageResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class PackageResource extends JsonResource
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
            "price_disc"=>$this->price_disc,
            "default_img"=>url('storage/packages/')."/".$this->default_img,
            "is_active"=>$this->is_active,
            "category"=>new CategoryResource($this->category),
            "village"=> new VillageResource($this->village),
            "images"=> Storage::files('packages/'.$this->id),
          
        ];
    }
}
