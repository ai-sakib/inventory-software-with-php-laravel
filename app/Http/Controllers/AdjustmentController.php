<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers;
use App\Models\Location;
use App\Models\SalesType;
use App\Models\Customer;
use App\Models\Supplier;
use App\Models\Item;
use App\Models\ItemCategory;
use App\Models\StockIn;
use App\Models\StockInDetails;
use App\Models\StockMoves;

class AdjustmentController extends Controller
{
  
    public function index()
    {
        $locations = Location::orderBy('id','desc')->where('status', 1)->get();
        $itemCategories = ItemCategory::orderBy('id','desc')->where('status', 1)->get();

        return view('admin.adjust.index',compact('locations','itemCategories'));
    }

    public function adjustmentHistory()
    {
        $adjustments = StockMoves::orderBy('trans_no','desc')->where('stock_type', 4)->get();
        return view('admin.adjust.history',compact('adjustments'));
    }

   
    public function create()
    {   
        $items = session()->get('adjustItems');
        if(!empty($items)){
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

    public function stockInLists(){
        $stockInLists = StockIn::orderBy('id','desc')->get();
        return view('admin.stockIn.stockInLists',compact('stockInLists'));
    }

    public function getDetails($stockInID){
        $stockInDetails = StockInDetails::orderBy('id','desc')->where('stock_in_id',$stockInID)->get();
        return view('admin.stockIn.getDetails',compact('stockInDetails'));
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'location_id' => 'required',
            'adjustment_date' => 'required',
        ]);

        $items = session()->get('adjustItems');
        if(empty($items)){
            session()->flash('error','Please add at least one item !');
            return redirect()->back();
        }

        $count = 0;
        $trans_no = transferNo(4);
        foreach ($items as $key => $item) {

            $quantity = $item['quantity'];
            if($item['status'] == '0'){
                $quantity = - $item['quantity'];
            }
            StockMoves::insert([
                'trans_no' => $trans_no,
                'stock_type' => 4,
                'item_id' => $item['item_id'],
                'location_id' => $request->location_id,
                'quantity' => $quantity,
                'stock_move_date' => date('Y-m-d',strtotime($request->adjustment_date)),
            ]);
            $count++;
        }

        if(count($items) == $count){
            session()->forget('adjustItems');
            session()->flash('success','Items have successfully adjusted !');
            return redirect()->back();
        }else{
            session()->forget('adjustItems');
            StockMoves::where('stock_type', 4)->where('trans_no',$trans_no)->delete();

            session()->flash('error','Something Went Wrong !');
            return redirect()->back();
        }


    }
    
    public function edit($data)
    {
        $item_id=explode('&',$data)[0];
        $quantity=explode('&',$data)[1];
        $location_id=explode('&',$data)[2];

        $items=\Session::get('adjustItems');

        if($items[$item_id]["status"] == '0'){
            $quantityInStock = StockMoves::where(['item_id'=>$item_id,'location_id'=>$location_id])->sum('quantity');
            if(($quantityInStock - $quantity) < 0){
                return response()->json(["success"=>false,"message"=>"Stock can't be less than 0 in <strong>".Location::find($location_id)->name.'</strong> !']);
            }
        }

        $items[$item_id]["quantity"] = $quantity;

        \Session::put("adjustItems", $items);
        return response()->json(["success"=>true]);
    }

    public function update(Request $request, $id)
    {
    }

    public function show($data)
    {
        $items = session()->get('adjustItems');

        $category_id = explode('&', $data)[0];
        $item_id = explode('&', $data)[1];
        $quantity = explode('&', $data)[2];
        $location_id = explode('&', $data)[3];
        $status = explode('&', $data)[4];

        if($status == '0'){
            $quantityInStock = StockMoves::where(['item_id'=>$item_id,'location_id'=>$location_id])->sum('quantity');
            if(($quantityInStock - $quantity) < 0){
                return response()->json(["success"=>false,"message"=>"Stock can't be less than 0 in <strong>".Location::find($location_id)->name.'</strong> !']);
            }
        }
        

        $category = ItemCategory::find($category_id);
        $item = Item::find($item_id);

        $stock = array();
        $stock['category_name'] = $category->name;
        $stock['item_id'] = $item_id;
        $stock['item_name'] = $item->name;
        $stock['quantity'] = $quantity;
        $stock['status'] = $status;

        if(!empty($items)){
            if(!array_key_exists($item_id,$items)){
                session()->put('adjustItems.'.$item_id, $stock);
            }else{
                return response()->json(["success"=>false,"message"=>"This item is already added !"]);
            }
        }else{
            session()->put('adjustItems.'.$item_id, $stock);
        }

        if($quantity > 0){
            return response()->json(["success"=>true]);
        }else{
            return response()->json(["success"=>false]);
        }
    }

    public function addItem($data){
        
    }

    public function selectCategory($category_id)
    {
        $items = Item::orderBy('id','desc')->where(['status' => 1, 'category_id' => $category_id])->get();
        if(isset($items[0]->id)){
            return response()->json([
                'success'=>true, 
                'items'=>$items,
            ]);
        }else{
            return response()->json([
                'success'=>false, 
            ]);
        }
        
    }

    public function selectItem($item_id)
    {
        $item = Item::find($item_id);
        if(isset($item->id)){
            return response()->json([
                'success'=>true, 
                'price'=>$item->purchase_price,
            ]);
        }else{
            return response()->json([
                'success'=>false, 
            ]);
        }
        
    }
   
    public function destroy($id)
    {
        $items=\Session::get('adjustItems');
        unset($items[$id]);
        \Session::put("adjustItems", $items);
        return response()->json(["success"=>true]);
    }

   
}
