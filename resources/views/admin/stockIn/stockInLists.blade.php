@extends('admin.layouts.app')

@section('title')
  <title>Stock In Lists</title>
@endsection

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Stock In Lists</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
          <li class="breadcrumb-item active">Stock In Lists</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->

<section style="margin: 0px 9px 0px 9px" class="content">
  <form method="post" action="{{ url('stock-in-lists') }}">
    @csrf
    <div class="row">
      <div class="col-md-2">
        <div class="form-group">
          <div class="date-picker-inner">
            <label for="from_date">From</label>
            <div class="form-group data-custon-pick" id="data_1">
              <div class="input-group date ">
                  <span class="input-group-addon"></span>
                  <input id="from_date" name="from_date" type="text" readonly style="background-color: white" class="form-control" @if(isset($info['from_date'])) value="{{ date('m/d/Y',strtotime($info['from_date'])) }}" @else value="{{ date('m/d/Y',strtotime('- 1 year')) }}" @endif>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-2">
        <div class="form-group">
          <div class="date-picker-inner">
            <label for="to_date">To</label>
            <div class="form-group data-custon-pick" id="data_1">
              <div class="input-group date ">
                  <span class="input-group-addon"></span>
                  <input id="to_date" name="to_date" type="text" readonly style="background-color: white" class="form-control" @if(isset($info['to_date'])) value="{{ date('m/d/Y',strtotime($info['to_date'])) }}" @else value="{{ date('m/d/Y') }}" @endif>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-2">
        <div class="form-group">
          <label for="supplier_id">Supplier</label>
          <select id="supplier_id" name="supplier_id" onchange="selectSupplier()" class="form-control" required>
            <option value="0">All Suppliers</option>
            @if(isset($suppliers[0]))
              @foreach($suppliers as $supplier)
                <option value="{{ $supplier->id }}" @if(isset($info['supplier_id']) && $info['supplier_id'] == $supplier->id) selected @endif>{{$supplier->name}}</option>
              @endforeach
            @endif
          </select>
        </div>
      </div>
      
      <div class="col-md-2">
        <div class="form-group">
          <label for="location_id">Received Location</label>
          <select id="location_id" name="location_id" class="form-control" required>
            <option value="0">All Locations</option>
            @if(isset($locations[0]))
              @foreach($locations as $location)
                <option value="{{ $location->id }}" @if(isset($info['location_id']) && $info['location_id'] == $location->id) selected @endif>{{$location->name}}</option>
              @endforeach
            @endif
          </select>
        </div>
      </div>
      <div class="col-md-2">
        <div class="form-group">
          <label for="payment_status">Payment Status</label>
          <select id="payment_status" name="payment_status" class="form-control" required>
            <option value="0" @if(isset($info['payment_status']) && $info['payment_status'] == '0') selected @endif>All</option>
            <option value="1" @if(isset($info['payment_status']) && $info['payment_status'] == '1') selected @endif>Paid</option>
            <option value="2" @if(isset($info['payment_status']) && $info['payment_status'] == '2') selected @endif>Unpaid</option>
          </select>
        </div>
      </div>
      <div class="col-md-2">
        <div class="form-group">
          <button type="submit" style="margin-top: 31.5px;" class="btn bg-info form-control">Search</button>
        </div>
      </div>

      

      <div class="col-12">
        <!-- /.card -->
        <div class="card">
          <!-- /.card-header -->
          <div class="card-body">
            
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                  <tr class="bg-info">
                    <th style="width: 5%">SL</th>
                    <th style="width: 10%">Details</th>
                    <th style="width: 12%">Order No</th>
                    <th style="width: 13%">Supplier</th>
                    <th style="width: 10%">Location</th>
                    <th style="width: 10%">Total</th>
                    <th style="width: 10%">Paid</th>
                    <th style="width: 10%">Due</th>
                    <th style="width: 15%">Payment</th>
                  </tr>
                </thead>
                <tbody>
                  @if(isset($stockInLists[0]))
                   @foreach($stockInLists as $key => $value)
                  <tr id="tr-{{$value->id}}">
                    <td>{{ $key+1 }}</td>
                    <td>
                      <a onclick="getDetails('{{ $value->id }}')" class="btn btn-xs bg-green"><i class="fa fa-eye"></i>&nbsp;View</a>
                    </td>
                    <td>{{ $value->id }}</td>
                    <td>{{ optional($value->supplier)->name }}</td>
                    <td>{{ optional($value->location)->name }}</td>
                    <td>{{ $value->total_price }}</td>
                    <td id="paid-{{ $value->id }}">{{ $value->paid }}</td>
                    <td id="due-{{ $value->id }}">{{ $value->total_price - $value->paid }}</td>
                    <td id="clear-{{ $value->id }}">
                      @if($value->total_price - $value->paid > 0)
                        <a onclick="setPayment('{{ $value->id }}','{{ $value->total_price }}','{{ $value->total_price - $value->paid }}')" class="btn btn-xs bg-danger"><i class="fas fa-money-bill-alt "></i>&nbsp;Pay</a>&nbsp;&nbsp;<a onclick="clearPayment('{{ $value->id }}')" class="btn btn-xs bg-success"><i class="fa fa-window-close "></i>&nbsp;Clear</a>
                      @else
                      <a class="btn btn-xs bg-info"><i class="fa fa-save "></i>&nbsp;&nbsp;Cleared</a>
                      @endif
                    </td>
                  </tr>
                  @endforeach
                  @endif
                </tbody>
              </table>
            </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </form>
