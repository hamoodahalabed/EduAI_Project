@extends('layouts.master')
@section('css')

@section('title')
{{trans('teacher_courses.Add New Quiz')}}
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
@section('PageTitle')
{{trans('teacher_courses.Add New Quiz')}}

@stop
<!-- breadcrumb -->
@endsection
@section('content')
<!-- row -->
<div class="row">
    <div class="col-md-12 mb-30">
        <div class="card card-statistics h-100">
            <div class="card-body">
                <div>
                    <div>
                        <div>
                            <form style="display:inline" method="post" action="{{route('store.quiz')}}">
                                @csrf
                                <div class="form-group">
                                    <input type="text" placeholder="{{trans('teacher_courses.Quiz Title')}}" name="title" required class="form-control">
                                    

                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="{{trans('teacher_courses.Duration in Minute')}}" name="duration" type="number" required>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group ">
                                        <label for="sections">{{trans('teacher_courses.Sections')}}<span class="text-danger"></span></label>
                                        <select class="custom-select mr-sm-2" name="section_id"  >
                                            <option selected disabled>{{trans('teacher_courses.Choose from the list')}}...</option>
                                            @foreach($sections as $section)
                                            @if($section->course_id == $current_id)
                                                <option  value="{{ $section->id }}">{{ $section->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('sections')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                    <button class="button" type="submit">{{trans('teacher_courses.Add')}}</button>
                                
                            </form>
                            <form style="display:inline" action="{{ route('lesson.editable', $current_id) }}" method="GET" class="mt-3">
                                <button type="submit" class="button-cancel">{{trans('teacher_courses.Return')}}</button>
                            </form>
                        </div>
                    </div>
                </div>
                        </div>
        </div>
    </div>
</div>
<!-- row closed -->
@endsection
@section('js')

@endsection





















