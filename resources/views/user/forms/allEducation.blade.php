
@extends('layouts.panel')
@section('title')
    {{$form->name}}
@endsection
@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">نظرسنجی سیستم کل آموزش</h1>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <!-- /.row -->
                <div class="card">
                    <div class="card-header">
                         {{$form->name}}
                    </div>
                    <div class="card-body">
                        <div class="container">

                            <form action="{{route('user.allEducationForms.update',$form->id)}}" method="POST">
                                @csrf
                                @method('PATCH')
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th scope="col">سوال</th>
                                        <th scope="col">پاسخ</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($form->questions as $q)
                                        <tr>
                                            <td>{{$q->question}}</td>
                                            <td>
                                                @foreach(\App\Models\Answer::all() as $a)
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="questions[{{$q->id}}]" id="inlineRadio1" value="{{$a->id}}" required>
                                                        <label class="form-check-label" for="inlineRadio1">{{$a->name}}</label>
                                                    </div>
                                                @endforeach
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <button class="btn btn-primary mt-3">
                                    ثبت نظرسنجی
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection