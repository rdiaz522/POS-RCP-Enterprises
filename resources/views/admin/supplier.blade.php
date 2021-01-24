@extends('layouts.admin')
@section('container-title')
    <h1>Supplier Management</h1>
@endsection
@section('content')
   <section>
        <div class="box box-primary">
            <div class="box-header with-border">
                <a href="#" id="addnewsupp" data-target="#addsupp" data-toggle="modal" class="btn btn-success btn-sm pull-right"><i class="fas fa-plus-circle"></i> Add New Supplier</a>
            </div><!-- /.box-header -->  
            <div class="container-fluid" style="margin-top: 1%">
                <table class="table display nowrap" id="mytable" style="width: 100%">
                    <thead>
                      <tr>
                         <th>SUPPLIER NAME</th>
                         <th>ADDRESS</th>
                         <th>CONTACT NO.</th>
                         <th>CREATED AT</th>
                         <th>CREATED BY</th>
                         <th>CONTROL</th>
                     </tr>
                    </thead>
                    <tbody>
                         @if (count($suppliers) > 0)
                             @foreach ($suppliers as $supplier)
                                 <tr>
                                     <td class="text-truncate" style="max-width:100px">{{$supplier->name}}</td>
                                     <td class="text-truncate" style="max-width:100px">{{$supplier->address}}</td>
                                     <td class="text-truncate" style="max-width:100px">{{$supplier->contact_no}}</td>
                                     <td class="text-truncate" style="max-width:100px">{{$supplier->created_at->calendar()}}</td>
                                     <td class="text-truncate" style="max-width:100px">{{$supplier->created_by}}</td>
                                 <td>
                                 <form action="{{route('supplier.destroy',$supplier->id)}}" method="POST" id="{{$supplier->id}}">
                                     @csrf
                                     @method('DELETE')
                                     <a href="#" class="edit btn btn-primary btn-sm" data-stuff='[&#34;{{$supplier->id}}&#34;, &#34;{{$supplier->name}}&#34;, &#34;{{$supplier->address}}&#34;, &#34;{{$supplier->contact_no}}&#34;]'><i class="fas fa-pen"></i> Edit</a> 
                                 <button type="submit" class="btn btn-danger btn-sm remove" data-id="{{$supplier->id}}"><i class="fas fa-trash"></i> Remove</button>
                                 </form></td>
                                 </tr>
                             @endforeach
                         @endif
                    </tbody>
                 </table>
            </div>
        </div>
   </section>
     {{-- ADD SUPPLIER MODAL --}}
     <div class="modal fade" id="addsupp" tabindex="-1" role="dialog" aria-labelledby="addsupplabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              <h3 class="modal-title" id="addsupplabel">New Supplier</h3>
            </div>
            <div class="modal-body">
            <form action="{{route('supplier.store')}}" id="addfrm" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Supplier Name</label>
                    <input type="text" name="name" id="name" class="form-control @if($errors->first('name')) is-invalid  @endif" value="{{old('name')}}">
                    @if ($errors->first('name'))
                        <span class="invalid-feedback text-danger" role="alert">
                            <strong>{{$errors->first('name')}}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="name">Address</label>
                    <input type="text" name="address" id="address" class="form-control @if($errors->first('address')) is-invalid  @endif" value="{{old('address')}}">
                    @if ($errors->first('address'))
                        <span class="invalid-feedback text-danger" role="alert">
                            <strong>{{$errors->first('address')}}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="name">Contact No.</label>
                    <input type="text" name="contact_no" id="contact_no" class="form-control @if($errors->first('contact_no')) is-invalid  @endif" value="{{old('contact_no')}}">
                    @if ($errors->first('contact_no'))
                        <span class="invalid-feedback text-danger" role="alert">
                            <strong>{{$errors->first('contact_no')}}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-window-close"></i> Close</button>
              <button type="submit" class="btn btn-primary add"><i class="spinner fas fa-spinner fa-spin"></i> <i class="fas fa-share-square"></i> Add</button>
            </div>
        </form>
          </div>
        </div>
      </div>

      {{-- EDIT SUPPLIER MODAL --}}
     <div class="modal fade" id="editsupp" tabindex="-1" role="dialog" aria-labelledby="editsupplabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              <h3 class="modal-title" id="editsupplabel">Edit Supplier</h3>
            </div>
            <div class="modal-body">
                <span class="errors text-danger"></span>
            <form action="" id="editfrm" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="namee">Supplier Name</label>
                    <input type="text" name="namee" id="namee" class="form-control" value="{{old('namee')}}">
                </div>
                <div class="form-group">
                    <label for="addresse">Address</label>
                    <input type="text" name="addresse" id="addresse" class="form-control" value="{{old('addresse')}}">
                </div>
                <div class="form-group">
                    <label for="contact_noe">Contact No.</label>
                    <input type="text" name="contact_noe" id="contact_noe" class="form-control" value="{{old('contact_noe')}}">
                </div>
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
            $('#namee').on('input', function(){
                if($(this).val() !== ''){
                    $('.update').prop('disabled', false);
                }else{
                    $('.update').prop('disabled', true);
                }
            })
            const Toast2 = Swal.mixin({
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            });

            if("{{session('success')}}"){
                Swal.fire(
                    'New Supplier Added!',
                    '{{session("success")}}',
                    'success'
                )
            }

            if("{{session('updated')}}"){
                Swal.fire(
                    'Supplier Updated!',
                    '{{session("updated")}}',
                    'success'
                )
            }

            if('{{count($errors)}}' > 0){
                $("#addsupp").modal('show');
            }
            if('{{session("erroring")}}'){
                $("#editsupp").modal('show');
                $('.errors').html('{{session("erroring")}}');
            }

            $('.add').on('click', function(){
                $('.spinner').show();
                $(this).attr('disabled', true);
                $('#addfrm').submit();
            })

            $('.edit').on('click', function() {
                var data = $(this).data('stuff');
                $('#editsupp').modal('show');
                $('#namee').val(data[1]);
                $('#addresse').val(data[2]);
                $('#contact_noe').val(data[3]);
                $('.update').on('click', function(){
                    $('.spinner').show();
                    $(this).attr('disabled', true);
                    $('#editfrm').attr('action',"{{route('supplier.update','')}}" +'/'+ data[0]);
                    setTimeout(() => {
                        $('#editfrm').submit();
                    }, 500);
                })
            })

            $('.remove').click(function(e){
                e.preventDefault();
                var data = $(this).attr('data-id');
                Toast2.fire({
                    type: 'warning',
                    title: "Are you sure you want to delete this?"
                }).then((result) => {
                    if (result.value) {
                        $('.remove').unbind('click');
                        $('#'+data).submit();
                    }else{
                        e.preventDefault();
                    }
                })
            })
       })
    </script>
@endsection