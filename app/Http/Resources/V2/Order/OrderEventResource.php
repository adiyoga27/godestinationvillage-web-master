<?php

namespace App\Http\Resources\V2\Order;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderEventResource extends JsonResource
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
            'event_name' => $this->event_name,
            'event_price' => $this->event_price,
            'event_discount' => $this->event_discount,
            'qty' => $this->pax,
            'note' => $this->special_note,
            'total_payment' => $this->total_payment,
            'payment_type' => $this->payment_type,
            'payment_date' => $this->payment_date,
            'payment_status' => $this->payment_status,
            'snap_token' => $this->snap_token,
            'uuid' => $this->uuid,
            'link_payment' => url('api/v2/payment')."/".$this->snap_token


        ];
    }
}