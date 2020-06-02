<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers;
use App\Models\Project;
use App\Models\AdminRole;
use App\Models\MainMenu;
use Illuminate\Support\Facades\Hash;

use Auth;
use DB;

class ProjectController extends Controller
{
  
    public function index()
    {
        $project=Project::find(1);
        return view('admin.project.index',compact('project'));
    }

    public function changePassword()
    {
        return view('admin.project.changePassword');
    }

    public function forgetPassword()
    {
        return view('admin.project.forgetPassword');
    }

    public function adminPriority(){
        $adminRoles = AdminRole::get();
        return view('admin.project.adminPriority', compact('adminRoles'));
    }

    public function adminPriorityStore(Request $request){
        $adminRole = AdminRole::find($request->role_id);
        $mainMenus = MainMenu::whereNotIn('id',[4,5])->orderBy('serial_no','asc')->get();

        $mainMenuArray = array();
        $subMenuArray = array();

        $mainMenuForRole = DB::table('main_menu_permission')->where('role_id',$request->role_id)->get();
        $subMenuForRole = DB::table('sub_menu_permission')->where('role_id',$request->role_id)->get();

        if(isset($mainMenuForRole[0]->id)){
            foreach ($mainMenuForRole as $value) {
                array_push($mainMenuArray, $value->main_menu_id);
            }
        }

        if(isset($subMenuForRole[0]->id)){
            foreach ($subMenuForRole as $value) {
                array_push($subMenuArray, $value->sub_menu_id);
            }
        }
        return view('admin.project.adminPriorityStore', compact('adminRole','mainMenus','mainMenuArray','subMenuArray'));
    }

    public function adminPermissionStore(Request $request){
        DB::table('main_menu_permission')->where('role_id',$request->role_id)->delete();
        DB::table('sub_menu_permission')->where('role_id',$request->role_id)->delete();

        if(!empty($request->mainMenu)){
            foreach ($request->mainMenu as $key => $value) {
                DB::table('main_menu_permission')->insert([
                    'id' => DB::table('main_menu_permission')->max('id')+1,
                    'role_id' => $request->role_id,
                    'main_menu_id' => $value,
                ]);
            }
        }
        if(!empty($request->subMenu)){
            foreach ($request->subMenu as $key => $value) {
                DB::table('sub_menu_permission')->insert([
                    'id' => DB::table('sub_menu_permission')->max('id')+1,
                    'role_id' => $request->role_id,
                    'sub_menu_id' => $value,
                ]);
            }
        }
        return redirect('/');

    }
    public function changePasswordStore(Request $request)
    {
        $this->validate($request,[
            'old_password' => 'required',
            'new1_password' => 'required',
            'confirm_password' => 'required',
        ]);

        if(Hash::check($request->old_password, Auth()->user()->password)) {
            if($request->new1_password != $request->confirm_password){
                session()->flash('error', 'Sorry ! password did not matched !');
            }else{
                Auth()->user()->password = Hash::make($request->new1_password);
                Auth()->user()->save();
                session()->flash('success', 'Password Changed !');
            }
        }else{
            session()->flash('error', 'Sorry ! wrong password !');
        }
        
        return redirect()->back();
    }

    public function store(Request $request){
        $this->validate($request,[
            'name',
            'email',
            'phone',
            'address',
        ]);

        $project = Project::find(1);
        $project->fill($request->all())->save();
        if($project) {    
            session()->flash('success', 'Project details has been updated Successfully');
            if(isset($project)){
                $file=$request->file('file');
                if(isset($file)){
                    if($project->logo != "" && file_exists(public_path('project/').$project->logo)){
                        unlink(public_path('project/').$project->logo);
                    }
                    $fileInfo=fileInfo($file);
                    $logo= $project->name.'-'.date('YmdHis').'.'.$fileInfo['extension']; 
                    $upload=fileUpload($file,'project',$logo);
                    Project::find(1)->update(['logo'=>$logo]);
                }
                return redirect()->back();
            }
            return redirect()->back();
        }else{
            session()->flash('error', 'Something Went Wrong !');
            return redirect()->back();
        }
    }
   
}
