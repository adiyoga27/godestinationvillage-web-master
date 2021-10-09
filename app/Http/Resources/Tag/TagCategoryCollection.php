<?php

namespace App\Http\Resources\Tag;

use Illuminate\Http\Resources\Json\ResourceCollection;

class TagCategoryCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public $collects = TagResource::class;
    public function toArray($request)
    {
        return  [
            'data' => $this->collection, 
          
          'status' =>true,
          'messages' => "Success"
        ]; 
    }

}
