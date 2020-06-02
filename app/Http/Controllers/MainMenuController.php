<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers;
use App\Models\MainMenu;

class MainMenuController extends Controller
{
  
    public function index()
    {
        $mainMenus=MainMenu::orderBy('serial_no','asc')->get();
        return view('admin.mainMenu.index',compact('mainMenus'));
    }

   
    public function create()
    {   
        return view('admin.mainMenu.create');
    }

    public function store(Request $request, MainMenu $mainMenu )
    {
        $this->validate($request, [
            'serial_no'=> 'required',
            'name'=> 'required',
            'icon'=> 'required',
        ]);

        $mainMenu->fill($request->all());
        //$mainMenus->created_by=admin_id();
        $mainMenu->save();
        if($mainMenu) {    
            session()->flash('success', 'Main Menu has been added Successfully');
            return redirect()->back();
        }else{
            session()->flash('error', 'Something Went Wrong !');
            return redirect()->back();
        }
    }
    
    public function edit($id)
    {
        $mainMenu = MainMenu::find($id);
        return view('admin.mainMenu.edit', compact('mainMenu'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'serial_no'=> 'required',
            'name'=> 'required',
            'icon'=> 'required',
        ]);
        
        $mainMenu = MainMenu::find($id);
        $mainMenu->fill($request->all());
        $mainMenu->save();
        if($mainMenu) {    
            session()->flash('success', 'Main Menu has been added Successfully');
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

        MainMenu::find($id)->update(['status'=>$status]);
        
        return response()->json([
            'success'=>true, 
            'status'=>$status,
            'id'=>$id,
        ]);
    }
   
    public function destroy($id)
    {
       
        $delete = MainMenu::find($id)->delete();
        if ($delete) {
            return response()->json(["success" => true]);
        } else {
            return response()->json(["success" => false]);
        }
    }

   
}
