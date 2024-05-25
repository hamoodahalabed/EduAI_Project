@extends('layouts.master')
@section('css')

@section('title')
    {{trans('teacher_courses.Quiz List')}}
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
@section('PageTitle')
{{trans('teacher_courses.Quiz List')}}

@stop
<!-- breadcrumb -->
@endsection
@section('content')
<!-- row -->
<div class="row">
    <div class="col-md-12 mb-30">
        <div class="card card-statistics h-100">
            <div class="card-body">

                <div class="text-center">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">{{trans('teacher_courses.Title')}} </th>
                              
                                <th scope="col">{{trans('teacher_courses.Duration')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $sl = 1;
                            @endphp
                            @foreach ($quiz_list as $quiz)
                                <tr>
                                    <th scope="row">{{ $sl++ }}</th>
                                    <td><a href="/add-question/{{ $quiz->id }}"
                                            target="_blank">{{ $quiz->title }}</a></td>
                           
                                    <td>{{ $quiz->duration }} {{trans('teacher_courses.minutes')}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <form style="display:inline" action="{{ route('lesson.editable', $current_id) }}" method="GET"
                    class="mt-3">
                    <button type="submit" class="button-cancel">{{trans('teacher_courses.Return')}}</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- row closed -->
@endsection
@section('js')

@endsection
