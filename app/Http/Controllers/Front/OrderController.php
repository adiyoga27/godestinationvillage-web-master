<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Input;
use function GuzzleHttp\json_encode;
use App\Helpers\CustomImage;
use Illuminate\Support\Facades\Storage;
use Auth;
use App\Mail\OrderEmail as OrderEmail;
use App\Mail\SendEmail;
use Mail;


class OrderController extends Controller
{
    //
    public function send(Request $request)
    {
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
            return redirect('reservation/' . $customer_email);
        }
    }
    function transactionWish(Request $request)
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
        $paywish = Input::get('paywish');
            
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
                    'package_price' => $paywish,
                    'package_discount' => 0,
                    'total_payment' => $paywish,
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
              
                 Mail::to([$order->customer_email, 'hello@godestinationvillage.com'])->send($email);

            return redirect('reservation/' . $customer_email);


            }
    
    }
    public function sendEvent(Request $request)
    {
        $paywish = Input::get('paywish');
       
        if($paywish > 0){
            return $this->transactionWish($request);

            exit;
        }
        $datenow = date('Y-m-d');
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
        $special_note = Input::get('special_note');
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
                'payment_type' => 'bank_transfer',
                'payment_status' => 'success',
                'bank_account_id' => 7,
                'payment_date' => $datenow,
                'pax' => $pax,
                'special_note' => $special_note,
                'checkin_date' => $checkin_date
            ]
        );
        if ($proses) {
            $order =  Order::latest()->first();
            $subject = 'Godevi - Order ' . $order->id . ' - Confirmation';
            $message = "This is your booking confirmation. Thank you for joining our event. <br><br>Note: The information regarding of the event will be sent through email / phone number registered on this booking. For further information do not hesitate to contact us via <br>Whatsapp : 081933158949 <br>Instagram : <a href='https://www.instagram.com/godestinationvillage/'> @godestinationvillage</a>";


            $email = new SendEmail($subject, $message);
            Mail::to([$order->customer_email, 'hello@godestinationvillage.com'])->send($email);
            return redirect('reservation/paid/' . $customer_email);
        }
    }

    public function paypalPayment(Request $request)
    {
        $id = $request->input('editid');
        $proses = Order::find($id);

        $proses->payment_type = 'paypal';
        $proses->payment_date = date("Y-m-d H:i:s");
        $proses->payment_status = 'success';


        $proses->save();
        $return = $proses->customer_email;
        if ($proses) {
            $order =  Order::find($id);
            $subject = 'Godevi - Order ' . $order->id . ' - Sukses';
            $message = "We have received your Order(<a href='https://godevi.id/reservation/" . $customer_email . "'>Details Order</a>) and Payment through paypal, here are your order details:";


            $email = new OrderEmail($subject, $order, $message);
            Mail::to($order->customer_email)->send($email);
            Mail::to('hello@godevi.id')->send($email);

            return $return;
        }
    }

    public function bankPayment(Request $request)
    {
        $id = $request->idtrx;
        $proses = Order::find($id);

        // var_dump($request->bank);
        $proses->bank_account_id = $request->bank_godevi;
        $proses->bank_name = $request->bank;
        $proses->bank_account_id = $request->bank_godevi;
        $proses->bank_acc_name = $request->name;
        $proses->payment_type = 'bank_transfer';
        $proses->payment_date = $request->date;
        $proses->payment_status = 'pending';
        if (!empty($request->bukti)) {
            $upload = CustomImage::storeImage($request->bukti, 'orders');
            $proses->payment_img = $upload['name'];
        }



        $proses->save();
        if ($proses) {
            // return redirect('reservation/paid/' . $proses->customer_email);
            return redirect('payment-detail/' . $id);

        }
    }

    public function confirmPayment(Request $request)
    {
        $id = $request->idtrx;
        $proses = Order::find($id);
        $proses->bank_name = $request->bank;
        $proses->bank_acc_name = $request->name;
        $proses->payment_date = $request->date;
        $proses->payment_status = 'pending';
        if (!empty($request->bukti)) {
            $upload = CustomImage::storeImage($request->bukti, 'orders');
            $proses->payment_img = $upload['name'];
        }



        $proses->save();
        if ($proses) {
            return redirect('reservation/paid/' . $proses->customer_email);
           

        }
    }

    // public function reservationPaid()
    // {
    //     $data['order'] = Order::whereNotNull('payment_type')
    //         ->where('user_id', Auth::id())
    //         ->get();
    //     return view('frontend/reservation/paid', $data);
    // }

    // public function reservationPaypal()
    // {
    //     $data['order'] = Order::where('payment_type', 'paypal')
    //         ->where('user_id', Auth::id())
    //         ->get();
    //     return view('frontend/reservation/paypal', $data);
    // }

    // public function reservationBank()
    // {
    //     $data['order'] = Order::where('payment_type', 'bank_transfer')
    //         ->where('user_id', Auth::id())
    //         ->get();
    //     return view('frontend/reservation/bank', $data);
    // }

    // public function reservationCancel()
    // {
    //     $data['order'] = Order::where('payment_status','cancel')
    //         ->where('user_id',Auth::id())
    //         ->get();
    //     return view('frontend/reservation/cancel', $data);
    // }


    //non registred
    public function reservationPaid(Request $request)
    {
        $data['order'] = Order::whereNotNull('payment_type')
            ->where('customer_email', $request->email)
            ->orderBy('id', 'desc')
            ->paginate(5);
        $data['isiemail'] = $request->email;
        return view('customer/reservation/paid', $data);
    }

    public function reservationPaypal(Request $request)
    {
        $data['order'] = Order::where('payment_type', 'paypal')
            ->where('customer_email', $request->email)
            ->orderBy('id', 'desc')
            ->paginate(5);
        $data['isiemail'] = $request->email;
        return view('customer/reservation/paypal', $data);
    }

    public function reservationBank(Request $request)
    {
        $data['order'] = Order::where('payment_type', 'bank_transfer')
            ->where('customer_email', $request->email)
            ->orderBy('id', 'desc')
            ->paginate(5);
        $data['isiemail'] = $request->email;
        return view('customer/reservation/bank', $data);
    }

    public function reservationCancel(Request $request)
    {
        $data['order'] = Order::where('payment_status', 'cancel')
            ->where('customer_email', $request->email)
            ->orderBy('id', 'desc')
            ->paginate(5);
        $data['isiemail'] = $request->email;
        return view('customer/reservation/cancel', $data);
    }
}
