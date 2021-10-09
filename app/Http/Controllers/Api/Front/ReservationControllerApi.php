<?php

namespace App\Http\Controllers\Api\Front;

use App\Http\Controllers\Controller;
use App\Http\Resources\Transaction\TransactionCollection;
use App\Models\Order;
use App\Traits\JsonResponseTrait;

class ReservationControllerApi extends Controller
{
    use JsonResponseTrait;

    
    public function reservationUnpaid($email)
    {

        $data= Order::where('payment_status', NULL)
        ->with('package')

            ->where('customer_email', $email)

            ->orderBy('id', 'desc')

            ->paginate(10);

        $result = new TransactionCollection($data);
        return $this->responseCollection($result);
    }

    public function reservationPaid($email)
    {
        
        $data= Order::where('payment_status', 'success')
        ->with('package')

            ->where('customer_email', $email)

            ->orderBy('id', 'desc')

            ->paginate(10);

        $result = new TransactionCollection($data);
        return $this->responseCollection($result);
        // $data['order'] = Order::whereNotNull('payment_type')
        //     ->where('customer_email', $email)
        //     ->orderBy('id', 'desc')
        //     ->get();
        // $data['isiemail'] = $email;
        // return $this->responseDataMessage($data);
    }

    public function reservationCancel($email)
    {
        $data= Order::where('payment_status', 'cancel')
        ->with('package')

            ->where('customer_email', $email)

            ->orderBy('id', 'desc')

            ->paginate(10);

        $result = new TransactionCollection($data);
        return $this->responseCollection($result);
    }

    public function reservationPaypal($email)
    {
        $data['order'] = Order::where('payment_type', 'paypal')
            ->where('customer_email', $email)
            ->orderBy('id', 'desc')
            ->get();
        $data['isiemail'] = $email;
        return $this->responseDataMessage($data);
    }

    public function reservationBank($email)
    {
        $data['order'] = Order::where('payment_type', 'bank_transfer')
            ->where('customer_email', $email)
            ->orderBy('id', 'desc')
            ->get();
        $data['isiemail'] = $email;
        return $this->responseDataMessage($data);
    }

   

}
