<!DOCTYPE html>
<html>
<head>
    @php
        use \App\Http\Controllers;
        use \Illuminate\Support\Facades\Route;
        $route = explode('/',Route::current()->uri)[0];
        $project = \App\Models\Project::find(1);
        

        $mainMenuArray = array();
        $subMenuArray = array();

        $role_id = \Auth::user()->role_id;

        $mainMenuForRole = \DB::table('main_menu_permission')->where('role_id',$role_id)->get();
        $subMenuForRole = \DB::table('sub_menu_permission')->where('role_id',$role_id)->get();

        if(isset($mainMenuForRole[0]->id)){
            foreach ($mainMenuForRole as $value) {
                array_push($mainMenuArray, $value->main_menu_id);
            }
        }
        if($role_id == 1){
          if(\Auth::id() != 1){
            $subMenuForSuperAdmin = \App\Models\SubMenu::where('main_menu_id',5)->get();
            array_push($mainMenuArray, 5);
          }else{
            $subMenuForSuperAdmin = \App\Models\SubMenu::whereIn('main_menu_id',[4,5])->get();
            array_push($mainMenuArray, 4);
            array_push($mainMenuArray, 5);
          }
          if(isset($subMenuForSuperAdmin[0]->id)){
            foreach ($subMenuForSuperAdmin as  $sub) {
              array_push($subMenuArray, $sub->id);
            }
          }
          
        }
        

        if(!empty($mainMenuArray)){
          $mainMenus = \App\Models\MainMenu::whereIn('id',$mainMenuArray)->orderBy('serial_no','asc')->get();
        }

        if(isset($subMenuForRole[0]->id)){
          foreach ($subMenuForRole as $value) {
              array_push($subMenuArray, $value->sub_menu_id);
          }
        }
    @endphp
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  @yield('title')
  <!-- Tell the browser to be responsive to screen width -->
  <link rel="shortcut icon" href="{{ url('public') }}/project/{{ $project->logo }}">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ url('public') }}/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="{{ url('public') }}/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="{{ url('public') }}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="{{ url('public') }}/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{ url('public') }}/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  {{-- <link rel="stylesheet" href="{{ url('public') }}/plugins/jqvmap/jqvmap.min.css"> --}}
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ url('public') }}/dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ url('public') }}/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{ url('public') }}/plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="{{ url('public') }}/plugins/summernote/summernote-bs4.css">
  <!-- Google Font: Source Sans Pro -->
  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">

  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

  <link rel="stylesheet" href="{{ url('public') }}/css/datapicker/datepicker3.css">

  <style type="text/css">
    .content-header{
      margin: -8px 0px -8px 0px !important;
    }
  </style>

