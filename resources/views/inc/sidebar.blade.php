
{{-- <aside class="main-sidebar sidebar-dark-success elevation-4" style="background-color:#1c2a48">
 
<a href="{{route('home')}}" class="brand-link">

      <span class="brand-text font-weight-light">
        @if (Auth::user()->roles->first()->name == 'Admin')
            Administrator
        @else 
            Staff Manager
        @endif
      </span>
    </a>

  
    <div class="sidebar" style="background-color:#1c2a48">

      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info">
          <a href="#" class="d-block">SALES AND INVENTORY</a>
        </div>
      </div>
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item has-treeview">
          <a href="{{route('home')}}" id="dashboard" class="nav-link dashboard">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard Sales
              </p>
            </a>
          </li>

          <li class="nav-item has-treeview">
          <a href="{{route('products.index')}}" id="inventory" class="nav-link inventory">
            <i class="nav-icon fas fa-list"></i> 
              <p>
                Inventory
              </p>
            </a>
          </li>

          <li class="nav-item has-treeview">
            <a href="{{route('categories.index')}}" id="categories" class="nav-link categories">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  Item Categories
                </p>
              </a>
            </li>
            <li class="nav-item has-treeview">
            <a href="{{route('supplier.index')}}" id="supplier" class="nav-link supplier">
                  <i class="nav-icon fas fa-tachometer-alt"></i>
                  <p>
                    Supplier Management
                  </p>
                </a>
            </li>
            <li class="nav-item has-treeview">
            <a href="{{route('user.index')}}" id="user" class="nav-link user">
                  <i class="nav-icon fas fa-tachometer-alt"></i>
                  <p>
                    User Management
                  </p>
                </a>
            </li>
              <li class="nav-item has-treeview">
                <a href="#" id="logs" class="nav-link logs">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>
                      Activity Logs
                    </p>
                  </a>
                </li>
         <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Report
                  <i class="fas fa-angle-left right"></i>
              </p>
            </a>
             <ul class="nav nav-treeview">
              <li class="nav-item">
                <a class="nav-link soloparent" style="cursor: pointer;">
                 <i class="nav-icon fas fa-file-pdf"></i>
                  <p>Solo Parent Report</p>
                </a>
              </li>
            </ul>
          </li>
      </nav>
    </div>
  </aside> --}}


<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

      <!-- Sidebar user panel (optional) -->
      <div class="user-panel">
        <div class="pull-left image">
            {{-- Admin Image --}}
          {{-- <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image"> --}}
          IMG
        </div>
        <div class="pull-left info">
          <p class="admin-name">
            @if (Auth::user()->roles->first()->name == 'Admin')
                Administrator
            @else 
                Staff Manager
            @endif
          </p>
        </div>
      </div>
      <!-- Sidebar Menu -->
      <ul class="sidebar-menu">
        <li class="header text-center">MENU</li>

        <!-- Optionally, you can add icons to the links -->
      @can('admin')
        <li class="dashboards">
          <a href="{{route('home')}}" class="dashboard" id="dashboard">
            <i class="fas fa-tachometer-alt"></i> 
            <span>&nbsp Sales Summary</span>
          </a>
        </li>
        @endcan
       

        <li class="inventorys">
          <a href="{{route('products.index')}}" class="inventory" id="inventory">
            <i class="fas fa-clipboard-list"></i>
            <span>&nbsp Items</span>
          </a>
        </li>

        <li class="invs">
          <a href="{{route('inventory.index')}}" class="inv" id="inv">
            <i class="fas fa-warehouse"></i>
            <span>&nbsp Inventory</span>
          </a>
        </li>
        @can('admin')
          <li class="stocks">
            <a href="{{route('stock.index')}}" class="stock" id="stock">
              <i class="fas fa-clipboard-list"></i>
              <span>&nbsp Stock Logs</span>
            </a>
          </li>
        @endcan
       
        @can('admin')
          <li class="voids">
            <a href="{{route('void.index')}}" class="voids" id="voids">
              <i class="fas fa-clipboard-list"></i>
              <span>&nbsp Transaction Void Logs</span>
            </a>
          </li>
        @endcan
        
        <li class="categoriess">
          <a href="{{route('categories.index')}}" class="categories" id="categories">
            <i class="fas fa-clipboard-list"></i>
            <span>&nbsp Item Categories</span>
          </a>
        </li>
        
        <li class="suppliers">
          <a href="{{route('supplier.index')}}" class="supplier" id="supplier">
            <i class="fas fa-parachute-box"></i>
            <span>&nbsp Suppliers</span>
          </a>
        </li>
        @can('admin')
        <li class="users">
          <a href="{{route('user.index')}}" class="user" id="user">
            <i class="fas fa-user-shield"></i>
            <span>&nbsp User's Management</span>
          </a>
        </li>

        <li class="customers">
          <a href="{{route('customer.index')}}" class="customer" id="customer">
            <i class="fas fa-users"></i>
            <span>&nbsp Customer Management</span>
          </a>
        </li>
        @endcan
        

        {{-- <li class="users">
          <a href="{{route('user.index')}}" class="user" id="user">
            <i class="fas fa-tachometer-alt"></i> 
            <span>&nbsp Income</span>
          </a>
        </li>

        <li class="users">
          <a href="{{route('user.index')}}" class="user" id="user">
            <i class="fas fa-tachometer-alt"></i> 
            <span>&nbsp Settings</span>
          </a>
        </li> --}}

      </ul><!-- /.sidebar-menu -->
      

    </section>
    <!-- /.sidebar -->
  </aside>