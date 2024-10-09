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
        $msg = self::msg($request->status);
        $to = '09162072427';
        //$message = 'Good day! Welcome to DMS System.';

        // Call the service to send SMS
        //$response = $this->semaphoreService->sendSMS($to, $message);

        return response()->json([
            'msg' => $msg
        ]);
    }

    public function msg($status){
        if($status=='Due')
            return 'REMINDER: Your payment is due. Please settle the amount by the due date to avoid any penalties.';
        elseif($status == 'Overdue')
            return 'NOTICE: Your payment is overdue. Kindly settle your outstanding balance as soon as possible to avoid further penalties.';
        elseif($status == 'Late and Overdue')
            return 'URGENT: Your payment is both late and overdue. Please settle the total balance now to avoid additional penalties.';
        else
            return 'REMINDER: You have a pending balance. Please make the payment at your earliest convenience.';
    }
}
