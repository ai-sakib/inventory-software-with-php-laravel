@extends('admin.layouts.app')

@section('title')
  <title>{{ $adminRole->name }}</title>
@endsection

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">{{ $adminRole->name }}</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('admin-priority') }}">Admin Permission</a></li>
          <li class="breadcrumb-item active">{{ $adminRole->name }}</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->

<section class="content">
  <div class="container-fluid">
    <!-- Small boxes (Stat box) -->
    <div class="row">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <!-- /.card -->
            <div class="card">
              <!-- /.card-header -->
              <div class="card-body">
                <div class="product-status-wrap" style="min-height: 400px;">
                  <form id="admin-priority-form" method="POST" action="{{ url('admin-priority/0/store') }}">
                    @csrf
                    <input type="hidden" name="role_id" value="{{ $adminRole->id }}">
                      <div class="row">
                        @if(isset($mainMenus[0]->id))
                          @foreach($mainMenus as $mainKey => $mainMenu)
                            <div class="col-md-3">
                              <div class="form-group">
                                <div class="icheck-info">

                                  <input type="checkbox" onclick="checkAll(this,'{{ $mainKey }}')" name="mainMenu[]" value="{{ $mainMenu->id }}" id="mainMenu_{{ $mainKey }}" class="mainMenu_{{ $mainKey }}" @if(!empty($mainMenuArray)) @if(in_array($mainMenu->id, $mainMenuArray)) checked @endif @endif>

                                  <label for="mainMenu_{{ $mainKey }}">
                                    <h5><strong>{{ $mainMenu->name }}</strong></h5>
                                  </label>

                                </div>
                                
                                @php
                                  $subMenus = \App\Models\SubMenu::where('main_menu_id',$mainMenu->id)->orderBy('serial_no','asc')->get();
                                @endphp
                                @if(isset($subMenus[0]->id))
                                  @foreach($subMenus as $subKey => $subMenu)
                                    <div class="icheck-success">

                                      <input type="checkbox" class="mainMenu_{{ $mainKey }}" name="subMenu[]" value="{{ $subMenu->id }}" id="subMenu-{{ $mainKey }}-{{ $subKey }}" @if(!empty($subMenuArray)) @if(in_array($subMenu->id, $subMenuArray)) checked @endif @endif>

                                      <label style="font-weight: normal;" for="subMenu-{{ $mainKey }}-{{ $subKey }}">
                                        {{ $subMenu->name }}
                                      </label>

                                    </div>
                                  @endforeach
                                @endif
                              </div>
                            </div>
                          @endforeach
                        @endif
                        
                      </div>
                      <div class="row">
                        <div class="col-12">
                          <button class="btn bg-info" type="submit">Save</button>
                        </div>
                      </div>
                      
                  </form>
                </div>
            </div>
          </div>
        </div>
      </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
  
</section>
<!-- /.content -->

<script type="text/javascript">
  
  function checkAll(source,mainKey) {
    var checkboxes = document.getElementsByClassName("mainMenu_"+mainKey);
    console.log(checkboxes.length);
    for (var i = 0; i < checkboxes.length; i++) {
      if (checkboxes[i] != source){
        checkboxes[i].checked = source.checked;
      }
    }
  }
</script>
@endsection