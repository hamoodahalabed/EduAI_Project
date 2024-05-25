@extends('layouts.master')
@section('css')

@section('title')
{{trans('admin_courseOverview.course-overview')}}
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
@section('PageTitle')
{{trans('admin_courseOverview.course-overview')}}
@stop
<!-- breadcrumb -->
@endsection
@section('content')
<!-- row -->
<div class="row">
    <div class="col-md-12 mb-30">
        <div class="card card-statistics h-100">
            <div class="card-body">
                <table id="datatable" class="table  table-hover table-sm table-bordered p-0"
                data-page-length="50"
                style="text-align: center">
             <thead>
             <tr>
                 <th>#</th>
                 <th>{{trans('admin_courseOverview.Course Name')}} </th>
                 <th>{{trans('admin_courseOverview.Students')}}</th>
                 <th>{{trans('admin_courseOverview.Completion')}}</th>
             </tr>
             </thead>
             <tbody>
             <?php $i = 0; ?>
             @foreach($Courses as $Course)
             @php
    $completedStudentsCount = 0;

    foreach ($Course->students as $student) {
        $studentCourse = DB::table('student_course')
            ->where('student_id', $student->id)
            ->where('course_id', $Course->id)
            ->first();

        $checkedItemsCounter = $studentCourse ? $studentCourse->checked_items_counter : 0;
        $totalItems = $Course->item_counter;

        if ($checkedItemsCounter == $totalItems) {
            $completedStudentsCount++;
        }
    }
@endphp
                 <tr>
                 <?php $i++; ?>
                 <td>{{ $i }}</td>
                 <td>{{$Course->title}}</td>
                 <td>{{ $Course->students->count() }}</td>  <!-- Display the count of students enrolled -->
                 <td>{{ $completedStudentsCount }}</td>
                </tr>

               
             @endforeach
         </table>
            </div>
        </div>
    </div>
</div>
<!-- row closed -->
@endsection
@section('js')

@endsection
