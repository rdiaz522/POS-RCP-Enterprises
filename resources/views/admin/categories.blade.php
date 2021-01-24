@extends('layouts.admin')
@section('container-title')
    <h1>Category List </h1> 
@endsection

@section('content')
    <section> 
            <div class="box box-primary">
                    <div class="box-header with-border">
                        <a href="#" id="addnewcatag" data-target="#addcateg" data-toggle="modal" class="btn btn-success btn-sm pull-right"><i class="fas fa-plus-circle"></i> Add New Category</a>
                    </div><!-- /.box-header -->
                    <div class="container-fluid" style="margin-top: 1%">
                        <table class="table display nowrap" id="mytable" style="width: 100%">
                            <thead>
                                <tr>
                                    <th class="all">CATEGORY NAME</th>
                                    <th class="all">CREATED AT</th>
                                    <th>CREATED BY</th>
                                    <th class="all">CONTROL</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($categories) > 0)
                                    @foreach ($categories as $category)
                                        <tr>
                                        <td class="text-truncate" style="max-width:100px">{{$category->name}}</td>
                                        <td class="text-truncate" style="max-width:100px">{{$category->created_at->calendar()}}</td>
                                        <td class="text-truncate" style="max-width:100px">{{$category->created_by}}</td>
                                        <td>
                                        <form action="{{route('categories.destroy',$category->id)}}" method="POST" id="{{$category->id}}">
                                            @csrf
                                            @method('DELETE')
                                            <a href="#" class="edit btn btn-primary btn-sm" data-id="{{$category->id}}" data-name="{{$category->name}}"><i class="fas fa-pen"></i> Edit</a> 
                                            <button class="remove btn btn-danger btn-sm"  data-id="{{$category->id}}"><i class="fas fa-trash"></i> Remove</button>
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

    {{-- ADD CATEGORY MODAL --}}
    <div class="modal fade" id="addcateg" tabindex="-1" role="dialog" aria-labelledby="addcateglabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              <h3 class="modal-title" id="addcateglabel">New Category</h3>
            </div>
            <div class="modal-body">
            <form action="{{route('categories.store')}}" id="addfrm" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Category Name</label>
                    <input type="text" name="name" id="name" class="form-control @if($errors->first('name')) is-invalid  @endif" value="{{old('name')}}">
                    @if ($errors->first('name'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{$errors->first('name')}}</strong>
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

      {{-- EDIT CATEGORY MODAL --}}
      <div class="modal fade" id="editcateg" tabindex="-1" role="dialog" aria-labelledby="editcateglabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              <h3 class="modal-title" id="editcateglabel">Edit Category</h3>
            </div>
            <div class="modal-body">
            <form action="" method="POST" id="frmupdate">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="name">Category Name</label>
                    <input type="text" name="name" id="namee" class="form-control">
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-window-close"></i> Close</button>
              <button type="button" class="update btn btn-primary"><i class="spinner fas fa-spinner fa-spin"></i> <i class="fas fa-share-square"></i>Update</button>
            </div>
        </form>
          </div>
        </div>
      </div>
@endsection

@section('script')
    <script>
        $(document).ready(function(e){
            $('.loading-spinner').hide();
            $('.spinner').hide();
            $('#mytable').DataTable({
                responsive:true,
                order: [ [0, 'desc'] ]
            });

            const Toast2 = Swal.mixin({
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            });

            if("{{session('success')}}"){
                Swal.fire(
                    'New Category Added!',
                    '{{session("success")}}',
                    'success'
                )
            }

            if("{{session('update')}}"){
                Swal.fire(
                    'Category Updated!',
                    '{{session("update")}}',
                    'success'
                )
            }

            if("{{session('deleted')}}"){
                Swal.fire(
                    'Category Removed!',
                    '{{session("deleted")}}',
                    'success'
                )
            }
            if('{{session("errors")}}'){
                $('#addcateg').modal('show');
            }
            var id = 0;
            $('#namee').on('input', function(){
                if($(this).val() == ''){
                    $('.update').prop('disabled', true);
                }else{
                    $('.update').prop('disabled', false);
                }
            })
            $('.edit').on('click', function(){
                id = $(this).attr('data-id');
                $('#editcateg').modal('show');
                $('#namee').val($(this).attr('data-name'));
                var code = e.keyCode || e.which;
                $('.update').on('click', function(){
                    $('.spinner').show();
                    $(this).attr('disabled', true);
                    $('#frmupdate').attr('action',"{{route('categories.update','')}}"+'/'+id)
                    setTimeout(() => {
                        $('#frmupdate').submit();
                    }, 300);
                })
                $('#frmupdate').bind('keypress', function(e){
                    if(e.keyCode == 13){
                        return false;
                    }
                })
            })
            $('.remove').on('click', function(e){
                var cat_id = $(this).attr('data-id');
                e.preventDefault();
                Toast2.fire({
                    type: 'warning',
                    title: "Are you sure you want to delete this?"
                }).then((result) => {
                    if (result.value) {
                        $('.remove').unbind('click');
                        $('#'+cat_id).submit();
                    }else{
                        e.preventDefault();
                    }
                })
            })
            $('.add').on('click', function(){
                $('.spinner').show();
                $(this).attr('disabled', true);
                $('#addfrm').submit();

            })
        })
    </script>
@endsection