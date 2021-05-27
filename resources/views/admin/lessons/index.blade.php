
@extends('layouts.panel')
@section('Lessons')
    active
@endsection
@section('Lesson')
    active
@endsection
@section('title')
    دروس
@endsection
@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">مدیریت دروس </h1>
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
                        <h3 class="card-title" style="float: right">دروس</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <button class="btn btn-primary" data-toggle="modal" data-target="#modal-create">ایجاد درس</button>

                        <!-- Create Modal -->
                        <div class="modal fade" id="modal-create">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" style="float:right;">ایجاد درس</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- form start -->
                                        <form  method="POST" action="{{route('lessons.store')}}"  enctype="multipart/form-data">
                                            @csrf
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">نام</label>
                                                    <input name="name" type="text" class="form-control" id="exampleInputEmail1" placeholder="نام درس" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="js-example-basic-multiple">استاد مربوطه</label>
                                                    <select class="js-example-basic-multiple form-control" name="master" required style="width: 100%;">
                                                        @foreach($masters as $master)
                                                            <option value="{{$master->id}}" >{{$master->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <!-- /.card-body -->

                                            <div class="card-footer">
                                                <button type="submit" class="btn btn-primary">ثبت</button>
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
                                <th>نام</th>
                                <th>عملیات</th>
                            </tr>
                            </thead>
                            <tbody >
                            @foreach ($lessons as $lesson)
                                <tr>
                                    <td>
                                        {{$lesson->name}}
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-sliders-h"></i>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                            <button type="button" class="btn btn-success dropdown-item" data-toggle="modal" data-target="#modal-edit{{$lesson->id}}" >ویرایش</button>
                                            <button type="button" class="dropdown-item" data-toggle="modal" data-target="#modal-delete{{$lesson->id}}" >حذف</button>
                                        </div>
                                    </td>

                                </tr>
                                <!-- Delete Modal -->
                                <div class="modal fade" id="modal-delete{{$lesson->id}}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">حذف درس</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <h5>آیا در حذف درس `{{$lesson->name}}` مطمین هستید؟ </h5>
                                            </div>
                                            <div class="modal-footer justify-content-between">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">بستن</button>
                                                <form action="{{route('lessons.destroy',$lesson->id)}}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">حذف</button>

                                                </form>

                                            </div>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                                <!-- /.modal -->

                                <!-- /.modal -->
                                <!-- Change Modal -->
                                <div class="modal fade" id="modal-edit{{$lesson->id}}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">ویرایش درس</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <!-- form start -->
                                                <form  method="POST" action="{{route('lessons.update',$lesson->id)}}"  enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="id" value="{{$lesson->id}}">
                                                    <div class="card-body">
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1">نام</label>
                                                            <input name="name" type="text" class="form-control" id="exampleInputEmail1" placeholder="نام درس" required value="{{$lesson->name}}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="js-example-basic-multiple">استاد مربوطه</label>
                                                            <select class="js-example-basic-multiple form-control" name="master" required style="width: 100%;" >
                                                                @foreach($masters as $master)
                                                                    <option value="{{$master->id}}"
                                                                            @if($lesson->master)
                                                                            @foreach($lesson->master as $m)
                                                                            @if($m->id == $master->id)
                                                                            selected
                                                                            @endif
                                                                            @endforeach
                                                                            @endif
                                                                    >{{$master->name}}</option>
                                                                @endforeach
                                                            </select>
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
        $(document).ready(function() {
            $('.js-example-basic-multiple').select2();
        });
    </script>
@endsection