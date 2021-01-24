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
                                <td>{{$sale->cashier}}</td>
                                <td><a id="{{$sale->id}}"  data-stuff='[&#34;{{$sale->id}}&#34;, &#34;{{$sale->invoice_number}}&#34;, &#34;{{$sale->name}}&#34;, &#34;{{$sale->net_wt}}&#34;, &#34;{{$sale->unit}}&#34;,&#34;{{$sale->price}}&#34;,&#34;{{$sale->quantity}}&#34;,&#34;{{$sale->subtotal}}&#34;,&#34;{{$sale->cashier}}&#34;,&#34;{{$sale->barcode}}&#34;,&#34;{{$sale->profit}}&#34;]' class="void btn btn-danger btn-sm"><i class="fas fa-ban"></i> Cancel</a>
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
               <div class="form-group">
                <label>Item Name</label>
                <input type="text" name="name" id="name" class="form-control form-control-sm" readonly>
               </div>
               <div class="form-group">
                <label>Net WT.</label>
                <input type="text" name="net-wt" id="net_wt" class="form-control form-control-sm" readonly>
               </div>
               <div class="form-group">
                <label>Unit</label>
                <input type="text" name="unit" id="unit" class="form-control form-control-sm" readonly>
               </div>
               <div class="form-group">
                <label>Unit Price</label>
                <input type="text" name="price" id="price" class="form-control form-control-sm" readonly>
               </div>
               <div class="form-group">
                <label>Current Stock</label>
                <input type="text" name="stock" id="stocks" class="form-control form-control-sm" readonly>
               </div>
               <div class="form-group">
                <label>Quantity</label>
                    <input type="number" name="quantity" id="quantity" min=1 class="form-control form-control-sm">
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
                <input type="number" name="item_quantity" id="item_quantity" min="1" class="form-control">
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
        $(document).ready(function(){
            //Spinner hide
            $('.loading-spinner').hide();
            $('.spinner').hide();
            $('#search').prop('disabled', true);
            $('#myTable').DataTable({
                searching:false,
                paging:false,
                info:false,
                sorting:false,
            });
            $('#customerTable').DataTable({
                searching:true,
                paging:true,
                info:false,
                sorting:false,
                pageLength:5
            });
            $('#salesTable').DataTable({
                responsive:true,
                order: [ [0, 'desc'] ],
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });
            const Toast2 = Swal.mixin({
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, proceed!',
                showCloseButton: true,
            });
            const Toast3 = Swal.mixin({
                showCancelButton: true,
                confirmButtonColor: '#00a65a',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, print reciept!',
                cancelButtonText: 'No.',
                showCloseButton: true,
            });
            const Toast4 = Swal.mixin({
                showCancelButton: true,
                confirmButtonColor: '#00a65a',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Return on stock.',
                cancelButtonText: 'Reject item.',
                showCloseButton: true,
            });

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
            

             /*converting numbers*/
            function formatNumber(num) {
                 return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
            }
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
            /*---------------------------*/

            /* disabled buttons */
            $('#payment').attr('disabled', true);
            $('#proceed').attr('disabled', true);
             /*---------------------------*/

            //after hide search modal focus scan barcode
            $('#new_item').on('hide.bs.modal', function (e) {
                $('#barcode').focus();
            })

            //ajax header setup
            $.ajaxSetup({
                  headers: {
                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                 }
            });

            //barcode sound
            function PlaySound() {
                var sound = document.getElementById("audio");
                sound.play()
            }

            //after showing modal autofocus
            $('.modal').on('shown.bs.modal', function() {
                $(this).find('[autofocus]').focus();
              });

            $('.modal').on('hidden.bs.modal', function() {
                $('#barcode').focus();
            });

            $('#btnSetting').click(function(){
                $('#printer').modal('show');
            })
            $('#print_receipt').click(function(){
                $('#receipt').modal('show');
            })
            $('#printBtn').click(function(e){
                if($('#invoice').val() !== ''){
                    window.location = '/index.php/index.php/cashier/' + $('#invoice').val(); 
                }else{
                    e.preventDefault();
                }
                
            })

            //ajax fetch all products
            $.ajax({
                url:'/index.php/index.php/getProducts',
                method:'GET',
                success:function(data){
                   let product = [];
                   let product_name = [];
                   let amount_total = 0;
                   const cart = [];
                   const barcodes = [];
                   let discount = 0;
                   let customer = '';
                   let business_tyle = '';
                   let customer_address = '';
                   console.log(data);
                    //pushing all data into product & product_name variable
                   for(let i = 0; i < data.length;i++){
                        const id = data[i].id;
                        const name = data[i].name;
                        const barcode = data[i].barcode;
                        const brand = data[i].brand;
                        const price = data[i].price;
                        const stock = data[i].stocks.quantity;
                        const image = data[i].image;
                        const unit = data[i].unit;
                        const status = data[i].status;
                        const net_wt = data[i].net_wt;
                        const profit = data[i].profit;
                        const dataObj = Object.assign({id:id,barcode:barcode,name:name,price:price,profit:profit,stock:stock,image:image,unit:unit,status:status,net_wt:net_wt});
                        product.push(dataObj);
                        product_name.push(name+' '+net_wt);
                   
                   }

                    //payment processing..
                    pay_proceed = () => {
                        if(parseFloat($('#cash').val()) >= amount_total){
                            $.ajax({
                                url:'/index.php/index.php/cashier',
                                method:'POST',
                                data:{
                                    _token: "{{ csrf_token() }}",
                                    cart:cart,
                                    cash: parseFloat($('#cash').val()),
                                    discount: discount,
                                    total: amount_total,
                                    customer: customer,
                                    business_style: business_tyle,
                                    customer_address:customer_address
                                },
                                dataType:'json',
                                success:function(data){
                                    Toast3.fire({
                                            type: 'warning',
                                            title: "Print Reciept?"
                                    }).then((result) => {
                                            if (result.value) {
                                                // window.location = '/index.php/index.php/cashier/' + data; 
                                                window.location = '/index.php/index.php/cashier/noreciept';
                                            }else{
                                                window.location = '/index.php/index.php/cashier/noreciept';
                                            }
                                    })
                                }
                            })
                        }else{
                            $('.errorcash').html('Insufficient Cash!');
                        }
                   }
                   //payment proceed button
                   $('#proceed').on('click', function(){
                        Toast2.fire({
                                type: 'warning',
                                title: "Transaction Proceed?"
                        }).then((result) => {
                                if (result.value) {
                                    pay_proceed();
                                }else{
                                    e.preventDefault();
                                    return false;
                                }
                        })
                    }) 

                    $('#removedisc').on('click', function(){
                        $('.customercart').html('');
                        $('.customerdiscount').html('0');
                        discount = 0;
                        customer = '';
                        business_tyle = '';
                        customer_address = '';
                    })
 
                // data items output on tables
                   dataoutput = () => {
                        let total_all = 0;
                         $('#dataTable').html(cart.map((item,key) => {
                              const table = '<tr>'+
                                            '<td class="text-truncate" style="max-width:100px; vertical-align: middle;">'+ item.name + '</td>' +
                                            '<td>'+ item.net_wt + '</td>' +
                                            '<td>'+ item.unit + '</td>' +
                                            '<td>₱ '+ item.price + '</td>' +
                                            '<td>'+ item.quantity+ '</td>' +
                                            '<td>₱ '+ item.subtotal + '</td>'+
                                            '<td><a href="#" class="text-success" id="plus'+key+'"><i class="fas fa-plus-circle fa-2x"></i></a> <a  href="#" class="text-primary" id="minus'+key+'"><i class="fas fa-minus-circle fa-2x"></i></a> <a  href="#" class="text-danger" id="trash'+key+'"><i class="fas fa-trash-alt fa-2x"></i></a></td>'
                                        +'</tr>';

                                return table;
                            }));
                            for(let i = 0; i < cart.length; i++){
                                parseFloat(cart[i].subtotal.replace(/,/g, ''));
                                    total_all += parseFloat(cart[i].subtotal.replace(/,/g, ''));
                            }
                           const totalConverted  = commas(total_all);
                            $('#pname').html('₱ ' + findDecimal(totalConverted));
                            amount_total = total_all;
                            $('#cash').on('input', function(e){
                                var code = e.keyCode || e.which;
                                var input_cash = parseFloat($(this).val());
                                var val_cash = 0;
                                if(Number.isInteger(input_cash)){
                                    if(input_cash.toString().length <= 3){
                                        val_cash = input_cash.toFixed(2);
                                    }else{
                                        val_cash = commas(input_cash) + '.00';
                                    }
                                }else{
                                    val_cash = input_cash.toFixed(2);
                                }
                                if(isNaN(input_cash)){
                                    $('.cash').html('')
                                }else{
                                    $('.cash').html(val_cash);
                                }
                                if($(this).val() == ''){
                                    $('#change').hide();
                                }else{
                                    if(parseFloat($(this).val()) >= total_all){
                                        $('#change').show();
                                        total = parseFloat($(this).val()) - parseFloat(total_all);
                                        $('#change').text(commas(total));
                                        $('#proceed').attr('disabled', false);
                                    }else{
                                        $('#change').hide();
                                        total = parseFloat($(this).val()) - parseFloat(total_all);
                                        $('#change').text(commas(total));
                                        $('#proceed').attr('disabled', true);
                                    }
                                }
                                if(code == 13){
                                   e.preventDefault();
                                   return false;
                                }
                         }) 
                        
                        //control cart
                         cart.map((products,val) => {
                            $("#plus"+val).on('click', function(){
                                product.filter((item,index) => {
                                    if(item.barcode == products.barcode){
                                        if(item.stock > products.quantity){
                                            let quantity = 1;
                                            let disc = 100 - parseInt(discount);
                                            let price;
                                            let subtotal;
                                            console.log(disc);
                                            if(discount > 0){
                                                price = disc * parseFloat(item.price.replace(/,/g, '')) / 100;
                                                subtotal = quantity * price;
                                            }else{
                                                price = parseFloat(item.price.replace(/,/g, ''));
                                                subtotal = quantity * price;
                                            }
                                            const totalSub = commas(subtotal);
                                            $('#payment').attr('disabled', false);
                                            inserProduct = () => {
                                                const cartObj = Object.assign({id:item.id,barcode:item.barcode,name:item.name,unit:item.unit,price:item.price,profit:item.profit,status:item.status,quantity:quantity,subtotal:findDecimal(totalSub),net_wt:item.net_wt})
                                                cart.push(cartObj);
                                                barcodes.push(item.barcode);
                                            }
                                            if(cart.length > 0){
                                                if(barcodes.find(e => e == products.barcode)){
                                                    cart.filter((i,k) => {
                                                    if(i.barcode === products.barcode){
                                                            const newquantity = i.quantity + 1;
                                                            const total = price + parseFloat(i.subtotal.replace(/,/g, ''));
                                                            const pretotal = commas(total);
                                                            i.subtotal = findDecimal(pretotal);
                                                            i.quantity = newquantity;
                                                        }
                                                    });    
                                                }else{
                                                    inserProduct();
                                                }
                                            }else{  
                                                inserProduct();
                                            }
                                            $(this).val('');
                                            dataoutput();
                                            PlaySound();
                                        }else{
                                            Swal.fire(
                                                'Out of Stock!',
                                                'This item is out of stock!',
                                                'error'
                                            );
                                        }
                                    }
                                })
                            })
                            $("#minus"+val).on('click', function(e){
                                product.filter((item,index) => {
                                    if(item.barcode == products.barcode){
                                        if(item.stock > products.quantity){
                                            if(products.quantity > 1){
                                                let quantity = 1;
                                                let disc = 100 - parseInt(discount);
                                                let price;
                                                let subtotal;
                                                console.log(disc);
                                                if(discount > 0){
                                                    price = disc * parseFloat(item.price.replace(/,/g, '')) / 100;
                                                    subtotal = quantity * price;
                                                }else{
                                                    price = parseFloat(item.price.replace(/,/g, ''));
                                                    subtotal = quantity * price;
                                                }
                                                const totalSub = commas(subtotal);
                                                $('#payment').attr('disabled', false);
                                                inserProduct = () => {
                                                    const cartObj = Object.assign({id:item.id,barcode:item.barcode,name:item.name,unit:item.unit,price:item.price,profit:item.profit,status:item.status,quantity:quantity,subtotal:findDecimal(totalSub),net_wt:item.net_wt})
                                                    cart.push(cartObj);
                                                    barcodes.push(item.barcode);
                                                }
                                                if(cart.length > 0){
                                                    if(barcodes.find(e => e == products.barcode)){
                                                        cart.filter((i,k) => {
                                                        if(i.barcode === products.barcode){
                                                                const newquantity = i.quantity - 1;
                                                                const total = parseFloat(i.subtotal.replace(/,/g, '')) - price;
                                                                const pretotal = commas(total);
                                                                i.subtotal = findDecimal(pretotal);
                                                                i.quantity = newquantity;
                                                            }
                                                        });    
                                                    }else{
                                                        inserProduct();
                                                    }
                                                }else{  
                                                    inserProduct();
                                                }
                                                $(this).val('');
                                                dataoutput();
                                                PlaySound();
                                            }else{
                                                Toast2.fire({
                                                    type: 'warning',
                                                    title: "This item will be remove in cart!"
                                                }).then((result) => {
                                                    if (result.value) {
                                                        cart.filter((items,key) => {
                                                            // if cart index equals to cart map
                                                            if(key == val){
                                                                // if key value is greater than -1
                                                               if(key > -1){
                                                                   //remove item on cart
                                                                  cart.splice(key,1);
                                                                  PlaySound();
                                                                  //remove element value on barcodes array
                                                                  const barcarry = barcodes.indexOf(items.barcode);
                                                                  barcodes.splice(barcarry,1);
                                                                  dataoutput();
                                                               }
                                                            }
                                                        })
                                                    }else{
                                                        e.preventDefault();
                                                    }
                                                })
                                            }
                                        }
                                    }
                                })
                            })

                            $("#trash"+val).on('click', function(e){
                                Toast2.fire({
                                     type: 'warning',
                                     title: "This item will be remove in cart!"
                                }).then((result) => {
                                     if (result.value) {
                                         cart.filter((items,key) => {
                                         // if cart index equals to cart map
                                         if(key == val){
                                         // if key value is greater than -1
                                         if(key > -1){
                                            //remove item on cart
                                            cart.splice(key,1);
                                            PlaySound();
                                            //remove element value on barcodes array
                                            const barcarry = barcodes.indexOf(items.barcode);
                                            barcodes.splice(barcarry,1);
                                            dataoutput();
                                          }
                                        }
                                     })
                                   }else{
                                       e.preventDefault();
                                    }
                                })
                            })
                         })
                   };
                   /*--------------------*/

                   //Scanning barcode
                   $('#barcode').on('input', function(e){
                        setTimeout(() => {
                            product.filter((item,key) => {
                                const barcode_no = $(this).val();
                                if(item.barcode === barcode_no){
                                        if(item.stock > 0){
                                            let quantity = 1;
                                            let disc = 100 - parseInt(discount);
                                            let price;
                                            let subtotal;
                                            console.log(disc);
                                            if(discount > 0){
                                                price = disc * parseFloat(item.price.replace(/,/g, '')) / 100;
                                                subtotal = quantity * price;
                                            }else{
                                                price = parseFloat(item.price.replace(/,/g, ''));
                                                subtotal = quantity * price;
                                            }
                                            const totalSub = commas(subtotal);
                                            $('#payment').attr('disabled', false);
                                            inserProduct = () => {
                                                const cartObj = Object.assign({id:item.id,barcode:item.barcode,name:item.name,unit:item.unit,price:item.price,profit:item.profit,status:item.status,quantity:quantity,subtotal:findDecimal(totalSub),net_wt:item.net_wt})
                                                cart.push(cartObj);
                                                barcodes.push(item.barcode);
                                            }
                                            if(cart.length > 0){
                                                if(barcodes.find(e => e == barcode_no)){
                                                    cart.filter((i,k) => {
                                                    if(i.barcode === barcode_no){
                                                            const newquantity = i.quantity + 1;
                                                            const total = price + parseFloat(i.subtotal.replace(/,/g, ''));
                                                            const pretotal = commas(total);
                                                            i.subtotal = findDecimal(pretotal);
                                                            i.quantity = newquantity;
                                                        }
                                                    });    
                                                }else{
                                                    inserProduct();
                                                }
                                            }else{  
                                                inserProduct();
                                            }
                                            $(this).val('');
                                            dataoutput();
                                            PlaySound();
                                            
                                    }else{
                                        Swal.fire(
                                            'Out of Stock!',
                                            'This item is out of stock!',
                                            'error'
                                        );
                                    }
                                    
                                }
                            });
                            
                        }, 250);
 
                   })
                    /*--------------------*/
  
                   addItems = () => {
                         //Searching item on modal
                        $('#search').autocomplete({
                                source:product_name,
                                select:function(){
                                    setTimeout(() => {
                                        product.filter((item,key) => {
                                        if(item.name+' '+item.net_wt === $(this).val()){
                                            $('#id').val(item.id);
                                            $('#codebar').val(item.barcode);
                                            $('#unit').val(item.unit);
                                            $('#name').val(item.name);
                                            $('#price').val(item.price);
                                            $('#net_wt').val(item.net_wt);
                                            $('#quantity').attr('max', item.stock);
                                            $('#stocks').val(item.stock);
                                            $('#quantity').focus();
                                            $('#status').val(item.status);
                                            $('#profit').val(item.profit);
                                            }
                                        })
                                    },100);
                                }   
                            }); 

                            //add item into cart
                            cart_add = () => {
                                let quantity = parseInt($('#quantity').val());
                                if(quantity && quantity > 0){
                                    if(quantity <= parseInt($('#stocks').val())){
                                        $('#payment').attr('disabled', false);
                                        const item_price = $('#price').val();
                                        let disc = 100 - parseInt(discount);
                                        let price;
                                        let subtotal;
                                        console.log(disc);
                                        if(discount > 0){
                                           price = disc * parseFloat(item_price.replace(/,/g, '')) / 100;
                                           subtotal = quantity * price;
                                        }else{
                                            price = parseFloat(item_price.replace(/,/g, ''));
                                            subtotal = quantity * price;
                                        }
                                        const totalSub = commas(subtotal);
                                        if(barcodes.find(e => e == $('#codebar').val())){
                                            console.log('test');
                                            cart.filter((i,k) => {
                                                if(i.barcode == $('#codebar').val()){
                                                        const newquantity = i.quantity + quantity;
                                                        const total = price + parseFloat(i.subtotal.replace(/,/g, ''));
                                                        const pretotal = commas(total);
                                                        if(newquantity <= parseInt($('#stocks').val())){
                                                            i.subtotal = findDecimal(pretotal);
                                                            i.quantity = newquantity;
                                                            PlaySound();
                                                            dataoutput();
                                                            $('#search').val('');
                                                            $('#codebar').val('');
                                                            $('#id').val('');
                                                            $('#unit').val('');
                                                            $('#name').val('');
                                                            $('#price').val('');
                                                            $('#quantity').val('');
                                                            $('#search').focus();
                                                            $('#stocks').val('');
                                                            $('#profit').val('');
                                                            $('#status').val('');
                                                            $('#net_wt').val('');
                                                            $('.errorstock').html('');
                            
                                                        }else{
                                                           $('.errorstock').html('Out of Stock!, Please check your cart and stock!');
                                                        }
                                                }
                                            }); 
                                        }else{
                                            const cartObj = Object.assign({id:$('#id').val(),barcode:$('#codebar').val(),name:$('#name').val(),unit:$('#unit').val(),price:$('#price').val(),profit:$('#profit').val(),status:$('#status').val(),net_wt:$('#net_wt').val(),quantity:quantity,subtotal:findDecimal(totalSub)})
                                            cart.push(cartObj);
                                            barcodes.push($('#codebar').val());
                                            PlaySound();
                                            dataoutput();
                                            $('#search').val('');
                                            $('#codebar').val('');
                                            $('#id').val('');
                                            $('#unit').val('');
                                            $('#name').val('');
                                            $('#price').val('');
                                            $('#profit').val('');
                                            $('#quantity').val('');
                                            $('#search').focus();
                                            $('#stocks').val('');
                                            $('#status').val('');
                                            $('#net_wt').val('');
                                            $('.errorstock').html('');
                                        }
                                    }else{
                                        $('.errorstock').html('Out of Stock!, Please check your cart and stock!');
                                    }
                                }
                            }

                            /*-------------*/

                            $('#add_cart').click(function(){
                                  cart_add();
                            })  

                            $("input[name=quantity]").on("keydown", function(e) {
                                var code = e.keyCode || e.which;
                                //Key Enter to add items
                                if ( code == 13 ) {
                                    cart_add();
                                    e.preventDefault();
                                    return false;
                                }
                                //key Home Clear
                                if(code == 36){
                                    e.preventDefault();
                                    $('#search').val('');
                                    $('#codebar').val('');
                                    $('#id').val('');
                                    $('#unit').val('');
                                    $('#name').val('');
                                    $('#price').val('');
                                    $('#profit').val('');
                                    $('#quantity').val('');
                                    $('#search').focus();
                                    $('#stocks').val('');
                                    $('#status').val('');
                                    $('#net_wt').val('');
                                    $('#search').focus();
                                    return false;
                                }
                            });

                            //click clear 
                            $('#clearing').click(function(){
                                $('#search').val('');
                                    $('#codebar').val('');
                                    $('#id').val('');
                                    $('#unit').val('');
                                    $('#name').val('');
                                    $('#price').val('');
                                    $('#quantity').val('');
                                    $('#profit').val('');
                                    $('#search').focus();
                                    $('#stocks').val('');
                                    $('#status').val('');
                                    $('#net_wt').val('');
                                    $('#search').focus();
                            })

                            $('#search').on('keydown', function(e){
                                var code = e.keyCode || e.which;
                                if( code == 37){
                                    e.preventDefault();
                                    return false;
                                }
                            })
                   }
                   
                   $('#add_item').click(function(){
                        $('#new_item').modal('show');
                        setTimeout(() => {
                            $('#search').prop('disabled', false);
                            $('#search').focus();
                            addItems();
                        }, 1000);
                   })
                   $('#customers').click(function(){
                        $('#searchcustomer').modal('show');
                        $('.selectbuy').on('click', function(){
                            var data = $(this).data('stuff');
                            $('.customercart').html('[' + data[0] + ']');
                            $('.customerdiscount').html(data[1]);
                            discount = data[1];
                            customer = data[0];
                            business_tyle = data[2];
                            customer_address = data[3];
                            $('#searchcustomer').modal('hide');
                        })
                   })
                   $('#cancel_transac').click(function(){
                       cart.splice(0,cart.length);
                       barcodes.splice(0,barcodes.length);
                       PlaySound();
                       dataoutput();
                       $('#cash').val('');
                       $('.errorcash').html('');
                       $('#barcode').focus();
                       $('.cash').html('');
                       $('#change').html('');
                   })

                   $("input[name=barcode]").on("keydown", function(e) {
                        var code = e.keyCode || e.which;
                        //key ctrl to show search item modal
                        if ( code == 16 ) {
                            $('#new_item').modal('show');
                            e.preventDefault();
                            setTimeout(() => {
                                $('#search').prop('disabled', false);
                                $('#search').focus();
                                addItems();
                            }, 1000);
                            return false;
                        }
                        //shift key to search customer
                        if(code == 192){
                            $('#searchcustomer').modal('show');
                            $('.selectbuy').on('click', function(){
                                var data = $(this).data('stuff');
                                $('.customercart').html('[' + data[0] + ']');
                                $('.customerdiscount').html(data[1]);
                                discount = data[1];
                                customer = data[0];
                                business_tyle = data[2];
                                customer_address = data[3];
                                $('#searchcustomer').modal('hide');
                            })
                        }

                    });
                    $('#cash').on('keyup', function(e){
                        var code = e.keyCode || e.which;
                        if(code == 13){
                            Toast2.fire({
                                type: 'warning',
                                title: "Transaction Proceed?"
                            }).then((result) => {
                                if (result.value) {
                                    pay_proceed();
                                }else{
                                    e.preventDefault();
                                }
                            })
                        }
                    })
                    $(document).keyup(function(e){
                        var code = e.keyCode || e.which;
                        //key ctrl Arrow to show search item modal
                        if ( code == 16 ) {
                            $('#new_item').modal('show');
                                e.preventDefault();
                                setTimeout(() => {
                                    $('#search').prop('disabled', false);
                                    $('#search').focus();
                                    addItems();
                                }, 1000);
                                return false;
                        }

                        //shift key to search customer
                        if(code == 192){
                            $('#searchcustomer').modal('show');
                            $('.selectbuy').on('click', function(){
                                var data = $(this).data('stuff');
                                $('.customercart').html('[' + data[0] + ']');
                                $('.customerdiscount').html(data[1]);
                                discount = data[1];
                                customer = data[0];
                                business_tyle = data[2];
                                customer_address = data[3];
                                $('#searchcustomer').modal('hide');
                            })
                        }

                        //key page up
                        if(code == 33){
                            $('#barcode').focus();
                        }
                        //key home
                        if(code == 36){
                            $('#cash').focus();
                        }
                        //key Delete
                        if(code == 46){
                            cart.splice(0,cart.length);
                            barcodes.splice(0,barcodes.length);
                            PlaySound();
                            dataoutput();
                            $('#cash').val('');
                            $('.errorcash').html('');
                            $('#barcode').focus();
                            $('.cash').html('');
                            $('#change').html('');
                        }
                    })
                    
                }   
            })

            $('#salesTable').on('click',".void",function(){
                console.log('HELLO');
                var data = $(this).data('stuff');
                $('#void').modal('show');
                if($('.reason').val() !== ''){
                    $('.item_void').prop('disabled', false);
                }else{
                    $('.item_void').prop('disabled', true);
                }
                console.log(data);
                $('#item_name').val(data[2]);
                $('#item_quantity').val(data[6]);
                $('#item_quantity').attr('max', data[6]);
                $('#item_id').val(data[0]);
                $('#item_inv').val(data[1]);
                $('#item_netwt').val(data[3]);
                $('#item_unit').val(data[4]);
                $('#item_price').val(data[5]);
                $('#item_sub').val(data[7]);
                $('#item_cashier').val(data[8]);
                $('#item_barcode').val(data[9]);
                $('#item_profit').val(data[10]);
                $('.reason').on('keyup', function(){
                if($(this).val() !== ''){
                    $('.item_void').prop('disabled', false);
                }else{
                    $('.item_void').prop('disabled', true);
                }
                 })

                 $('.item_void').on('click', function(e){
                    Toast4.fire({
                                type: 'warning',
                                title: "Return On Stock?"
                        }).then((result) => {
                                if (result.value) {
                                    $('#item_status').val('Return On Stock');
                                    setTimeout(() => {
                                        $('#voidfrm').submit();
                                    }, 500);
                                } else if(result.dismiss == 'cancel') {
                                    $('#item_status').val('Rejected');
                                    setTimeout(() => {
                                        $('#voidfrm').submit();
                                    }, 500);
                                }else{
                                   e.preventDefault();
                                   return false;
                                }
                        })
                 })
            })
            
        })
    </script>
@endsection