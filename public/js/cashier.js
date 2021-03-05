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
    async function getdata(){
        const data = await fetch('/index.php/index.php/getProducts')
        .then(res => res.json())
        .catch(err => location.reload());
           let product = [];
           let product_name = [];
           let amount_total = 0;
           const cart = [];
           const barcodes = [];
           let discount = 0;
           let customer = '';
           let business_tyle = '';
           let customer_address = '';
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
                            _token: token,
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
                                        window.location = '/index.php/index.php/cashier/' + data; 
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
                                if(discount > 0){
                                   price = disc * parseFloat(item_price.replace(/,/g, '')) / 100;
                                   subtotal = quantity * price;
                                }else{
                                    price = parseFloat(item_price.replace(/,/g, ''));
                                    subtotal = quantity * price;
                                }
                                const totalSub = commas(subtotal);
                                if(barcodes.find(e => e == $('#codebar').val())){
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
                if ( code == 119 ) {
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
                if ( code == 119 ) {
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
    getdata();
    $('#salesTable').on('click',".void",function(){
        var data = $(this).data('stuff');
        $('#void').modal('show');
        if($('.reason').val() !== ''){
            $('.item_void').prop('disabled', false);
        }else{
            $('.item_void').prop('disabled', true);
        }
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