@extends('layouts.admin')
@section('container-title')
   <h1>Stock Logs</h1>
@endsection
@section('content')
    <section>
        <div class="box box-primary">
            <div class="box-header with-border">
                <strong>Daily Stock Logs</strong>
                <button type="button" class="btn btn-primary btn-sm pull-right" id="daterange-btn">
                    <i class="far fa-calendar-alt"></i> Select Stock Date
                    <i class="fas fa-caret-down"></i>
                  </button>
            </div><!-- /.box-header -->
            <div class="container-fluid" style="margin-top: 1%">
                <table class="table display nowrap" id="mytable" style="width: 100%">
                    <thead>
                        <tr>
                            <th class="none">ID</th>
                            <th class="all">ITEM</th>
                            <th class="all">NET WT.</th>
                            <th>UNIT</th>
                            <th class="none">BRAND</th>
                            <th class="all">OLD STOCK</th>
                            <th class="all">STATUS</th>
                            <th class="all">QUANTITY</th>
                            <th>NEW STOCK</th>
                            <th class="none">DESCRIPTION: </th>
                            <th class="all">STOCK BY</th>
                            <th>DATE OF STOCK</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($stocks) > 0)
                           @foreach ($stocks->chunk(250) as $item)
                                @foreach ($item as $stock)
                                <tr>
                                    <td>{{$stock->id}}</td>
                                    <td class="text-truncate" style="max-width: 100px">{{$stock->item}}</td>
                                    <td class="text-truncate" style="max-width: 100px">{{$stock->net_wt}}</td>
                                    <td class="text-truncate" style="max-width: 100px">{{$stock->unit}}</td>
                                    <td class="text-truncate" style="max-width: 100px">{{$stock->brand}}</td>
                                    <td class="text-truncate">{{$stock->oldstock}}</td>
                                    @if ($stock->status == 'Stock In')
                                        <td class="bg-success ">{{$stock->status}} </td>
                                        <td class="text-truncate">+{{$stock->quantity}}</td>
                                    @else
                                        <td class="bg-danger">{{$stock->status}} </td>
                                        <td class="text-truncate">-{{$stock->quantity}}</td>
                                    @endif
                                    <td class="text-truncate">{{$stock->newstock}}</td>
                                    <td class="text-truncate" style="max-width: 100px">{{$stock->description}}</td>
                                    <td class="text-truncate">{{$stock->stock_by}}</td>
                                    <td class="text-truncate" style="max-width: 100px">{{$stock->created_at->calendar()}}</td>
                                </tr>
                            @endforeach
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
        $(document).ready(function() {
            $('.spinner').hide();
            $('#mytable').DataTable({
                responsive:true,
                order: [ [0, 'desc'] ],
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
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
        $('.loading-spinner').hide();
        $('#blur').attr('id', 'notblur');
    })
 </script>
@endsection