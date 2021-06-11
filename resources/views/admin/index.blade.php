
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
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{Auth::user()->students()->count()}}</h3>

                                <p>دانشجویان</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
{{--                            <a href="{{route('users.index')}}" class="small-box-footer">اطلاعات بیشتر <i class="fas fa-arrow-circle-right"></i></a>--}}
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{Auth::user()->finishedStudents()->count()}}</h3>

                                <p>فارغ التحصیلان</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
{{--                            <a href="{{route('users.index')}}" class="small-box-footer">اطلاعات بیشتر <i class="fas fa-arrow-circle-right"></i></a>--}}
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>{{Auth::user()->masters()->count()}}</h3>

                                <p>اساتید</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
{{--                            <a href="{{route('users.index')}}" class="small-box-footer">اطلاعات بیشتر <i class="fas fa-arrow-circle-right"></i></a>--}}
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>{{\App\Models\Form::count()}}</h3>

                                <p>فرم ها</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-pie-graph"></i>
                            </div>
{{--                            <a href="#" class="small-box-footer">اطلاعات بیشتر <i class="fas fa-arrow-circle-right"></i></a>--}}
                        </div>
                    </div>
                    <!-- ./col -->
                </div>
                <!-- /.row -->
                <div class="card">
                    <div class="card-header">
                       خانه
                    </div>
                    <div class="card-body">
                        <div class="container">
                            <div  class="mt-3 mx-auto">
                                <h5>میانگین نظرات کلیه نقش های دانشگاه</h5>
                                <!-- Chart's container -->
                                <div id="chart3" style="height: 300px;"></div>
                                <!-- Your application script -->
                                <script>
                                    const chart3 = new Chartisan({
                                        el: '#chart3',
                                        data: {!! $chart3 !!},
                                    });
                                </script>
                                <hr>
                                <h5>میانگین نظرات دانشکده ها</h5>
                                <!-- Chart's container -->
                                <div id="chart" style="height: 300px;"></div>
                                <!-- Your application script -->
                                <script>
                                    const chart = new Chartisan({
                                        el: '#chart',
                                        data: {!! $chart !!},
                                    });
                                </script>
                                <hr>

{{--                                <h5>نظرسنجی دروس</h5>--}}
{{--                                <!-- Chart's container -->--}}
{{--                                <div id="lessons" style="height: 300px;"></div>--}}
{{--                                <hr>--}}
{{--                                <h5>نظرسنجی اساتید</h5>--}}
{{--                                <!-- Chart's container -->--}}
{{--                                <div id="masters" style="height: 300px;"></div>--}}
{{--                                <hr>--}}

                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
@section('js')

    <!-- Your application script -->
    <script>
        const chart2 = new Chartisan({
            el: '#lessons',
            url: "@chart('lesson_chart')",
        });
    </script>
    <!-- Your application script -->
    <script>
        const chart_2 = new Chartisan({
            el: '#masters',
            url: "@chart('master_chart')",
        });
    </script>
@endsection