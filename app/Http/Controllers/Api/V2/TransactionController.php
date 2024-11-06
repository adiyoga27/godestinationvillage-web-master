<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Http\Resources\V2\Order\OrderEventResource;
use App\Http\Resources\V2\Order\OrderHomestayResource;
use App\Http\Resources\V2\Order\OrderResource;
use App\Models\Order;
use App\Models\OrderEvent;
use App\Models\OrderHomestay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function status(Request $request, $type) {
        $paymentStatus = 'pending';
        if($request->payment_status == 'paid'){
            $paymentStatus = 'success';
        }else{
            $paymentStatus = 'cancel';
        }
        if($type == 'event'){
            $data = OrderEvent::where('user_id', Auth::user()->id)
                    ->where('payment_type', $paymentStatus)
                    ->orderBy('id', 'DESC')->get();
            return OrderEventResource::collection($data)->additional([
                'status' => true,
                'message' => 'Success'
            ]);
        }else if($type == 'homestay'){
            $data = OrderHomestay::where('user_id', Auth::user()->id)
            ->where('payment_type', $paymentStatus)
            ->orderBy('id', 'DESC')->get();
                return OrderEventResource::collection($data)->additional([
                    'status' => true,
                    'message' => 'Success'
                ]);
        }else{
            $data = Order::where('user_id', Auth::user()->id)
            ->where('payment_type', $paymentStatus)
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
}
