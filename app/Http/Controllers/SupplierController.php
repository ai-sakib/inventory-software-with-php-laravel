<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers;
use App\Models\Supplier;
use App\Models\StockIn;

class SupplierController extends Controller
{
  
    public function index()
    {
        //StockIn::where('id','>', 0)->update(['paid'=>0]);
        $suppliers=Supplier::orderBy('id','desc')->get();
        return view('admin.supplier.index',compact('suppliers'));
    }

    public function viewPayment($supplier_id)
    {
        $stockInDetails = StockIn::orderBy('id','desc')->whereRaw('total_price > paid')->where('supplier_id',$supplier_id)->get();
        return view('admin.supplier.viewPayment',compact('stockInDetails'));
    }

    public function clearPayment($supplier_id)
    {
        $stockIn = StockIn::where('supplier_id',$supplier_id)->get();
        $total = 0;
        foreach ($stockIn as $value) {
            StockIn::where('id',$value->id)->update(['paid'=>$value->total_price]);
            $total += $value->total_price;
        }
        return response()->json([
            'success'=>true,
            'id'=>$supplier_id,
            'paid'=>$total,
        ]);
    }

    public function checkPayment($supplier_id)
    {

        $main_total = StockIn::where('supplier_id',$supplier_id)->sum('total_price');
        $main_paid = StockIn::where('supplier_id',$supplier_id)->sum('paid');

        return response()->json([
            'success'=>true,
            'main_total'=>$main_total,
            'main_paid'=>$main_paid,
        ]);
    }

    public function clearPaymentEach($id)
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

   
    public function create(){   
        return view('admin.supplier.create');
    }

    public function store(Request $request, Supplier $supplier )
    {
        $this->validate($request, [
            'name'=> 'required',
            'address'=> 'required',
            'phone'=> 'required',
            'email'=> 'required',
        ]);
        $supplier->fill($request->all());
        $supplier->uid = uniqueCode(10,'c-','uid','items');
        $supplier->save();
        if($supplier) {    
            session()->flash('success', 'Cutomer has been added Successfully');
            $file=$request->file('file');
            if(isset($file)){
                $fileInfo=fileInfo($file);
                $image=$supplier->id.'-'.date('YmdHis').'.'.$fileInfo['extension']; 
                $upload=fileUpload($file,'suppliers',$image);
                Supplier::where('id',$supplier->id)->update(['image'=>$image]);
            }
        }else{
            session()->flash('error', 'Something Went Wrong !');
        }
        return redirect()->back();
    }
    
    public function edit($id)
    {
        $supplier = Supplier::find($id);
        return view('admin.supplier.edit', compact('supplier'));
    }

    public function update(Request $request, $id)
    {
          $this->validate($request, [
            'name'=> 'required',
            'address'=> 'required',
            'phone'=> 'required',
            'email'=> 'required',
        ]);
        $supplier = Supplier::find($id);
        $supplier->fill($request->all());
        $supplier->save();
        if($supplier) {    
            session()->flash('success', 'Cutomer has been updated Successfully');
            $file=$request->file('file');
            if(isset($file)){
                if($supplier->image != "" && file_exists(public_path('suppliers/').$supplier->image)){
                    unlink(public_path('suppliers/').$supplier->image);
                }
                $fileInfo=fileInfo($file);
                $image=$supplier->id.'-'.date('YmdHis').'.'.$fileInfo['extension']; 
                $upload=fileUpload($file,'suppliers',$image);
                Supplier::where('id',$supplier->id)->update(['image'=>$image]);
            }
        }else{
            session()->flash('error', 'Something Went Wrong !');
        }
        return redirect()->back();
    }
    public function show($data)
    {
        $id = explode('&', $data)[0];
        $status = explode('&', $data)[1];

        Supplier::find($id)->update(['status'=>$status]);
        
        return response()->json([
            'success'=>true, 
            'status'=>$status,
            'id'=>$id,
        ]);
    }
   
    public function destroy($id){
        $supplier = Supplier::find($id);
        $delete = $supplier->delete();
        if($delete) {
            if($supplier->image != "" && file_exists(public_path('suppliers/').$supplier->image)){
                unlink(public_path('suppliers/').$supplier->image);
            }
            return response()->json(["success" => true]);
        }else{
            return response()->json(["success" => false]);
        }
    }
}
