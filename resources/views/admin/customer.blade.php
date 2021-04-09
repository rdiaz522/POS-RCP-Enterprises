@extends('layouts.admin')
@section('container-title')
    <h1>Customer Management</h1>
@endsection
@section('content')
   <section>
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <a href="#" id="addnewcustomer" data-target="#addcustomer" data-toggle="modal" class="btn btn-success btn-sm pull-right"><i class="fas fa-plus-circle"></i> Add New Customer</a>
                      </div><!-- /.box-header -->
                      <div class="container-fluid">
                        <table class="table" id="mytable" width="100%">
                            <thead>
                                 <tr>
                                     <th>FULLNAME</th>
                                     <th>CONTACT NO.</th>
                                     <th>ADDRESS</th>
                                     <th>DISCOUNT</th>
                                     <th>CREATED AT</th>
                                     <th>CONTROL</th>
                                 </tr>
                            </thead>
                            <tbody>
                                    @if (count($customers) > 0)
                                        @foreach ($customers as $customer)
                                        <tr>
                                          <td class="text-truncate">{{$customer->fullname}}</td>
                                          <td>{{$customer->contact_no}}</td>
                                          <td>{{$customer->address}}</td>
                                          <td>{{$customer->discount}}</td>
                                          <td>{{$customer->created_at->calendar()}}</td>  
                                          <td>
                                          <form action="{{route('customer.destroy',$customer->id)}}" id="{{$customer->id}}" method="POST">
                                                <a href="#" class="edit btn btn-primary btn-sm" data-stuff='[&#34;{{$customer->fullname}}&#34;, &#34;{{$customer->contact_no}}&#34;, &#34;{{$customer->id}}&#34;,&#34;{{$customer->address}}&#34;,&#34;{{$customer->discount}}&#34;]'>Edit</a>
                                                @csrf
                                                @method('DELETE')
                                          <button type="submit" class="btn btn-danger btn-sm delete" data-id="{{$customer->id}}">Delete</button>
                                          </form>
                                          </td> 
                                        </tr>
                                        @endforeach
                                    @endif
    
                            </tbody>
                        </table>
                      </div>
                </div>
            </div>
        </div>
   </section>
   
{{-- ADD CUSTOMER --}}
<div class="modal fade" id="addcustomer" tabindex="-1" role="dialog" aria-labelledby="addcustomerlabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h3 class="modal-title" id="addcustomerlabel">New Customer</h3>
        </div>
        <div class="modal-body">
            <span class="erroredit text-danger"></span>
        <form action="{{route('customer.store')}}" id="addfrm" method="POST" autocomplete="off">
          @csrf
            <div class="form-group">
                <input type="text" class="form-control" name="fullname" id="fullname" placeholder="Fullname" maxlength="15">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="contact_no" id="contact_no" placeholder="Contact No.">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="address" id="address" placeholder="Address" maxlength="25">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="business_style" id="business_style" placeholder="Business Style">
            </div>
            <div class="form-group">
                <label for="discount">Discount %</label>
                <input type="number" class="form-control" name="discount" id="discount" min="0" max="100" placeholder="%">
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-window-close"></i> Close</button>
          <button type="button" class="btn btn-primary add"><i class="spinner fas fa-spinner fa-spin"></i> <i class="fas fa-share-square"></i> Save</button>
        </div>
    </form>
      </div>
    </div>
</div>

          {{-- EDIT USER --}}
          <div class="modal fade" id="editcustomer" tabindex="-1" role="dialog" aria-labelledby="editcustomerlabel" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                      <h3 class="modal-title" id="editcustomerlabel">Edit Customer</h3>
                    </div>
                    <div class="modal-body">
                        <span class="erroredit text-danger"></span>
                    <form action="" id="editfrm" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="fullnames">Fullname</label>
                            <input type="text" name="fullname" id="fullnames" class="form-control" maxlength="15">
                        </div>
                        <div class="form-group">
                            <label for="contact_nos">Contact No.</label>
                            <input type="text" name="contact_no" id="contact_nos" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="addresss">Address</label>
                            <input type="text" name="address" id="addresss" class="form-control" maxlength="25">
                        </div>
                        <div class="form-group">
                            <label for="business_styles">Business Style</label>
                            <input type="text" name="business_style" id="business_styles" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="discounts">Discount %</label>
                            <input type="number" name="discount" id="discounts" min="0" max="100" class="form-control">
                        </div>
                        <input type="text" name="id" id="ids" hidden>
             
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-window-close"></i> Close</button>
                      <button type="button" class="btn btn-primary update"><i class="spinner fas fa-spinner fa-spin"></i> <i class="fas fa-share-square"></i> Update</button>
                    </div>
                </form>
                  </div>
                </div>
              </div>
@endsection

@section('script')
    <script>
       $(document).ready(function(){
            $('.spinner').hide();
            $('#mytable').DataTable({
                order: [ [0, 'desc'] ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
            });

            if('{{session("success")}}'){
                    Swal.fire(
                    'Successfully!',
                    '{{session("success")}}',
                    'success'
                )
            }
            $('.add').on('click', function(){
                $('.spinner').show();
                $(this).prop('disabled', true);
                setTimeout(() => {
                    $('#addfrm').submit();    
                }, 500);
            })
            
            const Toast2 = Swal.mixin({
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            });
            if('{{count($errors)}}' > 0){
                $("#addcustomer").modal('show');
            }

            if("{{session('updated')}}"){
                Swal.fire(
                    'Successfully Updated!',
                    '{{session("updated")}}',
                    'success'
                )
            }

            if("{{session('deleted')}}"){
                Swal.fire(
                    'Customer Removed!',
                    '{{session("deleted")}}',
                    'success'
                )
            }

    //         if('{{session("erroredit")}}'){
    //             $("#edituser").modal('show');
    //             var err = '{{session("erroredit")}}';
    //             var errormessge = JSON.parse(err.replace(/&quot;/g,'"'))
    //             errormessge.username.map(i => {
    //                 $('.erroredit').html(i);
    //             })
    //             $('#usernamee').val('{{session("username")}}');
    //         }
    //         $('.add').on('click', function(){
    //             $('.spinner').show();
    //             $(this).attr('disabled', true);
    //             $('#addfrm').submit();
    //         })
            $('.edit').on('click', function() {
                var data = $(this).data('stuff');
                console.log(data);
                $('#editcustomer').modal('show');
                $('#fullnames').val(data[0]);
                $('#contact_nos').val(data[1]);
                $('#ids').val(data[2]);
                $('#addresss').val(data[3]);
                $('#discounts').val(data[4]);
                
                $('.update').on('click', function(){
                    $('.spinner').show();
                    $(this).attr('disabled', true);
                    $('#editfrm').attr('action',"{{route('customer.update','')}}" +'/'+ data[2]);
                    setTimeout(() => {
                        $('#editfrm').submit();
                    }, 500);
                })
            })
            $('.delete').click(function(e){
                e.preventDefault();
                var data = $(this).attr('data-id');
                Toast2.fire({
                    type: 'warning',
                    title: "Are you sure you want to delete this?"
                }).then((result) => {
                    if (result.value) {
                        $('.delete').unbind('click');
                        $('#'+data).submit();
                    }else{
                        e.preventDefault();
                    }
                })
            })
            $('.loading-spinner').hide();
        $('#blur').attr('id', 'notblur');
       })
    </script>
@endsection