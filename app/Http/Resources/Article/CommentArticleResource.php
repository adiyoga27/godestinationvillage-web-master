<?php

namespace App\Http\Resources\Article;

use Illuminate\Http\Resources\Json\JsonResource;

class CommentArticleResource extends JsonResource
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
            'user_id' => $this->users->id,
            'user_name' => $this->users->name,
            'user_avatar' => $this->users->avatar,
            'comment' => $this->comment,
            'likes' => json_decode($this->likes ) ?? [] ,
            'replies' => CommentArticleResource::collection($this->replies)
        ];
    }
}
