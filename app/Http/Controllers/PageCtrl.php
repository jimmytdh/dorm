<?php

namespace App\Http\Controllers;

use App\Models\Bed;
use App\Models\Document;
use App\Models\Payment;
use App\Models\Profile;
use App\Models\Tracking;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class PageCtrl extends Controller
{
    public function index(){
        return redirect('/dashboard');
    }

    public function dashboard(){
        if(request()->ajax()){
            $data = array(
                'beds' => Bed::count(),
                'residents' => Profile::count(),
                'available' => Bed::where('status','<>','Occupied')->count(),
                'earned' => Payment::whereBetween('created_at',[Carbon::now()->startOfMonth(),Carbon::now()->endOfMonth()])->sum('amount')
            );

            $view = view('page.dashboard',compact('data'))->render();
            return loadPage($view,'Dashboard');
        };
        return view('app');
    }

    public function logout(){
        if(request()->ajax()){
            return loadPage('Show logout here...','Logout');
        };
        return view('app');
    }

    public function defaultPage(){
        if(request()->ajax()){
            return loadPage(view('404')->render(),'Unauthorized Access');
        };
        return view('app');
    }
}
