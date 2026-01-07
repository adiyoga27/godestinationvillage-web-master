<?php

namespace App\Http\Resources\Transaction;

use Illuminate\Http\Resources\Json\JsonResource;

class TourOrderResource extends JsonResource
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
            'code' => $this->code,
            'village_name' => $this->village_name,
            'package_name' => $this->package_name,
            'customer_name' => $this->customer_name,
            'customer_email' => $this->customer_email,
            'customer_phone' => $this->customer_phone,
            'customer_address' => $this->customer_address,
            'package_price' => $this->package_price,
            'package_discount' => $this->package_discount,
            'total_payment' => $this->total_payment,
            'payment_type' => $this->payment_type,
            'payment_date' => $this->payment_date,
            'payment_status' => $this->payment_status,
            'special_note' => $this->special_note,
            'checkin_date' => $this->checkin_date,
            'created_at' => $this->created_at,
            'uuid' => $this->uuid,
            'snap_token' => $this->snap_token,
            'link_payment' => url('api/v2/payment')."/".$this->snap_token,

            'village_id' => $this->package->id,
            'thumbnail' => url('storage/packages')."/".$this->package->default_img,
            
        ];
    }
}
