<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class BotHelper  
{
    public static function sendTelegram($message)
    {
        $token = env('TELEGRAM_TOKEN');
        $chatid = env('TELEGRAM_CHATID');
        Http::post("https://api.telegram.org/bot$token/sendmessage?chat_id=$chatid&text=$message");
        return true;
    }
    public static function errorBot($activity, $message)
    {
        $date = date('d M Y H:i')." wita";
        $messages = "Godevi - Error Website \\nnDate:$date \nActivity : $activity \n\nMessage:$message";
        $token = env('TELEGRAM_TOKEN');
        $chatid = env('TELEGRAM_CHATID');
        Http::post("https://api.telegram.org/bot$token/sendmessage?chat_id=$chatid&text=$messages");
        return true;
    }
}
