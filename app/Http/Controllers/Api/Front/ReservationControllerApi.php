<?php

namespace App\Http\Controllers\Api\Front;

use App\Http\Controllers\Controller;
use App\Http\Resources\Transaction\TransactionCollection;
use App\Models\Order;
use App\Models\OrderEvent;
use App\Models\OrderHomestay;
use App\Traits\JsonResponseTrait;

class ReservationControllerApi extends Controller
{
    use JsonResponseTrait;

    
    public function reservationUnpaid($email)
    {

        $orderTours = Order::where('payment_status', NULL)
            ->with('package')
            ->where('customer_email', $email)
            ->orderBy('id', 'desc');
        $orderEvents = OrderEvent::where('payment_status', 'pending')
            ->with('package')
            ->where('customer_email', $email)
            ->orderBy('id', 'desc');
        $orderHomestay = OrderHomestay::where('payment_status', 'pending')
            ->with('package')
            ->where('customer_email', $email)
            ->orderBy('id', 'desc');

        $data = [
            'orderTours' => $orderTours,
            'orderEvents' => $orderEvents,
            'orderHomestay' => $orderHomestay,
        ];
        return $this->responseDataMessage($data);
        
    }

    public function reservationPaid($email)
    {
        
      $orderTours = Order::where('payment_status', 'success')
            ->with('package')
            ->where('customer_email', $email)
            ->orderBy('id', 'desc')
            ->paginate(10);
        $orderEvents = OrderEvent::where('payment_status', 'success')
            ->with('package')
            ->where('customer_email', $email)
            ->orderBy('id', 'desc')
            ->paginate(10);
        $orderHomestay = OrderHomestay::where('payment_status', 'success')
            ->with('package')
            ->where('customer_email', $email)
            ->orderBy('id', 'desc')
            ->paginate(10);

        $data = [
            'orderTours' => $orderTours,
            'orderEvents' => $orderEvents,
            'orderHomestay' => $orderHomestay,
        ];
        return $this->responseDataMessage($data);
        // $data['order'] = Order::whereNotNull('payment_type')
        //     ->where('customer_email', $email)
        //     ->orderBy('id', 'desc')
        //     ->get();
        // $data['isiemail'] = $email;
        // return $this->responseDataMessage($data);
    }

    public function reservationCancel($email)
    {
        

          $orderTours = Order::where('payment_status', 'cancel')
            ->with('package')
            ->where('customer_email', $email)
            ->orderBy('id', 'desc')
            ->paginate(10);
        $orderEvents = OrderEvent::where('payment_status', 'cancel')
            ->with('package')
            ->where('customer_email', $email)
            ->orderBy('id', 'desc')
            ->paginate(10);
        $orderHomestay = OrderHomestay::where('payment_status', 'cancel')
            ->with('package')
            ->where('customer_email', $email)
            ->orderBy('id', 'desc')
            ->paginate(10);

        $data = [
            'orderTours' => $orderTours,
            'orderEvents' => $orderEvents,
            'orderHomestay' => $orderHomestay,
        ];
        return $this->responseDataMessage($data);
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
