@extends('admin.layouts.app')

@section('title')
  <title>Project Details</title>
@endsection

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Edit Project Details</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
          <li class="breadcrumb-item active">Project Details</li>
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
                <div class="product-status-wrap" style="min-height: 500px;">
                    <form action="{{ url('project') }}" method="post" enctype="multipart/form-data">
                      {{ csrf_field() }}
                      <div class="row">
                        <div class="col-md-8">
                          <div class="form-group">
                            <label for="name">Project Name</label> <span style="color:red"> *</span>
                            <input type="text" id="name" class="form-control" name="name" value="{{old('name',$project->name)}}" placeholder="Project Name" required>
                          </div>
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="email">Email</label> <span style="color:red"> *</span>
                                <input type="email" id="email" class="form-control" name="email" value="{{old('email',$project->email)}}" placeholder="Project Email" required>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="phone">Phone</label> <span style="color:red"> *</span>
                                <input type="text" id="phone" class="form-control" name="phone" value="{{old('phone',$project->phone)}}" placeholder="Project Phone" required>
                              </div>
                            </div>
                          </div>
                          
                          
                          <div class="form-group">
                            <label for="address">Address</label> <span style="color:red"> *</span>
                            <textarea id="address" name="address" class="form-control"> {{ old('address',$project->address) }} </textarea>
                            </div>
                          <div class="form-group">
                            <label for="file">Logo</label>
                            <input type="file" name="file" class="form-control-file" id="file">
                          </div>
                          <div class="form-group">
                            @if($project->logo != '' && file_exists(public_path('project/'.$project->logo)))
                              <img src="{{ url('public/project/') }}/{{ $project->logo }}" style="max-width: 65px">
                            @endif
                          </div>
                          <button type="submit" class="btn btn-primary">Update</button>
                        </div>
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
@endsection