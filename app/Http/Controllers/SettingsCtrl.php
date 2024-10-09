<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccountRequest;
use App\Http\Requests\UserRequest;
use App\Models\Fee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SettingsCtrl extends Controller
{
    public function updateFees(Request $request){
        $validate = $request->validate([
            'daily' => 'required|numeric|min:50',
            'monthly' => 'required|numeric|min:100',
        ],[
            'daily.min' => 'The minimum daily rent value  is 50',
            'monthly.min' => 'The minimum monthly rent value is 100',
        ]);

        Fee::where('particulars','Daily')->first()->update(['amount' => $request->daily]);
        Fee::where('particulars','Monthly')->first()->update(['amount' => $request->monthly]);
        return response()->json([
            'msg' => 'Fees successfully updated!',
            'status' => 'success'
        ]);
    }

    public function editAccount(){
        if (request()->ajax()) {
            $profile = User::findOrFail(auth()->id());
            $view = view('page.editAccount', compact('profile'))->render();
            return loadPage($view, "Update Account");
        }
        return view('app');
    }

    public function updateAccount(AccountRequest $request){
        $id = auth()->id();

        $user = User::findorFail($id);
        $data = [
            'username' => $request->username,
            'fname' => ucfirst(strtolower($request->fname)),
            'lname' => ucfirst(strtolower($request->lname)),
        ];

        // Only update the password if it's provided
        if (!empty($request->password)) {
            $data['password'] = bcrypt($request->password);
        }

        // Update the user with the new data
        $user->update($data);
        return $user;

    }
}
