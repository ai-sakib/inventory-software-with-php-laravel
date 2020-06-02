<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers;
use App\Models\StockMoves;
use App\Models\ItemCategory;
use App\Models\Location;
use App\Models\Item;

class StockStatusController extends Controller
{
  
    public function locationWise()
    {
        $locations=Location::where('status', 1)->orderBy('id','desc')->get();
        $itemCategories=ItemCategory::where('status', 1)->orderBy('id','desc')->get();
        return view('admin.stockStatus.locationWise.index',compact('locations','itemCategories'));
    }
    public function locationWiseSearch($data)
    {
        $location_id = explode('&', $data)[0];
        $category_id = explode('&', $data)[1];
        $item_id = explode('&', $data)[2];

        $locations = Location::where('status', 1)->orderBy('id','desc')
                    ->when($location_id != '0', function($query) use ($location_id){
                        return $query->where('id',$location_id);
                    })->get();

        return view('admin.stockStatus.locationWise.search',compact('locations','category_id','item_id'));
    }

    public function productWise()
    {
        $locations=Location::where('status', 1)->orderBy('id','desc')->get();
        $itemCategories=ItemCategory::where('status', 1)->orderBy('id','desc')->get();
        $items=Item::where('status', 1)->orderBy('id','desc')->get();
        return view('admin.stockStatus.productWise.index',compact('locations','itemCategories','items'));
    }

    public function productWiseSearch($data)
    {
        $location_id = explode('&', $data)[0];
        $category_id = explode('&', $data)[1];
        $item_id = explode('&', $data)[2];

        $items = Item::where('status', 1)->orderBy('id','desc')
                    ->when($category_id != '0', function($query) use ($category_id){
                        return $query->where('category_id',$category_id);
                    })
                    ->when($item_id != '0', function($query) use ($item_id){
                        return $query->where('id',$item_id);
                    })->get();

        return view('admin.stockStatus.productWise.search',compact('items','category_id','item_id','location_id'));
    }

    public function selectCategory($category_id)
    {
        $items=Item::where('status', 1)->where('category_id',$category_id)->orderBy('id','desc')->get();
        if(isset($items[0]->id)){
            return response()->json([
                'success' => true,
                'items' => $items,
            ]);
        }else{
            return response()->json([
                'success' => false,
            ]);
        }
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
