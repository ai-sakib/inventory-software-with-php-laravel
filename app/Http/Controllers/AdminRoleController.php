<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers;
use App\Models\AdminRole;
use Auth;

class AdminRoleController extends Controller
{
  
    public function index()
    {
        $adminRoles=AdminRole::orderBy('id','asc')->get();
        return view('admin.adminRole.index',compact('adminRoles'));
    }

   
    public function create()
    {   
        return view('admin.adminRole.create');
    }

    public function store(Request $request, AdminRole $adminRole )
    {
        $this->validate($request, [
            'name'=> 'required',
        ]);

        $adminRole->fill($request->all());
        $adminRole->created_by=Auth::id();
        $adminRole->save();
        if($adminRole) {    
            session()->flash('success', 'Admin Role has been added successfully');
            return redirect()->back();
        }else{
            session()->flash('error', 'Something Went Wrong !');
            return redirect()->back();
        }
    }
    
    public function edit($id)
    {
        $adminRole = AdminRole::find($id);
        return view('admin.adminRole.edit', compact('adminRole'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name'=> 'required',
        ]);
        $adminRole = AdminRole::find($id);
        $adminRole->fill($request->all());
        //$adminRole->created_by=admin_id();
        $adminRole->save();
        if($adminRole) {    
            session()->flash('success', 'Admin Role has been updated successfully');
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

        AdminRole::find($id)->update(['status'=>$status]);
        
        return response()->json([
            'success'=>true, 
            'status'=>$status,
            'id'=>$id,
        ]);
    }
   
    public function destroy($id)
    {
       
        $delete = AdminRole::find($id)->delete();
        if ($delete) {
            return response()->json(["success" => true]);
        } else {
            return response()->json(["success" => false]);
        }
    }

   
}
