<?php

namespace App\Http\Resources\V2;

use Illuminate\Http\Resources\Json\JsonResource;

class AuthResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */

     protected $token;

     // Tambahkan parameter token di konstruktor
     public function __construct($resource, $token = null)
     {
         parent::__construct($resource);
         $this->token = $token;
     }

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'role_id' => $this->role_id,
            'phone' => $this->phone,
            'country' => $this->country,
            'address' => $this->address,
            'avatar' => url('storage/users')."/".$this->avatar,
            'token' => $this->token
        ];
    }
}
