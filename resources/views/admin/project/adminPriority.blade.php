@extends('admin.layouts.app')

@section('title')
  <title>Admin Priority</title>
@endsection

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Admin Priority</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
          <li class="breadcrumb-item active">Admin Priority</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->

<section class="content">
  <div class="container-fluid">
    <!-- Small boxes (Stat box) -->
    <div class="row">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <!-- /.card -->
            <div class="card">
              <!-- /.card-header -->
              <div class="card-body">
                <div class="product-status-wrap" style="min-height: 400px;">
                  <form id="admin-priority-form" method="POST" action="{{ url('admin-priority') }}">
                    @csrf
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="role_id">Admin Role</label>
                        <select class="form-control" name="role_id" id="role_id">
                          <option value="0">--- Select Role ---</option>
                          @if(isset($adminRoles[0]->id))
                            @foreach($adminRoles as $role)
                              <option value="{{$role->id}}">{{$role->name}}</option>
                            @endforeach
                          @endif
                        </select>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <a onclick="submitPriority()" class="btn bg-info" type="submit">Set Permission</a>
                    </div>
                  </form>
                </div>
            </div>
          </div>
        </div>
      </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
  
</section>
<!-- /.content -->

<script type="text/javascript">
  function submitPriority(){
    var role_id = $('#role_id').val();
    if(role_id != 0){
      $('#admin-priority-form').submit();
    }
  }
</script>
@endsection