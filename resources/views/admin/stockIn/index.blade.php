@extends('admin.layouts.app')

@section('title')
  <title>Stock In</title>
@endsection

@section('content')
<style type="text/css">
  .table td, .table th {
      padding: 0.4rem !important;
  }
  .content{
    font-size: 16px!important;
  }
</style>
<script src="{{ url('public') }}/plugins/jquery/jquery.min.js"></script>
  <!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Stock In</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
          <li class="breadcrumb-item active">Stock In</li>
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
        <form id="stock-in-form" class="form-group" method="post" action="{{ route('stock-in.store') }}">
          @csrf
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="supplier_id">Supplier</label>
                    <select id="supplier_id" name="supplier_id" onchange="selectSupplier()" class="form-control" required>
                      @if(isset($suppliers[0]))
                        @foreach($suppliers as $supplier)
                          <option value="{{ $supplier->id }}"@if($supplier->id == old('supplier_id')) selected @endif>{{$supplier->name}}</option>
                        @endforeach
                      @endif
                    </select>
                  </div>
                </div>
                
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="location_id">Receive Into Location</label>
                    <select id="location_id" name="location_id" class="form-control" required>
                      @if(isset($locations[0]))
                        @foreach($locations as $location)
                          <option value="{{ $location->id }}" @if($location->id == old('location_id')) selected @endif>{{$location->name}}</option>
                        @endforeach
                      @endif
                    </select>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <div class="date-picker-inner">
                      <label for="stock_in_date">Receive Date</label>
                      <div class="form-group data-custon-pick" id="data_1">
                        <div class="input-group date ">
                            <span class="input-group-addon"></span>
                            <input id="stock_in_date" name="stock_in_date" type="text" readonly style="background-color: white" class="form-control" value="{{ date('m/d/Y') }}">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-body table-responsive p-0">
                <table class="table table-bordered table-striped" style="overflow-x: auto;">
                  <thead>
                    <tr class="bg-info">
                      <th style="width: 5%">SL</th>
                      <th style="width: 20%">Category</th>
                      <th style="width: 20%">Items</th>
                      <th style="width: 10%">Quantity</th>
                      <th style="width: 15%">Unit Price</th>
                      <th style="width: 15%">Total</th>
                      <th style="width: 15%;text-align: center;">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr class="bg-white">
                      <td></td>
                      <td>
                        <select onchange="selectCategory()" name="category_id" id="category_id" class="form-control">
                          @if(isset($itemCategories[0]->id))
                            @foreach($itemCategories as $category)
                              <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                          @endif
                        </select>
                      </td>

                      <td>
                        <select onchange="selectItem()" name="item_id" id="item_id" class="form-control">
                          <option value="0">Select Item</option>
                        </select>
                      </td>

                      <td>
                        <input type="number" onchange="lineTotal()" onkeyup="lineTotal()" class="form-control" name="quantity" id="quantity" value="1" min="1">
                      </td>

                      <td>
                        <input type="number" onchange="lineTotal()" onkeyup="lineTotal()" class="form-control" step="0.01" name="price" id="price" value="0" min="0">
                      </td>

                      <td style="text-align: right" id="total">0.00</td>

                      <td style="text-align: center;">
                        <a onclick="addItem()" class="btn btn-sm bg-success"><i class="fa fa-plus"></i> Add Item</a>
                      </td>
                    </tr>

                  </tbody>
                  <tbody id="viewItems">
                    
                  </tbody>
                </table>
              </div>
              <br>
              <div id="payment-details" class="row">

                <div class="col-md-8">
                 {{--  <center>
                    <div class="form-group">
                      <label for="remarks">Remarks</label>
                      <textarea name="remarks" id="remarks" class="form-control" style="resize: none;height: 100px;width: 70%" >{{ old('remarks') }}</textarea>
                    </div>
                  </center> --}}
                </div>
                <div class="col-md-4">
                  <div style="margin-left: 7%" class="form-group">
                    <table class="table table-bordered">
                      <tr>
                        <td style="width: 50%">Tax (<span id="tax"></span> %)</td>
                        <td style="padding: 0.0rem !important;"><input style="border: none" type="number" value="0" id="tax_amount" readonly class="form-control bg-white" name="tax_amount"></td>
                      </tr>
                      <tr>
                        <td>Discount</td>
                        <td style="padding: 0.0rem !important;"><input onkeyup="setPayment(),setTotalAmount()" onchange="setPayment(),setTotalAmount()" style="border: none" type="number" value="0.00" min="0.00" step="0.01" class="form-control" id="discount" name="discount"></td>
                      </tr>
                      <tr>
                        <td><strong>Total Amount</strong></td>
                        <td style="padding: 0.0rem !important;"><input style="border: none" type="number" value="0" id="total_amount" readonly class="form-control bg-white font-weight-bold" name="total_amount"></td>
                      </tr>
                      <tr class="font-weight-bold">
                        <td>Payment</td>
                        <td style="padding: 0.0rem !important;"><input onkeyup="setTotalAmount()" onchange="setTotalAmount()" style="border: none" type="number" value="0" step="0.01" class="form-control font-weight-bold" id="payment" name="paid"></td>
                      </tr>
                      <tr class="font-weight-bold">
                        <td>Due</td>
                        <td style="padding: 0.0rem !important;"><input style="border: none" type="number" value="0" id="due" readonly class="form-control bg-white font-weight-bold" name="due"></td>
                      </tr>
                      
                    </table>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <center>
                    <a style="width: 50%" onclick="submitStockIn()" class="btn bg-info">Stock Out</a>
                  </center>
                </div>
              </div>
        </form>
      </div>
    </div>
  </div>
