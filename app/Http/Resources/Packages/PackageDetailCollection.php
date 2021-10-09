<?php

namespace App\Http\Resources\Packages;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PackageDetailCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public $collects = PackageResource::class;
    public function toArray($request)
    {
        return  [
            'data' => $this->collection->first(), 
            'status' => true,
            'messages' => 'Success'
         ]; 
    }
}
