<div class="row">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <div class="product-status-wrap">
          <form action="{{ route('main-menu.store') }}" method="post">
            {{ csrf_field() }}
                <div class="form-group">
                  <label for="serial_no">Serial No</label><span style="color:red"> *</span>
                  <input type="number" id="serial_no" class="form-control" name="serial_no" value="{{old('serial_no')}}" placeholder="Serial No" required>
                </div>
                <div class="form-group">
                  <label for="name">Main Menu Name</label><span style="color:red"> *</span>
                  <input type="text" id="name" class="form-control" name="name" value="{{old('name')}}" placeholder="Main Menu Name" required>
                </div>
                <div class="form-group">
                  <label for="icon">Icon</label><span style="color:red"> *</span>
                  <input type="text" id="icon" class="form-control" name="icon" value="{{old('icon')}}" placeholder="Icon" required>
                </div>
                
                <button type="submit" class="btn btn-primary">Submit</button>
                <button type="button" data-dismiss="modal" class="btn btn-default">Close</button>
                
          </form>
        </div>
    </div>
</div>
