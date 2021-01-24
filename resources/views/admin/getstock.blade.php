@extends('layouts.admin')
@section('container-title')
   <h1>Stock Logs</h1>
@endsection
@section('content')
    <section>
        <div class="box box-primary">
            <div class="box-header with-border">
                <strong>{{$label}} Stock Logs</strong>
                <button type="button" class="btn btn-primary btn-sm pull-right" id="daterange-btn">
                    <i class="far fa-calendar-alt"></i> Select Stock Date
                    <i class="fas fa-caret-down"></i>
                  </button>
            </div><!-- /.box-header -->
            <div class="container-fluid" style="margin-top: 1%">
                <table class="table display nowrap" id="mytable" style="width: 100%">
                    <thead>
                        <tr>
                            <th class="none"><h5>ID</h5></th>
                            <th class="all"><h5>Item</h5></th>
                            <th class="all"><h5>Net WT.</h5></th>
                            <th><h5>Unit</h5></th>
                            <th class="none"><h5>Brand</h5></th>
                            <th class="all"><h5>Old Stock</h5></th>
                            <th class="all"><h5>Status</h5></th>
                            <th class="all"><h5>Quantity</h5></th>
                            <th><h5>New Stock</h5></th>
                            <th class="none"><h5>Description</h5></th>
                            <th class="all"><h5>Stock by</h5></th>
                            <th><h5>Date of Stock</h5></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($stocks) > 0)
                            @foreach ($stocks as $stock)
                                <tr>
                                    <td>{{$stock->id}}</td>
                                    <td class="text-truncate">{{$stock->item}}</td>
                                    <td class="text-truncate">{{$stock->net_wt}}</td>
                                    <td class="text-truncate">{{$stock->unit}}</td>
                                    <td class="text-truncate">{{$stock->brand}}</td>
                                    <td >{{$stock->oldstock}}</td>
                                    @if ($stock->status == 'Stock In')
                                        <td class="bg-green">{{$stock->status}} +</td>
                                    @else
                                        <td class="bg-red">{{$stock->status}} -</td>
                                    @endif
                                    <td>{{$stock->quantity}}</td>
                                    <td>{{$stock->newstock}}</td>
                                    <td class="text-truncate">{{$stock->description}}</td>
                                    <td>{{$stock->stock_by}}</td>
                                    <td class="text-truncate">{{$stock->created_at->calendar()}}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    <form action="{{route('getWhatStock')}}" id="frmData" method="POST">
        @csrf
            <input type="text" name="start" id="start" hidden>
            <input type="text" name="end" id="end" hidden>
            <input type="text" name="label" id="label" hidden>
    </form>
@endsection

@section('script')
    <script>
        $('.loading-spinner').hide();
        $('.spinner').hide();
        $('#mytable').DataTable({
            responsive:true,
            order: [ [0, 'desc'] ],
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
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
        $('#daterange-btn').daterangepicker(
      {
        ranges: {
          'Today' : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
        },
        startDate: start,
        endDate  : end
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

    </script>
@endsection