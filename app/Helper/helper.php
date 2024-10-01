<?php

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
