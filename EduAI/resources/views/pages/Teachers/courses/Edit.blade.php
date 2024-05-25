@extends('layouts.master')
@section('css')
    @toastr_css
@section('title')
{{trans('teacher_courses.Course Edit')}}
@stop
@endsection
@section('page-header')
    <!-- breadcrumb -->
@section('PageTitle')
{{trans('teacher_courses.Course Edit')}}
@stop
<!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row">
        <div class="col-md-12 mb-30">
            <div class="card card-statistics h-100">
                <div class="card-body">

                    @if(session()->has('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>{{ session()->get('error') }}</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <div class="col-xs-12">
                        <div class="col-md-12">
                            <br>
                            <form action="{{route('courses.update', $course->id)}}" method="post" enctype="multipart/form-data">
                                @method('put')
                                @csrf
                             @if(auth('teacher')->check())
                             <input type="hidden" value="{{Auth::user()->id}}" name="teacher_id"/>
                             <input type="hidden" value="{{$course->id}}" name="id"/>

                             @endif
                            <div class="form-row">
                                <div class="col">
                                    <label for="title">{{trans('teacher_courses.Title')}}
                                    </label>
                                    <input type="text" id="title" name="title" class="form-control" value="{{ old('title', isset($course) ? $course->title : '') }}" >
                                    @error('title')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <br>


                            <div class="form-row">


                            </div>
                            <br>
                            <div class="form-group ">
                                <label for="published">{{trans('teacher_courses.Published')}}
                                </label>
                                <select name="published" class="form-control" id="published">
                                    <option {{ $course->published == 'Active' ? 'selected' : null }} value="1">Active</option>
                                    <option {{ $course->published == 'Inactive' ? 'selected' : null }} value="0">In Active</option>
                                </select>
                                @error('published')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <br>

                            <div class="form-row">
                                <div class="col">
                                    <label for="title">{{trans('teacher_courses.Course Image')}}
                                        </label>
                                    <div class='input-group date'>
                                        <input type="file" id="course_image" name="course_image" class="form-control" value="{{ old('course_image', isset($course) ? $course->course_image : '') }}">
                                    </div>
                                    @error('Joining_Date')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <br>
                          
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="departments">{{trans('teacher_courses.Department')}}<span class="text-danger"></span></label>
                                    <select class="custom-select mr-sm-2" name="departments[]"  multiple>
                                        <option selected disabled>{{trans('teacher_courses.Choose from the list')}}...</option>
                                        @foreach($departments as $department)
                                        @if(in_array($department->id, $course->Department->pluck('id')->toArray()))
                                       <option selected value="{{ $department->id }}">{{ $department->Name }}</option>
                                         @else
                                         <option value="{{ $department->id }}">{{ $department->Name }}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>



                            <div class="col-md-5">
                                <div class="form-group text-left">
                                    <label for="years">{{trans('teacher_courses.Years')}}</label>
                                    <select class="custom-select mr-sm-2" name="years"  >
                                        <option selected disabled>{{trans('teacher_courses.Choose from the list')}}...</option>
                                        @foreach($years as $year)
                                            @if($course->year_id === $year->id)
                                            <option selected  value="{{ $year->id }}">{{ $year->Name }}</option>
                                            @else
                                            <option  value="{{ $year->id }}">{{ $year->Name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">{{trans('teacher_courses.Description')}}</label>
                                <textarea id="description" name="description" rows="5" class="form-control" >{{ old('description', isset($course) ? $course->description : '') }}</textarea>
                                @error('Address')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <button class="btn btn-success btn-sm nextBtn btn-lg pull-right" type="submit">{{trans('teacher_courses.Edit')}}</button>
                    </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- row closed -->
@endsection
@section('js')
    @toastr_js
    @toastr_render
@endsection
