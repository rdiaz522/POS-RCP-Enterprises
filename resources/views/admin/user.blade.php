@extends('layouts.admin')
@section('container-title')
    <h1>User Management</h1>
@endsection
@section('content')
   <section>
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                       @can('admin')
                       <a href="#" id="addnewuser" data-target="#adduser" data-toggle="modal" class="btn btn-success btn-sm pull-right"><i class="fas fa-plus-circle"></i> Add New User</a>
                       @endcan
                      </div><!-- /.box-header -->
                      <div class="container-fluid">
                        <table class="table" id="mytable" width="100%">
                            <thead>
                                 <tr>
                                     <th>USERNAME</th>
                                     <th>ROLE</th>
                                     <th>CREATED AT</th>
                                     <th>CONTROL</th>
                                 </tr>
                            </thead>
                            <tbody>
                                    @if (count($users) > 0)
                                        @foreach ($users as $user)
                                        <tr>
                                          <td>{{$user->username}}</td>
                                            @foreach ($user->roles as $roles)
                                             <td>{{$roles->name}}</td>
                                            @endforeach
                                          <td>{{$user->created_at->calendar()}}</td>  
                                          <td>
                                        @can('admin')
                                          <form action="{{route('user.destroy',$user->id)}}" id="{{$user->id}}" method="POST">
                                                @foreach ($user->roles as $roles)
                                                <a href="#" class="edit btn btn-primary btn-sm" data-stuff='[&#34;{{$user->username}}&#34;, &#34;{{$roles->name}}&#34;, &#34;{{$user->id}}&#34;,&#34;{{$user->password}}&#34;]'>Edit</a>
                                                @endforeach
                                                @csrf
                                                @method('DELETE')
                                                @if ($user->id !== 1)
                                                    <button type="submit" class="btn btn-danger btn-sm delete" data-id="{{$user->id}}">Delete</button>
                                                @endif
                                          </form>
                                          @endcan
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
    {{-- ADD USER MODAL --}}
    <div class="modal fade" id="adduser" tabindex="-1" role="dialog" aria-labelledby="adduserlabel" aria-hidden="true">
            <div class="modal-dialog modal-sm">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                  <h3 class="modal-title" id="adduserlabel">New User</h3>
                </div>
                <div class="modal-body">
                <form action="{{route('user.store')}}" id="addfrm" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name">Username</label>
                        <input type="text" name="username" id="username" class="form-control @if($errors->first('username')) is-invalid  @endif" value="{{old('username')}}">
                        @if ($errors->first('username'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{$errors->first('username')}}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="name">Password</label>
                        <input type="password" name="password" id="password" class="form-control @if($errors->first('password')) is-invalid  @endif" value="{{old('password')}}">
                        @if ($errors->first('password'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{$errors->first('password')}}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="name">Role</label>
                        <select name="role" id="role" class="form-control">
                            <option value="1" @if(1 == old('role')) selected @endif>Admin</option>
                            <option value="2" @if(2 == old('role')) selected @endif>Cashier</option>
                            <option value="3" @if(3 == old('role')) selected @endif>Staff</option>
                        </select>
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
   
          {{-- EDIT USER --}}
          <div class="modal fade" id="edituser" tabindex="-1" role="dialog" aria-labelledby="edituserlabel" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                      <h3 class="modal-title" id="editsupplabel">Edit User</h3>
                    </div>
                    <div class="modal-body">
                        <span class="erroredit text-danger"></span>
                    <form action="" id="editfrm" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name">Username</label>
                            <input type="text" name="username" id="usernamee" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="name">Password</label>
                            <input type="password" name="password" id="passworde" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="name">Role</label>
                            <select name="rolee" id="rolee" class="form-control">
                                <option id="admin" value="Admin">Admin</option>
                                <option value="Cashier">Cashier</option>
                                <option value="Staff">Staff</option>
                             </select>
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
            const Toast2 = Swal.mixin({
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            });
            if('{{count($errors)}}' > 0){
                $("#adduser").modal('show');
            }
            
            if("{{session('success')}}"){
                Swal.fire(
                    'Successfully Registered!',
                    '{{session("success")}}',
                    'success'
                )
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
                    'User Removed!',
                    '{{session("deleted")}}',
                    'success'
                )
            }

            if('{{session("erroredit")}}'){
                $("#edituser").modal('show');
                var err = '{{session("erroredit")}}';
                var errormessge = JSON.parse(err.replace(/&quot;/g,'"'))
                errormessge.username.map(i => {
                    $('.erroredit').html(i);
                })
                $('#usernamee').val('{{session("username")}}');
            }
            $('.add').on('click', function(){
                $('.spinner').show();
                $(this).attr('disabled', true);
                $('#addfrm').submit();
            })
            $('.edit').on('click', function() {
                var data = $(this).data('stuff');
                $('#edituser').modal('show');
                $('#usernamee').val(data[0]);
                $('#passworde').val(data[3]);
                $('#rolee').val(data[1]).change();
                if(data[2] == 1) {
                    $('#rolee > option[value="Staff"').hide();
                    $('#rolee > option[value="Cashier"').hide();
                } else{
                    $('#rolee > option[value="Staff"').show();
                    $('#rolee > option[value="Cashier"').show();
                }
                $('.update').on('click', function(){
                    $('.spinner').show();
                    $(this).attr('disabled', true);
                    $('#editfrm').attr('action',"{{route('user.update','')}}" +'/'+ data[2]);
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