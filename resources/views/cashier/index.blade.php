@extends('layouts.cashier')
@section('content')
<audio id="audio" src="{{asset('storage/beep-07.wav')}}" autostart="false"></audio>
<section>
    <div class="box box-success">
        <div class="box-header with-border">
            <h4><strong><i class="fas fa-shopping-cart text-success"></i> CART <span class="customercart"></span></strong></h4>
        </div><!-- /.box-header -->  
        <div class="row">
            <div class="col-lg-8 col-md-8">
                <div class="container-fluid" style="margin-top: 1%">
                    <div class="box box-primary">
                        <table id="myTable" class="table display nowrap" style="width: 100%">
                            <thead>
                                <tr>
                                    <th class="all" >NAME</th>
                                    <th>NET.WT</th>
                                    <th>UNIT</th>
                                    <th class="all">UNIT PRICE</th>
                                    <th>QUANTITY</th>
                                    <th>SUBTOTAL</th>
                                    <th class="all">CONTROL</th>
                                </tr>
                            </thead>
                            <tbody id="dataTable">
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4">
                <div class="container-fluid" style="margin-top:1%">
                    <div class="box box-warning">
                       <div class="container-fluid amountdue">
                            <form method="POST" id="add_sale" autocomplete="off" onkeydown="return event.key != 'Enter';">
                            <p class="text-truncate" style="max-width: 100%; font-size:25px;">Total Amount: <span id="pname">₱ 0.00</span></p>
                            <div class="form-group">
                                <input type="hidden" name="old" id="old_val">
                                <p class="text-truncate" style="max-width: 100%; font-size:25px;">Discount: -<span class="customerdiscount">0</span>%</p>
                                <p class="text-truncate" style="max-width: 100%;font-size:25px;">Cash: ₱ <span class="cash">0.00</span></p>
                                <p class="text-truncate" style="max-width: 100%; font-size:25px;">Change: ₱ <span id="change">0.00</span></p>
                                <strong class="errorcash text-danger"></strong>
                            </div> 
                            <input type="text" name="cash" id="cash" class="form-control" placeholder="Cash Amount -[Home]" style="font-size:20px;" autofocus> <br>
                            <button type="button" class="btn btn-primary btn-sm" id="proceed"><i class="fas fa-share-square"></i> Pay Proceed -[Enter]</button>
                            <button type="button" class="btn btn-danger btn-sm float-right" id="removedisc"><i class="fas fa-ban"></i> Remove Discount %</button> <br><br> 
                        </form>    
                       </div>
                    </div>    
                </div>   
            </div>
        </div>
    </div>
    <span style="display: none"> 
        {{$total = 0}}
        @foreach ($sales ?? '' as $sale)
            {{ $total += floatval(str_replace(",","",$sale->subtotal))}}
        @endforeach
        </span>
    <div class="box box-primary">
        <div class="box-header with-border">
            <h4><strong><i class="fas fa-shopping-cart text-success"></i> SALES TODAY</strong></h4>
        </div><!-- /.box-header --> 
        <div class="container-fluid" style="margin-top: 1%">
            <table id="salesTable" class="table display nowrap" style="width: 100%">
                <thead>
                    <tr>
                        <th class="none">ID</th>
                        <th class="all">INVOICE NUMBER</th>
                        <th class="all">NAME</th>
                        <th>NET WT.</th>
                        <th>UNIT</th>
                        <th class="all">UNIT PRICE</th>
                        <th class="all">QUANTITY</th>
                        <th class="all">SUBTOTAL</th>
                        <th class="all">DISCOUNT</th>
                        <th>CASHIER</th>
                        <th class="all">CONTROL</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($sales) > 0)
                        @foreach ($sales as $sale)
                            <tr>
                            <td>{{$sale->id}}</td>
                                <td>@if ($sale->invoice_number)
                                    {{$sale->invoice_number}}
                                @else
                                    [No Invoice No.]
                                @endif</td>
                                <td>{{$sale->name}}</td>
                                <td>{{$sale->net_wt}}</td>
                                <td>{{$sale->unit}}</td>
                                <td>₱ {{number_format($sale->price,2)}}</td>
                                <td>{{$sale->quantity}}</td>
                                <td>₱ {{$sale->subtotal}}</td>
                                <td>{{$sale->discount}}%</td>
                                <td>{{$sale->cashier}}</td> 
                                @php
                                    $name = str_replace('"', "", $sale->name);
                                    $quantity = (float)$sale->quantity;
                                @endphp
                                <td><a id="{{$sale->id}}"  data-stuff='[&#34;{{$sale->id}}&#34;, &#34;{{$sale->invoice_number}}&#34;, &#34;{{$name}}&#34;, &#34;{{$sale->net_wt}}&#34;, &#34;{{$sale->unit}}&#34;,&#34;{{$sale->price}}&#34;,&#34;{{$quantity}}&#34;,&#34;{{$sale->subtotal}}&#34;,&#34;{{$sale->cashier}}&#34;,&#34;{{$sale->barcode}}&#34;,&#34;{{$sale->profit}}&#34;]' class="void btn btn-danger btn-sm"><i class="fas fa-ban"></i> Cancel</a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
            <strong style="font-size:25px">MY TOTAL SALES: <strong style="font-size:25px;color:maroon">₱{{number_format($total, 2)}}</strong></strong>
        </div> 
    </div>
