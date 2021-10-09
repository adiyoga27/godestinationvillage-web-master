<?php

namespace App\Http\Controllers\Api\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Booking\BookingCollection;
use App\Http\Resources\Booking\BookingResource;
use App\Mail\OrderEmail;
use App\Models\Order;
use App\Models\Package;
use App\Traits\JsonResponseTrait;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class BookingController extends Controller
{
    use JsonResponseTrait;

    public function show($id)
    {
        $collection = collect(Package::with(['category', 'village'])->where('packages.id', '=', $id)->orderBy('id', 'desc')->first());
        $collection->put('customer', User::where('id', Auth::id())->first());

        $result=$collection->all();
        $data = new BookingCollection($result);
        return $this->responseCollection($data);

    }

    public function send(Request $request)
    {
        // try {
            $count =  Order::count();
            if ($count > 0) {
                $code = Order::latest()->first()->id + 1;
            } else {
                $code = 1;
            }
            $package_id = Input::get('idtour');
            $user_id = Input::get('customerid');
            $village_id = Input::get('village_id');
            $package_name = Input::get('tourname');
            $village_name = Input::get('village');
            $customer_name = Input::get('customername');
            $customer_address = Input::get('address');
            $customer_phone = Input::get('phone');
            $customer_email = Input::get('email');
            $package_price = Input::get('price');
            $package_discount = 0;
            $total_payment = Input::get('totalprice');
            $pax = Input::get('pax');
            $pickup = Input::get('pickup');
            $pickupname = Input::get('pickupname');
            $special_note = "Location - " . $pickup . " | Hotel Name - " . $pickupname . " | Special Note - " . Input::get('special_note');
            $checkin_date = Input::get('checkin_date');
            $proses = Order::create(
                [
                    'package_id' => $package_id,
                    'user_id' => $user_id,
                    'village_id' => $village_id,
                    'code' => 'INV' . $code,
                    'package_name' => $package_name,
                    'village_name' => $village_name,
                    'customer_name' => $customer_name,
                    'customer_address' => $customer_address,
                    'customer_phone' => $customer_phone,
                    'customer_email' => $customer_email,
                    'package_price' => $package_price,
                    'package_discount' => $package_discount,
                    'total_payment' => $total_payment,
                    'pax' => $pax,
                    'special_note' => $special_note,
                    'checkin_date' => $checkin_date
                ]
            );
            if ($proses) {
                $order =  Order::latest()->first();
                $subject = 'Godevi - Order ' . $order->id . ' - Confirmation';
                $message = "This is your booking information, please make payment to confirm your reservation as following details(<a href='https://godevi.id/reservation/" . $customer_email . "'>Details Order</a>) : <br> Note: We will proces your booking after we receive your payment. This can take up to 24 hours to verify your payment. After the verification you will get the e-tour voucher through email";
    
    
                $email = new OrderEmail($subject, $order, $message);
                Mail::to([$order->customer_email, 'hello@godevi.id'])->send($email);
                return $this->responseDataMessage(['order_id'=>$order->id]);
                // return redirect('reservation/' . $customer_email);

            }
        // }
        // catch (\Throwable $th) {
        //    return $this->responseErrorDataMessage($th);
        // }
    }
      
}
