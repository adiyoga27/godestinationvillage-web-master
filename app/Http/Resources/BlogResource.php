<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
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
            "post_title"=>$this->post_title,
            "post_content"=>$this->post_content,
            "post_thumbnail"=>url('storage/blogs/')."/".$this->post_thumbnail,
            "post_author"=>$this->post_author,
            "post_tags"=>$this->post_tags,
            "isPublished"=>$this->isPublished,
            "last_updated"=>$this->last_updated,
            "updated_by"=>$this->updated_by,
            "created_at"=>$this->created_at
        ];
    }
}
