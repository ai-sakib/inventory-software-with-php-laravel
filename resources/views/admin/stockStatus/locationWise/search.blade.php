@if(isset($locations[0]->id))
  @php
    $totalStock = 0;
    if($category_id != '0'){
      if($item_id == '0'){
        $items = \App\Models\Item::where('category_id',$category_id)->where('category_id',$category_id)->get();
        $item_array = array();
        foreach ($items as $itemKey => $item) {
          array_push($item_array, $item->id);
        }
      }
    }
  @endphp
  @foreach($locations as $key => $location)
    @php
      if($category_id == '0' ){
        $locationStock = \App\Models\StockMoves::where('location_id', $location->id)->sum('quantity');
      }else{
        if($item_id == '0'){
          $locationStock = \App\Models\StockMoves::where('location_id', $location->id)
                        ->whereIn('item_id',$item_array)
                        ->sum('quantity');
        }else{
          $locationStock = \App\Models\StockMoves::where('location_id', $location->id)
                        ->where('item_id', $item_id)
                        ->sum('quantity');
        }
      }
      
      $totalStock += $locationStock;  
    @endphp
    <tr style="border: 0;">
      <td>{{ $key + 1 }}</td>
      <td>{{ $location->name }}</td>
      <td>{{ $locationStock }}</td>
    </tr>
  @endforeach
  <tr>
    <td colspan="2" style="text-align: right;"><strong>Total</strong></td>
    <td><strong>{{ $totalStock }}</strong></td>
  </tr>
@endif