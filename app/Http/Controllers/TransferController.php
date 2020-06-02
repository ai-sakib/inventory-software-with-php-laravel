<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers;
use App\Models\Location;
use App\Models\Item;
use App\Models\ItemCategory;
use App\Models\StockMoves;

class TransferController extends Controller
{
  
    public function index()
    {
        $locations = Location::orderBy('id','desc')->where('status', 1)->get();
        $itemCategories = ItemCategory::orderBy('id','desc')->where('status', 1)->get();

        return view('admin.transfer.index',compact('locations','itemCategories'));
    }

    public function transferHistory()
    {
        $transfers = StockMoves::orderBy('trans_no','desc')->where('quantity', '>', 0)->where('stock_type', 3)->get();
        return view('admin.transfer.history',compact('transfers'));
    }

    public function quantityAlert($data){
        $quantity = explode('&', $data)[0];
        $item_id = explode('&', $data)[1];
        $location_id = explode('&', $data)[2];

        $quantityInStock = StockMoves::where(['item_id'=>$item_id,'location_id'=>$location_id])->sum('quantity');
        if($quantity > $quantityInStock){
            return response()->json(["success"=>true,"message"=>'* limited stock']);
        }
        return response()->json(["success"=>false]);
    }
   
    public function create()
    {   
        $items = session()->get('transferItems');
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
        if($request->from_location_id == $request->to_location_id){
            session()->flash('error',"'From Location' and 'To Location' can't be same !");
            return redirect()->back();
        }
        $this->validate($request,[
            'from_location_id' => 'required',
            'to_location_id' => 'required',
        ]);
        $items = session()->get('transferItems');

        if(empty($items)){
            session()->flash('error','Please add at least one item !');
            return redirect()->back();
        }

        $data = '';
        $limitedStockArray = array();
        foreach ($items as $key => $value) {
            $stockQuanitity = StockMoves::where('item_id',$value['item_id'])->where('location_id', $request->from_location_id)->sum('quantity');
            if($value['quantity'] > $stockQuanitity){
                array_push($limitedStockArray, Item::find($value['item_id'])->name);
            }
        }
        if(isset($limitedStockArray[0])){
            $countLimitedStock = count($limitedStockArray);
            for ($i=0; $i < $countLimitedStock; $i++) { 
                if($i < $countLimitedStock - 1){
                    if($i == $countLimitedStock - 2){
                        $data .= '<strong>'.$limitedStockArray[$i].'</strong> and ';
                    }else{
                        $data .= '<strong>'.$limitedStockArray[$i].'</strong>, ';
                    }
                }else{
                    $data .= '<strong>'.$limitedStockArray[$i].'</strong>';
                }
            }
            session()->flash('error','Stock Limited for '.$data.' in <strong>'.Location::find($request->from_location_id)->name.'</strong>');
            return redirect()->back();
        }
        
        $count = 0;
        $trans_no = transferNo(3);
        foreach ($items as $key => $item) {

            StockMoves::insert([
                'trans_no' => $trans_no,
                'stock_type' => 3,
                'item_id' => $item['item_id'],
                'location_id' => $request->from_location_id,
                'quantity' => -($item['quantity']),
                'stock_move_date' => date('Y-m-d',strtotime($request->transfer_date)),
            ]);

            StockMoves::insert([
                'trans_no' => $trans_no,
                'stock_type' => 3,
                'item_id' => $item['item_id'],
                'from_location_id' => $request->from_location_id,
                'location_id' => $request->to_location_id,
                'quantity' => $item['quantity'],
                'stock_move_date' => date('Y-m-d',strtotime($request->transfer_date)),
            ]);
            $count++;
        }

        if(count($items) == $count){
            session()->forget('transferItems');
            session()->flash('success','Items have successfully transfered !');
            return redirect()->back();
        }else{
            session()->forget('transferItems');
            StockMoves::where('stock_type', 3)->where('trans_no',$trans_no)->delete();

            session()->flash('error','Something Went Wrong !');
            return redirect()->back();
        }


    }
    
    public function edit($data)
    {
        $item_id=explode('&',$data)[0];
        $quantity=explode('&',$data)[1];
        $location_id=explode('&',$data)[2];

        $items=\Session::get('transferItems');

        $quantityInStock = StockMoves::where(['item_id'=>$item_id,'location_id'=>$location_id])->sum('quantity');
        if($quantity > $quantityInStock){
            return response()->json(["success"=>false,"message"=>"Stock is limited !"]);
        }

        $items[$item_id]["quantity"] = $quantity;

        \Session::put("transferItems", $items);
        return response()->json(["success"=>true]);
    }

    public function update(Request $request, $id)
    {
    }



    public function show($data)
    {
        $items = session()->get('transferItems');

        $category_id = explode('&', $data)[0];
        $item_id = explode('&', $data)[1];
        $quantity = explode('&', $data)[2];
        $location_id = explode('&', $data)[3];

        $quantityInStock = StockMoves::where(['item_id'=>$item_id,'location_id'=>$location_id])->sum('quantity');
        if($quantity > $quantityInStock){
            return response()->json(["success"=>false,"message"=>"Stock is limited !"]);
        }

        $category = ItemCategory::find($category_id);
        $item = Item::find($item_id);

        $stock = array();
        $stock['category_name'] = $category->name;
        $stock['item_id'] = $item_id;
        $stock['item_name'] = $item->name;
        $stock['quantity'] = $quantity;

        if(!empty($items)){
            if(!array_key_exists($item_id,$items)){
                session()->put('transferItems.'.$item_id, $stock);
            }
        }else{
            session()->put('transferItems.'.$item_id, $stock);
        }

        if($quantity > 0){
            return response()->json(["success"=>true]);
        }else{
            return response()->json(["success"=>false]);
        }
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
   
    public function destroy($id)
    {
        $items=\Session::get('transferItems');
        unset($items[$id]);
        \Session::put("transferItems", $items);
        return response()->json(["success"=>true]);
    }

   
}
