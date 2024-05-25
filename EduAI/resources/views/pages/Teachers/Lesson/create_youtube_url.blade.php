@extends('layouts.master')
@section('css')
    @toastr_css
@endsection
@section('title')
    {{trans('teacher_courses.Add New Youtube Link')}}

@endsection
@section('page-header')
    <!-- breadcrumb -->
@endsection
@section('PageTitle')
{{trans('teacher_courses.Add New Youtube Link')}}

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
                            <form style="display:inline" action="{{route('Item.storeURL')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-row">
                                    <input type="hidden" name="file_name" value="Youtube_Video">

                                    <div class="col">
                                        <label for="title">{{trans('teacher_courses.Vedio Name')}}
                                        </label>
                                        <input type="text" name="title" class="form-control">
                                        @error('title')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <br>
                                <div class="form-row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="title">    {{trans('teacher_courses.Youtube Link')}}
                                            </label>
                                            <input type="text" name="youtube_url" class="form-control"/>
                                            @error('youtube_url')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="sections">    {{trans('teacher_courses.Sections')}}
                                            <span class="text-danger"></span></label>
                                        <select class="custom-select mr-sm-2" name="section_id"  >
                                            <option selected disabled>    {{trans('teacher_courses.Choose from the list')}}
                                                ...</option>
                                            @foreach($sections as $section)
                                            @if($section->course_id == $current_id)
                                                <option  value="{{ $section->id }}">{{ $section->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>

                                    @error('section_id')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button class="button" type="submit">     {{trans('teacher_courses.Saving data')}}
                                </button>

                            </form>
                            <form style="display:inline" action="{{ route('lesson.editable', $current_id) }}" method="GET" class="mt-3">
                                <button type="submit" class="button-cancel">    {{trans('teacher_courses.Return')}}
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
