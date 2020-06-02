<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers;
use App\Models\SubMenu;
use App\Models\MainMenu;


class SubMenuController extends Controller
{
  
    public function index()
    {
        $subMenus=SubMenu::orderBy('serial_no','asc')->get();
        return view('admin.subMenu.index',compact('subMenus'));
    }
   
    public function create()
    {   
        $mainMenus = MainMenu::get();
        return view('admin.subMenu.create',compact('mainMenus'));
    }

    public function store(Request $request, SubMenu $subMenu )
    {
        $this->validate($request, [
            'serial_no'=> 'required',
            'main_menu_id'=> 'required',
            'name'=> 'required',
            'link'=> 'required',
            'icon'=> 'required',
        ]);

        $subMenu->fill($request->all());
        $subMenu->save();
        if($subMenu) {    
            session()->flash('success', 'Sub Menu has been added Successfully');
            return redirect()->back();
        }else{
            session()->flash('error', 'Something Went Wrong !');
            return redirect()->back();
        }
    }
    
    public function edit($id)
    {
        $subMenu = SubMenu::find($id);
        $mainMenus = MainMenu::get();
        return view('admin.subMenu.edit', compact('subMenu','mainMenus'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'serial_no'=> 'required',
            'main_menu_id'=> 'required',
            'name'=> 'required',
            'link'=> 'required',
            'icon'=> 'required',
        ]);

        $subMenu = SubMenu::find($id);
        $subMenu->fill($request->all());
        $subMenu->save();
        if($subMenu) {    
            session()->flash('success', 'Sub Menu has been added Successfully');
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

        SubMenu::find($id)->update(['status'=>$status]);
        
        return response()->json([
            'success'=>true, 
            'status'=>$status,
            'id'=>$id,
        ]);
    }
   
    public function destroy($id)
    {
       
        $delete = SubMenu::find($id)->delete();
        if ($delete) {
            return response()->json(["success" => true]);
        } else {
            return response()->json(["success" => false]);
        }
    }

   
}
