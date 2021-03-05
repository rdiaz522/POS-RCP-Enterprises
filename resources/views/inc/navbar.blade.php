{{-- <nav class="main-header navbar navbar-expand navbar-navy navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link text-white" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <h3 style="font-weight:400"></h3>
      </li>

    </ul>
    <ul class="navbar-nav ml-auto ">
      <li class="nav-item dropdown">
       <a class="nav-link text-white" data-toggle="dropdown" href="#">
        {{Auth::user()->roles->first()->name}}
      </a>
      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <div class="dropdown-divider"></div>
           <a class="dropdown-item create" style="cursor: pointer;">
          <i class="fas fa-user-tie"></i> Create Account
          </a>
        <a href="{{route('logout')}}" class="dropdown-item">
            <i class="fas fa-sign-out-alt"></i> Logout
          </a>
      </li>
    </ul>
  </nav> --}}

  <header class="main-header">
    <!-- Logo -->
  <a href="{{route('home')}}" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>POS</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Point of Sale</b></span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Tasks Menu -->
          <li class="dropdown tasks-menu">
            <!-- Menu Toggle Button -->
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="far fa-envelope"></i>
              <span class="label label-warning">@if (count($critical) > 0)
                {{count($critical)}}
              @endif</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header"><strong class="text-success">You have {{count($critical)}} items of critical stocks.</strong></li>
              <li>
                <!-- Inner menu: contains the tasks -->
                <ul class="menu">
                  @if (count($critical) > 0)
                  @foreach ($critical as $items)
                  <li><!-- Task item -->
                    <a href="#">
                      <!-- Task title and progress text -->
                      <h3> <strong class="text-overflow">Name: {{$items['name']}}</strong>
                        <strong class="pull-right">Stock: {{$items['quantity']}}</strong>
                      </h3><br>
                      <!-- The progress bar -->
                      <div class="progress xs">
                        <!-- Change the css width attribute to simulate progress -->
                      <div class="progress-bar progress-bar-red" style="width:{{$items['quantity'] * 10}}%" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                        </div>
                      </div>
                    </a>
                  </li><!-- end task item -->
                  @endforeach
                  @endif
                </ul>
              </li>
              <li class="footer">
                <a href="#" id="viewcriticalstock"><strong class="text-primary">View all of critical stocks.</strong></a>
              </li>
            </ul>
          </li>
          <!-- Tasks Menu -->
          <li class="dropdown tasks-menu">
            <!-- Menu Toggle Button -->
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="far fa-envelope"></i>
              <span class="label label-danger">@if (count($outofstock) > 0)
                {{count($outofstock)}}
              @endif</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header"><strong class="text-danger">You have {{count($outofstock)}} items of out of stocks.</strong></li>
              <li>
                <!-- Inner menu: contains the tasks -->
                <ul class="menu">
                  @if (count($outofstock) > 0)
                  @foreach ($outofstock as $items)
                  <li><!-- Task item -->
                    <a href="#">
                      <!-- Task title and progress text -->
                      <h3> <strong class="text-overflow">Name: {{$items['name']}}</strong>
                        <strong class="pull-right">Stock: {{$items['quantity']}}</strong>
                      </h3><br>
                      <!-- The progress bar -->
                      <div class="progress xs">
                        <!-- Change the css width attribute to simulate progress -->
                        <div class="progress-bar progress-bar-red" style="width: 2%" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                        </div>
                      </div>
                    </a>
                  </li><!-- end task item -->
                  @endforeach
                  @endif
                </ul>
              </li>
              <li class="footer">
                <a href="#" id="viewoutofstock"><strong class="text-primary">View all of out of stocks</strong></a>
              </li>
            </ul>
          </li>
           <!-- Tasks Menu -->
           <li class="dropdown tasks-menu">
            <!-- Menu Toggle Button -->
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              Logout
            </a>
            <ul class="dropdown-menu">
              <li style="border:1px solid black">
              <a href="{{route('logout')}}" class="btn btn-secondary text-black">Yes</a>
              </li>
              <li style="border:1px solid black">
                <a href="#" class="btn btn-secondary text-black">No</a>
              </li>
            </ul>
          </li>
             
        </ul>
      </div>
    </nav>
  </header>
<form action="{{route('getStocker')}}" method="POST" id="frmStocker">
    @csrf
    <input type="text" name="stocker" id="stocker" hidden>
</form>
