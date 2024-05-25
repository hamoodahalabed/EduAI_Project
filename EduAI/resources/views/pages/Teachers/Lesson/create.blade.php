@extends('layouts.master')
@section('css')
    @toastr_css

    <style>
        .buttonLe {
            background: #84ba3f;
            padding: 2px 3px;
            font-size: 1rem;
            letter-spacing: 1px;
            border: 0;
            color: #ffffff;
            text-transform: uppercase;
            font-weight: 500;
            display: inline-block;
            border-radius: 3px;
            text-align: center;
            border: 2px solid #84ba3f;
            cursor: pointer;
            -webkit-transition: all 0.5s ease;
            -moz-transition: all 0.5s ease;
            -ms-transition: all 0.5s ease;
            -o-transition: all 0.5s ease;
            transition: all 0.5s ease;
        }
    </style>
@section('title')
{{trans('teacher_courses.Add New Book')}}
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
@section('PageTitle')
{{trans('teacher_courses.Add New Book')}}
@stop
<!-- breadcrumb -->
@endsection
@section('content')
<!-- row -->
<div class="row">
    <div class="col-md-12 mb-30">
        <div class="card card-statistics h-100">
            <div class="card-body">

                @if (session()->has('error'))
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
                        <form style="display:inline" action="{{ route('Item.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-row">

                                <div class="col">
                                    <label for="title">{{trans('teacher_courses.Book Name')}}
                                    </label>
                                    <input type="text" name="title" class="form-control">
                                </div>
                                @error('title')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <br>

                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="sections">{{trans('teacher_courses.Sections')}}<span
                                            class="text-danger"></span></label>
                                    <select class="custom-select mr-sm-2" name="section_id">
                                        <option selected disabled>{{trans('teacher_courses.Choose from the list')}}
                                            ...</option>
                                        @foreach ($sections as $section)
                                            @if ($section->course_id == $current_id)
                                                <option value="{{ $section->id }}">{{ $section->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                @error('section_id')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                            </div>


                            <br>
                            <div class="form-row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="academic_section">{{trans('teacher_courses.Attachments')}}
                                            <span
                                                class="text-danger"></span></label>
                                        <input type="file" accept="application" name="file_name" required>
                                    </div>
                                </div>
                                @error('file_name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <button class="button" type="submit">{{trans('teacher_courses.Saving data')}}
                            </button>
                        </form>
                        <form style="display:inline" action="{{ route('lesson.editable', $current_id) }}" method="GET" class="mt-3">
                            <button type="submit" class="button-cancel">{{trans('teacher_courses.Return')}}
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