</section>
<script type="text/javascript">
  selectCategory();
  selectSupplier();
  viewItems();

  function setPayment(){
    var tax = parseFloat($('#tax').html());
    var discount = $('#discount').val();
    var total = parseFloat($('#grandTotal').html());
    var total_tax = (total*tax)/100;

    if((discount < 0) && (discount == '')){
      discount = 0;
      $('#discount').val('0.00');
    }

    var total_amount = total + total_tax - discount;
    $('#payment').val(total_amount.toFixed(2));
  }

  function setTotalAmount(){
    var tax = parseFloat($('#tax').html());
    var discount = $('#discount').val();
    var total = parseFloat($('#grandTotal').html());
    var total_tax = (total*tax)/100;
    var payment = $('#payment').val();


    if(discount < 0){
      discount = 0;
      $('#discount').val('0.00');
    }
    if(discount > total_tax + total){
      discount = total_tax + total;
      $('#discount').val(parseFloat(total_tax + total).toFixed(2));
    }


    var total_amount = parseFloat(total + total_tax - discount).toFixed(2);
    

    if(payment > total_amount){
      payment = total_amount;
      $('#payment').val(payment).toFixed(2);
    }
    if(payment < 0){
      payment = 0;
      $('#payment').val(payment).toFixed(2);
    }

    var due = parseFloat(total_amount - payment).toFixed(2);

    $('#tax_amount').val(total_tax.toFixed(2));
    $('#total_amount').val(total_amount);
    $('#due').val(due);

  }

  function selectSupplier(){
    var supplier_id = $('#supplier_id').val();

    if(supplier_id > 0){
      $.ajax({
        url: '{{ url('stock-in') }}/'+supplier_id+'/selectSupplier',
        type: 'GET',
        dataType: 'json',
      })
      .done(function(response) {
        if(response.success){
          $('#tax').html(response.tax);
          setPayment();
          setTotalAmount();
        }else{
          $('#tax').html('0');
        }
      })
      .fail(function() {
        console.log("error");
      });
    }
  }

  function submitStockIn() {
    $.confirm({
      title: '',
      content: '<div style="padding-top:35px;padding-bottom:15px"><h3 class="text-center"><strong class="text-success">Are you sure to Stock In ?</strong></h3></div>',
      buttons: {
        confirm: {
          text: 'Stock In',
          btnClass: 'bg-info',
          action: function(){
              $('#stock-in-form').submit();
          }
        },
        close: {
          text: 'Cancel',
          btnClass: 'btn-default',
          action: function(){
              
          }
        }
      }
    });
  }
  function addItem(){
    var category_id = $('#category_id').val();
    var item_id = $('#item_id').val();
    var quantity = $('#quantity').val();
    var price = $('#price').val();

    if(category_id > 0 && item_id > 0 && quantity > 0 && price > 0){
      $.ajax({
        url: '{{ url('stock-in') }}/'+category_id+'&'+item_id+'&'+quantity+'&'+price,
        type: 'GET',
        dataType: 'json',
      })
      .done(function(response) {
        if(response.success){
          console.log(1);
          viewItems();
        }
      })
      .fail(function() {
        console.log("error");
      });
    }else{
      $.alert({
        title:"Whoops!",
        content:"<hr><strong class='text-danger'>Please select all the fields correctly !</strong><hr>",
        type:"red"
     });
    }
  }

  function viewItems(){
    $.ajax({
      url: '{{ url('stock-in/create') }}',
      type: 'GET',
      dataType: 'json',
    })
    .done(function(response) {
      if(response.success){
        var data = '';
        var i = 0;
        var amountTotal = 0;
        $.each(response.items, function(index, item) {
          i++;
          var total = parseFloat(item['quantity']*item['price']).toFixed(2);
          amountTotal = parseFloat(parseFloat(amountTotal) + parseFloat(total)).toFixed(2);
          data += '<tr id="tr-'+index+'">'+
                    '<td>'+i+'</td>'+
                    '<td>'+item['category_name']+'</td>'+
                    '<td>'+item['item_name']+'</td>'+
                    '<td>'+item['quantity']+'</td>'+
                    '<td style="text-align:right">'+item['price']+'</td>'+
                    '<td style="text-align:right">'+total+'</td>'+
                    '<td style="text-align:center"><a class="btn btn-xs bg-primary" onclick="Edit('+index+','+item['quantity']+','+item['price']+')"><i class="fa fa-edit"></i><a>&nbsp;<a class="btn btn-xs bg-danger" onclick="Delete('+index+')"><i class="fa fa-trash"></i></a></td>'+
                    '</tr>';


        });
        data += '<tr>'+
                '<td style="text-align:right" colspan="5"><strong>Total</strong></td>'+
                '<td style="text-align:right"><strong id="grandTotal">'+amountTotal+'</strong></td>'+
                '<td></td>';
              '</tr>';
        $('#viewItems').html(data);
        setPayment();
        setTotalAmount();
        $('#discount').val('0.00');
      }else{
        $('#viewItems').html('');
        setPayment();
        $('#discount').val('');
        setTotalAmount();
      }
    })
    .fail(function() {
      console.log("error");
    });
  }


  function Edit(index,quantity,price) {
    $.confirm({
      title: 'Update',
      content:
      '<div class="form-group">' +
      '<label>Quantity</label>' +
      '<input type="number" min="1" class="quantity form-control" value="'+quantity+'" />' +
      '</div>'+
      '<div class="form-group">' +
      '<label>Price</label>' +
      '<input type="number" step="0.01" class="price form-control" value="'+price+'" />' +
      '</div>',
      buttons: {
          formSubmit: {
              text: 'Update',
              btnClass: 'btn-blue',
              action: function () {
                  var quantity = this.$content.find('.quantity').val();
                  var price = this.$content.find('.price').val();
                  if(quantity>0){
                    if(price>0){
                      editItem(index,quantity,price);
                    }
                  }
              }
          },
          cancel: function () {
              //close
          }
        }
    });
  }

  function editItem(index,quantity,price) {
    $.ajax({
        url: "{{url('stock-in')}}/"+index+"&"+quantity+"&"+price+"/edit",
        type: 'GET',
        data: {},
    })
    .done(function(response) {
        if(response.success){
          viewItems();
        }
    });
  }

  function Delete(index) {
    $.confirm({
      title: '',
      content: '<div style="padding-top:35px;padding-bottom:15px"><h3 class="text-center"><strong class="text-success">Are you sure to Delete ?</strong></h3></div>',
      buttons: {
          confirm: {
              text: 'Delete',
              btnClass: 'btn-danger',
              action: function(){
                deleteItem(index);
              }
          },
          close: {
              text: 'Cancel',
              btnClass: 'btn-default',
              action: function(){
                  
              }
          }
      }
    });  
  }

  function deleteItem(index) {
    $.ajax({
      headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' },
      type: 'DELETE',
      url: "{{url('stock-in')}}/"+index,
      dataType: 'json',
    })
    .done(function(response) {
      if(response.success){
        $('#tr-'+index).fadeOut();
        viewItems();

      }
    });

        
  }

  function selectCategory(){
    var category_id = $('#category_id').val();
    if(category_id > 0){ 
      $.ajax({
        url: '{{ url('stock-in') }}/'+category_id+'/selectCategory',
        type: 'GET',
        dataType: 'json',
      })
      .done(function(response) {
        var data = '';
        if(response.success){
          $.each(response.items, function(index, item) {
             data += '<option value="'+item.id+'">'+item.name+'</option>';
          });
        }
        $('#item_id').html(data);
        selectItem();
      })
      .fail(function() {
        console.log("error");
      });
    }else{
      $.alert({
        title:"Whoops!",
        content:"<hr><strong class='text-danger'>Something Went Wrong!</strong><hr>",
        type:"red"
     });
    }
  }

  function selectItem(){
    var item_id = $('#item_id').val();
    if(item_id > 0){
      $.ajax({
        url: '{{ url('stock-in') }}/'+item_id+'/selectItem',
        type: 'GET',
        dataType: 'json',
      })
      .done(function(response) {
        if(response.success){
          $('#price').val(response.price);
        }else{
          $('#price').val(0);
        }
        lineTotal();
      });
    }else{
      $('#price').val(0);
      lineTotal();
    }
    
  }

  function lineTotal(){
    var quantity = $('#quantity').val();
    var price = $('#price').val();

    if(quantity > 0 && price > 0){
      var total = parseFloat(quantity*price).toFixed(2);
    }else{
      var total = '0.00';
    }

    $('#total').html(total);

  }
</script>
@endsection