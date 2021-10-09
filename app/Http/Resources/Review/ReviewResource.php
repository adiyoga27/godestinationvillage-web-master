<?php

namespace App\Http\Resources\Review;

use App\Http\Resources\User\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
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
            "user_id"=>$this->user_id,
            "package_id"=>$this->package_id,
            "rating"=>$this->rating,
            "comment"=>$this->comment,
            "users"=>$this->users
          
        ];
    }
}
