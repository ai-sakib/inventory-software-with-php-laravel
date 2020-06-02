@extends('admin.layouts.app')

@section('title')
  <title>Stock Out Lists</title>
@endsection

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Stock Out Lists</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
          <li class="breadcrumb-item active">Stock Out Lists</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->

<section class="content">
    <div class="row">
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
                    <th style="width: 13%">Customer</th>
                    <th style="width: 10%">Location</th>
                    <th style="width: 10%">Total</th>
                    <th style="width: 10%">Paid</th>
                    <th style="width: 10%">Due</th>
                    <th style="width: 15%">Payment</th>
                  </tr>
                </thead>
                <tbody>
                  @if(isset($stockOutLists[0]))
                   @foreach($stockOutLists as $key => $value)
                  <tr id="tr-{{$value->id}}">
                    <td>{{ $key+1 }}</td>
                    <td>
                      <a onclick="getDetails('{{ $value->id }}')" class="btn btn-xs bg-green"><i class="fa fa-eye"></i>&nbsp;View</a>
                    </td>
                    <td>{{ $value->id }}</td>
                    <td>{{ optional($value->customer)->name }}</td>
                    {{-- <td>{{ optional($value->salesType)->name }}</td> --}}
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
                        url: "{{url('stock-out-lists')}}/"+id+'&'+payment+"/setPayment",
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
                url: "{{url('stock-out-lists')}}/"+id+'/clearPayment',
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
  function getDetails(stock_out_id){
    $.alert({
     title: 'Stock Out Details #'+stock_out_id,
     content: "url:{{url('stock-out')}}/"+stock_out_id+"/getDetails",
     animation: 'scale',
     closeAnimation: 'bottom',
     columnClass:"col-md-10 col-md-offset-1",
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
