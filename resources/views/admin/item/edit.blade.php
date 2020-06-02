  <div class="row">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
          <div class="product-status-wrap">
              <form method="post" action="{{ route('items.update',$item->id) }}" enctype="multipart/form-data" >
                {{ method_field('PUT') }}
                {{ csrf_field() }}
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="category_id">Select Category</label><span style="color:red"> *</span>
                      <select class="form-control" name="category_id" id="category_id">
                        @if(isset($itemCategories[0]))
                          @foreach($itemCategories as $category)
                            <option value="{{$category->id}}" @if($item->category_id == $category->id) selected @endif>{{$category->name}}</option>
                          @endforeach
                        @endif
                      </select>
                    </div>

                    <div class="form-group">
                      <label for="name">Item Name</label><span style="color:red"> *</span>
                      <input type="text" id="name" class="form-control" name="name" value="{{old('name',$item->name)}}" placeholder="Item Name" required>
                    </div>

                    <div class="form-group">
                      <label for="details">Item Details</label><span style="color:red"> *</span>
                      <textarea name="details"  required id="details" class="form-control">{{old('details',$item->details)}}</textarea>
                    </div>

                    <div class="form-group">
                      <label for="exampleFormControlFile1">Image</label><span style="color:red"> *</span>
                      <input type="file" name="file" class="form-control-file" id="exampleFormControlFile1">
                    </div>
                    <div class="form-group">
                      @if($item->image != '' && file_exists(public_path('items/'.$item->image)))
                        <img src="{{ url('public/items/') }}/{{ $item->image }}" style="max-width: 50px">
                      @endif
                    </div>

                  </div>
                  <div class="col-md-6">

                    <div class="form-group">
                      <label for="retail_price">Retail Price</label><span style="color:red"> *</span>
                      <input type="number" id="retail_price" class="form-control" name="retail_price" value="{{old('retail_price',$item->retail_price)}}" placeholder="Retail Price" required>
                    </div>

                    <div class="form-group">
                      <label for="wholesale_price">Wholesale Price</label><span style="color:red"> *</span>
                      <input type="number" id="wholesale_price" class="form-control" name="wholesale_price" value="{{old('wholesale_price',$item->wholesale_price)}}" placeholder="Wholesale Price" required>
                    </div>

                    <div class="form-group">
                      <label for="purchase_price">Purchase Price</label><span style="color:red"> *</span>
                      <input type="number" id="purchase_price" class="form-control" name="purchase_price" value="{{old('purchase_price',$item->purchase_price)}}" placeholder="Purchase Price" required>
                    </div>

                    
                  </div>
                  <div class="col-md-12">
                    <div class="modal-footer justify-content-between" id="quickViewModalFooter">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
      </div>