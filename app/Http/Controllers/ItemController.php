<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers;
use App\Models\Item;
use App\Models\Price;
use App\Models\ItemCategory;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
  
    public function index()
    {
        $items=Item::orderBy('id','desc')->get();
        return view('admin.item.index',compact('items'));
    }

   
    public function create()
    {   
        $itemCategories = ItemCategory::where('status',1)->get();
        return view('admin.item.create',compact('itemCategories'));
    }

    public function store(Request $request, Item $item, Price $price )
    {
        $this->validate($request, [
            'name'=> 'required',
            'category_id'=> 'required',
            'details'=> 'required',
        ]);
        $item->fill($request->all());
        $item->uid = uniqueCode(10,'i-','uid','items');
        $item->save();

        $price->fill($request->all());
        $price->item_id = $item->id;
        $price->save();

        if($item){ 
            session()->flash('success', 'Items has been added Successfully');
            if(isset($item)){
                $file=$request->file('file');
                if(isset($file)){
                    $fileInfo=fileInfo($file);
                    $image=$item->id.'-'.date('YmdHis').'.'.$fileInfo['extension']; 
                    $upload=fileUpload($file,'items',$image);
                    Item::where('id',$item->id)->update(['image'=>$image]);
                }
                return redirect()->back();
            }
            return redirect()->back();
        }else{
            session()->flash('error', 'Something Went Wrong !');
            return redirect()->back();
        }
    }
    
    public function edit($id)
    {
        $itemCategories = ItemCategory::where('status',1)->get();
        $item = Item::find($id);
        return view('admin.item.edit', compact('item','itemCategories'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name'=> 'required',
            'category_id'=> 'required',
            'details'=> 'required',
        ]);
        $item = Item::find($id);
        $item->fill($request->all());
        $item->save();

        $price = new Price();
        $price->fill($request->all());
        $price->item_id = $id;
        $price->save();

        if($item) {    
            session()->flash('success', 'Items has been updated Successfully');
            if(isset($item)){
                $file=$request->file('file');
                if(isset($file)){
                    if($item->image != "" && file_exists(public_path('items/').$item->image)){
                        unlink(public_path('items/').$item->image);
                    }
                    $fileInfo=fileInfo($file);
                    $image=$item->id.'-'.date('YmdHis').'.'.$fileInfo['extension']; 
                    $upload=fileUpload($file,'items',$image);
                    Item::where('id',$item->id)->update(['image'=>$image]);
                }
                return redirect()->back();
            }
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

        Item::find($id)->update(['status'=>$status]);
        
        return response()->json([
            'success'=>true, 
            'status'=>$status,
            'id'=>$id,
        ]);
    }
   
    public function destroy($id){
        $item = Customer::find($id);
        $delete = $item->delete();
        if($delete) {
            if($item->image != "" && file_exists(public_path('items/').$item->image)){
                unlink(public_path('items/').$item->image);
            }
            return response()->json(["success" => true]);
        }else{
            return response()->json(["success" => false]);
        }
    }
}
