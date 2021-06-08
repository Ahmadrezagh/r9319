@extends('layouts.panel')
@section('Forms')
    active
@endsection
@section('Form')
    active
@endsection
@section('title')
    @if(isset($form)) ویرایش فرم {{$form->name}} @else ساخت فرم @endif
@endsection
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">@if(isset($form)) ویرایش فرم {{$form->name}} @else ساخت
                            فرم @endif</h1>
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
                        <h3 class="card-title" style="float: right">@if(isset($form)) {{$form->name}} @else فرم
                            جدید @endif</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form @if(isset($form)) action="{{route('forms.update',$form->id)}}"
                              @else action="{{route('forms.store')}}" @endif method="POST">
                            @csrf
                            @if(isset($form))
                                @method('PATCH')
                            @endif
                            <div class="form-group">
                                <label for="exampleInputEmail1">نام فرم</label>
                                <input type="text" class="form-control" name="name"
                                       @if(isset($form)) value="{{$form->name}}" @endif required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">دروس</label>
                                <select class="js-example-basic-multiple form-control" name="lessons[]"
                                        multiple="multiple" style="width: 100%;">

                                    <option value="-1">انتخاب همه</option>
                                    @foreach($lessons as $lesson)
                                        <option value="{{$lesson->id}}"
                                                @if(isset($form) && $form->lessons)
                                                @foreach($form->lessons as $l)
                                                @if($l->id == $lesson->id)
                                                selected
                                                @endif
                                                @endforeach
                                                @endif
                                        >{{$lesson->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">دانشکده ها</label>
                                <select class="js-example-basic-multiple form-control" name="colleges[]"
                                        multiple="multiple" style="width: 100%;">
                                    <option value="-1">انتخاب همه</option>
                                    @foreach($colleges as $college)
                                        <option value="{{$college->id}}"
                                                @if(isset($form) && $form->colleges)
                                                @foreach($form->colleges as $c)
                                                @if($c->id == $college->id)
                                                selected
                                                @endif
                                                @endforeach
                                                @endif
                                        >{{$college->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="feds" value="1" class="custom-control-input" id="customCheck1" @if(isset($form) && $form->feds == 1) checked @endif >
                                <label class="custom-control-label" for="customCheck1"  >واحد آموزش کل دانشگاه </label>
                            </div>
                            <div id="row">
                                @if(isset($form))
                                    @php
                                    $c = 1;
                                    @endphp
                                    @foreach($form->questions as $q)
                                        @if($c == 1)
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">متن سوال</label>
                                                <div class="row">
                                                    <div class="col-11">
                                                        <input type="text" name="questions[]" class="form-control" value="{{$q->question}}" required>
                                                    </div>
                                                    <div class="col-1">
                                                        <button type="button" class="btn btn-success pluss">+</button>
                                                    </div>
                                                </div>
                                            </div>
                                            @php
                                                $c = 2;
                                            @endphp
                                        @else
                                            <div class="form-group removable" >
                                            <div class="row">
                                                <div class="col-11">
                                                    <input type="text" name="questions[]" value="{{$q->question}}"  class="form-control" required>
                                                </div>
                                                <div class="col-1">
                                                    <button type="button" class="btn btn-danger minus" onclick="$(this).parents('.removable').remove()">-</button>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    @endforeach
                                    @else
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">متن سوال</label>
                                        <div class="row">
                                            <div class="col-11">
                                                <input type="text" name="questions[]" class="form-control"  required>
                                            </div>
                                            <div class="col-1">
                                                <button type="button" class="btn btn-success pluss">+</button>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <button type="submit" class="btn btn-primary">ثبت</button>
                        </form>
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
        $(document).ready(function () {
            $('.js-example-basic-multiple').select2();
        });
    </script>
    <script>
        var x;
        $('.pluss').on('click', function () {
            x = Math.random();
            $('#row').append(`
                                <div class="form-group removable" >
                                    <div class="row">
                                        <div class="col-11">
                                            <input type="text" name="questions[]" class="form-control" required>
                                        </div>
                                        <div class="col-1">
                                            <button type="button" class="btn btn-danger minus" onclick="$(this).parents('.removable').remove()">-</button>
                                        </div>
                                    </div>
                                </div>
            `);
        });


    </script>
@endsection