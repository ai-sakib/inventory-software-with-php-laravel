@extends('admin.layouts.app')

@section('title')
  <title>Suppliers</title>
@endsection

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Suppliers &nbsp;<a onclick="addPage('suppliers','Supplier')" class="btn btn-sm bg-success"><i class="fas fa-plus"></i> Add</a></h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
          <li class="breadcrumb-item active">Suppliers</li>
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
                  <tr style="background-color: #3CAEA3;color: white">
                    <th style="width: 5%">SL</th>
                    <th style="width: 5%">Actions</th>
                    {{-- <th style="width: 5%">Image</th> --}}
                    <th style="width: 15%">Name</th>
                    <th style="width: 15%">Email</th>
                    <th style="width: 5%">Tax</th>
                    <th style="width: 15%">Total</th>
                    <th style="width: 10%">Received</th>
                    <th style="width: 8%">Due</th>
                    <th style="width: 20%">Payment</th>
                    <th style="width: 5%">Status</th>
                  </tr>
                </thead>
                <tbody>
                  @if(isset($suppliers[0]))
                    @foreach($suppliers as $mainKey => $value)
                      @php
                        $total = 0;
                        $paid = 0;
                        $due = 0;
                         $stockIn = \App\Models\StockIn::where('supplier_id', $value->id)->get();
                         if(isset($stockIn[0]->id)){
                          foreach ($stockIn as $key => $stock) {
                            $total += $stock->total_price;
                            $paid += $stock->paid;
                            $due += $stock->total_price - $stock->paid;
                          }
                         }
                      @endphp
                    <tr id="tr-{{$value->id}}">
                      <td style="width: 5%">{{ $mainKey+1 }}</td>
                      <td style="width: 5%">
                        <a onclick="editPage('suppliers','{{ $value->id }}', 'Supplier')"  title="Edit" class="btn bg-primary btn-xs"><i class="fas fa-edit"></i></a>
                        <a onclick="Delete('{{$value->id}}')" title="Delete" class="btn bg-danger btn-xs"><i class="fas fa-trash-alt" ></i></a>
                      </td>
                      {{-- <td style="width: 5%"><img src="{{ url('public/suppliers/') }}/{{ $value->image }}" style="max-width: 50px" ></td> --}}
                      <td style="width: 15%">{{ $value->name }}</td>
                      <td style="width: 15%">{{ $value->email }}</td>
                      <td style="width: 15%">{{ $value->tax }} %</td>
                      <td>{{ $total }}</td>
                      <td id="paid-{{ $value->id }}">{{ $paid }}</td>
                      <td id="due-{{ $value->id }}">{{ $due }}</td>
                      <td id="clear-{{ $value->id }}">
                        @if($due > 0)
                          <a onclick="viewPayment('{{ $value->id }}','{{ $value->name }}')" class="btn btn-xs bg-danger"><i class="fas fa-money-bill-alt "></i>&nbsp;Pay</a>&nbsp;&nbsp;<a onclick="clearPayment('{{ $value->id }}')" class="btn btn-xs bg-success"><i class="fa fa-window-close "></i>&nbsp;Clear</a>
                        @else
                          <a class="btn btn-xs bg-info"><i class="fa fa-save "></i>&nbsp;&nbsp;Cleared</a>
                        @endif
                      </td>
                      <td>
                        @if ($value->status == 1)
                         <button id="change-status-{{ $value->id }}" onclick="changeStatus('{{ $value->id }}','0')" class="btn btn-sm bg-success">Active</button>
                         @else
                         <button id="change-status-{{ $value->id }}" onclick="changeStatus('{{ $value->id }}','1')" class="btn btn-sm bg-danger">Inactive</button>
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
  function viewPayment(supplier_id, name){
    $.alert({
     title: 'Supplier Payment &nbsp;&nbsp;#<strong>'+name+'</strong',
     content: "url:{{url('suppliers')}}/"+supplier_id+"/viewPayment",
     animation: 'scale',
     closeAnimation: 'bottom',
     columnClass:"col-md-10 col-md-offset-1",
     buttons: {
       close: {
         text: 'Close',
         btnClass: 'btn-default',
         action: function(){
          $.ajax({
            url: "{{url('suppliers')}}/"+supplier_id+'/checkPayment',
            type: 'GET',
            dataType: 'json',
            success:function(response) {
              if(response.success){
                if((response.main_total- response.main_paid) > 0){
                  $('#clear-'+supplier_id).html('<a onclick="viewPayment('+supplier_id+','+response.main_total+','+(response.main_total-response.main_paid)+')" class="btn btn-xs bg-danger"><i class="fas fa-money-bill-alt "></i>&nbsp;Pay</a>&nbsp;&nbsp;<a onclick="clearPayment('+supplier_id+')" class="btn btn-xs bg-success"><i class="fa fa-window-close "></i>&nbsp;Clear</a>');
                }else{
                  $('#clear-'+supplier_id).html('<a class="btn btn-xs bg-info"><i class="fa fa-save "></i>&nbsp;&nbsp;Cleared</a>');
                }
                
                $('#paid-'+supplier_id).html(response.main_paid);
                $('#due-'+supplier_id).html(response.main_total- response.main_paid);
              }
            }
          });
         }
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
                url: "{{url('suppliers')}}/"+id+'/clearPayment',
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


  function changeStatus(id,status){
    if(status == '1'){
      var nextStatus = '0';
      $('#change-status-'+id+'').removeClass('bg-danger');
      $('#change-status-'+id+'').addClass('bg-success');
      $('#change-status-'+id+'').attr('onclick','changeStatus('+id+','+nextStatus+')');
      $('#change-status-'+id+'').html('Active');
    }else{
      var nextStatus = '1';
      $('#change-status-'+id+'').removeClass('bg-success');
      $('#change-status-'+id+'').addClass('bg-danger');
      $('#change-status-'+id+'').attr('onclick','changeStatus('+id+','+nextStatus+')');
      $('#change-status-'+id+'').html('Inactive');
    }
    $.ajax({
    url: '{{ url('suppliers') }}/'+id+'&'+status,
    type: 'GET',
    dataType: 'json',
  })
  .done(function(response) {
    //nothing
  });
  }
  
  function Delete(id) {
    $.confirm({
      title: '',
      content: '<div style="padding-top:35px;padding-bottom:15px"><h3 class="text-center"><strong class="text-success">Are you sure to Delete ?</strong></h3></div>',
      buttons: {
          confirm: {
              text: 'Delete',
              btnClass: 'btn-danger',
              action: function(){
                  $.ajax({
                  headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' },
                  url: "{{url('suppliers')}}/"+id,
                  type: 'DELETE',
                  dataType: 'json',
                  success:function(response) {
                    if(response.success){
                      $('#tr-'+id).fadeOut();
                    }else{
                      $.alert({
                        title:"Whoops!",
                        content:"<hr><strong class='text-danger'>Something Went Wrong!</strong><hr>",
                        type:"red"
                      });
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
</script>
@endsection
