
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
                        {{Auth::user()->role->first()->name}} - فرم ها
                    </div>
                    <div class="card-body">
                        <div class="container">
                            <div class="accordion" id="accordionExample">
                                @if(Auth::user()->isMaster())
                                    <h5>نتایج نظرسنجی درباره شما</h5>
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
                                    <!-- Chart's container -->
                                    <div id="chart2" style="height: 300px;"></div>
                                    <!-- Your application script -->
                                    <script>
                                        const chart2 = new Chartisan({
                                            el: '#chart2',
                                            data: {!! $chart2 !!},
                                        });
                                    </script>
                                @endif
                                @if(Auth::user()->can('toMaster'))
                                    <h4>فرم های نظرسنجی اساتید</h4>
                                    @foreach(Auth::user()->studentLessons as $lesson)
                                        @if($lesson->form())
                                            <div class="card">
                                                <div class="card-header" id="headingTwo">
                                                    <h2 class="mb-0">
                                                        <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#lesson{{$lesson->id}}" aria-expanded="false" aria-controls="collapseTwo">
                                                            {{$lesson->name}}
                                                        </button>
                                                    </h2>
                                                </div>
                                                <div id="lesson{{$lesson->id}}" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                                    <div class="card-body">
                                                        <h5>نام استاد : {{$lesson->master->first()->name}}</h5>
                                                        @if(Auth::user()->CompletedForm($lesson->id,get_class($lesson)))
                                                            <button disabled class="btn btn-primary">شما قبلا در این آزمون شرکت نموده اید</button>
                                                        @else
                                                            <a href="{{route('user.lessonForms.show',$lesson->id)}}" class="btn btn-primary">شرکت در نظرسنجی</a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                @endif
                                @if(Auth::user()->can('toEducation'))
                                <h4>فرم های نظرسنجی دانشکده</h4>
                                    @if(Auth::user()->isStudent() || Auth::user()->isFinishedStudent())
                                            @foreach(Auth::user()->studentColleges() as $college)
                                                @if($college->form())
                                                    <div class="card">
                                                        <div class="card-header" id="headingThree">
                                                            <h2 class="mb-0">
                                                                <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                                    {{$college->name}}
                                                                </button>
                                                            </h2>
                                                        </div>
                                                        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                                                            <div class="card-body">
                                                                @if(Auth::user()->CompletedForm($college->id,get_class($college)))
                                                                    <button disabled class="btn btn-primary">شما قبلا در این آزمون شرکت نموده اید</button>
                                                                @else
                                                                    <a href="{{route('user.educationForms.show',$college->id)}}" class="btn btn-primary">شرکت در نظرسنجی</a>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                    @elseif(Auth::user()->isMaster())
                                            @foreach(Auth::user()->masterColleges() as $college)
                                                @if($college->form())
                                                    <div class="card">
                                                        <div class="card-header" id="headingThree">
                                                            <h2 class="mb-0">
                                                                <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                                    {{$college->name}}
                                                                </button>
                                                            </h2>
                                                        </div>
                                                        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                                                            <div class="card-body">
                                                                @if(Auth::user()->CompletedForm($college->id,get_class($college)))
                                                                    <button disabled class="btn btn-primary">شما قبلا در این آزمون شرکت نموده اید</button>
                                                                @else
                                                                    <a href="{{route('user.educationForms.show',$college->id)}}" class="btn btn-primary">شرکت در نظرسنجی</a>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                    @endif
                                @endif
                                @if(Auth::user()->can('toAllEducation'))
                                        <h4>فرم های نظرسنجی بخش کل آموزش</h4>
                                        @foreach(\App\Models\Form::where('feds',1)->take(1)->get() as $form)
                                            <div class="card">
                                                <div class="card-header" id="headingTwo">
                                                    <h2 class="mb-0">
                                                        <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#form{{$form->id}}" aria-expanded="false" aria-controls="collapseTwo">
                                                            {{$form->name}}
                                                        </button>
                                                    </h2>
                                                </div>
                                                <div id="form{{$form->id}}" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                                    <div class="card-body">
                                                        @if(Auth::user()->CompletedFormAllEducation())
                                                            <button disabled class="btn btn-primary">شما قبلا در این آزمون شرکت نموده اید</button>
                                                        @else
                                                            <a href="{{route('user.allEducationForms.show',$form->id)}}" class="btn btn-primary">شرکت در نظرسنجی</a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
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
