<?php

namespace App\Http\Resources\Transaction;

use App\Http\Resources\Packages\PackageResource;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
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
            "id"=> $this->id,
            "village_id"=> $this->village_id,
            "package_id"=> $this->package_id,
            "user_id"=> $this->user_id,
            "bank_account_id"=> $this->bank_account_id,
            "code"=> $this->code,
            "village_name"=> $this->village_name,
            "package_name" => $this->package_name,
            "customer_name"=> $this->customer_name,
            "customer_address"=> $this->customer_address,
            "customer_phone"=> $this->customer_phone,
            "customer_email"=> $this->customer_email,
            "package_price"=> $this->package_price,
            "package_discount"=> $this->package_discount,
            "total_payment"=> $this->total_payment,
            "payment_type"=> $this->payment_type,
            "payment_date"=> $this->payment_date,
            "payment_status"=> $this->payment_status,
            "bank_name"=> $this->bank_name,
            "bank_acc_name"=> $this->bank_acc_name,
            "bank_acc_no"=> $this->bank_acc_no,
            "payment_img"=> $this->payment_img,
            "pax"=> $this->pax,
            "special_note"=> $this->special_note,
            "checkin_date"=> $this->checkin_date,
            "created_at"=> $this->created_at,
            "updated_at"=> $this->updated_at,
            "deleted_at"=> $this->deleted_at,
            "sms_status"=> $this->sms_status,
            "package"=> new PackageResource($this->package)
        ];
    }
}
