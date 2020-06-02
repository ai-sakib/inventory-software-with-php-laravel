@extends('admin.layouts.app')

@section('title')
  <title>System Users</title>
@endsection

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">System Users &nbsp;<a onclick="addPage('users','System User')" class="btn btn-sm bg-success"><i class="fas fa-plus"></i> Add</a></h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
          <li class="breadcrumb-item active">System Users</li>
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
                    <th style="width: 15%">Actions</th>
                    <th style="width: 25%">Name</th>
                    <th style="width: 15%">Role</th>
                    <th style="width: 15%">Created By</th>
                  </tr>
                </thead>
                <tbody>
                  @if(isset($users[0]))
                  @php
                    $color = 'bg-default';
                  @endphp
                   @foreach($users as $key => $value)
                    @php
                      if($value->role_id == 1){
                        $color = 'bg-info';
                      }elseif($value->role_id == 2){
                        $color = 'bg-success';
                      }elseif($value->role_id == 3){
                        $color = 'bg-primary';
                      }elseif($value->role_id == 4){
                        $color = 'bg-secondary';
                      }
                      
                    @endphp
                    <tr id="tr-{{$value->id}}">
                      <td>{{ $key+1 }}</td>
                      <td>
                        @if(optional($value->role)->id != 1)
                          <a onclick="editPage('users','{{ $value->id }}','System User')"  title="Edit" class="btn bg-primary btn-xs"><i class="fas fa-edit" aria-hidden="true"></i>&nbsp;Edit</a>
                          <a data-toggle="tooltip" onclick="Delete('{{$value->id}}')" title="Delete" class="btn bg-danger btn-xs"><i class="fas fa-trash-alt" aria-hidden="true"></i>&nbsp;Delete</a>
                        @endif
                      </td>
                      <td>{{ $value->name }}</td>
                      <td><a class="btn btn-sm {{ $color }}">{{ optional($value->role)->name }}</a></td>
                      <td>{{ optional($value->creator)->name }}</td>
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
    url: '{{ url('users') }}/'+id+'&'+status,
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
                  url: "{{url('users')}}/"+id,
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