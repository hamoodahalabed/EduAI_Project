@extends('layouts.master')
@section('css')
    @toastr_css
@section('title')
{{trans('teacher_courses.Edit book')}} --{{$item->name}}--
@stop
@endsection
@section('page-header')
    <!-- breadcrumb -->
@section('PageTitle')
--{{$item->name}}-- {{trans('teacher_courses.Edit book')}} 
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
                            <form action="{{route('Item.update','test')}}" method="post" enctype="multipart/form-data">
                                @method('PUT')
                                @csrf
                                <div class="form-row">

                                    <div class="col">
                                        <label for="title">{{trans('teacher_courses.Book Name')}}
                                        </label>
                                        <input type="text" name="title" value="{{ old('name', isset($item) ? $item->name : '') }}"class="form-control">
                                        <input type="hidden" name="id" value="{{$item->id}}" class="form-control">
                                    </div>

                                </div>
                                <br>

                                <div class="form-row">
                                    <div class="col">
                                        @php
                                        $filePath = public_path('attachments/') . 'Items/' . $item->file_name;
                                        $mimeType = mime_content_type($filePath);

                                    @endphp

@if(strpos($mimeType, 'video') !== false)
<video controls width="500" height="300">
    <source src="{{ URL::asset('attachments/items/'.$item->file_name) }}" type="{{ $mimeType }}">
    Your browser does not support the video tag.
</video>
@elseif(strpos($mimeType, 'image') !== false)
<img src="{{ URL::asset('attachments/items/'.$item->file_name) }}" width="500" height="300" alt="Image">
@elseif(strpos($mimeType, 'application/pdf') !== false)
<embed src="{{ URL::asset('attachments/items/'.$item->file_name) }}" type="application/pdf" height="500" width="500">
@else
<!-- Fallback for other file types -->
<a href="{{ URL::asset('attachments/items/'.$item->file_name) }}" target="_blank">{{trans('teacher_courses.Download')}}</a>
@endif
<br>
<br>

                                        <div class="form-group">
                                            <label for="academic_section">{{trans('teacher_courses.Attachments')}}<span class="text-danger"></span></label>
                                            <input type="file" accept="application/pdf"  name="file_name">
                                        </div>

                                    </div>
                                </div>
<br>
<div class="col-md-5">
    <div class="form-group text-left ">
        <label for="sections">{{trans('teacher_courses.Sections')}}<span class="text-danger"></span></label>
        <select class="custom-select mr-sm-2" name="section_id" required >
            <option selected disabled>{{trans('teacher_courses.Choose from the list')}}...</option>
            @foreach($sections as $section)
                @if($section->course_id == $current_id)
                @if($item->section_id == $section->id)
                <option selected  value="{{ $section->id }}">{{ $section->name }}</option>
                @else
                <option  value="{{ $section->id }}">{{ $section->name }}</option>
                @endif
                @endif
            @endforeach
        </select>
    </div> 
</div> 
                                <button class="btn btn-success btn-sm nextBtn btn-lg pull-right" type="submit">{{trans('teacher_courses.Saving data')}}</button>
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
    <script>
        $(document).ready(function () {
            $('select[name="Grade_id"]').on('change', function () {
                var Grade_id = $(this).val();
                if (Grade_id) {
                    $.ajax({
                        url: "{{ URL::to('classes') }}/" + Grade_id,
                        type: "GET",
                        dataType: "json",
                        success: function (data) {
                            $('select[name="Class_id"]').empty();
                            $.each(data, function (key, value) {
                                $('select[name="Class_id"]').append('<option value="' + key + '">' + value + '</option>');
                            });
                        },
                    });
                } else {
                    console.log('AJAX load did not work');
                }
            });
        });
    </script>
@endsection