</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="{{ url('public') }}/#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ url('/') }}" class="nav-link">Dashboard</a>
      </li>
    </ul>

    <!-- SEARCH FORM -->
    <form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
      {{-- <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="{{ url('public') }}/#">
          <i class="far fa-comments"></i>
          <span class="badge badge-danger navbar-badge">3</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="{{ url('public') }}/#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="{{ url('public') }}/dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Brad Diesel
                  <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">Call me whenever you can...</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="{{ url('public') }}/#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="{{ url('public') }}/dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  John Pierce
                  <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">I got your message bro</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="{{ url('public') }}/#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="{{ url('public') }}/dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Nora Silvester
                  <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">The subject goes here</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="{{ url('public') }}/#" class="dropdown-item dropdown-footer">See All Messages</a>
        </div>
      </li> --}}
      <!-- Notifications Dropdown Menu -->
      {{-- <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="{{ url('public') }}/#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="{{ url('public') }}/#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="{{ url('public') }}/#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="{{ url('public') }}/#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="{{ url('public') }}/#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li> --}}
      <li class="nav-item dropdown">
        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
           {{ \Auth::user()->name }} {{-- <i class="far fa-user"></i>  --}}<span class="caret"></span>
        </a>

        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="{{ route('logout') }}"
               onclick="event.preventDefault();
                             document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt"></i> {{ __('Logout') }}
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </li>

      {{-- <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="{{ url('public') }}/#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li> --}}
    </ul>
  </nav>
  {{-- <div style="padding: 10px">
      @include('error.msg')
      @yield('content')
  </div> --}}
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('/') }}" class="brand-link">
      <img src="{{ url('public') }}/project/{{ $project->logo }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">{{ $project->name }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
     {{--  <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ url('public') }}/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a style="cursor: pointer;" class="d-block">{{ \Auth::user()->name }}</a>
        </div>
      </div> --}}

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
           <li style="cursor: pointer;" class="main-menus nav-item has-treeview">
            <a href="{{ url('/') }}" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Dashboard</p>
            </a>
          </li>
          @if(isset($mainMenus[0]->id))
            @foreach($mainMenus as $mainMenu)
              <li style="cursor: pointer;" class="main-menus nav-item has-treeview">
                <a id="main-menu-{{ $mainMenu->id }}" class="nav-link">
                  <i class="nav-icon {{ $mainMenu->icon }}"></i>
                  <p>
                    {{ $mainMenu->name }}
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                @php
                   $subMenus = \App\Models\SubMenu::orderBy('serial_no','asc')->where('main_menu_id',$mainMenu->id)->get();
                @endphp
                <ul class="nav nav-treeview">
                  @if(isset($subMenus[0]->id))
                    @foreach($subMenus as $subMenu)
                      @if(!empty($subMenuArray) && in_array($subMenu->id, $subMenuArray))
                        <li class="sub-menus nav-item">
                          <a id="sub-menu-{{ $subMenu->id }}"  title="{{ $subMenu->name }}" href="{{ url('/') }}/{{ $subMenu->link }}" class="nav-link">
                            &nbsp;&nbsp;&nbsp;<i class="far fa-circle nav-icon"></i>
                            <p>{{ $subMenu->name }}</p>
                          </a>
                        </li>
                      @endif
                    @endforeach
                  @endif
                </ul>
              </li>
            @endforeach
          @endif
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <div style="padding: 10px 15px 0px 15px">
      @include('error.msg')
    </div>
    @yield('content')
  </div>
  

  
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2014-2019 <a href="{{ url('/') }}">REMSIS</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 1.0.0
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<div class="modal fade" id="modal-lg">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Large Modal</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>One fine body&hellip;</p>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
<div class="modal fade" id="quickViewModal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="quickViewModalTitle">Large Modal</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" id="quickViewModalBody">
          
        </div>
        <div class="modal-footer justify-content-between" id="quickViewModalFooter">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
</div>

<div class="modal fade" id="quickViewModalMD">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="quickViewModalTitleMD">Large Modal</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" id="quickViewModalMDBody">
          
        </div>
        <div class="modal-footer" id="quickViewModalMDFooter">
          <button type="button" class="btn btn-danger" data-dismiss="modal" id="quickViewModalMDClose">Close</button>
        </div>
      </div>
    </div>
</div>
@include('admin.includes.modalPages')
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{ url('public') }}/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ url('public') }}/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{ url('public') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="{{ url('public') }}/plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="{{ url('public') }}/plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
{{-- <script src="{{ url('public') }}/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="{{ url('public') }}/plugins/jqvmap/maps/jquery.vmap.usa.js"></script> --}}
<!-- jQuery Knob Chart -->
<script src="{{ url('public') }}/plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="{{ url('public') }}/plugins/moment/moment.min.js"></script>
<script src="{{ url('public') }}/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ url('public') }}/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="{{ url('public') }}/plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="{{ url('public') }}/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="{{ url('public') }}/dist/js/adminlte.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ url('public') }}/dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ url('public') }}/dist/js/demo.js"></script>
<!-- DataTables -->
<script src="{{ url('public') }}/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="{{ url('public') }}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="{{ url('public') }}/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{ url('public') }}/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
{{-- jQuery Confirm --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.js"></script>
<script src="{{ url('public') }}/js/datapicker/bootstrap-datepicker.js"></script>
    <script src="{{ url('public') }}/js/datapicker/datepicker-active.js"></script>
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true,
      "autoWidth": false,
    });
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
<script type="text/javascript">
  activeMenu();
  function activeMenu($subMenuID){
      var route = '{{ $route }}';
      if(route != ''){
          $.ajax({
              url: '{{ url('get-active-menu') }}/'+route,
              type: 'GET',
              dataType: 'json',
          })
          .done(function(response) {
              if(response.success){
                $('#main-menu-'+response.mainMenuID).click();
                $('#main-menu-'+response.mainMenuID).addClass('active').attr('style','background-color:#17a2b8');
                $('#sub-menu-'+response.subMenuID).addClass('active');                    
              }
          })
          .fail(function() {
              console.log("error");
          });
      }
      
  }
</script>
</body>
</html>
