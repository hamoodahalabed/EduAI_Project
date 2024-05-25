<!DOCTYPE html>
<html lang="en">
@section('title')
{{trans('teacher_dashboard.EduAi')}}
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
        @php
        // Get the teacher's ID
$teacherId = auth()->id();

// Get all courses for this teacher
$courses = DB::table('courses')->where('teacher_id', $teacherId)->get();

// Initialize counters
$zeroPercent = $lessThanFiftyPercent = $fiftyToHundredPercent = $hundredPercent = 0;

foreach ($courses as $course) {
    // Get all students who took this course
    $students = DB::table('student_course')
    ->where('course_id', $course->id)
    ->join('students', 'student_course.student_id', '=', 'students.id')
    ->select('students.*')
    ->get();


    foreach ($students as $student) {
        // Get the student's progress in this course
        $studentCourse = DB::table('student_course')
            ->where('student_id', $student->id)
            ->where('course_id', $course->id)
            ->first();

        $checkedItemsCounter = $studentCourse ? $studentCourse->checked_items_counter : 0;
        $totalItems = $course->item_counter;
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
}



        @endphp
        <div class="content-wrapper">
            <div class="page-title" >
                <div class="row">
                    <div class="col-sm-6" >
                        <h4 class="mb-0" style="font-family: 'Cairo', sans-serif">    {{trans('teacher_dashboard.welcome')}} {{auth()->user()->Name}}</h4>
                    </div><br><br>
                    <div class="col-sm-6">
                        <ol class="breadcrumb pt-0 pr-0 float-left float-sm-right">
                        </ol>
                    </div>
                </div>
            </div>
           
            <!-- Orders Status widgets-->

            <div class="card card-statistics ">
                        <div class="card-body">
                            <!-- Introductory sentence for the chatbot -->
   <div class="chatbot-intro">
    <p>{{trans('teacher_dashboard.welcome2')}} <a href="{{route('chat.index')}}" style="color:#198754">{{trans('teacher_dashboard.here')}}</a> {{trans('teacher_dashboard.chat')}}.</p>
</div>
            <div class="container" style="width: 50%">
        @if($zeroPercent>0||$lessThanFiftyPercent>0||$fiftyToHundredPercent>0||$hundredPercent>0)
    <canvas id="myChart"></canvas>
@else
<canvas id="myEmptyChart"></canvas>
    @endif

    </div></div>


    </div>
            <div class="row">

                <div  style="height: 400px;" class="col-xl-12 mb-30">
                    <div class="card card-statistics h-100">
                        <div class="card-body">
                            <div class="tab nav-border" style="position: relative;">
                                <div class="d-block d-md-flex justify-content-between">
                                    <div class="d-block w-100">
                                        <h5 style="font-family: 'Cairo', sans-serif" class="card-title">{{trans('teacher_dashboard.Latest on system operations')}}
                                        </h5>
                                    </div>
                                    <div class="d-block d-md-flex nav-tabs-custom">
                                        <ul class="nav nav-tabs" id="myTab" role="tablist">


                                        </ul>
                                    </div>
                                </div>
                                <div class="tab-content" id="myTabContent"></div>


                                    {{-- teachers Table --}}
<div class="tab-pane fade show active" id="teachers" role="tabpanel" aria-labelledby="teachers-tab">
    <div class="table-responsive mt-15">

        <table style="text-align: center" class="table center-aligned-table table-hover mb-0">
            <thead>
                <tr class="table-info text-danger">
                    <th>#</th>
                    <th>{{trans('teacher_dashboard.Instructor Name')}}
                    </th>
                    <th> {{trans('teacher_dashboard.Date of hiring')}}
                    </th>
                    <th>{{trans('teacher_dashboard.Date added')}}
                    </th>
                </tr>
            </thead>
            @forelse(\App\Models\Teacher::latest()->take(5)->get() as $teacher)
            <tbody>
                @if (auth()->id() == $teacher->id )
                    
                
                <tr>

                    <td>{{$loop->iteration}}</td>
                    <td>{{$teacher->Name}}</td>
                    <td>{{$teacher->Joining_Date}}</td>
                    <td class="text-success">{{$teacher->created_at}}</td>
                </tr>
                @endif
            </tbody>
            @empty
            <tbody>
                <tr>
                    <td class="alert-danger" colspan="8">{{trans('teacher_dashboard.data')}}
                         </td>
                </tr>
            </tbody>
            @endforelse
        </table>
        <br> <br> <br>
    </div>
</div>

   

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                @include('layouts.footer')
            </div>


            <!--=================================
 wrapper -->

            <!--=================================
 footer -->


        </div><!-- main content wrapper end-->
    </div>
    </div>
    </div>

    <!--=================================
 footer -->

 @include('layouts.footer-scripts')

    <script>
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Recently Enrolled students', 'Inprogress Students (less than 50)', 'Inprogress Students (more than 50)', 'Completed courses students'],
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
