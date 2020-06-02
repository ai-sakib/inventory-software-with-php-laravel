@if(isset($items[0]->id))
  @php
    $totalStock = 0;  
  @endphp
  @foreach($items as $key => $item)
    @php
      $productStock = \App\Models\StockMoves::where('item_id', $item->id)
                    ->when($location_id != '0', function($query) use ($location_id){
                        return $query->where('location_id',$location_id);
                    })
                    ->sum('quantity'); 
      $totalStock += $productStock;
    @endphp
    @if($productStock > 0)
      <tr>
        <td>{{ $key + 1 }}</td>
        <td>{{ $item->name }}</td>
        <td>{{ $productStock }}</td>
      </tr>
    @endif
  @endforeach
  <tr>
    <td colspan="2" style="text-align: right;"><strong>Total</strong></td>
    <td><strong>{{ $totalStock }}</strong></td>
  </tr>
@endif