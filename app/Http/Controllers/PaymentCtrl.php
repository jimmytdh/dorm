<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentRequest;
use App\Models\Bed;
use App\Models\BedAssignment;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PaymentCtrl extends Controller
{
    public function paymentIndex(){
        $searchKeyword = Session::get('searchPayment');
        if (request()->ajax()) {
            $data = BedAssignment::select('bed_assignments.*')
                ->where('bed_assignments.status','Rented')
                ->join('beds', 'bed_assignments.bed_id', '=', 'beds.id')
                ->join('profiles', 'bed_assignments.profile_id', '=', 'profiles.id')
                ->when($searchKeyword, function($query, $searchKeyword) {
                    return $query->where(function($query) use ($searchKeyword) {
                        // Search in beds.code or profiles lname/fname
                        $query->where('beds.code', 'LIKE', "%{$searchKeyword}%")
                            ->orWhere('profiles.lname', 'LIKE', "%{$searchKeyword}%")
                            ->orWhere('profiles.fname', 'LIKE', "%{$searchKeyword}%")
                            ->orWhere('bed_assignments.term', 'LIKE', "%{$searchKeyword}%");
                    });
                })
                ->orderBy('check_in','desc')->paginate(30);
            $view = view('report.payment', compact('data'))->render();
            return loadPage($view, 'Bed Rental Overview');
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

    public function paymentCheckout(Request $request){
        $assignment = BedAssignment::find($request->assignment_id);
        if(!$assignment){
            return abort(404, 'Unable to locate bed assignment!');
        }

        Bed::find($assignment->bed_id)->update([
            'status' => 'Available'
        ]);

        $assignment->update([
            'check_out' => Carbon::now(),
            'status' => 'Checkout',
            'remarks' => $request->remarks
        ]);
        return response()->json([
            'msg' => 'Checkout successfully!',
            'status' => 'success'
        ]);
    }

    public function paymentSearch(Request $request){
        Session::put('searchPayment', $request->search);
        return response()->json(['msg' => 'Search Complete']);
    }

    public function paymentHistorySearch(Request $request){
        Session::put('searchHistoryPayment', $request->search);
        return response()->json(['msg' => 'Search Complete']);
    }

    public function paymentHistory(){
        $searchKeyword = Session::get('searchHistoryPayment');
        if (request()->ajax()) {
            $data = Payment::orderBy('payments.created_at','desc')
                ->select('payments.*','profiles.*','bed_assignments.*','payments.created_at as date_paid','payments.id as payment_id')
                ->join('bed_assignments','payments.assignment_id','=','bed_assignments.id')
                ->join('beds', 'bed_assignments.bed_id', '=', 'beds.id')
                ->join('profiles', 'bed_assignments.profile_id', '=', 'profiles.id')
                ->when($searchKeyword, function($query, $searchKeyword) {
                    return $query->where(function($query) use ($searchKeyword) {
                        // Search in beds.code or profiles lname/fname
                        $query->where('beds.code', 'LIKE', "%{$searchKeyword}%")
                            ->orWhere('profiles.lname', 'LIKE', "%{$searchKeyword}%")
                            ->orWhere('profiles.fname', 'LIKE', "%{$searchKeyword}%")
                            ->orWhere('bed_assignments.term', 'LIKE', "%{$searchKeyword}%");
                    });
                })
                ->paginate(30);
            $view = view('report.history', compact('data'))->render();
            return loadPage($view, 'Payment History');
        }
        return view('app');
    }

    public function paymentHistoryProcess(PaymentRequest $request){
        Payment::find($request->id)
            ->update([
                'amount' => $request->amount,
                'remarks' => $request->remarks
            ]);
        return response()->json([
            'msg' => 'Payment successfully updated!',
            'status' => 'success'
        ]);
    }

    public function paymentInvoice($id){
        $payment = Payment::find($id);
        if(!$payment){
            return redirect('report/payment/history');
        }
        if (request()->ajax()) {
            $data = $payment;
            $view = view('report.invoice', compact('data'))->render();
            return loadPage($view, 'Payment Invoice');
        }
        return view('app');
    }
}
