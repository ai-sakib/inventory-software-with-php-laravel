<table class="table table-bordered">

	<thead>
		<tr style="background-color: #3CAEA3; color: white">
            <th >Order No</th>
            <th >Location</th>
            <th >Total</th>
            <th >Paid</th>
            <th >Due</th>
            <th >Payment</th>
		</tr>
	</thead>
	<tbody>
		@if(isset($stockInDetails[0]->id))
			@foreach($stockInDetails as $key => $value)
				<tr id="tr-{{$value->id}}">
                    <td>{{ $value->id }}</td>
                    <td>{{ optional($value->location)->name }}</td>
                    <td>{{ $value->total_price }}</td>
                    <td id="paid-each-{{ $value->id }}">{{ $value->paid }}</td>
                    <td id="due-each-{{ $value->id }}">{{ $value->total_price - $value->paid }}</td>
                    <td id="clear-each-{{ $value->id }}">
                      @if($value->total_price - $value->paid > 0)
                        <a onclick="setPayment('{{ $value->id }}','{{ $value->total_price }}','{{ $value->total_price - $value->paid }}','{{ $value->supplier_id }}','{{ $value->supplier_id }}')" class="btn btn-xs bg-info"><i class="fas fa-money-bill-alt "></i>&nbsp;Pay</a>&nbsp;&nbsp;<a onclick="clearPaymentEach('{{ $value->id }}','{{ $value->supplier_id }}')" class="btn btn-xs bg-success"><i class="fa fa-window-close "></i>&nbsp;Clear</a>
                      @else
                      <a class="btn btn-xs bg-info"><i class="fa fa-save "></i>&nbsp;&nbsp;Cleared</a>
                      @endif
                    </td>
                </tr>
			@endforeach
		@endif
	</tbody>
</table>
<script type="text/javascript">
	function setPayment(id,total,due,supplier_id) {
    $.confirm({
      title: 'Payment',
      content:
      '<div class="form-group">' +
      '<label>Total</label>' +
      '<input type="text" class="total form-control" readonly value="'+total+'" />' +
      '</div>'+
      '<div class="form-group">' +
      '<label>Due</label>' +
      '<input type="text" class="due form-control" readonly value="'+due+'" />' +
      '</div>'+
      '<div class="form-group">' +
      '<label>Pay</label>' +
      '<input type="number" required id="payment" step="0.01" placeholder="'+due+'" class="form-control"/>' +
      '</div>',
      buttons: {
          formSubmit: {
              text: 'Set Payment',
              btnClass: 'btn-info',
              action: function () {
                  var payment = parseFloat($('#payment').val());
                  console.log(due, payment);
                  if(payment > 0){
                    if(payment <= due){
                      $.ajax({
                        url: "{{url('suppliers')}}/"+id+'&'+payment+"/setPayment",
                        type: 'GET',
                        data: {},
                      })
                      .done(function(response) {
                          if(response.success){
                            if((total- response.paid) > 0){
                              $('#clear-each-'+response.id).html('<a onclick="setPayment('+id+','+total+','+(total-response.paid)+')" class="btn btn-xs bg-info"><i class="fas fa-money-bill-alt "></i>&nbsp;Pay</a>&nbsp;&nbsp;<a onclick="clearPaymentEach('+id+')" class="btn btn-xs bg-success"><i class="fa fa-window-close "></i>&nbsp;Clear</a>');
                            }else{
                              $('#clear-each-'+response.id).html('<a class="btn btn-xs bg-info"><i class="fa fa-save "></i>&nbsp;&nbsp;Cleared</a>');
                            }
                            
                            $('#paid-each-'+response.id).html(response.paid);
                            $('#due-each-'+response.id).html(total-response.paid);
                          }
                      });
                    }else{
                      $.alert({
                        title:"Whoops!",
                        content:"<hr><strong class='text-danger'>Payment must be less than due</strong><hr>",
                        type:"red"
                     });
                    }
                  }else{
                    $.alert({
                      title:"Whoops!",
                      content:"<hr><strong class='text-danger'>Payment must be greater than 0</strong><hr>",
                      type:"red"
                   });
                  }
                }
          },
          cancel: function () {
              
          }
        }
    });
  }

  function clearPaymentEach(id,supplier_id) {
    $.confirm({
      title: '',
      content: '<div style="padding-top:35px;padding-bottom:15px"><h3 class="text-center"><strong class="text-success">Are you sure to Clear Payment ?</strong></h3></div>',
      buttons: {
          confirm: {
              text: 'Clear',
              btnClass: 'btn-danger',
              action: function(){
                $.ajax({
                url: "{{url('suppliers')}}/"+id+'/clearPaymentEach',
                type: 'GET',
                dataType: 'json',
                success:function(response) {
                  if(response.success){
                    $('#clear-each-'+response.id).html('<a class="btn btn-xs bg-info"><i class="fa fa-save "></i>&nbsp;&nbsp;Cleared</a>');
                    $('#paid-each-'+response.id).html(response.paid);
                    $('#due-each-'+response.id).html(0);
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
