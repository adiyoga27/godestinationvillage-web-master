<?php

namespace App\Http\Resources\Packages;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PackageCollection extends ResourceCollection
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
            'data' => $this->collection, 
            'pagination' => $this->paginate($request),
            'status' => true,
            'messages' => 'Success'
         ]; 
    }

    
    public function paginate($request)
    {
        return [
            'path' => url($request->path()),
            'first_page_url' => url($request->path().'?page=1'),
            'prev_page_url' => $this->previousPageUrl(),
            'next_page_url' => $this->nextPageUrl(),
            'last_page_url' => url($request->path().'?page='.$this->lastPage()),
            'current_page_url' => url($request->path().'?page='.$this->currentPage()),
            'total' => $this->total(),
            'count' => $this->count(),
            'per_page' => $this->perPage(),
            'current_page' => $this->currentPage(),
            'total_pages' => $this->lastPage()
        ];
    }
    
}
