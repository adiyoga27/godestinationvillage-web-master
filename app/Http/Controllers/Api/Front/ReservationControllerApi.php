<?php

namespace App\Http\Controllers\Api\Front;

use App\Http\Controllers\Controller;
use App\Http\Resources\Transaction\EventOrderResource;
use App\Http\Resources\Transaction\HomestayOrderResource;
use App\Http\Resources\Transaction\TourOrderResource;
use App\Http\Resources\Transaction\TransactionCollection;
use App\Models\Event;
use App\Models\Homestay;
use App\Models\Order;
use App\Models\OrderEvent;
use App\Models\OrderHomestay;
use App\Traits\JsonResponseTrait;

class ReservationControllerApi extends Controller
{
    use JsonResponseTrait;

    
    public function reservationUnpaid($email)
    {

        $orderTours = Order::where('payment_status', 'pending')
            ->with('package')
            ->where('customer_email', $email)
            ->orderBy('id', 'desc')->get();
        $orderEvents = OrderEvent::where('payment_status', 'pending')
            ->with('package')
            ->where('customer_email', $email)
            ->orderBy('id', 'desc')->get();
        $orderHomestay = OrderHomestay::where('payment_status', 'pending')
            ->with('package')
            ->where('customer_email', $email)
            ->orderBy('id', 'desc')->get();

        $data = [
            'orderTours' => TourOrderResource::collection($orderTours),
            'orderEvents' => EventOrderResource::collection($orderEvents),
            'orderHomestay' => HomestayOrderResource::collection($orderHomestay),
        ];
        return $this->responseDataMessage($data);
        
    }

    public function detailReservation($type, $uuid)
    {
        if ($type == 'tour') {
            $order = Order::where('uuid', $uuid)->with('package')->first();
            return $this->responseDataMessage(new TourOrderResource($order));
        } elseif ($type == 'event') {
            $order = OrderEvent::where('uuid', $uuid)->with('package')->first();
            return $this->responseDataMessage(new EventOrderResource($order));
        } elseif ($type == 'homestay') {
            $order = OrderHomestay::where('uuid', $uuid)->with('package')->first();
            return $this->responseDataMessage(new HomestayOrderResource($order));
        } else {
            return $this->responseDataMessage('Invalid type');
        }
    }

    public function reservationPaid($email)
    {
        
      $orderTours = Order::where('payment_status', 'success')
            ->with('package')
            ->where('customer_email', $email)
            ->orderBy('id', 'desc')->get();
        $orderEvents = OrderEvent::where('payment_status', 'success')
            ->with('package')
            ->where('customer_email', $email)
            ->orderBy('id', 'desc')->get();
        $orderHomestay = OrderHomestay::where('payment_status', 'success')
            ->with('package')
            ->where('customer_email', $email)
            ->orderBy('id', 'desc')->get();
         $data = [
            'orderTours' => TourOrderResource::collection($orderTours),
            'orderEvents' => EventOrderResource::collection($orderEvents),
            'orderHomestay' => HomestayOrderResource::collection($orderHomestay),
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
            ->orderBy('id', 'desc')->get();
        $orderEvents = OrderEvent::where('payment_status', 'cancel')
            ->with('package')
            ->where('customer_email', $email)
            ->orderBy('id', 'desc')->get();
        $orderHomestay = OrderHomestay::where('payment_status', 'cancel')
            ->with('package')
            ->where('customer_email', $email)
            ->orderBy('id', 'desc')->get();
        $data = [
            'orderTours' => TourOrderResource::collection($orderTours),
            'orderEvents' => EventOrderResource::collection($orderEvents),
            'orderHomestay' => HomestayOrderResource::collection($orderHomestay),
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
