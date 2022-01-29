@extends('layouts.admin')
@section('container-title')
    <h1>Inventory</h1> 
@endsection
@section('content')
    <section>
           <div class="box box-primary">
               <div class="box-header with-border">
                <select name="selectStock" id="selectStock" class="selectStock pull-right">
                    <option value="all">All</option>
                    <option value="5">Critical Stock</option>
                    <option value="0">Out of Stock</option>
                </select>
              </div><!-- /.box-header -->
               <div class="container-fluid" style="margin-top:1%">
                <table id="mytable" class="table display nowrap" style="width:100%">
                    <thead class="">
                        <tr>
                            <th class="none">BARCODE </th>
                            <th class="all">NAME</th>
                            <th>NET WT.</th>
                            <th>UNIT</th>
                            <th>PRICE</th>
                            <th>STOCK ON HAND</th>
                            <th>BRAND</th>
                            <th class="none">CATEGORY:</th>
                            <th>SUPPLIER:</th>
                            <th class="all">CONTROL</th>
                        </tr>
                    </thead>
                    <tbody>    
                                            
                        @if (count($products) > 0)
                            @foreach ($products as $product)
                                <tr>
                                    <td class="text-truncate" style="max-width:100px; vertical-align: middle;">{{$product->barcode}}</td>
                                    <td class="text-truncate" style="max-width:100px; vertical-align: middle;">{{$product->name}}</td>
                                    <td class="text-truncate" style="max-width:100px; vertical-align: middle;">{{$product->net_wt}}</td>
                                    <td class="text-truncate" style="max-width:100px; vertical-align: middle;">{{$product->unit}}</td>
                                    <td class="text-truncate" style="max-width:100px; vertical-align: middle;">₱ {{number_format($product->price,2)}}</td>
                                    <td class="text-truncate" style="max-width:100px; vertical-align: middle;">{{$product->stocks->quantity}}</td>
                                    <td class="text-truncate" style="max-width:100px; vertical-align: middle;">{{$product->brand}}</td>
                                    <td class="text-truncate" style="max-width:100px; vertical-align: middle;">@if ($product->categories !== null)
                                        {{$product->categories->name}}
                                    @else
                                        {{'Pending'}}
                                    @endif </td>
                                    <td class="text-truncate" style="max-width:100px; vertical-align: middle;">@if($product->suppliers !== null)
                                        {{$product->suppliers->name}}
                                    @else
                                        {{'Pending'}}
                                    @endif</td>
                                    
                                    <td class="text-truncate" style="max-width:100px; vertical-align: middle;">
                                        <a href="#" class="stockin btn btn-success btn-sm" data-stuff='[&#34;{{$product->id}}&#34;, &#34;{{$product->name}}&#34;, &#34;{{$product->stocks->quantity}}&#34;]'><i class="fas fa-plus-circle"></i> Stocking</a>
                                    </td>
                               
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
            </table>
               </div>
           </div>
    </section>


    {{-- STOCK IN MODAL --}}
      <div class="modal fade bd-example-modal-sm" id="stockmodal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
          <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                <h3>Stocking</h3>
            </div>
            <div class="modal-body">
                <strong class="errors text-danger">
                </strong>
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h4 class="text-overflow1" id="prodname" style="font-weight: 600"></h4>
                        <hr>
                        <h4 class="text-truncate text-success" style="max-width: 100%">Stock In: <span id="total"></span></h4>
                        <hr>
                        <h4 class="text-truncate text-danger" style="max-width: 100%">Stock Out: <span id="stockout"></span></h4>
                    </div><!-- /.box-header -->
                    <form method="POST" id="formstock">
                        @csrf
                        @method('PUT')                       
                         <h4 class="text-truncate" style="max-width: 100%">Current Quantity: <span id="pname"></span></h4>  
                        <div class="form-group">
                            <input type="hidden" name="old" id="old_val">
                            <input type="hidden" name="newstock" id="newstock">
                            <input type="hidden" name="stockstatus" id="stockstatus">
                            <h4 class="text-truncate" style="max-width: 100%" >Quantity: <input type="number" name="quantity" id="quantt" placeholder="0" min="1" maxlength="9"></h4> 
                        </div> 
                        <div class="form-group">
                            <label>Leave message for stocking..</label>
                            <textarea name="message_stock" class="form-control" id="" cols="5" rows="5"></textarea>
                        </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-danger btn-sm pull-left" id="stock_out"><i class="spinner fas fa-spinner fa-spin"></i> <i class="fas fa-share-square"></i> Stock Out</button>
                <button type="submit" class="btn btn-success btn-sm pull-right" id="stock_add"><i class="spinner fas fa-spinner fa-spin"></i> <i class="fas fa-plus-circle"></i> Stock In</button> <br><br>
                </form>
            </div>
          </div>
        </div>
      </div>
