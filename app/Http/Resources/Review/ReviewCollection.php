<?php

namespace App\Http\Resources\Review;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ReviewCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
      /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public $collects = ReviewResource::class;
    public function toArray($request)
    {
        return  [
            'data' => $this->collection, 
            'status' => true,
            'messages' => 'Success'
         ]; 
    }

    
 
}
