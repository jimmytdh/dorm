<?php

namespace App\Http\Controllers;

use App\Services\InfoBipService;
use Illuminate\Http\Request;
use Twilio\Rest\Client;


class NotificationCtrl extends Controller
{
    protected $twilio;
    protected $infoBipService;

    public function __construct(InfoBipService $infoBipService)
    {
        $this->twilio = new Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));
        $this->infoBipService = $infoBipService;
    }

    public function sendSMS()
    {
        $to = '639162072427';
        $message = 'This is my first message';

        $response = $this->infoBipService->sendSMS($to, $message);

        return response()->json($response);
    }
    public function sendNotification(){
        $sid    = "AC658e6bc0773abe53ce672cfc29f6bac0";
        $token  = "76a83616e861d59055a1d2d4003fb994";
        $twilio = new Client($sid, $token);

        $message = $twilio->messages
            ->create("+639760130318", // to
                array(
                    "from" => "+15704059113",
                    "body" => "Lets try again."
                )
            );


        return $message;
    }
}
