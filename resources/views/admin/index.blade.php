@extends('layouts.admin')
@section('container-title')
   <h1>Sales Summary  <span class="pull-right time" style="font-family:cursive"></span></h1>
  
@endsection
@section('content')
  <div class="row">
      <div class="col-lg-6 col-md-6">
          <span style="display: none"> 
          {{$total = 0}}
          {{$total_item = 0}}
          {{$totalprofit = 0}}
          @foreach ($sales ?? '' as $sale)
              {{ $total += floatval(str_replace(",","",$sale->subtotal))}}
              {{ $total_item += $sale->quantity}}
              {{ $totalprofit += floatval(str_replace(",","",$sale->profit))}}
          @endforeach
          </span>
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Overview of Daily Sales</h3>
              <div class="form-group pull-right">
                <div class="input-group">
                  <button type="button" class="btn btn-primary btn-sm" id="daterange-btn">
                    <i class="far fa-calendar-alt"></i> Select Sales Date Range
                    <i class="fas fa-caret-down"></i>
                  </button>
                </div>
              </div>
            </div><!-- /.box-header -->
              <canvas id="myChart" width="400" height="245" class="elevation-2"></canvas>
          </div>
      </div>
      <div class="col-lg-6 col-md-6">
          <div class="row mt-3">
            <div class="col-lg-6 col-md-6">
              <div class="box box-success">
                <div class="box-header with-border">
                  <h1 class="box-title text-green" style="font-family:cursive">INCOME TODAY</h1>
                </div><!-- /.box-header -->
                <div class="small-box bg-green">
                  <div class="inner">
                    <br>
                     <p class="title-box">₱ {{number_format($total,2)}}</p>
                     <br>
                  </div>
                  <div class="icon">
                    <i class="fas fa-shopping-cart"></i>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h1 class="box-title text-primary" style="font-family:cursive">PROFITS TODAY</h1>
                </div><!-- /.box-header -->
                <div class="small-box bg-primary">
                  <div class="inner">
                    <br>
                    <p class="title-box">₱ {{number_format($totalprofit,2)}}</p>
                    <br>
                  </div>
                  <div class="icon">
                    <i class="fas fa-dollar-sign"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-6">
              <div class="box box-warning">
                <div class="box-header with-border">
                  <h1 class="box-title text-warning" style="font-family:cursive">SALES TODAY</h1>
                </div><!-- /.box-header -->
                <div class="small-box bg-yellow">
                  <div class="inner">
                    <br>
                    <p class="title-box text-black">{{number_format($total_item)}}</p>
                    <br>
                  </div>
                  <div class="icon">
                    <i class="fas fa-shopping-bag"></i>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="box box-info">
                <div class="box-header with-border">
                  <h1 class="box-title text-info" style="font-family:cursive">RECEIPT</h1>
                </div><!-- /.box-header -->
                <div class="small-box bg-info elevation-3">
                  <div class="inner">
                    <br>
                    <p class="title-box text-black">{{count($invoice)}}</p>
                    <br>
                  </div>
                  <div class="icon">
                    <i class="fas fa-file-invoice"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
          {{-- <div class="row">
              <div class="col-lg-12 col-md-12">
                sda
              </div>
          </div> --}}
      </div>
    </div>
    <div class="row">
      <div class="col-lg-12 col-md-12">
         <div class="box box-danger">
          <div class="box-header with-border">
            <h1 class="box-title text-warning">TODAY'S TRANSACTION</h1>
          </div><!-- /.box-header -->
          <div class="container-fluid" style="margin-top:1%">
            <table class="table display nowrap" id="mytable" style="width:100%">
              <thead>
                <tr>
                  <th class="none" style="display: none">ID</th>
                  <th class="text-truncate" style="max-width:100px">ITEM</th>
                  <th>NET WT.</th>
                  <th>PRICE</th>
                  <th>QUANTITY</th>
                  <th>SUBTOTAL</th>
                  <th>DISCOUNT</th>
                  <th>DATE OF TRANSACTION</th>
                  <th>CASHIER</th>
                </tr>
              </thead>
              <tbody>
                @if (count($sales) > 0)
                   @foreach ($sales->chunk(250) as $item)
                    @foreach ($item as $sale)
                    <tr>
                        <td style="display:none">{{$sale->id}}</td>
                        <td>{{$sale->name}}</td>
                        <td>{{$sale->net_wt}}</td>
                        <td>₱ {{number_format($sale->price, 2)}}</td>
                        <td>{{$sale->quantity}}</td>
                        <td>{{$sale->subtotal}}</td>
                        <td>{{$sale->discount}}%</td>
                        <td>{{$sale->created_at->calendar()}}</td>
                        <td>{{$sale->cashier}}</td>
                    </tr>
                    @endforeach
                   @endforeach
                @endif
              </tbody>
            </table>
          </div>
         </div>
      </div>
    </div>
  <form action="{{route('getwhatsales')}}" id="frmData" method="POST">
    @csrf
        <input type="text" name="start" id="start" hidden>
        <input type="text" name="end" id="end" hidden>
        <input type="text" name="label" id="label" hidden>
  </form>
