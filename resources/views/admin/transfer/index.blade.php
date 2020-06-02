@extends('admin.layouts.app')

@section('title')
  <title>Transfer</title>
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
        <h1 class="m-0 text-dark">Transfer</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
          <li class="breadcrumb-item active">Transfer</li>
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
        <form id="transfer-form" class="form-group" method="post" action="{{ route('transfer.store') }}">
          @csrf
              <div class="row">
                <div class="col-md-4">
              <div class="form-group">
                <label for="from_location_id">From Location</label>
                <select onchange="quantityAlert()" id="from_location_id" name="from_location_id" class="form-control update-select">
                  @if(isset($locations[0]))
                    @foreach($locations as $location)
                      <option value="{{ $location->id }}" @if($location->id == old('from_location_id')) selected @endif>{{$location->name}}</option>
                    @endforeach
                  @endif
                </select>
              </div>
            </div>
            
            <div class="col-md-4">
              <div class="form-group">
                <label for="to_location_id">To Location</label>
                <select id="to_location_id" name="to_location_id" class="form-control update-select" required>
                  @if(isset($locations[0]))
                    @foreach($locations as $location)
                      <option value="{{ $location->id }}" @if($location->id == old('to_location_id')) selected @endif>{{$location->name}}</option>
                    @endforeach
                  @endif
                </select>
              </div>
            </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <div class="date-picker-inner">
                      <label for="transfer_date">Transfer Date</label>
                      <div class="form-group data-custon-pick" id="data_1">
                        <div class="input-group date ">
                            <span class="input-group-addon"></span>
                            <input id="transfer_date" name="transfer_date" type="text" readonly style="background-color: white" class="form-control" value="{{ date('m/d/Y') }}">
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
                      <th style="width: 10%">SL</th>
                      <th style="width: 30%">Category</th>
                      <th style="width: 30%">Items</th>
                      <th style="width: 15%">Quantity</th>
                      <th style="width: 15%">Actions</th>
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
                        <select onchange="quantityAlert()" name="item_id" id="item_id" class="form-control">
                        </select>
                      </td>

                      <td>
                        <input type="number" onchange="quantityAlert()" onkeyup="quantityAlert()" class="form-control" name="quantity" id="quantity" value="1" min="1">
                        <small style="color: red" id="quantity-alert"></small>
                      </td>
                      <td style="text-align: center">
                        <a onclick="addItem()" class="btn btn-sm bg-green"><i class="fa fa-plus"></i> Add Item</a>
                      </td>
                    </tr>

                  </tbody>
                  <tbody id="viewItems">
                    
                  </tbody>
                </table>
              </div>

              <center>
            <div class="form-group">
              <label for="remarks">Remarks</label>
              <textarea name="remarks" id="remarks" class="form-control" style="resize: none;height: 70px;width: 50%" >{{ old('remarks') }}</textarea>
            </div>
          </center>
          <center><a onclick="submitTransfer()" class="btn bg-secondary">Transfer</a></center>
        </form>
      </div>
    </div>
  </div>
</section>
<script type="text/javascript">
  selectCategory();
  viewItems();

  function submitTransfer() {
    if($('#from_location_id').val() == $('#to_location_id').val()){
      $.confirm({
        title: '',
        content: '<div style="padding-top:35px;padding-bottom:15px"><h4 class="text-center"><strong class="text-danger">Please select different locations !</strong></h4></div>',
        buttons: {
          close: {
            text: 'Close',
            btnClass: 'btn-default',
            action: function(){
                
            }
          }
        }
      });
    }else{
      $.confirm({
        title: '',
        content: '<div style="padding-top:35px;padding-bottom:15px"><h3 class="text-center"><strong class="text-success">Are you sure to Transfer ?</strong></h3></div>',
        buttons: {
          confirm: {
            text: 'Transfer',
            btnClass: 'bg-secondary',
            action: function(){
                $('#transfer-form').submit();
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
    
  }

  function quantityAlert(){
    var quantity = $('#quantity').val();
    var item_id = $('#item_id').val();
    var location_id = $('#from_location_id').val();

    if(quantity > 0){
      $.ajax({
        url: '{{ url('transfer') }}/'+quantity+'&'+item_id+'&'+location_id+'/quantityAlert',
        type: 'GET',
        dataType: 'json',
      })
      .done(function(response) {
        if(response.success){
          $('#quantity-alert').html(response.message);
        }else{
          $('#quantity-alert').html('');
        }
      })
      .fail(function() {
        console.log("error");
      });
    }
  }

  function addItem(){
    var category_id = $('#category_id').val();
    var item_id = $('#item_id').val();
    var quantity = $('#quantity').val();

    if(category_id > 0 && item_id > 0 && quantity > 0){
      $.ajax({
        url: '{{ url('transfer') }}/'+category_id+'&'+item_id+'&'+quantity+'&'+$('#from_location_id').val(),
        type: 'GET',
        dataType: 'json',
      })
      .done(function(response) {
        if(response.success){
          viewItems();
        }else{
          $.alert({
            title:"Whoops!",
            content:"<hr><strong class='text-danger'>"+response.message+"</strong><hr>",
            type:"red"
         });
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
      url: '{{ url('transfer/create') }}',
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
          data += '<tr id="tr-'+index+'">'+
                    '<td>'+i+'</td>'+
                    '<td>'+item['category_name']+'</td>'+
                    '<td>'+item['item_name']+'</td>'+
                    '<td>'+item['quantity']+'</td>'+
                    '<td style="text-align:center"><a class="btn btn-xs bg-primary" onclick="Edit('+index+','+item['quantity']+')"><i class="fa fa-edit"></i><a>&nbsp;<a class="btn btn-xs bg-danger" onclick="Delete('+index+')"><i class="fa fa-trash"></i></a></td>'+
                    '</tr>';


        });
        $('#viewItems').html(data);
      }else{
        $('#viewItems').html('');
      }
    })
    .fail(function() {
      console.log("error");
    });
  }


  function Edit(index,quantity) {
    $.confirm({
      title: 'Update',
      content:
      '<div class="form-group">' +
      '<label>Quantity</label>' +
      '<input type="number" min="1" class="quantity form-control" value="'+quantity+'" />' +
      '</div>',
      buttons: {
          formSubmit: {
              text: 'Update',
              btnClass: 'btn-blue',
              action: function () {
                  var quantity = this.$content.find('.quantity').val();
                  if(quantity>0){
                    editItem(index,quantity);
                  }
              }
          },
          cancel: function () {
              //close
          }
        }
    });
  }

  function editItem(index,quantity) {
    $.ajax({
        url: "{{url('transfer')}}/"+index+"&"+quantity+"&"+$('#from_location_id').val()+"/edit",
        type: 'GET',
        data: {},
    })
    .done(function(response) {
        if(response.success){
          viewItems();
        }else{
          $.alert({
            title:"Whoops!",
            content:"<hr><strong class='text-danger'>"+response.message+"</strong><hr>",
            type:"red"
         });
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
      url: "{{url('transfer')}}/"+index,
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
        url: '{{ url('transfer') }}/'+category_id+'/selectCategory',
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
        quantityAlert();
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

</script>
@endsection
