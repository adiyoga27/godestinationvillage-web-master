<?php

namespace App\Http\Resources\V2;

use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
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
            'post_title' => $this->post_title,
            'post_content' => $this->post_content,
            'post_thumbnail' => url('storage/blogs/')."/".$this->post_thumbnail,
            'post_author' => $this->post_author,
            'slug' => $this->slug,
            'created_at' => $this->created_at,
            'liked_by' => json_encode($this->liked_by),
        ];
    }
}
