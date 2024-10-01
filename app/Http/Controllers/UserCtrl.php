<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UserCtrl extends Controller
{
    public function index()
    {
        $searchKeyword = Session::get('searchKeyword');
        if (request()->ajax()) {
            $users = User::select('*');
            if ($searchKeyword) {
                $users = $users->where(function ($q) use ($searchKeyword) {
                    $q->where('username', 'like', "$searchKeyword%")
                        ->orwhere('fname', 'like', "%$searchKeyword%")
                        ->orwhere('lname', 'like', "%$searchKeyword%");
                });
            }
            $users = $users->latest()
                ->paginate(30);
            $view = view('users.index', compact('users'))->render();
            return loadPage($view, 'Users');
        }
        return view('app');
    }

    public function searchUsers(Request $request)
    {
        Session::put('searchKeyword', $request->search);
        return response()->json(['msg' => 'Search Complete']);
    }

    public function create()
    {
        if (request()->ajax()) {
            $this->authorize('manage_users');
            $view = view('users.create')->render();
            return loadPage($view, 'Create User');
        }
        return view('app');
    }

    public function store(UserRequest $request){
        $data = [
            'username' => $request->username,
            'fname' => ucfirst(strtolower($request->fname)),
            'lname' => ucfirst(strtolower($request->lname)),
            'password' => bcrypt($request->password),
            'role' => strtolower($request->role)
        ];

        User::create($data);
        return $data;
    }

    public function edit($id)
    {
        if (request()->ajax()) {
            $user = User::find($id);
            $this->authorize('manage_users');

            $view = view('users.edit', compact('user'))->render();
            return loadPage($view, "Update: $user->username");
        }
        return view('app');
    }

    public function update(UserRequest $request, $id)
    {
        $user = User::findorFail($id);
        $this->authorize('manage_users');
        // Update user details
        $data = [
            'username' => $request->username,
            'fname' => ucfirst(strtolower($request->fname)),
            'lname' => ucfirst(strtolower($request->lname)),
            'role' => strtolower($request->role)
        ];

        // Only update the password if it's provided
        if (!empty($request->password)) {
            $data['password'] = bcrypt($request->password);
        }

        // Update the user with the new data
        $user->update($data);
        return $user;
    }

    public function destroy($id)
    {

        if(Auth::id() === (int)$id){
            return abort(404, 'Unable to delete own account.');
        }
        $user = User::findOrFail($id);
        $this->authorize('manage_users');
        $user = $user->delete();
        return response()->json(['msg' => 'deleted']);
    }
}
