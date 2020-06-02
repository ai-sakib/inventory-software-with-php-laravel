<?php
function admin_id(){
	return \Auth::id();
}

function stockType($i = false)
{
  $stockType = array(
    '1' => "Stock In",
    '2' => "Stock Out",
    '3' => "Transfer",
    '4' => "Adjustments",
    
  );
  if($i){
    if(isset($stockType[$i])){
      return $stockType[$i];
    }else{
      return '';
    }
  }
  return $stockType;
}

function stockInCount(){
  return \App\Models\StockIn::count();
}

function RoleColor($id){
  $color = array(
    '1' => 'bg-info',
    '2' => 'bg-success',
    '3' => 'bg-primary',
    '4' => 'bg-secondary',
  );

  if(array_key_exists($id, $color)){
    return $color[$id];
  }else{
    return 'bg-default';
  }

}

function stockOutCount(){
  return \App\Models\StockOut::count();
}
function transferCount(){
  return \App\Models\StockMoves::where('stock_type', 3)->where('quantity', '>', 0)->count();
}
function adjustmentCount(){
  return \App\Models\StockMoves::where('stock_type', 4)->count();
}

function transferNo($type){
  return \App\Models\StockMoves::where('stock_type',$type)->max('trans_no') + 1;
}

function uniqueCode($length,$prefix,$max_field,$table){
   $prefix_length=strlen($prefix);
   $max_id=\DB::select("SELECT MAX(".$max_field.") AS ".$max_field." FROM ".$table." WHERE SUBSTR(".$max_field.",1,".$prefix_length.")='".$prefix."'");
   $only_id=substr($max_id[0]->$max_field,$prefix_length);
   $new=(int)($only_id);
   $new++;
   $number_of_zero=$length-$prefix_length-strlen($new);
   $zero=str_repeat("0", $number_of_zero);
   $made_id=$prefix.$zero.$new;
   return $made_id;
}
function dateFormat($date){
	return date('F j, Y', strtotime($date));
}
function showDate($date){
	return date("F jS, Y", strtotime($date));
}

function onlyDate($date){
	return date("Y-m-d", strtotime($date));
}

function numberFormat($number){
	return number_format((float)($number), 2, '.', '');
}
function generatePDF($view,$data,$filename,$paper='a4',$orientation='landscape'){
    return $pdf = \PDF::loadView($view, $data)->setPaper($paper,$orientation)->setWarnings(false)->save(public_path('pdf/'.$filename.'.pdf'))->stream('pdf/'.$filename.'.pdf');
    // return $pdf->download('pdf/'.$filename.'.pdf');
}

function fileInfo($file)
{
    
    if(isset($file)){
        return $image = array(
            'name' => $file->getClientOriginalName(), 
            'type' => $file->getClientMimeType(), 
            'size' => $file->getClientSize(), 
            'width' => getimagesize($file)[0], 
            'height' => getimagesize($file)[1], 
            'extension' => $file->getClientOriginalExtension(), 
        );
    }else{
        return $image = array(
            'name' => '0', 
            'type' => '0', 
            'size' => '0', 
            'width' => '0', 
            'height' => '0', 
            'extension' => '0', 
        );
    }
}
function fileUpload($file,$destination,$name)
{
    $upload=$file->move(public_path('/'.$destination), $name);
    return $upload;
}

function getfileSize($size)
{
	if($size<1024){
		$size=$size.' KB';
	}elseif($size>=1024){
		$size=number_format((float)($size/1024), 2, '.', '').' MB';
	}else{
		$size='Unknown Size';
	}
	return $size;
}
