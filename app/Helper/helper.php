<?php

use Carbon\Carbon;
use App\Models\BedAssignment;
use App\Models\Payment;
use App\Models\Fee;

if (!function_exists('checkRentStatus')) {
    function checkRentStatus($assignmentId)
    {
        // Fetch the BedAssignment data
        $bedAssignment = BedAssignment::find($assignmentId);
        if (!$bedAssignment) {
            return "Assignment not found.";
        }

        // Get the check-in date
        $checkInDate = Carbon::parse($bedAssignment->check_in);
        $today = Carbon::today();
        $lastPay = lastPay($assignmentId);
        $month = ($lastPay['date']) ? Carbon::parse($lastPay['date'])->month : $checkInDate->month;

        // Determine the due date (last day of the current month)
        $dueDate = Carbon::createFromDate($today->year, $month, $checkInDate->day);

        // Calculate the difference in days between today and the due date
        $daysAfterDue = $dueDate->diffInDays($today, false); // false means not absolute value


        $balance = calculateRemainingBalance($assignmentId);

        if($balance <= 0){
            return "Settled";
        }

        // Determine status based on the days difference
        if ($daysAfterDue > -3 && $daysAfterDue <= 0) {
            // Today is the due date
            return "Due";
        } elseif ($daysAfterDue > 0 && $daysAfterDue <= 5) {
            // 1-5 days after the due date
            return "Overdue";
        } elseif ($daysAfterDue >= 6) {
            // 6 or more days after the due date
            return "Late and Overdue";
        } else {
            // Before the due date
            if($balance > 0){
                return "Pending";
            }
            return "Settled";
        }
    }
}

if (!function_exists('calculateRemainingBalance')) {
    function calculateRemainingBalance($assignmentId)
    {
        // Fetch the BedAssignment, Payment, and Fee information
        $bedAssignment = BedAssignment::find($assignmentId);
        if (!$bedAssignment) {
            return "Assignment not found.";
        }

        // Get check-in date
        $checkInDate = Carbon::parse($bedAssignment->check_in);
        $today = Carbon::today();

        $dailyFee = Fee::where('particulars','Daily')->first()->amount;
        $monthlyFee = Fee::where('particulars','Monthly')->first()->amount;

        // Calculate the total number of days or months depending on the term
        if ($bedAssignment->term == 'Daily') {
            $daysStayed = $checkInDate->diffInDays($today);
            $totalDue = $daysStayed * $dailyFee; // Multiply by daily rent
        } elseif ($bedAssignment->term == 'Monthly') {
            $monthsStayed = $checkInDate->diffInMonths($today);
            $totalDue = $monthsStayed * $monthlyFee; // Multiply by monthly rent
        } else {
            return "Invalid term.";
        }

        // Get the total amount paid by the occupant
        $totalPaid = Payment::where('assignment_id', $assignmentId)->sum('amount');

        // Calculate the remaining balance
        $remainingBalance = $totalDue - $totalPaid;

        return $remainingBalance;
    }
}

if (! function_exists('lastPay')) {
    function lastPay($assignment_id)
    {
        $data = array(
            'amount' => 0,
            'date' => null
        );
        $lastPay = Payment::where('assignment_id',$assignment_id)
            ->orderBy('created_at','desc')
            ->first();
        if($lastPay){
            $data = array(
                'amount' => $lastPay->amount,
                'date' => $lastPay->created_at
            );
        }

        return $data;
    }
}

if (! function_exists('loadPage')) {
    function loadPage($view, $title = 'Laravel SPA')
    {
        return response()->json([
            'title' => $title,
            'content' => $view
        ]);
    }
}

if (! function_exists('calculateAge')) {
    function calculateAge($dateOfBirth) {
        // Calculate the current date and time
        $currentDate = new DateTime();

        // Create a DateTime object from the date of birth string
        $dob = new DateTime($dateOfBirth);

        // Calculate the difference between the current date and date of birth
        $age = $currentDate->diff($dob)->y;
        $month = $currentDate->diff($dob)->m;

        //return $age."y ".$month."m";
        if($age>0)
            return "$age y/o";
        return "$month months";
    }
}
