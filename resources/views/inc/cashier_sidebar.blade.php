<style>
  input::-webkit-outer-spin-button,
  input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
  }
</style>
<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="pull-left image">
      User
      </div>
      <div class="pull-left info">
        <p style="text-transform:capitalize">@if (Auth::user()->username !== null)
          {{Auth::user()->username}}
          @else
          You must to logout error occured.
        @endif</p>

      </div>
    </div>>
    <form class="sidebar-form" onkeydown="return event.key != 'Enter';">
      <input type="number" min="0" max="15" maxlength="15" name="barcode" id="barcode" class="br_code form-control" placeholder="Scan barcode here.. -[Page Up]" autofocus>
    </form>
    <!-- /.search form -->
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu">
      <li class="header">MENU</li>
      <li><a href="#" id="add_item"><i class="fas fa-search"></i> <span> SEARCH PRODUCT - [F8]</span></a></li>
      <li><a href="#" id="customers"><i class="fas fa-search"></i> <span> SEARCH CUSTOMER - [`]</span></a></li>
      <li><a href="#" id="cancel_transac"><i class="fas fa-trash"></i><span> EMPTY CART - [DELETE]</span></a></li>
      <li><a href="#" id="print_receipt"><i class="fas fa-print"></i> PRINT RECEIPT</span></a></li>
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>