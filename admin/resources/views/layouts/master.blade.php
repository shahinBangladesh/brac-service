<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  {{-- <title>{{ count($notification) + count($assetNotification) + count($assetApproveNotification) }} Corporate | Dashboard</title> --}}
  <title>@isset($title) {{ $title }} @endisset</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('assets/css/font-awesome.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{ asset('assets/css/ionicons.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('assets/css/AdminLTE.min.css') }}">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="{{ asset('assets/css/skins/_all-skins.min.css') }}">
  <!-- Morris chart -->
  <link rel="stylesheet" href="{{ asset('assets/css/morris.css') }}">
  <!-- Date Picker -->
  <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datepicker.min.css') }}">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="{{ asset('assets/css/bootstrap3-wysihtml5.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap.min.css') }}">


  <!-- jQuery 3 -->
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="{{ route('dashboard') }}" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>eTraceability</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>eTraceability</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Notifications: style can be found in dropdown.less -->
          <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              {{-- <span class="label label-warning">{{ count($notification) + count($assetNotification) + count($assetApproveNotification) }}</span>  --}}
              <span class="label label-warning">0</span> 
            </a>
            {{-- <ul class="dropdown-menu" style="background-color: #D0D0A1">
              <li class="header text-bold text-center" style="border-bottom: 2px gray solid;margin-bottom: 20px;">You have {{ count($notification) + count($assetNotification) + count($assetApproveNotification) }} notifications</li>
              <li>
                <ul class="menu">
                  @if(count($notification)>0)
                    @foreach($notification as $value)
                      <li>
                        <a href="{{ route('notification.details',[$value->req_id,$value->id]) }}">
                          <span style="background-color: green;padding: 10px;color: white;margin-right: 5px">{{ $value->req_id }} </span>Request @if($value->status !=''){{ $value->status->name }} @endif On {{ $value->created_at->diffForHumans() }}
                        </a>
                      </li>
                    @endforeach
                  @endif
                  @if(count($assetNotification)>0)
                    @foreach($assetNotification as $value)
                      <li>
                        <a href="{{ route('assetNotification.details',[$value->id]) }}">
                          <span style="background-color: green;padding: 10px;color: white;margin-right: 5px">{{ $value->id }} </span>Asset Raised On {{ $value->created_at->diffForHumans() }}
                        </a>
                      </li>
                    @endforeach
                  @endif
                  @if(count($assetApproveNotification)>0)
                    @foreach($assetApproveNotification as $value)
                      <li>
                        <a href="{{ route('assetNotification.details',[$value->id]) }}">
                          <span style="background-color: green;padding: 10px;color: white;margin-right: 5px">{{ $value->id }} </span>Asset Approved by {{ $value->lastApprove->names }} On {{ $value->lastApprove->created_at->diffForHumans() }}
                        </a>
                      </li>
                    @endforeach
                  @endif
                  @if(count($assetOldNotification)>0)
                    @foreach($assetOldNotification as $value)
                      <li>
                        <a href="{{ route('assetNotification.details',[$value->id]) }}">
                          <span style="background-color: #F39C12;padding: 10px;color: white;margin-right: 5px">{{ $value->id }} </span>Asset Raised On {{ $value->created_at->diffForHumans() }}
                        </a>
                      </li>
                    @endforeach
                  @endif

                  @if(count($assetOldApproveNotification)>0)
                    @foreach($assetOldApproveNotification as $value)
                      <li>
                        <a href="{{ route('assetNotification.details',[$value->id]) }}">
                          <span style="background-color: #F39C12;padding: 10px;color: white;margin-right: 5px">{{ $value->id }} </span>Asset Approved by {{ $value->lastApprove->names }} On {{ $value->created_at->diffForHumans() }}
                        </a>
                      </li>
                    @endforeach
                  @endif

                  @if(count($oldNotification)>0)
                    @foreach($oldNotification as $value)
                      <li>
                        <a href="{{ route('notification.details',[$value->req_id,$value->id]) }}">
                          <span style="background-color: #F39C12;padding: 10px;color: white;margin-right: 5px">{{ $value->req_id }} </span>Request @if($value->status !=''){{ $value->status->name }} @endif On {{ $value->created_at->diffForHumans() }}
                        </a>
                      </li>
                    @endforeach
                  @endif
                </ul>
              </li>
              <li class="footer"><a href="#">View all</a></li>
            </ul> --}}
          </li>
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="@if(Auth::user()->photo != null) {!! asset('image/userPhoto/'.Auth::user()->photo) !!}@else{{ asset('image/defaultUser.png') }}@endif" class="user-image" alt="User Image">
              <span class="hidden-xs">
                @if(Auth::user()->name != null) {!! Auth::user()->name !!}@endif
              </span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="@if(Auth::user()->photo != null) {!! asset('image/userPhoto/'.Auth::user()->photo) !!}@else{{ asset('image/defaultUser.png') }}@endif" class="img-circle" alt="User Image">

                <p>
                  @if(Auth::user()->name != null) {!! Auth::user()->name !!}@endif
                </p>
              </li>              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-right">
                  <a href="{{ url('logout') }}" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <!-- <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li> -->
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="@if(Auth::user()->photo != null) {!! asset('image/userPhoto/'.Auth::user()->photo) !!}@else{{ asset('image/defaultUser.png') }}@endif" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>@if(Auth::user()->name != null) {!! Auth::user()->name !!}@endif</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- search form -->
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        <li class="active">
          <a href="{{ route('dashboard') }}">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>
        @if(Auth::user()->branch_id == null)
            @if(Auth::user()->approverOrConsent == 1) 
              <li class="treeview">
                <a href="#">
                  <i class="fa fa-users"></i>
                  <span>User Type</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu">
                  <li>
                    <a href="{!! route('user-type.create') !!}"><i class="fa fa-circle-o"></i> Create</a>
                  </li>
                  <li>
                    <a href="{!! route('user-type.index') !!}"><i class="fa fa-circle-o"></i> View</a>
                  </li>
                </ul>
              </li>

              <li class="treeview">
                <a href="#">
                  <i class="fa fa-users"></i>
                  <span>Users</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu">
                  <li>
                    <a href="{!! route('user.create') !!}"><i class="fa fa-circle-o"></i> Create</a>
                  </li>
                  <li>
                    <a href="{!! route('user.index') !!}"><i class="fa fa-circle-o"></i> View</a>
                  </li>
                </ul>
              </li>

              <li class="treeview">
                <a href="#">
                  <i class="fa fa-users"></i>
                  <span>Vendor</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu">
                  <li>
                    <a href="{!! route('vendor-company.create') !!}"><i class="fa fa-circle-o"></i> Create</a>
                  </li>
                  <li>
                    <a href="{!! route('vendor-company.index') !!}"><i class="fa fa-circle-o"></i> View</a>
                  </li>
                </ul>
              </li>
             @endif
        @endif
        @if(Auth::user()->branch_id == null)
          <li class="treeview">
            <a href="#">
              <i class="fa fa-pie-chart"></i>
              <span>Booth/Branch</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li>
                <a href="{!! route('branch.create') !!}"><i class="fa fa-circle-o"></i> Create</a>
              </li>
              <li>
                <a href="{!! route('branch.index') !!}"><i class="fa fa-circle-o"></i> View</a>
              </li>
            </ul>
          </li>
        @endif
        <li class="treeview">
          <a href="#">
            <i class="fa fa-files-o"></i>
            <span>Asset</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li>
              <a href="{!! route('asset.create') !!}"><i class="fa fa-circle-o"></i> Create</a>
            </li>
            <li>
              <a href="{!! route('asset.index') !!}"><i class="fa fa-circle-o"></i> View</a>
            </li>
          </ul>
        </li>
        @if(Auth::user()->branch_id == null)
          <li class="treeview">
            <a href="#">
              <i class="fa fa-laptop"></i>
              <span>Service Type</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li>
                <a href="{!! route('serviceType.create') !!}"><i class="fa fa-circle-o"></i> Create</a>
              </li>
              <li>
                <a href="{!! route('serviceType.index') !!}"><i class="fa fa-circle-o"></i> View</a>
              </li>
            </ul>
          </li>
        @endif
        <li class="treeview">
          <a href="#">
            <i class="fa fa-th"></i> 
            <span>Request a Problem</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li>
              <a href="{!! route('req.create') !!}"><i class="fa fa-circle-o"></i> Create</a>
            </li>
            <li>
              <a href="{!! route('req.index') !!}"><i class="fa fa-circle-o"></i> View</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="{!! route('req.estimate.reject') !!}">
            <i class="fa fa-th"></i> 
            <span>Estimate Reject List</span>
            <span class="pull-right-container">
              <i class="fa fa-circle-o pull-right"></i>
            </span>
          </a>
        </li>
        {{-- @if(Auth::user()->branch_id == null) --}}
          <li>
            <a href="{{ route('reports') }}">
              <i class="fa fa-th"></i> 
              <span>Reports</span>
            </a>
          </li>
          <li>
            <a href="{{ route('tatLists') }}">
              <i class="fa fa-th"></i> 
              <span>TAT</span>
            </a>
          </li>
        {{-- @endif --}}
        {{-- 
        <i class="fa fa-laptop"></i> 
        <i class="fa fa-edit"></i> 
        <i class="fa fa-table"></i>  
        <i class="fa fa-folder"></i> 
        --}}
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    @yield('main-content')
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 2.4.0
    </div>
    <strong>Copyright &copy; 2018-{{ date('Y') }} <a href="http://ess-bd.com">ESS</a>.</strong> All rights
    reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
      <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
      <!-- Home tab content -->
      <div class="tab-pane" id="control-sidebar-home-tab">
        <h3 class="control-sidebar-heading">Recent Activity</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-birthday-cake bg-red"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>

                <p>Will be 23 on April 24th</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-user bg-yellow"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>

                <p>New phone +1(800)555-1234</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>

                <p>nora@example.com</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-file-code-o bg-green"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>

                <p>Execution time 5 seconds</p>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

        <h3 class="control-sidebar-heading">Tasks Progress</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Custom Template Design
                <span class="label label-danger pull-right">70%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Update Resume
                <span class="label label-success pull-right">95%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-success" style="width: 95%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Laravel Integration
                <span class="label label-warning pull-right">50%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Back End Framework
                <span class="label label-primary pull-right">68%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

      </div>
      <!-- /.tab-pane -->
      <!-- Stats tab content -->
      <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
      <!-- /.tab-pane -->
      <!-- Settings tab content -->
      <div class="tab-pane" id="control-sidebar-settings-tab">
        <form method="post">
          <h3 class="control-sidebar-heading">General Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Report panel usage
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Some information about this general settings option
            </p>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Allow mail redirect
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Other sets of options are available
            </p>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Expose author name in posts
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Allow the user to show his name in blog posts
            </p>
          </div>
          <!-- /.form-group -->

          <h3 class="control-sidebar-heading">Chat Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Show me as online
              <input type="checkbox" class="pull-right" checked>
            </label>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Turn off notifications
              <input type="checkbox" class="pull-right">
            </label>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Delete chat history
              <a href="javascript:void(0)" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
            </label>
          </div>
          <!-- /.form-group -->
        </form>
      </div>
      <!-- /.tab-pane -->
    </div>
  </aside>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->


