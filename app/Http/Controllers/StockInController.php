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

class StockInController extends Controller
{
  
    public function index()
    {
        $locations = Location::orderBy('id','desc')->where('status', 1)->get();
        $suppliers = Supplier::orderBy('id','desc')->where('status', 1)->get();
        $itemCategories = ItemCategory::orderBy('id','desc')->where('status', 1)->get();

        return view('admin.stockIn.index',compact('locations','suppliers','itemCategories'));
    }

    public function clearPayment($id)
    {
        $stockIn = StockIn::find($id);
        $stockIn->paid = $stockIn->total_price;
        $stockIn->save();
        return response()->json([
            'success'=>true,
            'id'=>$id,
            'paid'=>$stockIn->total_price,
        ]);
    }

    public function setPayment($data)
    {
        $id = explode('&', $data)[0];
        $payment = explode('&', $data)[1];

        $stockIn = StockIn::find($id);
        $stockIn->paid = $stockIn->paid + $payment;
        $stockIn->save();
        return response()->json([
            'success'=>true,
            'id'=>$id,
            'paid'=>$stockIn->paid,
        ]);
    }

    public function selectSupplier($supplier_id)
    {
        $tax = Supplier::find($supplier_id)->tax;
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
        $items = session()->get('stockInItems');
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
        $locations = Location::get();
        $suppliers = Supplier::get();
        $stockInLists = StockIn::orderBy('id','desc')->get();
        return view('admin.stockIn.stockInLists',compact('stockInLists','suppliers','locations'));
    }

    public function search(Request $request){

        $from_date = date('Y-m-d',strtotime($request->from_date));
        $to_date = date('Y-m-d',strtotime($request->to_date));
        $supplier_id = $request->supplier_id;
        $location_id = $request->location_id;
        $payment_status = $request->payment_status;

        $info = array(
            'from_date' => $from_date,
            'to_date' => $to_date,
            'supplier_id' => $supplier_id,
            'location_id' => $location_id,
            'payment_status' => $payment_status,
        );

        $locations = Location::get();
        $suppliers = Supplier::get();
        $stockInLists = StockIn::orderBy('id','desc')
                        ->where([['stock_in_date', '>=', $from_date], ['stock_in_date', '<=', $to_date]])
                        ->when($supplier_id != '0', function($query) use($supplier_id){
                            return $query->where('supplier_id',$supplier_id);
                        })
                        ->when($location_id != '0', function($query) use($location_id){
                            return $query->where('location_id',$location_id);
                        })
                        ->when($payment_status == '1', function($query) {
                            return $query->whereRaw('total_price = paid');
                        })
                        ->when($payment_status == '2', function($query) {
                            return $query->whereRaw('paid < total_price');
                        })
                        ->get();
        return view('admin.stockIn.stockInLists',compact('stockInLists','suppliers','locations','info'));
    }

    public function getDetails($stockInID){
        $stockInDetails = StockInDetails::orderBy('id','desc')->where('stock_in_id',$stockInID)->get();
        return view('admin.stockIn.getDetails',compact('stockInDetails'));
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'supplier_id' => 'required',
            'location_id' => 'required',
        ]);
        $items = session()->get('stockInItems');
        if(empty($items)){
            session()->flash('error','Please add at least one item !');
            return redirect()->back();
        }

        $tax = Supplier::find($request->supplier_id)->tax;
        
        $stockIn = new StockIn();
        $stockIn->fill($request->all());
        $stockIn->tax = $tax;
        $stockIn->stock_in_date = date('Y-m-d',strtotime($request->stock_in_date));
        $stockIn->save();

        $count = 0;
        $total_price = 0;
        if($stockIn){
            foreach ($items as $key => $item) {
                $total_price += $item['price']*$item['quantity'];
                StockInDetails::insert([
                    'stock_in_id' => $stockIn->id,
                    'item_id' => $item['item_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);

                StockMoves::insert([
                    'trans_no' => $stockIn->id,
                    'stock_type' => 1,
                    'item_id' => $item['item_id'],
                    'location_id' => $request->location_id,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'stock_move_date' => date('Y-m-d',strtotime($request->stock_in_date)),
                ]);
                $count++;
            }

            $stockIn->total_price = ($total_price * $tax)/100 + $total_price - $request->discount;
            $stockIn->save();
        }

        if(count($items) == $count){
            session()->forget('stockInItems');
            session()->flash('success','Items have successfully stocked !');
            return redirect()->back();
        }else{
            session()->forget('stockInItems');
            StockIn::find($stockIn->id)->delete();
            StockInDetails::where('stock_in_id',$stockIn->id)->delete();
            StockMoves::where('stock_type', 1)->where('trans_no',$stockIn->id)->delete();

            session()->flash('error','Something Went Wrong !');
            return redirect()->back();
        }


    }
    
    public function edit($data)
    {
        $item_id=explode('&',$data)[0];
        $quantity=explode('&',$data)[1];
        $price=explode('&',$data)[2];

        $items=\Session::get('stockInItems');

        $items[$item_id]["quantity"] = $quantity;
        $items[$item_id]["price"] = $price;

        \Session::put("stockInItems", $items);
        return response()->json(["success"=>true]);
    }

    public function update(Request $request, $id)
    {
    }



    public function show($data)
    {
        $items = session()->get('stockInItems');

        $category_id = explode('&', $data)[0];
        $item_id = explode('&', $data)[1];
        $quantity = explode('&', $data)[2];
        $price = explode('&', $data)[3];

        $category = ItemCategory::find($category_id);
        $item = Item::find($item_id);

        $stock = array();
        $stock['category_name'] = $category->name;
        $stock['item_id'] = $item_id;
        $stock['item_name'] = $item->name;
        $stock['quantity'] = $quantity;
        $stock['price'] = $price;

        if(!empty($items)){
            if(!array_key_exists($item_id,$items)){
                session()->put('stockInItems.'.$item_id, $stock);
            }
        }else{
            session()->put('stockInItems.'.$item_id, $stock);
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
        $items=\Session::get('stockInItems');
        unset($items[$id]);
        \Session::put("stockInItems", $items);
        return response()->json(["success"=>true]);
    }

   
}
