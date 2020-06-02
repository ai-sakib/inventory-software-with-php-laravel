<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers;
use App\User;
use App\Models\AdminRole;
use Illuminate\Support\Facades\Hash;
use Auth;

class UserController extends Controller
{
  
    public function index()
    {
        $users=User::orderBy('role_id','asc')->get();
        return view('admin.user.index',compact('users'));
    }

   
    public function create()
    {   
        $adminRoles = AdminRole::get();
        return view('admin.user.create', compact('adminRoles'));
    }

    public function store(Request $request, User $user )
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6'],
            'role_id' =>'required',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role_id' => $request->role_id,
            'password' => Hash::make($request->password),
            'created_by' => Auth::id(),
        ]);
        if($user) {    
            session()->flash('success', 'User has been added Successfully');
            return redirect()->back();
        }else{
            session()->flash('error', 'Something Went Wrong !');
            return redirect()->back();
        }
    }
    
    public function edit($id)
    {
        $adminRoles = AdminRole::get();
        $user = User::find($id);
        return view('admin.user.edit', compact('user','adminRoles'));
    }

    public function update(Request $request, $id)
    {
        if(User::find($id)->email == $request->email){
            $this->validate($request, [
                'name' => ['required', 'string', 'max:255'],
                'password' => ['required', 'string', 'min:6'],
                'role_id' =>'required',
            ]);
        }else{
            $this->validate($request, [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255'],
                'password' => ['required', 'string', 'min:6'],
                'role_id' =>'required',
            ]);
        }
        

        if(trim($request->password) != ''){
            $user = User::find($id)->update([
                'name' => $request->name,
                'role_id' => $request->role_id,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
        }else{
             $user = User::find($id)->update([
                'name' => $data['name'],
                'role_id' => $request->role_id,
                'email' => $data['email'],
            ]);
        }

        if($user) {    
            session()->flash('success', 'User has been updated Successfully');
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

        User::find($id)->update(['status'=>$status]);
        
        return response()->json([
            'success'=>true, 
            'status'=>$status,
            'id'=>$id,
        ]);
    }
   
    public function destroy($id)
    {
       
        $delete = User::find($id)->delete();
        if ($delete) {
            return response()->json(["success" => true]);
        } else {
            return response()->json(["success" => false]);
        }
    }

   
}
