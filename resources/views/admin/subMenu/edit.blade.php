<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="product-status-wrap">
            <form action="{{ route('sub-menu.update',$subMenu->id) }}" method="post">
              {{ method_field('PUT') }}
              {{ csrf_field() }}
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="serial_no">Serial No</label><span style="color:red"> *</span>
                        <input type="number" id="serial_no" class="form-control" name="serial_no" value="{{old('serial_no',$subMenu->serial_no)}}" placeholder="Serial No" required>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="main_menu_id">Select Main Menu</label><span style="color:red"> *</span>
                        <select class="form-control" name="main_menu_id">
                          @if(isset($mainMenus[0]->id))
                            @foreach($mainMenus as $mainMenu)
                              <option value="{{ $mainMenu->id }}" @if(old('main_menu_id',$subMenu->main_menu_id) == $mainMenu->id) selected @endif>{{ $mainMenu->name }}</option>
                            @endforeach
                          @endif
                        </select>
                      </div>
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <label for="name">Sub Menu Name</label><span style="color:red"> *</span>
                    <input type="text" id="name" class="form-control" name="name" value="{{old('name',$subMenu->name)}}" placeholder="Sub Menu Name" required>
                  </div>
                  <div class="form-group">
                    <label for="link">Link</label><span style="color:red"> *</span>
                    <input type="text" id="link" class="form-control" name="link" value="{{old('link',$subMenu->link)}}" placeholder="Link" required>
                  </div>
                  <div class="form-group">
                    <label for="icon">Icon</label><span style="color:red"> *</span>
                    <input type="text" id="icon" class="form-control" name="icon" value="{{old('icon',$subMenu->icon)}}" placeholder="Icon" required>
                  </div>
                  <button type="submit" class="btn btn-primary">Update</button>
                  <button type="button" data-dismiss="modal" class="btn btn-default">Close</button>
            </form>
        </div>
    </div>
</div>
