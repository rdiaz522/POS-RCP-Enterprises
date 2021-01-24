<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>POS & SALES AND INVENTORY</title>
    <link rel="stylesheet" href="/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/vendor/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="/vendor/dist/css/font-awesome.min.css">
    <link rel="stylesheet" href="/vendor/dist/css/AdminLTE.css">
    <link rel="stylesheet" href="/vendor/dist/css/skins/_all-skins.min.css">
    <link rel="stylesheet" href="/vendor/plugins/sweetalert2/sweetalert2.min.css">
    <link rel="stylesheet" href="/vendor/dist/css/custom.css">
    <link rel="stylesheet" href="/vendor/plugins/jquery-ui/jquery-ui.min.css">
    <link rel="stylesheet" href="/vendor/DataTables-1.10.21/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="/vendor/Responsive-2.2.5/css/responsive.dataTables.min.css">
    <link rel="stylesheet" href="/vendor/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
</head>
<body class="hold-transition skin-green sidebar-mini" id="notblur">
    <span class="loading-spinner text-white" id="spinners"> <i class="fas fa-spinner fa-3x fa-spin"></i></span>
    <div class="wrapper">
      @include('inc.cashier_navbar')
      @include('inc.cashier_sidebar')
      <div class="content-wrapper" >
            <section class="content">
              @yield('content')
              <div style="bottom:100%;"><strong>Copyright © <span id="year"></span> RonDevIT </strong></div>
            </section><!-- /.content -->
        </div>
    </div>
    <script src="/vendor/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <script src="/vendor/plugins/jquery-ui/jquery-ui.min.js"></script>
    <script src="/vendor/plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <script src="/vendor/plugins/moment/moment.min.js"></script>
    <script src="/vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="/vendor/plugins/sweetalert2/sweetalert2.all.min.js"></script>
    <script src="/vendor/dist/js/submit.js"></script>
    <script src="/vendor/DataTables-1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="/vendor/Responsive-2.2.5/js/dataTables.responsive.min.js"></script>
        
    <script src="/vendor/Buttons-1.6.4/js/dataTables.buttons.min.js"></script>
    <script src="/vendor/Buttons-1.6.4/js/buttons.bootstrap.min.js"></script>
    <script src="/vendor/Buttons-1.6.4/js/buttons.html5.min.js"></script>
    <script src="/vendor/Buttons-1.6.4/js/buttons.print.min.js"></script>
    <script src="/vendor/pdfmake-0.1.36/pdfmake.min.js"></script>
    <script src="/vendor/pdfmake-0.1.36/vfs_fonts.js"></script>
    <script>
      let date = new Date();
      $('#year').text(date.getFullYear());
    </script>
    @yield('script')
</body>
</html>