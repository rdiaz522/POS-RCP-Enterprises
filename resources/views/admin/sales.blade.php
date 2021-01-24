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
                  <h3 class="box-title">Overview of {{$label}}</h3>
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
                      <h1 class="box-title text-green" style="font-family:cursive">{{$label}} INCOME</h1>
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
                      <h1 class="box-title text-primary" style="font-family:cursive">{{$label}} PROFITS</h1>
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
                      <h1 class="box-title text-warning" style="font-family:cursive">{{$label}} SALES</h1>
                    </div><!-- /.box-header -->
                    <div class="small-box bg-yellow">
                      <div class="inner">
                        <br>
                        <p class="title-box text-black">{{$total_item}} </p>
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
                      <h1 class="box-title text-warning" style="font-family:cursive">RECEIPT</h1>
                    </div><!-- /.box-header -->
                    <div class="small-box bg-info elevation-3">
                      <div class="inner">
                        <br>
                        <p class="title-box text-black">@if (count($invoices))
                          {{count($invoices)}}
                        @else
                            {{'0'}}
                        @endif</p>
                        <br>
                      </div>
                      <div class="icon">
                        <i class="fas fa-file-invoice"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12 col-md-12">
             <div class="box box-danger">
              <div class="box-header with-border">
                <h1 class="box-title text-warning">{{$label}} TRANSACTION</h1>
              </div><!-- /.box-header -->
              <div class="container-fluid" style="margin-top: 1%">
                <table class="table elevation-3" id="mytable"width="100%">
                  <thead>
                    <tr>
                      <th class="none">ID</th>
                      <th class="text-truncate" style="max-width:100px">ITEM</th>
                      <th>PRICE</th>
                      <th>QUANTITY</th>
                      <th>SUBTOTAL</th>
                      <th>DATE OF TRANSACTION</th>  
                      <th>CASHIER</th>
                    </tr>
                  </thead>
                  <tbody>
                    @if (count($sales) > 0)
                        @foreach ($sales as $sale)
                            <tr>
                                <td style="display:none">{{$sale->id}}</td>
                                <td>{{$sale->name}}</td>
                                <td>₱ {{$sale->price}}</td>
                                <td>{{$sale->quantity}}</td>
                                <td>{{$sale->subtotal}}</td>
                                <td>{{$sale->created_at->calendar()}}</td>
                                <td>{{$sale->cashier}}</td>
                            </tr>
                        @endforeach
                    @endif
                  </tbody>
                </table>
              </div>
             </div>
          </div>
        <form action="{{route('getwhatsales')}}" id="frmData" method="POST">
          @csrf
              <input type="text" name="start" id="start" hidden>
              <input type="text" name="end" id="end" hidden>
              <input type="text" name="label" id="label" hidden>
          </form>
    </section>
@endsection

@section('script')
    <script>
          $(document).ready(function(){
            $('.loading-spinner').hide();
            $('#dashboard').prop("class","nav-link active");
            $('#mytable').DataTable({
                responsive:true,
                order: [ [0, 'desc'] ],
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });
            var weekdays = [
              'Sunday',
              'Monday',
              'Tuesday',
              'Wednesday',
              'Thursday',
              'Friday',
              'Saturday'
            ];
            var d = new Date();
            $('.today').html(weekdays[d.getDay()]);
            time = () => {
            var nowDate = new Date();
                 $('.time').html(nowDate.toLocaleString());
            }
            setInterval(() => {
              time();
            },1000);
            var label = '{{$label}}';
            var start = '';
            var end = '';
            if(label == 'Yesterday'){
                start = moment().subtract(1, 'days');
                end = moment().subtract(1, 'days');
            }else if(label == 'Last 7 Days'){
                start = moment().subtract(6, 'days');
                end = moment();
            }else if(label == 'Last 30 Days'){
                start = moment().subtract(29, 'days');
                end = moment();
            }else if(label == 'This Month'){
                start = moment().startOf('month');
                end = moment().endOf('month');
            }else if(label == 'Last Month'){
                start = moment().subtract(1, 'month').startOf('month');
                end = moment().subtract(1, 'month').endOf('month');
            }else if(label == 'Today'){
                start = moment();
                end = moment();
            }else if(label == 'Annual Sales'){
              start = moment().subtract(11, 'month').startOf('month');
              end = moment().endOf('month');
            }
            else{
                start = moment().add(1,'month').startOf('month');
                end = moment().subtract(1, 'month').endOf('month');
            }

            var sales = JSON.parse('{{$sales}}'.replace(/&quot;/g,'"'))
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
                startDate: start,
                endDate  : end
              },
              function (start, end, label) {
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

              const dateArray = [];
              const subtotalArray = [];
              for(let i = 0; i < sales.length;i++){
                  const dateRaw = sales[i].created_at;
                  const subtotalRaw =  parseFloat(sales[i].subtotal.replace(/,/g, ''));
                  var date = new Date(dateRaw);
                  if(label == 'Yesterday' || label == 'Last 7 Days'){
                    var dateDay = moment(date).format('dddd');
                  }else{
                    var dateDay = moment(date).format('MMMM');
                  }
                
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
              var typeChart = '';
              var bgcolor = '';
              if(label == 'Yesterday' || label == 'This Month' || label == 'Last Month'){
                typeChart = 'bar';
                bgcolor = '#5c6bc0';
              }else{
                typeChart = 'line';
                bgcolor = 'rgba(0, 0, 0,0)';
              }
              var ctx = document.getElementById('myChart');
              var myChart = new Chart(ctx, {
                  type: typeChart,
                  data: {
                      labels: dataDay,
                      datasets: [{
                          label: "TOTAL SALES",
                          backgroundColor:bgcolor,
                          borderColor:'#5c6bc0',
                          borderWidth:3,
                          pointBackgroundColor:'#4db6ac',
                          pointHoverBackgroundColor:'#283593 ',
                          pointHoverBorderWidth: 5,
                          steppedLine:false,
                          pointHighlightFill: "#fff",
                          pointHighlightStroke: "rgba(220,220,220,1)",
                          pointStrokeColor: "#fff",
                          pointColor: "rgba(151,187,205,1)",
                          borderJoinStyle:'miter',
                          fill:true,
                          borderCapStyle:'butt',
                          data: dataTotal,
                      }],
                  },
                  options:{

                  },
              });
          })
    </script>
@endsection