@extends('admin.layouts.app')

@section('title')
  <title>Sub Menu</title>
@endsection

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Sub Menu &nbsp;<a onclick="addPage('sub-menu','Sub Menu')" class="btn btn-sm bg-success"><i class="fas fa-plus"></i> Add</a></h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
          <li class="breadcrumb-item active">Sub Menu</li>
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
                    <th style="width: 10%">SL</th>
                    <th style="width: 15%">Serial No</th>
                    <th style="width: 15%">Sub Menu</th>
                    <th style="width: 15%">Main Menu</th>
                    <th style="width: 15%">Link</th>
                    <th style="width: 10%">Icon</th>
                    <th style="width: 10%">Status</th>
                    <th style="width: 10%">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  @if(isset($subMenus[0]))
                   @foreach($subMenus as $key => $value)
                  <tr id="tr-{{$value->id}}">
                    <td>{{ $key+1 }}</td>
                    <td>{{ $value->serial_no }}</td>
                    <td>{{ $value->name }}</td>
                    <td>{{ optional($value->mainMenu)->name }}</td>
                    <td>{{ $value->link }}</td>
                    <td>{{ $value->icon }}</td>
                    <td>
                      @if ($value->status == 1)
                       <button id="change-status-{{ $value->id }}" onclick="changeStatus('{{ $value->id }}','0')" class="btn btn-sm bg-success">Active</button>
                       @else
                       <button id="change-status-{{ $value->id }}" onclick="changeStatus('{{ $value->id }}','1')" class="btn btn-sm bg-danger">Inactive</button>
                       @endif
                    </td>
                    <td>
                      <a onclick="editPage('sub-menu','{{ $value->id }}','Sub Menu')"  title="Edit" class="btn bg-primary btn-xs"><i class="fas fa-edit" aria-hidden="true"></i></a>
                      <a data-toggle="tooltip" onclick="Delete('{{$value->id}}')" title="Delete" class="btn bg-danger btn-xs"><i class="fas fa-trash-alt" aria-hidden="true"></i></a>
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
    url: '{{ url('sub-menu') }}/'+id+'&'+status,
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
                  url: "{{url('sub-menu')}}/"+id,
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