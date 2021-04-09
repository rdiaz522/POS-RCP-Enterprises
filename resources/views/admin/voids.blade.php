@extends('layouts.admin')
@section('container-title')
   <h1>Void Transaction Logs</h1>
@endsection
@section('content')
    <section>
        <div class="box box-primary">
            <div class="box-header with-border">
                <strong>Transaction Void Logs</strong>
            </div><!-- /.box-header -->
            <div class="container-fluid" style="margin-top: 1%">
                <table class="table display nowrap" id="mytable" style="width: 100%">
                    <thead>
                        <tr>
                            <th class="all"></th>
                            <th class="none">ID</th>
                            <th>INV .NO</th>
                            <th>ITEM</th>
                            <th>NET.WT</th>
                            <th>UNIT</th>
                            <th>PRICE</th>
                            <th>QUANTITY</th>
                            <th class="all">CASHIER</th>
                            <th class="all">STATUS</th>
                            <th class="none">REMARKS:</th>
                            <th class="all">DATE OF TRANSACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($voids) > 0)
                            @foreach ($voids->chunk(250) as $item)
                               @foreach ($item as $void)
                               <tr>
                                <td></td>
                                <td>{{$void->id}}</td>
                                <td class="text-truncate" style="max-width:100px; vertical-align: middle;">{{$void->invoice_number}}</td>
                                <td class="text-truncate" style="max-width:100px; vertical-align: middle;">{{$void->name}}</td>
                                <td>{{$void->net_wt}}</td>
                                <td>{{$void->unit}}</td>
                                <td>₱ {{number_format($void->price,2)}}</td>
                                <td>{{$void->quantity}}</td>
                                <td>{{$void->cashier}}</td>
                                 @if ($void->status == 'Rejected')
                                    <td class="bg-danger">{{$void->status}}</td>
                                @else
                                    <td class="bg-success">{{$void->status}}</td>
                                @endif
                                <td>{{$void->reason}}</td>
                                <td>{{$void->created_at->calendar()}}</td>
                            </tr>
                               @endforeach
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script>
        $('#mytable').DataTable({
            responsive:true,
            order: [ [1, 'desc'] ],
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
        $('.loading-spinner').hide();
        $('#blur').attr('id', 'notblur');
    </script>
@endsection