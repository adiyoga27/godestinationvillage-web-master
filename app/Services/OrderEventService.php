<?php

namespace App\Services;

use App\Mail\SendEmail;
use App\Models\Event;
use App\Models\OrderEvent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class OrderEventService
{

    public static function all()
    {
        DB::statement(DB::raw('set @rownum=0'));
        return OrderEvent::query()
                ->leftJoin('bank_accounts', 'order_events.bank_account_id', '=', 'bank_accounts.id')                            
                ->select([
                    DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                    DB::raw('order_events.*'),
                ])->where('order_events.deleted_at', NULL);
    }

    public static function count($village_id = NULL)
    {
        if($village_id == NULL)
            return OrderEvent::where('payment_status', 'success')->count();
        else
            return OrderEvent::where('payment_status', 'success')->where('village_id', $village_id)->count();
    }

    public static function income($village_id = NULL)
    {
        if($village_id == NULL)
            return OrderEvent::where('payment_status', 'success')->sum('total_payment');
        else
            return OrderEvent::where('payment_status', 'success')->where('village_id', $village_id)->sum('total_payment');
    }

    public static function find($id)
    {
        return OrderEvent::with(['bank_account'])->find($id);
    }

    public static function get_order_by_user($user_id)
    {
        DB::statement(DB::raw('set @rownum=0'));
        return OrderEvent::query()
        ->select([
            DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            DB::raw('order_events.*')
        ])->where('order_events.user_id', $user_id)->where('order_events.deleted_at', NULL);
    }

    public static function find_by_user($user_id)
    {
        DB::statement(DB::raw('set @rownum=0'));
        return OrderEvent::query()
        ->select([
            DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            DB::raw('order_events.*')
        ])->where('order_events.village_id', $user_id)->where('order_events.deleted_at', NULL);
    }

    public static function find_by_package($package_id)
    {
        DB::statement(DB::raw('set @rownum=0'));
        return OrderEvent::query()
        ->select([
            DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            DB::raw('order_events.*')
        ])->where('order_events.package_id', $package_id)->where('order_events.deleted_at', NULL);
    }

    public static function destroy($id)
    {
        $model = OrderEvent::find($id);
        return $model->destroy($id);
    }

    public static function change_status($id, $status)
    {
        $order = OrderEvent::find($id);
        $order->payment_status = $status;
        return $order->save();
    }

    public static function search_order($village_id = 'All', $package_id = 'All', $start_date = 0, $end_date = 0)
    {
        DB::statement(DB::raw('set @rownum=0'));
        $order = OrderEvent::query()
                ->leftJoin('bank_accounts', 'order_events.bank_account_id', '=', 'bank_accounts.id')                            
                ->select([
                    DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                    DB::raw('order_events.*'),
                ]);

        if($village_id != 'All')
            $order->where('order_events.village_id', $village_id);

        if($package_id != 'All')
            $order->where('order_events.package_id', $package_id);

        if($start_date != 0)
            $order->where(DB::raw('DATE(order_events.created_at)'), '>=', date('Y-m-d', strtotime($start_date)));

        if($end_date != 0)
            $order->where(DB::raw('DATE(order_events.created_at)'), '<=', date('Y-m-d', strtotime($end_date)));

        return $order->where('order_events.deleted_at', NULL);
    }

    public static function sendEvent($payload)
    {
        DB::beginTransaction();

        try {

            $event = Event::where('id', $payload['idevent'])->first();
            $status = 'pending';
            $price = $payload['price'];
            $disc = $event->disc;
            $total_payment = $price * $payload['pax'];
            if($disc > 0){
                $total_payment = $disc * $payload['pax'];
            }
      
            if($event->is_free){
                $status = 'success';
                $price = '0';
                $total_payment = '0';
                $disc = '0';
            }
            if($event->is_paywish){
                $price = '0';
                $total_payment = '0';
                $disc = '0';
            }
    
            $datenow = date('Y-m-d');
    
            $count =  OrderEvent::count();
            if ($count > 0) {
                $code = OrderEvent::latest()->first()->id + 1;
            } else {
                $code = 1;
            }
    
            $encryptcode = Crypt::encrypt($code);
           $data = array(
            'event_id' => $payload['idevent'],
            'user_id' => Auth::user()->id ?? null,
            'code' => 'EVT-' . $code,
            'uuid' => $encryptcode,
            'event_name' => $payload['eventname'],
            'customer_name' => $payload['customername'],
            'customer_address' => $payload['address'],
            'customer_phone' => $payload['phone'],
            'customer_email' => $payload['email'],
            'event_price' => $price,
            'event_discount' => $disc,
            'total_payment' => $total_payment,
            'payment_type' => 'bank_transfer',
            'payment_status' => $status,
            'bank_account_id' => 7,
            'payment_date' => $datenow,
            'pax' => $payload['pax'],
            'special_note' => $payload['special_note'],
           );
    
           $link = url('payment/event/'.$encryptcode);
          
            $proses = OrderEvent::create($data);
            if ($proses) {
                $order =  OrderEvent::latest()->first();
                $subject = 'Godevi - Order Events ' . $order->code . ' - Confirmation';
                $message = "This is your booking confirmation. Thank you for joining our event. <br><br> Klik this <a href='$link'>link</a> for payment<br><br><br>Note: The information regarding of the event will be sent through email / phone number registered on this booking. For further information do not hesitate to contact us via <br>Whatsapp : 081933158949 <br>Instagram : <a href='https://www.instagram.com/godestinationvillage/'> @godestinationvillage</a>";
    
    
                $email = new SendEmail($subject, $message);
                Mail::to([$order->customer_email, 'hello@godestinationvillage.com'])->send($email);
                 DB::commit();

                return $proses;
            }

        } catch (\Throwable $th) {  
            dd($th);
            DB::rollBack();
            return $th;
        }
       
    }

    
    

}