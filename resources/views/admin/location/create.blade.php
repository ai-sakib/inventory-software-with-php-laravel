<div class="container-fluid">
  <div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <div class="product-status-wrap" >
        <form action="{{ route('locations.store') }}" method="post">
          {{ csrf_field() }}
          <div class="row">
            <div class="col-md-8">
              <div class="form-group">
                
                <label for="name">Location Name</label><span style="color:red"> *</span>
                <input type="text" id="name" class="form-control" name="name" value="{{old('name')}}" placeholder="Location Name">
              </div>
              
              <button type="submit" class="btn btn-primary">Submit</button>
              <button data-dismiss="modal" class="btn btn-default">Close</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>