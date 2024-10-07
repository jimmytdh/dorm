<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssignmentRequest;
use App\Http\Requests\BedRequest;
use App\Models\Bed;
use App\Models\BedAssignment;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        if($bed->status !== 'Occupied'){
            $bed = $bed->delete();
            return response()->json(['msg' => 'deleted']);
        }else{
            return abort(404, 'Unable to delete occupied bed!');
        }
    }

    public function searchAssignment(Request $request)
    {
        Session::put('searchRoomAssignment', $request->search);
        return response()->json(['msg' => 'Search Complete']);
    }

    public function getAssignmentData(){
        $searchKeyword = Session::get('searchRoomAssignment');
        $assignment = BedAssignment::select('bed_assignments.*')
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
            ->where('bed_assignments.status','Rented')
            ->orderBy('bed_assignments.check_in', 'desc')
            ->paginate(30);
        return $assignment;
    }

    public function assignment(){
        $this->authorize('manage_assignment');
        if (request()->ajax()) {
            $beds = Bed::whereDoesntHave('bedAssignments',function($q) {
                $q->where('status','Rented');
            })->where('status','Available')
                ->orderBy('code','asc')->get();
            $profiles = Profile::whereDoesntHave('bedAssignments',function($q) {
                $q->where('status','Rented');
            })->orderBy('lname','asc')->get();
            $data = self::getAssignmentData();
            $view = view('page.assignment', compact('data','beds','profiles'))->render();
            return loadPage($view, 'Assign Room');
        }
        return view('app');
    }

    public function assignmentStore(AssignmentRequest $request){
        $this->authorize('manage_assignment');
        BedAssignment::create([
            'bed_id' => $request->bed_id,
            'profile_id' => $request->profile_id,
            'term' => $request->term,
            'process_by' => Auth::id(),
            'status' => 'Rented',
            'check_in' => $request->check_in
        ]);

        Bed::findOrFail($request->bed_id)->update(['status' => 'Occupied']);
        return response()->json(['msg' => 'Added']);
    }

    public function assignmentEdit($id){
        $this->authorize('manage_assignment');
        if(request()->ajax()) {
            $beds = Bed::whereDoesntHave('bedAssignments',function($q) {
                    $q->where('status','Rented');
                })
                ->where('status','Available')
                ->orderBy('code','asc')->get();
            $profiles = Profile::whereDoesntHave('bedAssignments',function($q) {
                $q->where('status','Rented');
            })->orderBy('lname','asc')->get();
            $data = self::getAssignmentData();
            $info = BedAssignment::findOrFail($id);
            $view = view('page.editAssignment', compact('info','data','beds','profiles'))->render();
            return loadPage($view, 'Update Assignment');
        }
        return view('app');
    }

    public function assignmentUpdate(AssignmentRequest $request, $id){
        $this->authorize('manage_assignment');
        $assignment = BedAssignment::findOrFail($id);
        $assignment->update([
            'bed_id' => $request->bed_id,
            'profile_id' => $request->profile_id,
            'term' => $request->term,
            'process_by' => Auth::id(),
            'status' => 'Rented',
            'check_in' => $request->check_in
        ]);
        // Return JSON response with success message
        Bed::findOrFail($request->selected_bed)->update(['status' => 'Available']);
        Bed::findOrFail($request->bed_id)->update(['status' => 'Occupied']);
        return response()->json([
            'msg' => 'Bed Assignment successfully updated!',
            'status' => 'success'
        ]);
    }

    public function rentalLogsSearch(Request $request){
        Session::put('searchRentalLogs', $request->search);
        return response()->json(['msg' => 'Search Complete']);
    }

    public function rentalLogs(){
        $searchKeyword = Session::get('searchRentalLogs');
        if (request()->ajax()) {
            $data = BedAssignment::select('bed_assignments.*')
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
                ->where('bed_assignments.status','Checkout')
                ->orderBy('bed_assignments.check_in', 'desc')
                ->paginate(30);

            $view = view('report.rental', compact('data'))->render();
            return loadPage($view, 'Rental Logs');
        }
        return view('app');
    }
}
