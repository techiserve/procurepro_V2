<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WhatsAppService
{
    public function send($to, $message)
    {
        $sid = config('services.twilio.sid');
        $token = config('services.twilio.token');
        $from = config('services.twilio.whatsapp_from');
      //  dd( $sid,$token,$from,$to,$message);
        $url = "https://api.twilio.com/2010-04-01/Accounts/{$sid}/Messages.json";

        return Http::withBasicAuth($sid, $token)->asForm()->post($url, [
            'From' => $from,
            'To' => $to,
            'Body' => $message
        ]);
    }
}
