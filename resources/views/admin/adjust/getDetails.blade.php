<table class="table table-bordered">
	<thead>
		<tr style="background-color: cadetblue !important; color: white !important">
			<th>SL</th>
			<th>Item</th>
			<th>Quantity</th>
			<th>Unit Price</th>
			<th>Total</th>
		</tr>
	</thead>
	<tbody>
		@if(isset($stockInDetails[0]->id))
			@php
				$total_price = 0;
			@endphp
			@foreach($stockInDetails as $key => $value)
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
			<tr>
				<td colspan="4" style="text-align: right"><strong>Total</strong></td>
				<td style="text-align: right"><strong>{{ $total_price }}</strong></td>
			</tr>
		@endif
	</tbody>
</table>