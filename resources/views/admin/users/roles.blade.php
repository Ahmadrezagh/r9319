@extends('layouts.panel')
@section('userRoles')
    active
@endsection
@section('User')
    active
@endsection

@section('title')
    نقش کاربران
@endsection
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">نقش ها و دسترسی ها</h1>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title" style="float: right">نقش ها</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
{{--                        <button class="btn btn-primary create-btn" data-toggle="modal" data-target="#modal-create">ایجاد نقش جدید</button>--}}

                        <!-- Create Modal -->
                        <div class="modal fade" id="modal-create">
                            <div class="modal-dialog ">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">ایجاد نقش جدید</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- form start -->
                                        <form  method="POST" action="{{route('userRoles.store')}}"  enctype="multipart/form-data">
                                            @csrf
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1" style="float: right">نام نقش</label>
                                                    <input name="name" type="text" class="form-control" id="exampleInputEmail1" placeholder="نام نقش" required>
                                                </div>
                                                <div class="row col-md-12">
                                                    <div class="form-check col-md-12">
                                                        <input class="form-check-input"  id="checkAllCreate" type="checkbox" >
                                                        <label class="form-check-label" for="checkAllCreate">
                                                            <h4>انتخاب همه</h4>
                                                        </label>
                                                    </div>
                                                    @foreach($permissions as $permission)
                                                        <div class="form-check col-12 mt-3">
                                                            <input class="form-check-input allCreate" name="permissions[]" type="checkbox" value="{{ $permission->name }}" id="defaultCheck1">
                                                            <label class="form-check-label" for="defaultCheck1">
                                                               <h5> {{$permission->persian_name}}</h5>
                                                            </label>

                                                        </div>
                                                    @endforeach

                                                </div>
                                            </div>
                                            <!-- /.card-body -->
                                            <div class="card-footer">
                                                <button type="submit" class="btn btn-primary">ایجاد</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                        <!-- /.modal -->

                        <table id="table" class="table table-bordered table-striped text-center">
                            <thead>
                            <tr>
                                <th style="width: 15%">شناسه پایگاه داده</th>
                                <th>نام نقش</th>
                                <th>عملیات</th>
                            </tr>
                            </thead>
                            <tbody >
                            @foreach ($roles as $role)
                                <tr>
                                    <td >{{$role->id}}</td>
                                    <td>
                                        {{$role->name}}
                                    </td>
                                    <td class="text-center">
                                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-sliders-h"></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                                <button type="button" class="btn btn-success dropdown-item" data-toggle="modal" data-target="#modal-edit{{$role->id}}" >ویرایش</button>
                                                @if(!setting('defaultRole') || setting('defaultRole') != $role->id)
{{--                                                <button type="button" class="dropdown-item" data-toggle="modal" data-target="#modal-delete{{$role->id}}" >حذف</button>--}}
                                                @endif
                                            </div>
                                    </td>

                                </tr>
                                @if(!setting('defaultRole') || setting('defaultRole') != $role->id)
                                <!-- Delete Modal -->
                                <div class="modal fade" id="modal-delete{{$role->id}}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">حذف نقش</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <h5>آیا در حذف نقش  `{{$role->name}}`  مطمین هستید؟</h5>
                                            </div>
                                            <div class="modal-footer justify-content-between">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">بستن</button>
                                            <form action="{{route('userRoles.destroy',$role->id)}}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                                <button type="submit" class="btn btn-danger">حدف</button>
                                            </form>
                                            </div>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                                <!-- /.modal -->
                                @endif
                                <!-- /.modal -->
                                <!-- Change Modal -->
                                <div class="modal fade" id="modal-edit{{$role->id}}">
                                    <div class="modal-dialog ">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">ویرایش نقش</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <!-- form start -->
                                                <form  method="POST" action="{{route('userRoles.update',$role->id)}}"  enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="id" value="{{$role->id}}">
                                                    <div class="card-body">
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1">نام</label>
                                                            <input name="name" type="text" class="form-control" id="exampleInputEmail1" placeholder="نام نقش" required value="{{$role->name}}" disabled>
                                                        </div>
                                                        <div class="row col-md-12">
                                                            <div class="form-check col-md-12">
                                                                <input class="form-check-input"  id="checkAll" type="checkbox" >
                                                                <label class="form-check-label" for="checkAll">
                                                                    <h5>انتخاب همه</h5>
                                                                </label>
                                                            </div>
                                                        @foreach($permissions as $permission)
                                                            <div class="form-check col-md-12 mt-3">
                                                                <input class="form-check-input all" name="permissions[]" type="checkbox" value="{{ $permission->name }}" @if($role->permissions){{ $role->permissions->contains($permission) ? 'checked' : '' }}@endif id="defaultCheck1">
                                                                <label class="form-check-label" for="defaultCheck1">
                                                                    <h5>{{$permission->persian_name}}</h5>
                                                                </label>
                                                            </div>
                                                        @endforeach
                                                        </div>
                                                    </div>
                                                    <!-- /.card-body -->

                                                    <div class="card-footer">
                                                        <button type="submit" class="btn btn-primary">ویرایش</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                                <!-- /.modal -->
                                @endforeach

                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->

            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
@section('js')
    <script>
        $('#checkAll').click(function () {
            checked = $("#checkAll").prop('checked')
            if(checked)
            {
                $(".all").prop("checked",true)
            }else{

                $(".all").prop("checked",false)
            }
        })
        $('#checkAllCreate').click(function () {
            checked = $("#checkAllCreate").prop('checked')
            if(checked)
            {
                $(".allCreate").prop("checked",true)
            }else{

                $(".allCreate").prop("checked",false)
            }
        })
    </script>
@endsection
