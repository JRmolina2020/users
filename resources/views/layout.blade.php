@include('header')
<body class="hold-transition skin-red sidebar-mini">
  <div class="wrapper">
    <header class="main-header">
      <a href="https://i.ya-webdesign.com/images/png-avatar-4.png" class="logo">
        <span data-toggle="push-menu" class="logo-mini"><b>A</b>LT</span>
        <span  data-toggle="push-menu" class="logo-lg"><b>Admin</b>LTE</span>
      </a>
      <nav class="navbar navbar-static-top">
        {{-- <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </a> --}}
      </nav>
    </header>
    <aside class="main-sidebar">
      <section class="sidebar">
        <div class="user-panel">
          <div class="pull-left image">
            <img src="{{ asset('storage').'/'. Auth::user()->image }}" height="40" width="40" class="img-circle" alt="User Image">
          </div>
          <div class="pull-left info">
            <p>{{ Auth::user()->name}}</p>
            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
          </div>
        </div>
        {{--  NAVIGATION  --}}
       @include('navegation')
        {{--  END NAVIGATION  --}}
      </section>
    </aside>

    <div class="content-wrapper">
      <section class="content" id="app">
        <div class="box box-danger col-lg-8 principal">
          <div class="box-header with-border">
            <h3 class="box-title">@yield('titlepanel')</h3>
          </div>
          <div class="box-body">
            @yield('content')
          </div>
        </div>
      </section>
    </div>
    <footer class="main-footer">
      <div class="pull-right hidden-xs">
        <b>Version</b> 2.4.18
      </div>
      <strong>Copyright &copy; 2014-2019 <a href="https://adminlte.io">AdminLTE</a>.</strong> All rights
      reserved.
    </footer>
    </aside>
    <div class="control-sidebar-bg"></div>
  </div>
  @include('footer')