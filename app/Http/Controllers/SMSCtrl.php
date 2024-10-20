<?php

namespace App\Http\Controllers;

use App\Models\BedAssignment;
use App\Models\Profile;
use App\Services\SemaphoreService;
use Illuminate\Http\Request;

class SMSCtrl extends Controller
{
    protected $semaphoreService;

    public function __construct(SemaphoreService $semaphoreService)
    {
        $this->semaphoreService = $semaphoreService;
    }

    public function sendTmpSms()
    {
        $to = '09162072427';
        $message = 'Good day! Welcome to DMS System.';

        // Call the service to send SMS
        $response = $this->semaphoreService->sendSMS($to, $message);

        return response()->json($response);
    }

    public function sendSMS(Request $request)
    {
        $balance = $request->balance;
        $msg = self::msg($request->status,$balance);
        $assignment = BedAssignment::find($request->assignment_id);
        $profile = Profile::find($assignment->profile_id);
        $mobile = $profile->contact;
        //$message = 'Good day! Welcome to DMS System.';

        // Call the service to send SMS
        $response = $this->semaphoreService->sendSMS($mobile, $msg);

        return response()->json([
            'msg' => $msg
        ]);
    }

    public function msg($status, $balance){
        $balance = number_format($balance,2);
        if($status=='Due')
            return 'REMINDER: Your payment is due. Please settle the amount of ₱'.$balance.' by the due date to avoid any penalties.';
        elseif($status == 'Overdue')
            return 'NOTICE: Your payment is overdue. Kindly settle your outstanding balance of ₱'.$balance.' as soon as possible to avoid further penalties.';
        elseif($status == 'Late and Overdue')
            return 'URGENT: Your payment is both late and overdue. Please settle the total balance of ₱'.$balance.' now to avoid additional penalties.';
        else
            return 'REMINDER: You have a pending balance of ₱'.$balance.'. Please make the payment at your earliest convenience.';
    }
}
