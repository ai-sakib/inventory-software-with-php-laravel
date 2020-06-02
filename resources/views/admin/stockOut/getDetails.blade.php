<table class="table table-bordered">
	<thead>
		<tr class="bg-info">
			<th>Customer Name</th>
			<th>Sales Type</th>
			<th>Delivery Date</th>
			<th>Issued By</th>
			<th>Total</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>{{ optional($stockOut->customer)->name }}</td>
			<td>{{ optional($stockOut->salesType)->name }}</td>
			
			<td>{{ dateFormat($stockOut->stock_out_date) }}</td>
			<td>{{ optional($stockOut->creator)->name }}</td>
			<td>{{ $stockOut->total_price }}</td>
		</tr>
	</tbody>
</table>
<center><h5><strong>Item Details</strong></h5></center>
<table class="table table-bordered">

	<thead>
		<tr style="background-color: #3CAEA3; color: white">
			<th>SL</th>
			<th>Item</th>
			<th>Quantity</th>
			<th>Unit Price</th>
			<th>Total</th>
		</tr>
	</thead>
	<tbody>
		@if(isset($stockOutDetails[0]->id))
			@php
				$total_price = 0;
			@endphp
			@foreach($stockOutDetails as $key => $value)
				<tr>
					<td>{{ $key + 1 }}</td>
					<td>{{ optional($value->item)->name }}</td>
					<td>{{ $value->quantity }}</td>
					<td style="text-align: right">{{ $value->price }}</td>
					<td style="text-align: right">{{ $value->quantity * $value->price }}</td>
				</tr>
				@php
					$total_price += $value->quantity * $value->price;
				@endphp
			@endforeach
			<tr >
				<td colspan="4" style="text-align: right"><strong>Total</strong></td>
				<td style="text-align: right"><strong>{{ $total_price }}</strong></td>
			</tr>
		@endif
	</tbody>
</table>
{{-- <div style="width: 30%;float: right">
	<table class="table table-bordered">
		<tr>
			<td style="width: 50%;">Tax (%)</td>
			<td>{{ $stockOut->tax }}</td>
		</tr>
		<tr>
			<td>Discount</td>
			<td>{{ $stockOut->discount }}</td>
		</tr>
		<tr>
			<td>Total Amount</td>
			<td>{{ $stockOut->total_price }}</td>
		</tr>
		<tr>
			<td>Paid</td>
			<td>{{ $stockOut->paid }}</td>
		</tr>
		<tr>
			<td>Due</td>
			<td>{{ $stockOut->total_price - $stockOut->paid }}</td>
		</tr>
	</table>
</div> --}}
<center><h5><strong>Payment Details</strong></h5></center>
<div class="row">
    <div class="col-md-6">
     <div class="form-group">
        <table class="table table-bordered">
          <tr>
            <td style="width: 50%">Tax ({{ $stockOut->tax }} %)</td>
            <td style="text-align: right;">{{ ($stockOut->tax *  $total_price)/100}}</td>
          </tr>
          <tr>
            <td>Discount</td>
            <td style="text-align: right;">{{ $stockOut->discount }}</td>
          </tr>
        </table>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <table class="table table-bordered">
          <tr>
            <td style="width: 50%">Total Amount</td>
            <td style="text-align: right;">{{ $stockOut->total_price }}</td>
          </tr>
          <tr>
            <td>Paid</td>
            <td style="text-align: right;">{{ $stockOut->paid }}</td>
          </tr>
          <tr>
            <td>Due</td>
            <td style="text-align: right;">{{ $stockOut->total_price - $stockOut->paid }}</td>
          </tr>
          
        </table>
      </div>
    </div>
  </div>