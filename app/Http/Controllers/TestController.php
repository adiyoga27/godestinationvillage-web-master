<?php

namespace App\Http\Controllers;

use App\Helpers\BotHelper;
use App\Mail\OrderEmail;
use App\Mail\OrderEventEmail;
use App\Mail\OrderHomestayEmail;
use App\Models\Blog;
use App\Models\Event;
use App\Models\Homestay;
use App\Models\Order;
use App\Models\OrderEvent;
use App\Models\OrderHomestay;
use App\Models\Package;
use App\Models\VillageDetail;
use App\Services\InstagramServices;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TestController extends Controller
{
    public function checkEmail()
    {
        $order =  OrderEvent::latest()->first();
        $subject = 'Godevi - Order ' . $order->id . ' - Confirmation';
        $message = "This is your booking information, please make payment to confirm your reservation as following details(<a href='https://godestinationvillage.com/reservation/'>Details Order</a>) : <br> ";


        $email = new OrderEventEmail($subject, $order, $message);
        return $email;
    }
    public function checkHomeStay()
    {
        $order =  OrderHomestay::latest()->first();
        $subject = 'Godevi - Order ' . $order->id . ' - Confirmation';
        $message = "This is your booking information, please make payment to confirm your reservation as following details(<a href='https://godestinationvillage.com/reservation/'>Details Order</a>) : <br> ";


        $email = new OrderHomestayEmail($subject, $order, $message);
        return $email;
    }
    public function checkPackage()
    {
        $order =  Order::latest()->first();
        $subject = 'Godevi - Order ' . $order->id . ' - Confirmation';
        $message = "This is your booking information, please make payment to confirm your reservation as following details(<a href='https://godestinationvillage.com/reservation/'>Details Order</a>) : <br> ";


        $email = new OrderEmail($subject, $order, $message);
        return $email;
    }
    public function postinstagram()
    {
        return InstagramServices::randomPost();
    }

    public function loopSlug()
    {
        try {
            $packages = Package::get();
            foreach ($packages as $value) {
                Package::where('id', $value['id'])->update(
                    [
                         'slug'=> Str::slug($value['name'],'-')
                    ]
                 );
            }
        } catch (\Throwable $th) {
            throw $th;
        }

        try {
            $event = Event::get();
            foreach ($event as $value) {
                Event::where('id', $value['id'])->update(
                    [
                         'slug'=> Str::slug($value['name'],'-')
                    ]
                 );
            }
        } catch (\Throwable $th) {
            throw $th;
        }

        try {
            $homestay = Homestay::get();
            foreach ($homestay as $value) {
                Homestay::where('id', $value['id'])->update(
                    [
                         'slug'=> Str::slug($value['name'],'-')
                    ]
                 );
            }
        } catch (\Throwable $th) {
            throw $th;
        }

        try {
            $post = Blog::get();
            foreach ($post as $value) {
                Blog::where('id', $value['id'])->update(
                    [
                         'slug'=> Str::slug($value['post_title'],'-')
                    ]
                 );
            }
        } catch (\Throwable $th) {
            throw $th;
        }

        try {
            $village = VillageDetail::get();
            foreach ($village as $value) {
                VillageDetail::where('id', $value['id'])->update(
                    [
                         'slug'=> Str::slug($value['village_name'],'-')
                    ]
                 );
            }
        } catch (\Throwable $th) {
            throw $th;
        }
     
     
    }
    public function testBot()
    {
        return BotHelper::sendTelegram('sadasd');
    }
}
