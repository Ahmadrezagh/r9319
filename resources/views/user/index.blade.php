
@extends('layouts.panel')
@section('home','active')
@section('title')
    خانه
@endsection
@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">خانه</h1>
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
                        {{Auth::user()->role->first()->name}}
                    </div>
                    <div class="card-body">
                        <div class="container">
                            <h5>نقش شما : {{Auth::user()->role->first()->name}}</h5>
                            <h4>لیست دسترسی های شما:</h4>
                            @foreach(Auth::user()->role->first()->permissions as $p)
                                <p>{{$p->persian_name}}</p>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
