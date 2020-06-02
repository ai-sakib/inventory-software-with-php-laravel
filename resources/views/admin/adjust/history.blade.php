@extends('admin.layouts.app')

@section('title')
  <title>Adjustments History</title>
@endsection

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">

  <div class="container-fluid">
    <div class="row mb-2">

      <div class="col-sm-6">
        @include('error.msg')
        <h1 class="m-0 text-dark">Adjustments History</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
          <li class="breadcrumb-item active">Adjustments History</li>
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
                    <th style="width: 15%">Adjust No</th>
                    <th style="width: 15%">Item</th>
                    <th style="width: 15%">Quantity</th>
                    <th style="width: 12%">Status</th>
                    <th style="width: 13%">Location</th>
                    <th style="width: 20%">Adjustment Date</th>
                  </tr>
                </thead>
                <tbody>
                  @if(isset($adjustments[0]))
                   @foreach($adjustments as $key => $value)
                  <tr>
                    <td>{{ $key+1 }}</td>
                    <td>{{ $value->trans_no }}</td>
                    <td>{{ optional($value->item)->name }}</td>
                    <td>
                      @php 
                        $quantity = $value->quantity;
                        $status = 'Added';
                        $class = 'bg-success';
                        if($quantity < 0){
                          $quantity = - ($value->quantity);
                          $status = 'Removed';
                          $class = 'bg-danger';
                        }
                      @endphp
                      {{ $quantity }}</td>
                    <td><button class="btn btn-sm {{ $class }}">{{ $status }}</button></td>
                    <td>{{ optional($value->location)->name }}</td>
                    <td>{{ dateFormat($value->stock_move_date) }}</td>
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
@endsection