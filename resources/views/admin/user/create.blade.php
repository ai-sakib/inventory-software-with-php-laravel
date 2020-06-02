<div class="container-fluid">
  <div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <div class="product-status-wrap" >
        <form method="POST" action="{{ route('users.store') }}">
          {{ csrf_field() }}
          <div class="row">
            <div class="col-md-8">
              <div class="form-group">
                <label for="name">Name</label><span style="color:red"> *</span>
                <input type="text" id="name" class="form-control" name="name" value="{{old('name')}}" placeholder="Name">
              </div>
              <div class="form-group">
                <label for="role_id">Admin Role</label><span style="color:red"> *</span>
                <select id="role_id" name="role_id" class="form-control">
                  @if(isset($adminRoles[0]->id))
                    @foreach($adminRoles as $role)
                      <option value="{{ $role->id }}">{{ $role->name }}</option>
                    @endforeach
                  @endif
                </select>
              </div>
              <div class="form-group">
                <label for="email">Email</label><span style="color:red"> *</span>
                <input type="email" id="email" class="form-control" name="email" value="{{old('email')}}" placeholder="Email">
              </div>
              <div class="form-group">
                <label for="password">Password</label><span style="color:red"> *</span>
                <input type="password" id="password" class="form-control" name="password" value="{{old('name')}}" placeholder="Password">
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