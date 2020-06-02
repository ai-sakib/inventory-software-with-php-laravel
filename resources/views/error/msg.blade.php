@if(Session::has('success'))
<div style="padding: -10px 0px -10px 0px" class="alert alert-success">
	<a style="cursor: pointer;" class="close" data-dismiss="alert">×</a>{!!Session::get('success')!!}
</div>
@endif


@if(Session::has('error'))
<div style="padding: -10px 0px -10px 0px" class="alert alert-danger">
	<a style="cursor: pointer;" class="close" data-dismiss="alert">×</a>{!!Session::get('error')!!} <br/>
</div>
@endif

@if (count($errors) > 0)
    <div style="padding: -10px 0px -10px 0px" class="alert alert-danger bg-danger">
    	<a style="cursor: pointer;" class="close" data-dismiss="alert">×</a>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif