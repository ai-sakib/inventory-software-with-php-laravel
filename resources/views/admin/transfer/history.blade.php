@extends('admin.layouts.app')

@section('title')
  <title>Transfer History</title>
@endsection

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Transfer History</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
          <li class="breadcrumb-item active">Transfer History</li>
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
                    <th style="width: 15%">Transfer No</th>
                    <th style="width: 15%">Item</th>
                    <th style="width: 15%">Quantity</th>
                    <th style="width: 15%">From Location</th>
                    <th style="width: 15%">To Location</th>
                    <th style="width: 15%">Transfer Date</th>
                  </tr>
                </thead>
                <tbody>
                  @if(isset($transfers[0]))
                     @foreach($transfers as $key => $value)
                    <tr id="tr-{{$value->id}}">
                      <td>{{ $key+1 }}</td>
                      <td>{{ $value->trans_no }}</td>
                      <td>{{ optional($value->item)->name }}</td>
                      <td>{{ $value->quantity }}</td>
                      <td>{{ optional($value->fromLocation)->name }}</td>
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