@endsection
@section('script')
   <script>
    $(document).ready(function(){
        $('.spinner').hide();
        var total = 0;
        var stockout =0;
        $('#selectStock').on('change', function(){
            $('#stocker').val($(this).val());
            $('.loading-spinner').show();
            $('#notblur').attr('id', 'blur');
            $('#frmStocker').submit();
        })

        $('#stock_add').on('click', function(e){
            e.preventDefault();
            $('#newstock').val(total);
            $('#stockstatus').val('Stock In');
            $('.spinner').show();
            $(this).attr('disabled', true);
            $('#stock_out').prop('disabled', true);
            $('#formstock').submit();
        })

        $('#stock_out').on('click', function(e){
            e.preventDefault();
            $('#newstock').val(stockout);
            $('#stockstatus').val('Stock Out');
            $('.spinner').show();
            $(this).attr('disabled', true);
            $('#stock_add').prop('disabled', true);
            $('#formstock').submit();
        })

        var id = 0;
        var isAjaxExecuting = false;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        function commas(x){
            var num = x.toLocaleString();
            return num;
        }
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 300000,
            showCloseButton: true,
            imageWidth:100,
            imageHeight:100
        });
        const Toast2 = Swal.mixin({
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        });
        $('#stockmodal').on('hidden.bs.modal', function (e) {
            $('#old_val').val('');
            $('#total').text('');
            $('#stockout').text('');
            $('#quantt').val('');
        })
        $('.stockin').click(function(){
            $('#stockmodal').modal('show');
            var data = $(this).data('stuff');
            console.log(data);
            id = data[0];
            $('#old_val').val(data[2]);
            var current_total = data[2];
            $('#pname').text(data[2]);
            $('#prodname').text(data[1]);
            $('#quantt').on('input', function(){
                if($(this).val() == ''){
                    $('#total').hide();
                }else{
                    $('#total').show();
                    total = parseFloat(current_total) + parseFloat($(this).val());
                    stockout = parseFloat(current_total) - parseFloat($(this).val());
                    $('#total').text(total);
                    $('#stockout').text(stockout);
                    if(stockout < 0){
                        $('#stock_out').prop('disabled', true);
                    }else{
                        $('#stock_out').prop('disabled', false);
                    }
                }
                
            })
            
            $('#formstock').submit(function(e){
                    if(isAjaxExecuting) return;
                    isAjaxExecuting = true;
                        e.preventDefault();
                        var dataform = new FormData(this);
                        $.ajax({
                            url:"{{ url('index.php/updatestock/') }}"+ '/' + id,
                            method:'POST',
                            data:dataform,
                            contentType:false,
                            processData:false,
                            success:function(data){
                                isAjaxExecuting = false;
                                if(data == 1) {
                                    window.location.href = '/index.php/index.php/stockupdate';
                                }else{
                                    console.log(data);
                                    $('.spinner').hide();
                                    $('#stock_add').attr('disabled', false);
                                    $.each(data.error, function(key,val){
                                        $('.errors').text(val);
                                    });
                                }
                            }
                        })
                })
           
        })
        if("{{session('stockupdate')}}"){
            Swal.fire(
                'Successfully!!',
                '{{session("stockupdate")}}',
                'success'
            )
        }
        $('#mytable').DataTable( {
                responsive: true,
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
        }); 
        $('.loading-spinner').hide();
        $('#blur').attr('id', 'notblur');
    })
   </script>
@endsection