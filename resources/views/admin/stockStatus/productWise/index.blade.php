@extends('admin.layouts.app')

@section('title')
  <title>Product Wise Stock Status</title>
@endsection

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Product Wise</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
          <li class="breadcrumb-item active">Product Wise Stock Status</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
  <div class="col-12">
    <!-- /.card -->
    <div class="card">
      <!-- /.card-header -->
      <div class="card-body">
        <form >
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label for="location_id">Location</label>
                <select onchange="searchProductWise()" id="location_id" name="location_id" class="form-control">
                  <option value="0">All Locations</option>
                  @if(isset($locations[0]->id))
                    @foreach($locations as $location)
                      <option value="{{ $location->id }}">{{$location->name}}
                      </option>
                    @endforeach
                  @endif
                </select>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="category_id">Item Category</label>
                <select onchange="selectCategory()" id="category_id" name="category_id" class="form-control">
                  <option value="0">All Categories</option>
                  @if(isset($itemCategories[0]->id))
                    @foreach($itemCategories as $category)
                      <option value="{{ $category->id }}">{{$category->name}}
                      </option>
                    @endforeach
                  @endif
                </select>
              </div>
            </div>
            
            <div class="col-md-3">
              <div class="form-group">
                <label for="item_id">Item</label>
                <select onchange="searchProductWise()" id="item_id" name="item_id" class="form-control">
                  <option value="0">All Items</option>
                </select>
              </div>
            </div>

          </div>
          <table id="example1" class="table table-bordered table-striped" style="overflow-x: auto;">
                <thead>
                  <tr style="background-color: #3CAEA3;color: white">
                    <th style="width: 20%">SL</th>
                    <th style="width: 40%">Product Name</th>
                    <th style="width: 40%">Available Quantity</th>
                  </tr>
                </thead>
                <tbody id="productWise">
                  @if(isset($items[0]->id))
                  @php
                    $totalStock = 0;  
                  @endphp
                  @foreach($items as $key => $item)
                    @php
                      $productStock = \App\Models\StockMoves::where('item_id', $item->id)->sum('quantity'); 
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
                  <tr >
                    <td colspan="2" style="text-align: right;"><strong>Total</strong></td>
                    <td><strong>{{ $totalStock }}</strong></td>
                  </tr>
                @endif
              </tbody>
          </table>
        </form>
      </div>
    </div>
  </div>
</section>

<!-- /.content -->
<script type="text/javascript">
  function selectCategory(){
    var category_id = $('#category_id').val();
    var data = '<option value="0">All Items</option>';
    if(category_id > 0){
      $.ajax({
        url: '{{ url('location-wise-stock-status') }}/'+category_id+'/selectCategory',
        type: 'GET',
        dataType: 'json',
      })
      .done(function(response) {
        if(response.success){
          $.each(response.items, function(index, val) {
            console.log(1);
             data += '<option value="'+val.id+'">'+val.name+'</option>';
          });
        }
        $('#item_id').html(data);
        searchProductWise();
      })
      .fail(function() {
        console.log("error");
      });
    }else{
      $('#item_id').html(data);
      searchProductWise();
    }
  }

  function searchProductWise(){
    $.ajax({
      url: '{{ url('product-wise-stock-status') }}/'+$('#location_id').val()+'&'+$('#category_id').val()+'&'+$('#item_id').val()+'/search',
      type: 'GET',
    })
    .done(function(response) {
      $('#productWise').html(response);
    })
    .fail(function() {
      console.log("error");
    });
    
  }
</script>
@endsection
