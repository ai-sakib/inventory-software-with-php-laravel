<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers;
use App\Models\Customer;
use App\Models\StockOut;

class CustomerController extends Controller
{
  
    public function index()
    {
        //StockOut::where('id','>', 0)->update(['paid'=>0]);
        $customers=Customer::orderBy('id','desc')->get();
        return view('admin.customer.index',compact('customers'));
    }

    public function viewPayment($customer_id)
    {
        $stockOutDetails = StockOut::orderBy('id','desc')->whereRaw('total_price > paid')->where('customer_id',$customer_id)->get();
        return view('admin.customer.viewPayment',compact('stockOutDetails'));
    }

    public function clearPayment($customer_id)
    {
        $stockOut = StockOut::where('customer_id',$customer_id)->get();
        $total = 0;
        foreach ($stockOut as $value) {
            StockOut::where('id',$value->id)->update(['paid'=>$value->total_price]);
            $total += $value->total_price;
        }
        return response()->json([
            'success'=>true,
            'id'=>$customer_id,
            'paid'=>$total,
        ]);
    }

    public function checkPayment($customer_id)
    {

        $main_total = StockOut::where('customer_id',$customer_id)->sum('total_price');
        $main_paid = StockOut::where('customer_id',$customer_id)->sum('paid');

        return response()->json([
            'success'=>true,
            'main_total'=>$main_total,
            'main_paid'=>$main_paid,
        ]);
    }

    public function clearPaymentEach($id)
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

   
    public function create(){   
        return view('admin.customer.create');
    }

    public function store(Request $request, Customer $customer )
    {
        $this->validate($request, [
            'name'=> 'required',
            'address'=> 'required',
            'phone'=> 'required',
            'email'=> 'required',
        ]);
        $customer->fill($request->all());
        $customer->uid = uniqueCode(10,'c-','uid','items');
        $customer->save();
        if($customer) {    
            session()->flash('success', 'Cutomer has been added Successfully');
            $file=$request->file('file');
            if(isset($file)){
                $fileInfo=fileInfo($file);
                $image=$customer->id.'-'.date('YmdHis').'.'.$fileInfo['extension']; 
                $upload=fileUpload($file,'customers',$image);
                Customer::where('id',$customer->id)->update(['image'=>$image]);
            }
        }else{
            session()->flash('error', 'Something Went Wrong !');
        }
        return redirect()->back();
    }
    
    public function edit($id)
    {
        $customer = Customer::find($id);
        return view('admin.customer.edit', compact('customer'));
    }

    public function update(Request $request, $id)
    {
          $this->validate($request, [
            'name'=> 'required',
            'address'=> 'required',
            'phone'=> 'required',
            'email'=> 'required',
        ]);
        $customer = Customer::find($id);
        $customer->fill($request->all());
        $customer->save();
        if($customer) {    
            session()->flash('success', 'Cutomer has been updated Successfully');
            $file=$request->file('file');
            if(isset($file)){
                if($customer->image != "" && file_exists(public_path('customers/').$customer->image)){
                    unlink(public_path('customers/').$customer->image);
                }
                $fileInfo=fileInfo($file);
                $image=$customer->id.'-'.date('YmdHis').'.'.$fileInfo['extension']; 
                $upload=fileUpload($file,'customers',$image);
                Customer::where('id',$customer->id)->update(['image'=>$image]);
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

        Customer::find($id)->update(['status'=>$status]);
        
        return response()->json([
            'success'=>true, 
            'status'=>$status,
            'id'=>$id,
        ]);
    }
   
    public function destroy($id){
        $customer = Customer::find($id);
        $delete = $customer->delete();
        if($delete) {
            if($customer->image != "" && file_exists(public_path('customers/').$customer->image)){
                unlink(public_path('customers/').$customer->image);
            }
            return response()->json(["success" => true]);
        }else{
            return response()->json(["success" => false]);
        }
    }
}
