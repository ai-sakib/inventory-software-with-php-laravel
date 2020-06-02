<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers;
use App\Models\Location;
use App\Models\SalesType;
use App\Models\Customer;
use App\Models\Item;
use App\Models\ItemCategory;
use App\Models\StockOut;
use App\Models\StockOutDetails;
use App\Models\StockMoves;
use Auth;

class StockOutController extends Controller
{
  
    public function index()
    {
        $locations = Location::orderBy('id','desc')->where('status', 1)->get();
        $customers = Customer::orderBy('id','desc')->where('status', 1)->get();
        $salesTypes = SalesType::where('status', 1)->get();
        $itemCategories = ItemCategory::orderBy('id','desc')->where('status', 1)->get();

        return view('admin.stockOut.index',compact('locations','customers','itemCategories','salesTypes'));
    }

    public function clearPayment($id)
    {
        $stockOut = StockOut::find($id);
        $stockOut->paid = $stockOut->total_price;
        $stockOut->save();
        return response()->json([
            'success'=>true,
            'id'=>$id,
            'paid'=>$stockOut->total_price,
        ]);
    }

    public function setPayment($data)
    {
        $id = explode('&', $data)[0];
        $payment = explode('&', $data)[1];

        $stockOut = StockOut::find($id);
        $stockOut->paid = $stockOut->paid + $payment;
        $stockOut->save();
        return response()->json([
            'success'=>true,
            'id'=>$id,
            'paid'=>$stockOut->paid,
        ]);
    }

    public function selectCustomer($customer_id)
    {
        $tax = Customer::find($customer_id)->tax;
        if((int)($tax) == 0){
            $tax = 0;
        }
        return response()->json([
            'success' => true,
            'tax' => $tax,
        ]);
    }

   
    public function create()
    {   
        $items = session()->get('stockOutItems');
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

    public function stockOutLists(){
        //StockOut::where('id','>', 0)->update(['paid'=>0]);
        $stockOutLists = StockOut::orderBy('id','desc')->get();
        return view('admin.stockOut.stockOutLists',compact('stockOutLists'));
    }

    public function getDetails($stockOutID){
        $stockOut = StockOut::find($stockOutID);
        $stockOutDetails = StockOutDetails::orderBy('id','desc')->where('stock_out_id',$stockOutID)->get();
        return view('admin.stockOut.getDetails',compact('stockOut','stockOutDetails'));
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'customer_id' => 'required',
            'sales_type_id' => 'required',
            'location_id' => 'required',
        ]);

        if($request->discount > $request->total_amount || $request->payment > $request->total_amount){
            session()->flash('error','Whoops ! something went wrong !');
            return redirect()->back();
        }
        $items = session()->get('stockOutItems');
        if(empty($items)){
            session()->flash('error','Please add at least one item !');
            return redirect()->back();
        }

        $data = '';
        $limitedStockArray = array();
        foreach ($items as $key => $value) {
            $stockQuanitity = StockMoves::where('item_id',$value['item_id'])->where('location_id', $request->location_id)->sum('quantity');
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
            session()->flash('error','Stock Limited for '.$data);
            return redirect()->back();
        }

        $tax = Customer::find($request->customer_id)->tax;

        $stockOut = new StockOut();
        $stockOut->fill($request->all());
        $stockOut->tax = $tax;
        $stockOut->stock_out_date = date('Y-m-d',strtotime($request->stock_out_date));
        $stockOut->created_by = Auth::id();
        $stockOut->save();

        $count = 0;
        $total_price = 0;
        if($stockOut){
            foreach ($items as $key => $item) {
                $total_price += $item['price']*$item['quantity'];
                StockOutDetails::insert([
                    'stock_out_id' => $stockOut->id,
                    'item_id' => $item['item_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);

                StockMoves::insert([
                    'trans_no' => $stockOut->id,
                    'stock_type' => 2,
                    'item_id' => $item['item_id'],
                    'location_id' => $request->location_id,
                    'quantity' => -($item['quantity']),
                    'price' => $item['price'],
                    'stock_move_date' => date('Y-m-d',strtotime($request->stock_in_date)),
                ]);
                $count++;
            }

            $stockOut->total_price = ($total_price * $tax)/100 + $total_price - $request->discount;
            $stockOut->save();
        }

        if(count($items) == $count){
            session()->forget('stockOutItems');
            session()->flash('success','Items have successfully stocked out!');
            return redirect()->back();
        }else{
            session()->forget('stockOutItems');
            StockOut::find($stockOut->id)->delete();
            StockOutDetails::where('stock_out_id',$stockOut->id)->delete();
            StockMoves::where('stock_type', 2)->where('trans_no',$stockOut->id)->delete();

            session()->flash('error','Something Went Wrong !');
            return redirect()->back();
        }


    }
    
    public function edit($data)
    {
        $item_id=explode('&',$data)[0];
        $quantity=explode('&',$data)[1];
        $price=explode('&',$data)[2];
        $location_id=explode('&',$data)[3];

        $items=\Session::get('stockOutItems');

        $quantityInStock = StockMoves::where(['item_id'=>$item_id,'location_id'=>$location_id])->sum('quantity');
        if($quantity > $quantityInStock){
            return response()->json(["success"=>false,"message"=>"Stock is limited !"]);
        }

        $items[$item_id]["quantity"] = $quantity;
        $items[$item_id]["price"] = $price;

        \Session::put("stockOutItems", $items);
        return response()->json(["success"=>true]);
    }

    public function update(Request $request, $id)
    {
    }



    public function show($data)
    {
        $items = session()->get('stockOutItems');

        $category_id = explode('&', $data)[0];
        $item_id = explode('&', $data)[1];
        $quantity = explode('&', $data)[2];
        $price = explode('&', $data)[3];
        $location_id = explode('&', $data)[4];

        $quantityInStock = StockMoves::where(['item_id'=>$item_id,'location_id'=>$location_id])->sum('quantity');
        if($quantity > $quantityInStock){
            return response()->json(["success"=>false,"message"=>"Stock is limited !"]);
        }

        $category = ItemCategory::find($category_id);
        $item = Item::find($item_id);

        $stock = array();
        $stock['category_name'] = $category->name;
        $stock['item_id'] = $item_id;
        $stock['location_id'] = $location_id;
        $stock['item_name'] = $item->name;
        $stock['quantity'] = $quantity;
        $stock['price'] = $price;

        if(!empty($items)){
            if(!array_key_exists($item_id,$items)){
                session()->put('stockOutItems.'.$item_id, $stock);
            }else{
                return response()->json(["success"=>false,"message"=>"This item is already added !"]);
            }
        }else{
            session()->put('stockOutItems.'.$item_id, $stock);
        }

        if($quantity > 0){
            return response()->json(["success"=>true]);
        }else{
            return response()->json(["success"=>false,"message"=>"Quantity must be greater than 0 !"]);
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

    public function selectItem($data){
        $sales_type_id = explode('&', $data)[0];
        $item_id = explode('&', $data)[1];

        $item = Item::find($item_id);

        if(isset($item->id)){
            $price = 0;
            if($sales_type_id == '1'){
                $price = $item->retail_price;
            }elseif($sales_type_id == '2'){
                $price = $item->wholesale_price;
            }
            return response()->json([
                'success'=>true, 
                'price'=>$price,
            ]);
        }else{
            return response()->json([
                'success'=>false, 
            ]);
        }
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
   
    public function destroy($id)
    {
        $items=\Session::get('stockOutItems');
        unset($items[$id]);
        \Session::put("stockOutItems", $items);
        return response()->json(["success"=>true]);
    }

   
}