</section>


{{-- SEARCH ITEM --}}
<div class="modal fade bd-example-modal-sm" id="new_item" tabindex="-1" role="dialog" aria-labelledby="new_productLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      <h3 class="modal-title" id="new_productLabel">SEARCH ITEM</h3>
    </div>
    <div class="modal-body">
        <div class="box box-success">
            <div class="box-header with-border">
                <div class="form-group">
                    <input type="text" name="search" class="form-control form-control-sm" id="search" placeholder="Search here..." autofocus>
                </div>
            </div><!-- /.box-header -->  
            <div class="container-fluid" style="margin-top:1%;">
                <input type="hidden" name="codebar" id="codebar" class="form-control" readonly>
                <input type="hidden" name="id" id="id" class="form-control" readonly>
                <input type="hidden" name="status" id="status" class="form-control" readonly>
                <input type="hidden" name="profit" id="profit" class="form-control">
                <input type="hidden" name="name" id="name" class="form-control form-control-sm" readonly>
                <input type="hidden" name="net-wt" id="net_wt" class="form-control form-control-sm" readonly>
                <input type="hidden" name="unit" id="unit" class="form-control form-control-sm" readonly>
               <div class="form-group">
                <label>Unit Price</label>
                <input type="text" name="price" id="price" class="form-control form-control-sm" readonly>
               </div>
               <div class="form-group">
                <label>Current Stock</label>
                <input type="text" name="stock" id="stocks" class="form-control form-control-sm" readonly>
               </div>
               <div class="form-group">
                <label>Discount Amount</label>
                <input type="number" name="less" id="less" class="form-control" placeholder="Discount Amount">
            </div>
               <div class="form-group">
                <label>Quantity</label>
                    <input type="number" name="quantity" id="quantity" min=1 class="form-control form-control-sm" placeholder="Quantity">
                    <strong class="errorstock text-danger"></strong>
                </div>
                <div class="form-group">
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fas fa-window-close"></i>Close -[Esc]</button>
                <button type="submit" class="btn btn-primary btn-sm" id="add_cart"><i class="fas fa-share-square"></i>Add to cart -[Enter]</button>
                <button type="submit" class="btn btn-warning btn-sm" id="clearing"><i class="fas fa-share-square"></i>Clear -[Home]</button>
              </div>
            </div>
        </div>
    </div>
</form>
  </div>
</div>
</div>

