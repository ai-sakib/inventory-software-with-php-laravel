<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers;
use App\Models\Location;

class LocationController extends Controller
{
  
    public function index()
    {
        $locations=Location::orderBy('id','desc')->get();
        return view('admin.location.index',compact('locations'));
    }

   
    public function create()
    {   
        return view('admin.location.create');
    }

    public function store(Request $request, Location $location )
    {
        $this->validate($request, [
            'name'=> 'required',
        ]);

        $location->fill($request->all());
        //$Locations->created_by=admin_id();
        $location->save();
        if($location) {    
            session()->flash('success', 'Location has been added Successfully');
            return redirect()->back();
        }else{
            session()->flash('error', 'Something Went Wrong !');
            return redirect()->back();
        }
    }
    
    public function edit($id)
    {
        $location = Location::find($id);
        return view('admin.location.edit', compact('location'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name'=> 'required',
        ]);
        $location = Location::find($id);
        $location->fill($request->all());
        //$location->created_by=admin_id();
        $location->save();
        if($location) {    
            session()->flash('success', 'Location has been updated Successfully');
            return redirect()->back();
        }else{
            session()->flash('error', 'Something Went Wrong !');
            return redirect()->back();
        }
    }



    public function show($data)
    {
        $id = explode('&', $data)[0];
        $status = explode('&', $data)[1];

        Location::find($id)->update(['status'=>$status]);
        
        return response()->json([
            'success'=>true, 
            'status'=>$status,
            'id'=>$id,
        ]);
    }
   
    public function destroy($id)
    {
       
        $delete = Location::find($id)->delete();
        if ($delete) {
            return response()->json(["success" => true]);
        } else {
            return response()->json(["success" => false]);
        }
    }

   
}
