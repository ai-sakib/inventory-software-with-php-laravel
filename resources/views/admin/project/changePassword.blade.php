@extends('admin.layouts.app')

@section('title')
  <title>Change Password</title>
@endsection

@section('content')


<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Change Password</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
          <li class="breadcrumb-item active">Change Password</li>
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
                    <form id="change-password-form" autocomplete="off" action="{{ url('change-password') }}" method="post" enctype="multipart/form-data">
                      {{ csrf_field() }}
                      <div class="row">
                        <div class="col-md-8">
                          <div class="form-group">
                            <label for="old_password">Old Password</label> <span style="color:red"> *</span>
                            <input type="password" id="old_password" class="form-control" name="old_password" value="{{old('old_password')}}" placeholder="Old Password" required>
                          </div>
                          <div class="form-group">
                            <label for="new_password">New Password</label> <span style="color:red"> *</span>
                            <input onkeyup="checkPassword('1')" type="password" id="new_password" class="form-control" name="new1_password" value="{{old('new_password')}}" placeholder="New Password" required>
                          </div>
                          <div class="form-group">
                            <label for="confirm_password">Confirm Password</label> <span style="color:red"> *</span>
                            <input onkeyup="checkPassword('2')" type="password" id="confirm_password" class="form-control" name="confirm_password" value="{{old('confirm_password')}}" placeholder="Confirm Password" required>
                          </div>
                          <small id="check-password" style="color: red;display: none">* red </small>
                          <div class="form-group">
                            <button type="submit" class="btn bg-primary">Change Password</button>
                          </div>
                        </div>
                      </div>
                    </form>
                </div>
            </div>
          </div>
        </div>
      </div>
    <!-- /.row -->
  
</section>
<!-- /.content -->
<script type="text/javascript">
  function changePassword(status){
    var new_password = $('#new_password').val();
    var confirm_password = $('#confirm_password').val();

    if(new_password != confirm_password){
      $('#check-password').show().removeAttr('style').attr('style','color:red').html('* password did not matched !');
    }else{
      $('#change-password-form').submit();
    }
  }
  function checkPassword(status){
    var new_password = $('#new_password').val();
    var confirm_password = $('#confirm_password').val();

    if(status == '1'){
      if(confirm_password != ''){
        if(new_password != confirm_password){
          $('#check-password').show().removeAttr('style').attr('style','color:red').html('* Sorry ! password did not matched');
        }else{
          $('#check-password').show().removeAttr('style').attr('style','color:green').html('* Congrats ! password matched !');
        }
      }
    }else{
      if(new_password != ''){
        if(new_password != confirm_password){
          $('#check-password').show().removeAttr('style').attr('style','color:red').html('* Sorry ! password did not matched !');
        }else{
          $('#check-password').show().removeAttr('style').attr('style','color:green').html('* Congrats ! password matched');
        }
      }
    }

    if((new_password == '') || (confirm_password == '')){
      $('#check-password').hide();
    }
  }
  

</script>
@endsection