{{--VOID TRANSACTION--}}
<div class="modal fade" id="void" role="dialog" aria-labelledby="void" aria-hidden="true">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h3 class="modal-title" id="void">Void Transaction</h3>
        </div>
        <div class="modal-body">
        <form action="{{route('void.store')}}" id="voidfrm" autocomplete="off" method="POST">
            @csrf
            <div class="form-group">
                <label for="item_name">Item Name</label>
                <input type="text" name="item_name" id="item_name" class="form-control" readonly>
            </div>
            <div class="form-group">
                <label for="item_quantity">Quantity</label>
                <input type="text" name="item_quantity" id="item_quantity" class="form-control">
            </div>
        <textarea name="reason" id="" cols="5" rows="7" class="form-control reason" placeholder="Leave message here..."></textarea>
        <input type="text" name="item_id" id="item_id" hidden>
        <input type="text" name="item_inv" id="item_inv"  hidden>
        <input type="text" name="item_netwt" id="item_netwt"  hidden>
        <input type="text" name="item_unit" id="item_unit"  hidden>
        <input type="text" name="item_price" id="item_price"  hidden>
        <input type="text" name="item_profit" id="item_profit" hidden>
        <input type="text" name="item_sub" id="item_sub"  hidden>
        <input type="text" name="item_cashier" id="item_cashier" hidden>
        <input type="text" name="item_status" id="item_status" hidden>
        <input type="text" name="item_barcode" id="item_barcode" hidden>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-window-close"></i> Close</button>
          <button type="button" class="item_void btn btn-primary"><i class="fas fa-share-square"></i>Void</button>
        </div>
    </form>
      </div>
    </div>
  </div>
{{--SEARCH CUSTOMER--}}
<div class="modal fade" id="searchcustomer" tabindex="-1" role="dialog" aria-labelledby="searchcustomerlabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h3 class="modal-title" id="searchcustomerlabel">SEARCH CUSTOMER</h3>
        </div>
        <div class="modal-body">
            <div class="box box-primary"> 
                <div  style="margin-top: 1%">
                    <table class="table display nowrap" id="customerTable" style="width:100%">
                        <thead>
                            <tr>
                                <th>Fullname</th>
                                <th>Discount</th>
                                <th>Control</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($customers) > 0)
                                @foreach ($customers as $customer)
                                    <tr>
                                        <td class="text-truncate" style="max-width:100px; vertical-align: middle;">{{$customer->fullname}}</td>
                                        <td class="text-danger" style="max-width:100px; vertical-align: middle;">{{$customer->discount}}%</td>
                                        <td><a class="btn btn-primary selectbuy" data-stuff='[&#34;{{$customer->fullname}}&#34;,&#34;{{$customer->discount}}&#34;,&#34;{{$customer->business_style}}&#34;,&#34;{{$customer->address}}&#34;]'>Select Buyer</a></td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
           
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-window-close"></i> Close</button>
        </div>
    </form>
      </div>
    </div>
  </div>

  {{-- SETTINGS --}}

  <div class="modal fade" id="printer" tabindex="-1" role="dialog" aria-labelledby="printerlabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h3 class="modal-title" id="printerlabel">PRINTER SETTINGS</h3>
        </div>
        <div class="modal-body">
            @if (count($settings) > 0)
                @foreach ($settings as $setting)
                <form method="POST" action="{{route('setting.update', $setting->id)}}">
                    @csrf
                    @method('PUT')
                <div class="form-group">
                    <input class="form-control" type="text" name="computer_name" placeholder="Computer Name:" value="{{$setting->computer_name}}">
                </div>
                <div class="form-group">
                    <input class="form-control" type="text" name="printer" placeholder="Printer Name:" value="{{$setting->printer}}">
                </div>
                <button type="submit" class="btn btn-primary"><i class="fas fa-share-square"></i> Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-window-close"></i> Close</button>
            </form>
                @endforeach
            @endif
        </div>
      </div>
    </div>
  </div>

   {{-- RECEIPT --}}

  <div class="modal fade" id="receipt" tabindex="-1" role="dialog" aria-labelledby="receiptlabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h3 class="modal-title" id="receiptlabel">PRINT RECEIPT</h3>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <input type="text" class="form-control" id="invoice"  placeholder="#INVOICE NUMBER ..." required>
            </div>
            <button type="button" class="btn btn-primary btn-sm" id="printBtn"><i class="fas fa-print"></i> PRINT</button>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('script')
    <script>
        const token = "{{ csrf_token() }}";
        if('{{session("success")}}'){
            Swal.fire(
            'Successfully!',
            '{{session("success")}}',
            'success'
        )
        }
        if('{{session("voids")}}'){
                Swal.fire(
                'Transaction Canceled!',
                '{{session("success")}}',
                'success'
            )
        }
        if('{{session("error")}}'){
                Swal.fire(
                'Fatal Error!',
                '{{session("error")}}',
                'error'
            )
        }
        if('{{session("invoice_error")}}'){
                Swal.fire(
                'Fatal Error!',
                '{{session("invoice_error")}}',
                'error'
            )
        }
    </script>
    <script src="{{asset('js/appCashier.js')}}"></script>
@endsection