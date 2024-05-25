<!DOCTYPE html>
<html lang="en">
@section('title')
{{trans('main_trans.Main_title')}}
@stop
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="keywords" content="HTML5 Template" />
    <meta name="description" content="Webmin - Bootstrap 4 & Angular 5 Admin Dashboard Template" />
    <meta name="author" content="potenzaglobalsolutions.com" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@600&display=swap" rel="stylesheet">
    @include('layouts.head')
</head>

<body style="font-family: 'Cairo', sans-serif">

    <div class="wrapper" style="font-family: 'Cairo', sans-serif">

        <!--=================================
 preloader -->

 <div id="pre-loader">
     <img src="{{ URL::asset('assets/images/pre-loader/loader-01.svg') }}" alt="">
 </div>

        <!--=================================
 preloader -->

        @include('layouts.main-header')

        @include('layouts.main-sidebar')

        <!--=================================
 Main content -->
        <!-- main-content -->
        <div class="content-wrapper">
            <div class="page-title" >
                <div class="row">
                    <div class="col-md-12 mb-30">
                        <div class="card card-statistics h-100">
                            <div class="card-body">
                        @php
                        // Get the student's ID
                        $studentId = auth()->id();

                        // Get all courses for this student
                        $courses = DB::table('student_course')->where('student_id', $studentId)->get();

                        // Initialize counters
                        $zeroPercent = $lessThanFiftyPercent = $fiftyToHundredPercent = $hundredPercent = 0;

                        foreach ($courses as $course) {
                            // Get the student's progress in this course
                            $studentCourse = DB::table('student_course')
                                ->where('student_id', $studentId)
                                ->where('course_id', $course->course_id)
                                ->first();

                            $checkedItemsCounter = $studentCourse ? $studentCourse->checked_items_counter : 0;
                            $totalItems = DB::table('courses')->where('id', $course->course_id)->first()->item_counter;
                            $percent = ($totalItems > 0) ? ($checkedItemsCounter / $totalItems) * 100 : 0;

                            // Categorize the student based on their progress
                            if ($percent == 0) {
                                $zeroPercent++;
                            } elseif ($percent > 0 && $percent < 50) {
                                $lessThanFiftyPercent++;
                            } elseif ($percent >= 50 && $percent < 100) {
                                $fiftyToHundredPercent++;
                            } elseif ($percent == 100) {
                                $hundredPercent++;
                            }
                        }
                        @endphp

                            <h4 class="mb-0" style="font-family: 'Cairo', sans-serif"> {{trans('student_dashboard.welcome')}} {{auth()->user()->name}}</h4>
                            <div class="container" style="width: 100%; display:block;height:50vh">
                                @if($zeroPercent>0||$lessThanFiftyPercent>0||$fiftyToHundredPercent>0||$hundredPercent>0)
                                    <canvas id="myChart" style="width: 100%; height: 75%;"></canvas>
                                @else
                                    <canvas id="myEmptyChart" style="width: 100%; height: 75%;"></canvas>
                                @endif
                            </div>

                        </div></div>
                        <br><br>
                    <div class="col-sm-6">
                        <ol class="breadcrumb pt-0 pr-0 float-left float-sm-right">
                        </ol>
                    </div>
                </div>
            </div>

            </div>
            <!--=================================
 wrapper -->

            <!--=================================
 footer -->

            @include('layouts.footer')
        </div><!-- main content wrapper end-->
    </div>
    </div>
    </div>
    <!--=================================
 footer -->

    @include('layouts.footer-scripts')
    @stack('scripts')
    <script>
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Recently Enrolled courses', 'Inprogress courses (less than 50)', 'Inprogress courses (more than 50)', 'Completed courses'],
                datasets: [{
                    label: '# of Votes',
                    data: [{{$zeroPercent}}, {{$lessThanFiftyPercent}}, {{$fiftyToHundredPercent}}, {{$hundredPercent}}],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.8)',

                        'rgba(255, 206, 86, 0.8)',

                        'rgba(153, 102, 255, 0.8)',
                        'rgba(255, 159, 64, 0.8)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',

                        'rgba(255, 206, 86, 1)',

                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
            }
        });


    </script>
    <script>var ctx = document.getElementById('myEmptyChart').getContext('2d');
        var myEmptyChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['NO DATA!!'],
                datasets: [{
                    label: '# of Votes',
                    data: [100],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.8)'

                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)'

                    ],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
            }
        });</script>
</body>

</html>