<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
<!-- Morris.js charts -->
<script src="{{ asset('assets/js/raphael.min.js') }}"></script>
<script src="{{ asset('assets/js/morris.min.js') }}"></script>
<!-- Sparkline -->
<script src="{{ asset('assets/js/jquery.sparkline.min.js') }}"></script>
<!-- jvectormap -->
<script src="{{ asset('assets/js/jquery-jvectormap-1.2.2.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery-jvectormap-world-mill-en.js') }}"></script>
<!-- jQuery Knob Chart -->
<script src="{{ asset('assets/js/jquery.knob.min.js') }}"></script>
<!-- daterangepicker -->
<script src="{{ asset('assets/js/moment.min.js') }}"></script>
<!-- datepicker -->
<script src="{{ asset('assets/js/bootstrap-datepicker.min.js') }}"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="{{ asset('assets/js/bootstrap3-wysihtml5.all.min.js') }}"></script>
<!-- Slimscroll -->
<script src="{{ asset('assets/js/jquery.slimscroll.min.js') }}"></script>
<!-- FastClick -->
<script src="{{ asset('assets/js/fastclick.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('assets/js/adminlte.min.js') }}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ asset('assets/js/dashboard.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('assets/js/demo.js') }}"></script>
<!-- DataTables -->
<script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
<script>
  $(function () {
    $('#example1').DataTable({'ordering': false});
    $('#example2').DataTable({'ordering': false});
    $('#example3').DataTable({'ordering': false});
    $('#example4').DataTable({'ordering': false});
    $('#example5').DataTable({'ordering': false});
    $('.datatable').DataTable({'ordering': false});
    //Date picker
    /*$('.datepicker').datepicker({
      autoclose: true,
      dateFormat: 'yy-mm-dd'
    });*/
    $('.datepicker').datepicker({ format: 'yyyy-mm-dd',autoclose: true,todayHighlight: true,startDate: new Date()});
    $('.datepicker-with-all-date').datepicker({ format: 'yyyy-mm-dd',autoclose: true,todayHighlight: true});
  });
</script>
</body>
</html>
