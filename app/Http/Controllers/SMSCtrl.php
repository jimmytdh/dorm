<?php

namespace App\Http\Controllers;

use App\Services\SemaphoreService;
use Illuminate\Http\Request;

class SMSCtrl extends Controller
{
    protected $semaphoreService;

    public function __construct(SemaphoreService $semaphoreService)
    {
        $this->semaphoreService = $semaphoreService;
    }

//    public function sendSMS()
//    {
//        $to = '09162072427';
//        $message = 'Good day! Welcome to DMS System.';
//
//        // Call the service to send SMS
//        $response = $this->semaphoreService->sendSMS($to, $message);
//
//        return response()->json($response);
//    }

    public function sendSMS(Request $request)
    {
        return $_POST;
        $to = '09162072427';
        $message = 'Good day! Welcome to DMS System.';

        // Call the service to send SMS
        $response = $this->semaphoreService->sendSMS($to, $message);

        return response()->json($response);
    }
}