</section>
<!-- /.content -->
<script type="text/javascript">
  function setPayment(id,total,due) {
    $.confirm({
      title: 'Payment',
      content:
      '<div class="form-group">' +
      '<label>Total</label>' +
      '<input type="text" class="total form-control" readonly value="'+total+'" />' +
      '</div>'+
      '<div class="form-group">' +
      '<label>Due</label>' +
      '<input type="text" class="due form-control" readonly value="'+due+'" />' +
      '</div>'+
      '<div class="form-group">' +
      '<label>Pay</label>' +
      '<input type="number" id="payment" step="0.01" placeholder="'+due+'" class="form-control"/>' +
      '</div>',
      buttons: {
          formSubmit: {
              text: 'Set Payment',
              btnClass: 'btn-info',
              action: function () {
                  var payment = parseFloat($('#payment').val());
                  console.log(due, payment);
                  if(payment > 0){
                    if(payment <= due){
                      $.ajax({
                        url: "{{url('stock-in-lists')}}/"+id+'&'+payment+"/setPayment",
                        type: 'GET',
                        data: {},
                      })
                      .done(function(response) {
                          if(response.success){
                            if((total- response.paid) > 0){
                              $('#clear-'+response.id).html('<a onclick="setPayment('+id+','+total+','+(total-response.paid)+')" class="btn btn-xs bg-danger"><i class="fas fa-money-bill-alt "></i>&nbsp;Pay</a>&nbsp;&nbsp;<a onclick="clearPayment('+id+')" class="btn btn-xs bg-success"><i class="fa fa-window-close "></i>&nbsp;Clear</a>');
                            }else{
                              $('#clear-'+response.id).html('<a class="btn btn-xs bg-info"><i class="fa fa-save "></i>&nbsp;&nbsp;Cleared</a>');
                            }
                            
                            $('#paid-'+response.id).html(response.paid);
                            $('#due-'+response.id).html(total-response.paid);
                          }
                      });
                    }else{
                      $.alert({
                        title:"Whoops!",
                        content:"<hr><strong class='text-danger'>Payment must be less than due</strong><hr>",
                        type:"red"
                     });
                    }
                  }else{
                    $.alert({
                      title:"Whoops!",
                      content:"<hr><strong class='text-danger'>Payment must be greater than 0</strong><hr>",
                      type:"red"
                   });
                  }
                }
          },
          cancel: function () {
              //close
          }
        }
    });
  }

  function clearPayment(id) {
    $.confirm({
      title: '',
      content: '<div style="padding-top:35px;padding-bottom:15px"><h3 class="text-center"><strong class="text-success">Are you sure to Clear Payment ?</strong></h3></div>',
      buttons: {
          confirm: {
              text: 'Clear',
              btnClass: 'btn-danger',
              action: function(){
                $.ajax({
                url: "{{url('stock-in-lists')}}/"+id+'/clearPayment',
                type: 'GET',
                dataType: 'json',
                success:function(response) {
                  if(response.success){
                    $('#clear-'+response.id).html('<a class="btn btn-xs bg-info"><i class="fa fa-save "></i>&nbsp;&nbsp;Cleared</a>');
                    $('#paid-'+response.id).html(response.paid);
                    $('#due-'+response.id).html(0);
                  }
                }
              });
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
  function getDetails(stock_in_id){
    $.alert({
     title: 'Stock In Details #'+stock_in_id,
     content: "url:{{url('stock-in')}}/"+stock_in_id+"/getDetails",
     animation: 'scale',
     closeAnimation: 'bottom',
     columnClass:"col-md-8 col-md-offset-2",
     buttons: {
       close: {
         text: 'Close',
         btnClass: 'btn-default',
         action: function(){
             // do nothing
         }
       }
     }
   });
  }

</script>
@endsection
