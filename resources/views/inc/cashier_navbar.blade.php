<header class="main-header">
  <!-- Logo -->
<a href="{{route('cashier.index')}}" class="logo">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class="logo-mini"><b>POS</b></span>
    <!-- logo for regular state and mobile devices -->
    <span class="logo-lg"><i class="fas fa-shopping-cart"></i> <b>Point of Sale</b> </span>
  </a>
  <!-- Header Navbar: style can be found in header.less -->
  <nav class="navbar navbar-static-top" role="navigation">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </a>
    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">
        <!-- User Account: style can be found in dropdown.less -->
        <li class="dropdown user user-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <span class="hidden-xs" style="text-transform:capitalize">
              @if (Auth::user()->roles->first()->name !== null)
              {{Auth::user()->roles->first()->name}}
              @else
              You must to logout error occured.
            @endif
          </span>
          </a>
          <ul class="dropdown-menu">
            <li class="user-footer">
              <div class="pull-left">
                <a id="btnSetting" class="btn btn-default btn-flat">Settings</a>
              </div>
              <div class="pull-right">
              <a href="{{route('logout')}}" class="btn btn-default btn-flat">Sign out</a>
              </div>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </nav>
</header>