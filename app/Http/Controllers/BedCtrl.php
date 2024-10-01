<?php

namespace App\Http\Controllers;

use App\Http\Requests\BedRequest;
use App\Models\Bed;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class BedCtrl extends Controller
{

    public function getBedsData(){
        $searchKeyword = Session::get('searchBed');
        $beds = Bed::select('*')->orderBy('code','asc');
        if ($searchKeyword) {
            $beds = $beds->where(function ($q) use ($searchKeyword) {
                $q->where('code', 'like', "$searchKeyword%")
                    ->orwhere('description', 'like', "%$searchKeyword%")
                    ->orwhere('remarks', 'like', "%$searchKeyword%")
                    ->orwhere('status', 'like', "%$searchKeyword%");
            });
        }
        $beds = $beds->latest()
            ->paginate(30);
        return $beds;
    }

    public function index()
    {
        if (request()->ajax()) {
            $beds = self::getBedsData();
            $view = view('beds.index', compact('beds'))->render();
            return loadPage($view, 'Bed');
        }
        return view('app');
    }

    public function searchBeds(Request $request)
    {
        Session::put('searchBed', $request->search);
        return response()->json(['msg' => 'Search Complete']);
    }

    public function create()
    {
        if (request()->ajax()) {
            $this->authorize('manage_beds');
            $view = view('rooms.create')->render();
            return loadPage($view, 'Create Room');
        }
        return view('app');
    }

    public function store(BedRequest $request)
    {
        $data = [
            'code' => strtoupper($request->code),
            'description' => $request->description,
            'remarks' => $request->remarks,
            'status' => $request->status,
        ];

        Bed::create($data);
        // Return JSON response with success message
        return response()->json([
            'msg' => 'Bed successfully created!',
            'status' => 'success'
        ]);
    }

    public function edit($id)
    {
        if (request()->ajax()) {
            $beds = self::getBedsData();
            $bed = Bed::find($id);
            $this->authorize('manage_beds');

            $view = view('beds.edit', compact('bed','beds'))->render();
            return loadPage($view, "Update: $bed->code");
        }
        return view('app');
    }

    public function update(BedRequest $request, $id)
    {
        $this->authorize('manage_beds');
        $bed = Bed::findOrFail($id);
        $bed->update([
            'code' => strtoupper($request->code),
            'description' => $request->description,
            'remarks' => $request->remarks,
            'status' => $request->status,
        ]);
        // Return JSON response with success message
        return response()->json([
            'msg' => 'Bed successfully updated!',
            'status' => 'success'
        ]);
    }

    public function destroy($id)
    {
        $this->authorize('manage_beds');

        //before delete, check assignment table if it is used
        $bed = Bed::findOrFail($id);
        $bed = $bed->delete();
        return response()->json(['msg' => 'deleted']);
    }

    public function assignment(){
        if (request()->ajax()) {
            $beds = Bed::orderBy('code','asc')->get();
            $profiles = Profile::orderBy('lname','asc')->get();
            $data = [];
            $view = view('page.assignment', compact('data','beds','profiles'))->render();
            return loadPage($view, 'Assign Room');
        }
        return view('app');
    }
}
