<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Models\BedAssignment;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ProfileCtrl extends Controller
{
    public function getData(){
        $searchKeyword = Session::get('searchProfile');
        $data = Profile::select('*')->orderBy('lname','asc');
        if ($searchKeyword) {
            $data = $data->where(function ($q) use ($searchKeyword) {
                $q->where('fname', 'like', "$searchKeyword%")
                    ->orwhere('lname', 'like', "%$searchKeyword%")
                    ->orwhere('sex', 'like', "%$searchKeyword%");
            });
        }
        $data = $data->latest()
            ->paginate(30);
        return $data;
    }

    public function index()
    {
        if (request()->ajax()) {
            $profiles = self::getData();
            $view = view('profile.index', compact('profiles'))->render();
            return loadPage($view, 'Profiles');
        }
        return view('app');
    }

    public function searchProfiles(Request $request)
    {
        Session::put('searchProfile', $request->search);
        return response()->json(['msg' => 'Search Complete']);
    }

    public function create()
    {
        if (request()->ajax()) {
            $this->authorize('manage_profiles');
            $view = view('profile.index')->render();
            return loadPage($view, 'Profiles');
        }
        return view('app');
    }

    public function store(ProfileRequest $request)
    {
        $data = [
            'fname' => strtoupper($request->fname),
            'lname' => strtoupper($request->lname),
            'sex' => $request->sex,
            'dob' => $request->dob,
            'contact' => $request->contact,
            'address' => strtoupper($request->address),
        ];

        Profile::create($data);
        // Return JSON response with success message
        return response()->json([
            'msg' => 'Profile successfully created!',
            'status' => 'success'
        ]);
    }

    public function edit($id)
    {
        $this->authorize('manage_profiles');
        if (request()->ajax()) {
            $profiles = self::getData();
            $profile = Profile::findOrFail($id);
            $view = view('profile.edit', compact('profile','profiles'))->render();
            return loadPage($view, "Update: $profile->fname");
        }
        return view('app');
    }

    public function update(ProfileRequest $request, $id)
    {
        $this->authorize('manage_profiles');
        $data = Profile::findOrFail($id);
        $data->update([
            'fname' => strtoupper($request->fname),
            'lname' => strtoupper($request->lname),
            'sex' => $request->sex,
            'dob' => $request->dob,
            'contact' => $request->contact,
            'address' => strtoupper($request->address),
        ]);
        // Return JSON response with success message
        return response()->json([
            'msg' => 'Profile successfully updated!',
            'status' => 'success'
        ]);
    }

    public function destroy($id)
    {
        $this->authorize('manage_profiles');

        //before delete, check assignment table if it is used
        $profile = Profile::findOrFail($id);
        $rented = BedAssignment::where('profile_id',$id)->where('status','rented')->first();
        if($rented){
            return abort(404, 'Unable to delete profile because the person is currently a renter!');
        }
        $profile->delete();
        return response()->json(['msg' => 'deleted']);
    }
}
