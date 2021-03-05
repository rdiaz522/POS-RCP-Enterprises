@extends('layouts.admin')
@section('container-title')
    <h1>Item List </h1> 
@endsection
@section('content')
    <section>
           <div class="box box-primary">
               <div class="box-header with-border">
                <a href="#" class="new_prod btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#new_product"><i class="fas fa-plus-circle"></i> Add New Item</a>
              </div><!-- /.box-header -->
               <div class="container-fluid" style="margin-top:1%">
                <table id="mytable" class="table display nowrap" style="width:100%">
                    <thead class="">
                        <tr>
                            <th class="none">Barcode: </th>
                            <th>PICTURE</th>
                            <th class="all">NAME</th>
                            <th>NET WT.</th>
                            <th>UNIT</th>
                            <th>PRICE</th>
                            <th>QUANTITY</th>
                            <th>PROFIT</th>
                            <th>ADDED BY</th>
                            <th class="none">BRAND</th>
                            <th class="none">CATEGORY:</th>
                            <th class="none">SUPPLIER:</th>
                            @if (Auth::user()->roles->first()->name == 'Staff')
                                 <th class="none">CONTROL</th>
                            @else
                                 <th class="all">CONTROL</th>
                            @endif
                           
                        </tr>
                    </thead>
                    <tbody>    
                                            
                        @if (count($products) > 0)
                            @foreach ($products as $product)
                                <tr>
                                    <td><img src="data:image/png;base64,{{DNS1D::getBarcodePNG($product->barcode, 'EAN13')}}" alt="barcode" /> <a href="{{route('products.show', $product->barcode)}}" class="btn btn-warning">Print Barcode</a></td>
                                    <td><img src="/storage/product_images/{{$product->image}}" alt="Product Image" width="70" height="70" class="float-left"></td>
                                    <td class="text-truncate"  style="max-width:100px; vertical-align: middle;" >{{$product->name}}</td>
                                    <td class="text-truncate" style="max-width:100px; vertical-align: middle;">{{$product->net_wt}}</td>
                                    <td class="text-truncate" style="max-width:100px; vertical-align: middle;">{{$product->unit}}</td>
                                    <td class="text-truncate" style="max-width:100px; vertical-align: middle;">₱ {{number_format($product->price,2)}}</td>
                                    <td class="text-truncate" style="max-width:100px; vertical-align: middle;">{{number_format($product->stocks->quantity)}}</td>
                                    <td class="text-truncate" style="max-width:100px; vertical-align: middle;">₱ {{number_format($product->profit,2)}}</td>
                                    <td class="text-truncate" style="max-width:100px; vertical-align: middle;">{{$product->added_by}}</td>
                                    <td class="text-truncate" style="max-width:100px; vertical-align: middle;">{{$product->brand}}</td>
                                    <td class="text-truncate" style="max-width:100px; vertical-align: middle;">@if ($product->categories !== null)
                                        {{$product->categories->name}}
                                    @else
                                        {{'Pending'}}
                                    @endif </td>
                                    <td class="text-truncat" style="max-width:100px; vertical-align: middle;">@if($product->suppliers !== null)
                                        {{$product->suppliers->name}}
                                    @else
                                        {{'Pending'}}
                                    @endif</td>
                                    
                                    <td class="text-truncate" style="max-width:100px; vertical-align: middle;">
                                    <form action="{{route('products.update',$product->id)}}" id="{{$product->id}}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        @can('admin')
                                        <a href="#" class="edit btn btn-primary btn-sm" data-id="{{$product->id}}"><i class="fas fa-pen"></i>Edit</a>
                                            <button type="submit" class="remove btn btn-danger btn-sm" data-id="{{$product->id}}"><i class="fas fa-trash"></i> Remove</button>
                                        @endcan
                                        </form>
                                    </td>
                               
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
            </table>
               </div>
           </div>
    </section>

 
    {{-- ADD PRODUCT MODAL --}}
    <div class="modal fade " id="new_product" tabindex="-1" role="dialog" aria-labelledby="new_productLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
          <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
              <h2 class="modal-title" id="new_productLabel">New Item</h2>
            </div>

            <a href="#" class="barcode nav-link"><i class="fas fa-barcode"></i> Generate Barcode</a>
            <div class="barcode_output">
                <center> <img src="data:image/png;base64,{{DNS1D::getBarcodePNG($barcode, 'EAN13')}}" alt="barcode" /> </center>
            </div>
            <div class="modal-body">
            <div class="box box-primary">

                <form action="{{route('products.store')}}" method="POST" id="formadd" enctype="multipart/form-data" autocomplete="off">
                    @csrf
              <div class="form-group" style="margin-top:1%">
              <input type="text" name="barcode" id="barcode" minlength="4" maxlength="20" class="form-control form-control-sm @if($errors->first('barcode')) is-invalid @endif" value="{{old('barcode')}}" placeholder="* Barcode">
                    @if ($errors->first('barcode'))
                    <span class="invalid-feedback text-danger" role="alert">
                        <strong>{{$errors->first('barcode')}}</strong>
                    </span>
                    @endif
              </div>
              <div class="form-group">
                    <input type="text" name="name" id="name" class="form-control form-control-sm @if($errors->first('name')) is-invalid @endif" value="{{old('name')}}" placeholder="* Item Name" maxlength="25">
                    @if ($errors->first('name'))
                    <span class="invalid-feedback text-danger" role="alert">
                        <strong>{{$errors->first('name')}}</strong>
                    </span>
                    @endif
              </div>
              <div class="form-group">
                <input type="text" name="unit" id="unit" class="form-control form-control-sm @if($errors->first('unit')) is-invalid @endif" value="{{old('unit')}}"  placeholder="* Unit" maxlength="15">
                @if ($errors->first('unit'))
                <span class="invalid-feedback text-danger" role="alert">
                    <strong>{{$errors->first('unit')}}</strong>
                </span>
                @endif
              </div>
              <div class="form-group">
                <input type="text" name="price" id="price" class="form-control form-control-sm @if($errors->first('price')) is-invalid @endif" value="{{old('price')}}" maxlength="11" placeholder="* Selling Price">
                @if ($errors->first('price'))
                <span class="invalid-feedback text-danger" role="alert">
                    <strong>{{$errors->first('price')}}</strong>
                </span>
                @endif
              </div>

              <div class="form-group">
                <input type="text" name="profit" id="profit" class="form-control form-control-sm @if($errors->first('profit')) is-invalid @endif" value="{{old('profit')}}" maxlength="11" placeholder="Profit">
                @if ($errors->first('profit'))
                <span class="invalid-feedback text-danger" role="alert">
                    <strong>{{$errors->first('profit')}}</strong>
                </span>
                @endif
              </div>
              
              <div class="form-group">
                <input type="text" name="quantity" id="quantity" class="form-control form-control-sm @if($errors->first('quantity')) is-invalid @endif" maxlength="11" value="{{old('quantity')}}" placeholder="* Quantity">
                @if ($errors->first('quantity'))
                <span class="invalid-feedback text-danger" role="alert">
                    <strong>{{$errors->first('quantity')}}</strong>
                </span>
                @endif
              </div>

              <div class="form-group">
                <input type="text" name="net_wt" id="net_wt" class="form-control form-control-sm @if($errors->first('net_wt')) is-invalid @endif" value="{{old('net_wt')}}" maxlength="8" placeholder="Net Weight">
                @if ($errors->first('net_wt'))
                <span class="invalid-feedback text-danger" role="alert">
                    <strong>{{$errors->first('net_wt')}}</strong>
                </span>
                @endif
              </div>

              <div class="form-group">
                <input type="text" name="brand" id="brand" class="form-control form-control-sm @if($errors->first('brand')) is-invalid @endif" value="{{old('brand')}}" maxlength="30" placeholder="Brand">
                @if ($errors->first('brand'))
                <span class="invalid-feedback text-danger" role="alert">
                    <strong>{{$errors->first('brand')}}</strong>
                </span>
                @endif
              </div>

              <div class="form-group">
                    <select name="category" id="category" class="form-control form-control-sm @if($errors->first('category')) is-invalid @endif">
                        <option value="" selected>Select Category</option>
                        @if (count($categories) > 0)
                            @foreach ($categories as $categorie)
                                <option value="{{$categorie->id}}" @if($categorie->id==old('category')) selected @endif>{{$categorie->name}}</option>
                            @endforeach
                        @endif
                    </select>
                    @if ($errors->first('category'))
                    <span class="invalid-feedback text-danger" role="alert">
                        <strong>{{$errors->first('category')}}</strong>
                    </span>
                    @endif
              </div>
              <div class="form-group">
                <select name="supplier" id="supplier" class="form-control form-control-sm @if($errors->first('supplier')) is-invalid @endif">
                    <option value="" selected>Select Supplier</option>
                    @if (count($suppliers) > 0)
                        @foreach ($suppliers as $supplier)
                            <option value="{{$supplier->id}}" @if($supplier->id==old('supplier')) selected @endif>{{$supplier->name}}</option>
                        @endforeach
                    @endif
                </select>
                @if ($errors->first('supplier'))
                <span class="invalid-feedback text-danger" role="alert">
                    <strong>{{$errors->first('supplier')}}</strong>
                </span>
                @endif
            </div>
            <div class="form-group">
                <div class="form-group clearfix">
                    <div class="icheck-danger d-inline">
                      <input type="radio" name="status" value="V"  id="radioDanger1">
                      <label for="radioDanger1">
                          VAT
                      </label>
                    </div>

                    <div class="icheck-danger d-inline">
                      <input type="radio" name="status" value="N" checked id="radioDanger2">
                      <label for="radioDanger2">
                         NO VAT
                      </label>
                    </div>

                </div>
            </div>
            <div class="form-group">
                <input type="file" name="image" id="image" class="@if($errors->first('image')) is-invalid @endif" value="{{old('image')}}">
                <label for="image">Item Picture</label>
                @if ($errors->first('image'))
                <span class="invalid-feedback text-danger" role="alert">
                    <strong>{{$errors->first('image')}}</strong>
                </span>
                @endif
            </div>

            </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-window-close"></i> Close</button>
              <button type="button" class="modal-clear btn btn-info mr-auto"><i class="fas fa-eraser"></i> Clear</button>
              <button type="submit" class="btn btn-primary" id="save"><i class="spinner fas fa-spinner fa-spin"></i> <i class="fas fa-share-square"></i> Save</button>
            </form>
            </div>
          </div>
        </div>
      </div>


      {{-- EDIT MODAL --}}
      <div class="modal fade" id="edit_product" tabindex="-1" role="dialog" aria-labelledby="edit_productLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              <h2 class="modal-title" id="edit_productLabel">Edit Item</h2>
            </div>
            <div class="modal-body">
                <div class="box box-primary">
                    <strong class="errors text-danger">
                    </strong>
                <form method="POST" id="formedit" enctype="multipart/form-data" autocomplete="off">
                    @csrf
                    @method('PUT')
                  <div class="form-group">
                    <label>Barcode</label>
                        <input type="text" name="barcode" id="barcodee" class="form-control form-control-sm" minlength="4" maxlength="20"> 
                  </div>
                  <div class="form-group">
                    <label>Item Name</label>
                        <input type="text" name="name" id="namee" class="form-control form-control-sm" maxlength="25"> 
                  </div>
                  <div class="form-group">
                    <label>Unit</label>
                        <input type="text" name="unit" id="unite" class="form-control form-control-sm" maxlength="15">  
                  </div>
                  <div class="form-group">
                    <label>Price</label>
                        <input type="text" name="price" id="pricee" class="form-control form-control-sm" maxlength="11">  
                  </div>
                  <div class="form-group">
                    <label>Profit</label>
                        <input type="text" name="profit" id="profitt" class="form-control form-control-sm" maxlength="11">  
                  </div>
                  <div class="form-group">
                    <label>Net Weight</label>
                        <input type="text" name="net_wt" id="net_wte" class="form-control form-control-sm" maxlength="8"> 
                  </div>
                  <div class="form-group">
                    <label>Brand</label>
                        <input type="text" name="brand" id="brande" class="form-control form-control-sm" maxlength="30"> 
                  </div>
                  <div class="form-group">
                    <label>Category</label>
                        <select name="category" id="categorye" class="form-control form-control-sm @if($errors->first('categorye')) is-invalid @endif">
                            <option value="" selected>Select Category</option>
                            @if (count($categories) > 0)
                                @foreach ($categories as $categorie)
                                    <option value="{{$categorie->id}}" @if($categorie->id==old('categorye')) selected @endif>{{$categorie->name}}</option>
                                @endforeach
                            @endif
                        </select>
                  </div>
                  <div class="form-group">
                    <label>Supplier</label>
                    <select name="supplier" id="suppliere" class="form-control form-control-sm @if($errors->first('suppliere')) is-invalid @endif">
                        <option value="" selected>Select Supplier</option>
                        @if (count($suppliers) > 0)
                            @foreach ($suppliers as $supplier)
                                <option value="{{$supplier->id}}" @if($supplier->id==old('suppliere')) selected @endif>{{$supplier->name}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="form-group">
                    <div class="form-group clearfix">
                        <div class="icheck-danger d-inline">
                          <input type="radio" name="status" value="V" id="status1">
                          <label for="status1">
                              VAT
                          </label>
                        </div>
    
                        <div class="icheck-danger d-inline">
                          <input type="radio" name="status" value="N" id="status2">
                          <label for="status2">
                             NO VAT
                          </label>
                        </div>
    
                    </div>
                </div>
                <div class="form-group">
                    <label for="imagee">Item Picture</label>
                    <input type="file" name="image" id="imagee">
                </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-window-close"></i> Close</button>
              <button type="submit" class="btn btn-primary" id="update_product"><i class="spinner fas fa-spinner fa-spin"></i> <i class="fas fa-share-square"></i> Update</button>
            </form>
            </div>
          </div>
        </div>
      </div>
@endsection
@section('script')
   <script>
    $(document).ready(function(){
        $('.loading-spinner').hide();
        $('.spinner').hide();

        $('#save').on('click', function(e){
            e.preventDefault();
            $('.spinner').show();
            $(this).attr('disabled', true);
            $('#formadd').submit();
        })


        $('#update_product').on('click', function(e){
            e.preventDefault();
            $('.spinner').show();
            $(this).attr('disabled', true);
            $('#formedit').submit();
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
        $('#formadd').on('submit', function(){
            var num = $('#price').val();
            var val = 0;
            if(num.indexOf(',') !== -1){
                const price = parseFloat(num.replace(/,/g, ''));
                if(Number.isInteger(price)){
                    if(price.toString().length <= 3){
                        val = price.toFixed(2);
                    }else{
                        val = commas(price) + '.00';
                    }
                }else{
                    val = price;
                }
                if(isNaN(price)){
                    $(this).val('');
                }else{
                    $(this).val(val);
                }
            }else{
                const price = parseFloat(num);
                if(Number.isInteger(price)){
                    if(price.toString().length <= 3){
                        val = price.toFixed(2);
                    }else{
                        val = commas(price) + '.00';
                    }
                }else{
                    val =  commas(price);
                }
                if(isNaN(price)){
                    $(this).val('');
                }else{
                    $(this).val(val);
                }
            }
        })
        $('#pricee').focusout(function(){
            var num = $(this).val();
            var val = 0;
            if(num.indexOf(',') !== -1){
                const price = parseFloat(num.replace(/,/g, ''));
                if(Number.isInteger(price)){
                    if(price.toString().length <= 3){
                        val = price.toFixed(2);
                    }else{
                        val = commas(price) + '.00';
                    }
                }else{
                    val = commas(price);
                }
                if(isNaN(price)){
                    $(this).val('');
                }else{
                    $(this).val(val);
                }
            }else{
                const price = parseFloat(num);
                if(Number.isInteger(price)){
                    if(price.toString().length <= 3){
                        val = price.toFixed(2);
                    }else{
                        val = commas(price) + '.00';
                    }
                }else{
                    val = commas(price);
                }
                if(isNaN(price)){
                    $(this).val('');
                }else{
                    $(this).val(val);
                }
            }
        })

        $('#price').focusout(function(){
            var num = $(this).val();
            var val = 0;
            if(num.indexOf(',') !== -1){
                const price = parseFloat(num.replace(/,/g, ''));
                if(Number.isInteger(price)){
                    if(price.toString().length <= 3){
                        val = price.toFixed(2);
                    }else{
                        val = commas(price) + '.00';
                    }
                }else{
                    val = commas(price);
                }
                if(isNaN(price)){
                    $(this).val('');
                }else{
                    $(this).val(val);
                }
            }else{
                const price = parseFloat(num);
                if(Number.isInteger(price)){
                    if(price.toString().length <= 3){
                        val = price.toFixed(2);
                    }else{
                        val = commas(price) + '.00';
                    }
                }else{
                    val = commas(price);
                }
                if(isNaN(price)){
                    $(this).val('');
                }else{
                    $(this).val(val);
                }
            }
            
        })

        $('#profit').focusout(function(){
            var num = $(this).val();
            var val = 0;
            if(num.indexOf(',') !== -1){
                const price = parseFloat(num.replace(/,/g, ''));
                if(Number.isInteger(price)){
                    if(price.toString().length <= 3){
                        val = price.toFixed(2);
                    }else{
                        val = commas(price) + '.00';
                    }
                }else{
                    val = commas(price);
                }
                if(isNaN(price)){
                    $(this).val('');
                }else{
                    $(this).val(val);
                }
            }else{
                const price = parseFloat(num);
                if(Number.isInteger(price)){
                    if(price.toString().length <= 3){
                        val = price.toFixed(2);
                    }else{
                        val = commas(price) + '.00';
                    }
                }else{
                    val = commas(price);
                }
                if(isNaN(price)){
                    $(this).val('');
                }else{
                    $(this).val(val);
                }
            }
            
        })

        $('#profitt').focusout(function(){
            var num = $(this).val();
            var val = 0;
            if(num.indexOf(',') !== -1){
                const price = parseFloat(num.replace(/,/g, ''));
                if(Number.isInteger(price)){
                    if(price.toString().length <= 3){
                        val = price.toFixed(2);
                    }else{
                        val = commas(price) + '.00';
                    }
                }else{
                    val = commas(price);
                }
                if(isNaN(price)){
                    $(this).val('');
                }else{
                    $(this).val(val);
                }
            }else{
                const price = parseFloat(num);
                if(Number.isInteger(price)){
                    if(price.toString().length <= 3){
                        val = price.toFixed(2);
                    }else{
                        val = commas(price) + '.00';
                    }
                }else{
                    val = commas(price);
                }
                if(isNaN(price)){
                    $(this).val('');
                }else{
                    $(this).val(val);
                }
            }
            
        })
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

        if("{{session('success')}}"){
            Swal.fire(
                'Successfully!',
                '{{session("success")}}',
                'success'
            )
        }
        if("{{session('updated')}}"){
            Swal.fire(
                'Successfully!',
                '{{session("updated")}}',
                'success'
            )
        }
        if("{{session('deleted')}}"){
            Swal.fire(
            'Deleted!',
            'Your product has been deleted.',
            'warning'
            )
        }
        
        if("{{session('barcode_error')}}"){
            Swal.fire(
            'Error Occured!',
            '{{session("barcode_error")}}',
            'error'
            )
        }
        $('.barcode_output').hide();
        if('{{count($errors)}}' > 0){
            $("#new_product").modal('show');
        }
        if(! "{{$errors->first('barcode')}}"){
            if($('#barcode').val() !== ''){
                $('.barcode_output').show();
                $('#barcode').hide();
            }
        }
        $('.modal').on('shown.bs.modal', function() {
            $('#barcode').focus();
             $(this).find('[autofocus]').focus();
        });
        $('.barcode').on('click', function(){
            $('.barcode_output').show();
            $('#barcode').val('{{$barcode}}').attr('readonly',true);
            $('#name').focus();
            $('#barcode').hide();
        })
        $('.modal-clear').on('click', function(){
            $('#barcode').show();
            $('#barcode').focus();
            $('.barcode_output').hide();
            $('#barcode').val('').attr('readonly',false);;
            $('#name').val('');
            $('#brand').val('');
            $('#price').val('');
            $('#profit').val('');
            $('#quantity').val('');
            $('#category').val("").change();
            $('#supplier').val("").change();
            $('#image').val("");
        })
        $('#mytable').DataTable( {
                responsive: true,
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
        }); 
         $('.edit').on('click', function(){
           
             id = $(this).attr('data-id');
             $('#edit_product').modal('show');
             $.ajax({
                     url:"{{ url('index.php/products/') }}"+ '/' + id + '/edit',
                     method:'GET',
                     success:function(data){
                        if(data){
                            $('#barcodee').val(data.barcode);
                            $('#namee').val(data.name);
                            $('#net_wte').val(data.net_wt);
                            $('#brande').val(data.brand);
                            $('#pricee').val(data.price);
                            $('#profitt').val(data.profit);
                            $('#unite').val(data.unit);
                            $('#quantitye').val(data.stocks.quantity);
                            $('#categorye').val(data.category_id).change();
                            if(data.supplier_id !== null){
                                $('#suppliere').val(data.supplier_id).change();
                            }
                            if(data.status == 'V'){
                                $('#status1').attr('checked', true);
                            }else{
                                $('#status2').attr('checked', true);
                            }
                        }
                    }
                })
            $('#formedit').submit(function(e){
                var num = $('#pricee').val();
                var val = 0;
                if(num.indexOf(',') !== -1){
                    const price = parseFloat(num.replace(/,/g, ''));
                    if(Number.isInteger(price)){
                        if(price.toString().length <= 3){
                            val = price.toFixed(2);
                        }else{
                            val = commas(price) + '.00';
                        }
                    }else{
                        val = commas(price);
                    }
                    if(isNaN(price)){
                        $('#pricee').val('');
                    }else{
                        $('#pricee').val(val);
                    }
                }else{
                    const price = parseFloat(num);
                    if(Number.isInteger(price)){
                        if(price.toString().length <= 3){
                            val = price.toFixed(2);
                        }else{
                            val = commas(price) + '.00';
                        }
                    }else{
                        val = commas(price);
                    }
                    if(isNaN(price)){
                        $('#pricee').val('');
                    }else{
                        $('#pricee').val(val);
                    }
                }
                var num1 = $('#profitt').val();
                if(num1.indexOf(',') !== -1){
                    const price = parseFloat(num1.replace(/,/g, ''));
                    if(Number.isInteger(price)){
                        if(price.toString().length <= 3){
                            val = price.toFixed(2);
                        }else{
                            val = commas(price) + '.00';
                        }
                    }else{
                        val = commas(price);
                    }
                    if(isNaN(price)){
                        $('#profitt').val('');
                    }else{
                        $('#profitt').val(val);
                    }
                }else{
                    const price = parseFloat(num1);
                    if(Number.isInteger(price)){
                        if(price.toString().length <= 3){
                            val = price.toFixed(2);
                        }else{
                            val = commas(price) + '.00';
                        }
                    }else{
                        val = commas(price);
                    }
                    if(isNaN(price)){
                        $('#profitt').val('');
                    }else{
                        $('#profitt').val(val);
                    }
                }

                if(isAjaxExecuting) return;
                 isAjaxExecuting = true;
                e.preventDefault();
                var formdata = new FormData(this);
                $.ajax({
                    url:"{{ url('index.php/products/') }}"+ '/' + id,
                    method:'POST',
                    enctype:'multipart/form-data',
                    data:formdata,
                    contentType:false,
                    processData:false,
                    success:function(data){
                      isAjaxExecuting = false;
                        if(data == 1) {
                            window.location.href = '/index.php/index.php/update';
                        }else{
                            $.each(data.error, function(key,val){
                                $('#update_product').attr('disabled', false);
                                $('.spinner').hide();
                                $('.errors').text(val);
                            });
                        }
                    },
                    error:function(data){
                        console.log(data);
                    }
                })
            });
         })
         $('.remove').click(function(e){
            var pid = $(this).attr('data-id');
            e.preventDefault();
            Toast2.fire({
                type: 'warning',
                title: "Are you sure you want to delete this?"
            }).then((result) => {
                if (result.value) {
                    $('.remove').unbind('click');
                    $('#'+pid).submit();
                }else{
                    e.preventDefault();
                }
            })
         })
    })
   </script>
@endsection