@endsection

@section('script')
<script>
$(document).ready(function(){
  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });
  $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today' : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
          'Annual Sales': [moment().subtract(11, 'month').startOf('month'), moment().endOf('month')]
        },
      },
      function (start, end, label) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        $('#start').val(start.format('YYYY-MM-D'));
        $('#end').val(end.format('YYYY-MM-D'));
        $('#label').val(label);
        $('.loading-spinner').show();
        $('#notblur').attr('id', 'blur');
        setTimeout(() => {
            $('#frmData').submit();
        }, 500);
       
      }
    )
    time = () => {
        var nowDate = new Date();
        $('.time').html(nowDate.toLocaleString());
    }
    setInterval(() => {
      time();
    },1000);

    $('#mytable').DataTable({
          responsive:true,
          order: [ [0, 'desc'] ],
          dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
      });
      function findDecimal(num){
          if(num.indexOf('.') == -1){
                return num + ".00";
            }else{
                return num;
          }
      }
      function commas(x){
          var num = x.toLocaleString();
          return num;
      }

      async function getSales(){
              const data = await fetch('index.php/getSales')
              .then(res => res.json())
              .catch(error => location.reload());
              console.log(data);
              const dateArray = [];
              const subtotalArray = [];
              for(let i = 0; i < data.length;i++){
                  const dateRaw = data[i].created_at;
                  const subtotalRaw =  parseFloat(data[i].subtotal.replace(/,/g, ''));
                  var date = new Date(dateRaw);
                  var dateDay = moment(date).format('dddd');
                  var dataObj = Object.assign({Day: dateDay, Subtotal: subtotalRaw});
                  dateArray.push(dateDay);
                  subtotalArray.push(dataObj);
              }
                let dataDay = [];
                let dataTotal = [];
                dateArray.filter((item,index) => {
                  let day;
                  let total = 0;
                  if(dateArray.indexOf(item) === index){
                      subtotalArray.filter((value) => {
                            if(value.Day === item){
                                total += parseFloat(value.Subtotal);
                            }
                      })
                  }else{
                      total = null;
                  }

                  if(total !== null){
                      dataDay.push(item);
                      dataTotal.push(total);
                      return true;
                  }else{
                    return null;
                  }
              });
              // console.log(dataDay);
              // console.log(dataTotal);
              var ctx = document.getElementById('myChart');
              var myChart = new Chart(ctx, {
                  type: 'bar',
                  data: {
                      labels: dataDay,
                      datasets: [{
                          label: "TOTAL INCOME",
                          data: dataTotal,
                          backgroundColor: [
                              '#5c6bc0',
                              '#5c6bc0',
                              '#5c6bc0',
                              '#5c6bc0',
                              '#5c6bc0',
                              '#5c6bc0',
                              '#66ff66',
                          ],
                          borderColor: [
                              '#5c6bc0',
                              '#5c6bc0',
                              '#5c6bc0',
                              '#5c6bc0',
                              '#5c6bc0',
                              '#5c6bc0',
                              '#5c6bc0',
                          ],
                          borderWidth: 1
                      }]
                  },
                  options: {
                      scales: {
                          yAxes: [{
                              ticks: {
                                  beginAtZero: true
                              }
                          }]
                      }
                  }
              });
              $('.loading-spinner').hide();
              $('#blur').attr('id', 'notblur');
      }

      getSales();
      
  
})
      
</script>
@endsection
