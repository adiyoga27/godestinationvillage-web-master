<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Http\Resources\V2\Order\OrderEventResource;
use App\Http\Resources\V2\Order\OrderHomestayResource;
use App\Http\Resources\V2\Order\OrderResource;
use App\Models\Event;
use App\Models\Homestay;
use App\Models\Order;
use App\Models\OrderEvent;
use App\Models\OrderHomestay;
use App\Models\Package;
use App\Services\Midtrans\CreateSnapTokenService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TransactionController extends Controller
{
    public function status(Request $request, $type) {
        $paymentStatus = 'pending';
        if($request->payment_status == 'paid'){
            $paymentStatus = 'success';
        }else if($request->payment_status == 'unpaid'){
            $paymentStatus = 'pending';
        }else{
            $paymentStatus = 'cancel';
        }
        if($type == 'event'){
            $data = OrderEvent::where('user_id', Auth::user()->id)
                    ->where('payment_status', $paymentStatus)
                    ->orderBy('id', 'DESC')->get();

            return OrderEventResource::collection($data)->additional([
                'status' => true,
                'message' => 'Success'
            ]);
        }else if($type == 'homestay'){
            $data = OrderHomestay::where('user_id', Auth::user()->id)
            ->where('payment_status', $paymentStatus)
            ->orderBy('id', 'DESC')->get();
                return OrderEventResource::collection($data)->additional([
                    'status' => true,
                    'message' => 'Success'
                ]);
        }else{
            $data = Order::where('user_id', Auth::user()->id)
            ->where('payment_status', $paymentStatus)
            ->orderBy('id', 'DESC')->get();
                return OrderResource::collection($data)->additional([
                    'status' => true,
                    'message' => 'Success'
                ]);
        }
    }

    public function invoice(Request $request, $type) {
        try {
            if($type == 'event'){
                $data = OrderEvent::where('user_id', Auth::user()->id)
                        ->where('uuid', $request->uuid)
                        ->orderBy('id', 'DESC')->first();
                return response()->json([
                    'status' => true,
                    'message' => false,
                    'data' => new OrderEventResource($data)
                ]);
            }else if($type == 'homestay'){
                $data = OrderHomestay::where('user_id', Auth::user()->id)
                    ->where('uuid', $request->uuid)
                    ->orderBy('id', 'DESC')->first();
                return response()->json([
                    'status' => true,
                    'message' => false,
                    'data' => new OrderHomestayResource($data)
                ]);
            }else{

                $data = Order::where('user_id', Auth::user()->id)
                    ->where('uuid', $request->uuid)
                    ->orderBy('id', 'DESC')->first();
                return response()->json([
                    'status' => true,
                    'message' => false,
                    'data' => new OrderResource($data)
                ]);
            }
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'status' => false,
                'message' => "Invoice Tidak ditemukan"
            ], 400);
        }
        
    }
    public function payment(Request $request, $snapToken) {
        return view('midtrans/payment', compact('snapToken'));
    }
    public function checkoutEvent(Request $request) {
        $request->validate([
            'event_id' => 'required',
            'customer_name' => 'required',
            'customer_address' => 'required',
            'customer_phone' => 'required',
            'customer_email' => 'required',
            'qty' => 'required',
            'special_note' => 'nullable',
        ]);
        $count =  OrderEvent::count();
        if ($count > 0) {
            $code = OrderEvent::latest()->first()->id + 1;
        } else {
            $code = 1;
        }
        $code = "EVT-".$code;
        $uuid = (string) Str::uuid();
        try {
            $event = Event::where('id', $request->event_id)->first();
        
            // $total = ($event->price - $event->disc) * $request->qty;

               if($event->disc >0 ){

                $total = ( $event->disc) * $request->qty;
            }else{
                $total = ( $event->price) * $request->qty;

            }
            $data = OrderEvent::create([
                'user_id' => Auth::user()->id,
                'event_id' => $request->event_id,
                'code' => $code,
                'customer_name' => $request->customer_name,
                'customer_address' => $request->customer_address,
                'customer_phone' => $request->customer_phone,
                'customer_email' => $request->customer_email,
                'pax' => $request->qty,
                'event_name' => $event->name,
                'event_price' => $event->price,
                'event_disc' => $event->disc,
                'total_payment' => $total,
                'payment_status' => 'pending',
                'payment_type' => 'bank_transfer',
                'uuid' =>  $uuid
            ]);

                // Jika snap token masih NULL, buat token snap dan simpan ke database

                $payload = [
                    'transaction_details' => [
                        'order_id' => $data->code,
                        'gross_amount' => $data->total_payment,
                    ],
                    'item_details' => [
                        [
                            'id' =>  $data->event_id,
                            'price' => ($data->event_disc > 0) ?  $data->event_disc : $data->event_price,
                            'quantity' => $data->pax,
                            'name' => Str::limit($data->event_name,30),
                        ],
                    ],
                    'customer_details' => [
                        'first_name' => $data->customer_name,
                        'email' => $data->customer_email,
                        'phone' => $data->customer_phone,
                    ]
                ];

                $midtrans = new CreateSnapTokenService($data);
                $snapToken = $midtrans->getSnapToken($payload);
                 OrderEvent::where('uuid', $data->uuid)->update([
                        'snap_token' => $snapToken
                ]);
                $order = OrderEvent::where('uuid', $data->uuid)->first();
               
                
            return response()->json([
                'status' => true,
                'message' => 'Success checkout',
                'data' => [
                    'invoice' => $data->code,
                    'snap_token' => $order->snap_token,
                    'link_payment' => url('api/v2/payment')."/".$order->snap_token
                ]
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function checkoutHomestay(Request $request) {
        $request->validate([
            'homestay_id' => 'required',
            'customer_name' => 'required',
            'customer_address' => 'required',
            'customer_phone' => 'required',
            'customer_email' => 'required',
            'qty' => 'required',
            'special_note' => 'nullable',
            'check_in' => 'required'
        ]);
        $count =  OrderHomestay::count();
        if ($count > 0) {
            $code = OrderHomestay::latest()->first()->id + 1;
        } else {
            $code = 1;
        }
        $code = "HTY-".$code;
        $uuid = (string) Str::uuid();
        try {
            $homestay = Homestay::where('id', $request->homestay_id)->first();
        
            // $total = ($homestay->price - $homestay->disc) * $request->qty;

             if($homestay->disc >0 ){

                $total = ( $homestay->disc) * $request->qty;
            }else{
                $total = ( $homestay->price) * $request->qty;

            }

            $data = OrderHomestay::create([
                'user_id' => Auth::user()->id,
                'homestay_id' => $request->homestay_id,
                'code' => $code,
                'customer_name' => $request->customer_name,
                'customer_address' => $request->customer_address,
                'customer_phone' => $request->customer_phone,
                'customer_email' => $request->customer_email,
                'pax' => $request->qty,
                'homestay_name' => $homestay->name,
                'homestay_price' => $homestay->price,
                'homestay_disc' => $homestay->disc,
                'total_payment' => $total,
                'payment_status' => 'pending',
                'payment_type' => 'bank_transfer',
                'uuid' =>  $uuid
            ]);

                // Jika snap token masih NULL, buat token snap dan simpan ke database

                $payload = [
                    'transaction_details' => [
                        'order_id' => $data->code,
                        'gross_amount' => $data->total_payment,
                    ],
                    'item_details' => [
                        [
                            'id' =>  $data->homestay_id,
                            'price' => ($data->homestay_disc > 0) ?  $data->homestay_disc : $data->homestay_price,
                            'quantity' => $data->pax,
                            'name' => Str::limit($data->homestay_name,30),
                        ],
                    ],
                    'customer_details' => [
                        'first_name' => $data->customer_name,
                        'email' => $data->customer_email,
                        'phone' => $data->customer_phone,
                    ]
                ];

                $midtrans = new CreateSnapTokenService($data);
                $snapToken = $midtrans->getSnapToken($payload);
                OrderHomestay::where('uuid', $data->uuid)->update([
                        'snap_token' => $snapToken
                ]);
                $order = OrderHomestay::where('uuid', $data->uuid)->first();
               
                
            return response()->json([
                'status' => true,
                'message' => 'Success checkout',
                'data' => [
                    'invoice' => $data->code,
                    'snap_token' => $order->snap_token,
                    'link_payment' => url('api/v2/payment')."/".$order->snap_token
                ]
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function checkoutTour(Request $request) {
        $request->validate([
            'tour_id' => 'required',
            'customer_name' => 'required',
            'customer_address' => 'required',
            'customer_phone' => 'required',
            'customer_email' => 'required',
            'qty' => 'required',
            'special_note' => 'nullable',
            'check_in' => 'required'
        ]);
        $count =  Order::count();
        if ($count > 0) {
            $code = Order::latest()->first()->id + 1;
        } else {
            $code = 1;
        }
        $code = "INV-".$code;
        $uuid = (string) Str::uuid();
        try {
            $tour = Package::where('id', $request->tour_id)->first();
        
            if($tour->disc >0 ){

                $total = ( $tour->disc) * $request->qty;
            }else{
                $total = ( $tour->price) * $request->qty;

            }
            $data = Order::create([
                'user_id' => Auth::user()->id,
                'package_id' => $request->tour_id,
                'code' => $code,
                'customer_name' => $request->customer_name,
                'customer_address' => $request->customer_address,
                'customer_phone' => $request->customer_phone,
                'customer_email' => $request->customer_email,
                'pax' => $request->qty,
                'village_name' => $tour->villageDetail?->village_name,
                'package_name' => $tour->name,
                'package_price' => $tour->price,
                'package_disc' => $tour->disc,
                'total_payment' => $total,
                'checkin_date' => $request->check_in,
                'payment_status' => 'pending',
                'payment_type' => 'bank_transfer',
                'uuid' =>  $uuid
            ]);

                // Jika snap token masih NULL, buat token snap dan simpan ke database

                $payload = [
                    'transaction_details' => [
                        'order_id' => $data->code,
                        'gross_amount' => $data->total_payment,
                    ],
                    'item_details' => [
                        [
                            'id' =>  $data->package_id,
                            'price' => ($data->package_disc > 0) ?  $data->package_disc : $data->package_price,
                            'quantity' => $data->pax,
                            'name' => Str::limit($data->package_name,30),
                        ],
                    ],
                    'customer_details' => [
                        'first_name' => $data->customer_name,
                        'email' => $data->customer_email,
                        'phone' => $data->customer_phone,
                    ]
                ];

                $midtrans = new CreateSnapTokenService($data);
                $snapToken = $midtrans->getSnapToken($payload);
                Order::where('uuid', $data->uuid)->update([
                        'snap_token' => $snapToken
                ]);
                $order = Order::where('uuid', $data->uuid)->first();
               
                
            return response()->json([
                'status' => true,
                'message' => 'Success checkout',
                'data' => [
                    'invoice' => $data->code,
                    'snap_token' => $order->snap_token,
                    'link_payment' => url('api/v2/payment')."/".$order->snap_token
                ]
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
