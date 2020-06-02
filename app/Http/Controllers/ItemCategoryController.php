<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers;
use App\Models\ItemCategory;

class ItemCategoryController extends Controller
{
  
    public function index()
    {
        $ItemCategories=ItemCategory::orderBy('id','desc')->get();
        return view('admin.itemCategory.index',compact('ItemCategories'));
    }

   
    public function create()
    {   
        return view('admin.itemCategory.create');
    }

    public function store(Request $request, ItemCategory $ItemCategories )
    {
        $this->validate($request, [
            'name'=> 'required',
        ]);

        $ItemCategories->fill($request->all());
        //$ItemCategories->created_by=admin_id();
        $ItemCategories->save();
        if($ItemCategories) {    
            session()->flash('success', 'ItemCategories has been added Successfully');
            return redirect()->back();
        }else{
            session()->flash('error', 'Something Went Wrong !');
            return redirect()->back();
        }
    }
    
    public function edit($id)
    {
        $ItemCategories = ItemCategory::find($id);
        return view('admin.itemCategory.edit', compact('ItemCategories'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name'=> 'required',
        ]);
        $ItemCategories = ItemCategory::find($id);
        $ItemCategories->fill($request->all());
        //$ItemCategories->created_by=admin_id();
        $ItemCategories->save();
        if($ItemCategories) {    
            session()->flash('success', 'ItemCategories has been added Successfully');
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

        ItemCategory::find($id)->update(['status'=>$status]);
        
        return response()->json([
            'success'=>true, 
            'status'=>$status,
            'id'=>$id,
        ]);
    }
   
    public function destroy($id)
    {
       
        $delete = ItemCategory::find($id)->delete();
        if ($delete) {
            return response()->json(["success" => true]);
        } else {
            return response()->json(["success" => false]);
        }
    }

   
}
