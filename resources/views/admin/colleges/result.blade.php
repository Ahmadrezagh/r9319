
@extends('layouts.panel')
@section('Colleges'.$college->id)
    active
@endsection
@section('College')
    active
@endsection
@section('title')
    {{$college->name}}
@endsection
@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">نتایج نظرسنجی دانکشده ها </h1>
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
                        <h3 class="card-title" style="float: right">{{$college->name}}</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <!-- Chart's container -->
                        <div id="chart" style="height: 300px;"></div>
                        <!-- Your application script -->
                        <script>
                            const chart = new Chartisan({
                                el: '#chart',
                                data: {!! $chart !!},
                            });
                        </script>
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