<?php

namespace App\Http\Resources\Village;

use App\Http\Resources\User\UserResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class VillageDetailCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public $collects = VillageResource::class;
    public function toArray($request)
    {
        return  [
            'data' => $this->collection->first(), 
            'status' =>true,
            'messages' => "Success"
         ]; 
    }

}
