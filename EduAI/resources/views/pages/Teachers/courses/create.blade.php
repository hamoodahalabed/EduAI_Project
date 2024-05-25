@extends('layouts.master')
@section('css')
    @toastr_css
@section('title')
{{trans('teacher_courses.Add New')}}
@stop
@endsection
@section('page-header')
    <!-- breadcrumb -->
@section('PageTitle')
{{trans('teacher_courses.Add New')}}
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
                            <form action="{{route('courses.store')}}" method="post" enctype="multipart/form-data">
                             @csrf
                             @if(auth('teacher')->check())
                             <input type="hidden" value="{{Auth::user()->id}}" name="teacher_id"/>
                              @endif
                            <div class="form-row">
                                <div class="col">
                                    <label for="title">{{trans('teacher_courses.Title')}}
                                        </label>
                                    <input type="text" id="title" name="title" class="form-control" value="{{ old('title', isset($course) ? $course->title : '') }}"   >
                                    @error('title')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col">
                                    <label for="title">{{trans('teacher_courses.Description')}}
                                        </label>
                                    <input id="desccription" name="description" rows="5" class="form-control" value="{{ old('description', isset($course) ? $course->description : '') }}" >
                                    @error('description')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <br>


                           
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label
                                        for="academic_year">{{trans('teacher_courses.Course Image')}}

                                        : <span class="text-danger"></span></label>
                                    <input type="file" accept="image/*" name="photos"   required>
                                  
                                    @error('photos')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <br>

            <div class="col-md-5 ">
                <div class="form-group ">
                    <label for="departments" class="">{{trans('teacher_courses.Department')}}
                        <span class="text-danger"></span></label>
                    <select class="custom-select mr-sm-2" name="departments[]"   multiple>
                        <option selected disabled>{{trans('teacher_courses.Choose from the list')}}...</option>
                        @foreach($departments as $department)
                            <option  value="{{ $department->id }}">{{ $department->Name }}</option>
                        @endforeach
                    </select>
                </div>
                @error('departments')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

<br>
            <div class="col-md-5">
                <div class="form-group text-left ">
                    <label for="years">{{trans('teacher_courses.Years')}}
                        <span class="text-danger"></span></label>
                    <select class="custom-select mr-sm-2" name="years"  >
                        <option selected disabled>{{trans('teacher_courses.Choose from the list')}}...</option>
                        @foreach($years as $year)
                            <option  value="{{ $year->id }}">{{ $year->Name }}</option>
                        @endforeach
                    </select>
                </div>
                @error('years')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
                            <br>

                            <div class="form-group ">
                                <label for="published">{{trans('teacher_courses.Published')}}
                                </label>
                                <select name="published" class="form-control" id="published" >
                                    <option value="1">Active</option>
                                    <option value="0">In Active</option>
                                </select>
                                @error('published')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <br>



                            <button class="btn btn-success btn-sm nextBtn btn-lg pull-right" type="submit">{{trans('teacher_courses.Add')}}
                            </button>
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
