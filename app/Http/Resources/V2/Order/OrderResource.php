<?php

namespace App\Http\Resources\V2\Order;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'invoice' => $this->code,
            'customer_name' => $this->customer_name,
            'customer_address' => $this->customer_address,
            'customer_phone' => $this->customer_phone,
            'customer_email' => $this->customer_email,
            'category_tour' => $this->village_name,
            'tour_name' => $this->package_name,
            'tour_price' => $this->package_price,
            'tour_discount' => $this->package_discount,
            'qty' => $this->pax,
            'checkin_date' => $this->checkin_date,
            'note' => $this->special_note,
            'total_payment' => $this->total_payment,
            'payment_type' => $this->payment_type,
            'payment_date' => $this->payment_date,
            'payment_status' => $this->payment_status,
            'snap_token' => $this->snap_token,
            'uuid' => $this->uuid
        ];
    }
}
