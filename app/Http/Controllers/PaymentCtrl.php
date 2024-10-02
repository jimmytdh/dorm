<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentRequest;
use App\Models\BedAssignment;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentCtrl extends Controller
{
    public function paymentIndex(){
        if (request()->ajax()) {
            $data = BedAssignment::where('status','Rented')->orderBy('check_in','desc')->paginate(50);
            $view = view('report.payment', compact('data'))->render();
            return loadPage($view, 'Payment Status');
        }
        return view('app');
    }

    public function paymentProcess(PaymentRequest $request){
        Payment::create([
            'assignment_id' => $request->assignment_id,
            'amount' => $request->amount,
            'status' => 'paid',
            'process_by' => auth()->id(),
            'remarks' => $request->remarks,
        ]);
        return response()->json([
            'msg' => 'Occupant successfully paid!',
            'status' => 'success'
        ]);
    }
}
