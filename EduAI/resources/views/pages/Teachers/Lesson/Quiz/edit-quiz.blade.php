@extends('layouts.master')
@section('css')

@section('title')
{{trans('teacher_courses.Edit Quiz')}}
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
@section('PageTitle')
{{trans('teacher_courses.Edit Quiz')}}

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
                            <form method="post" action="{{route('update.quiz', ['id' => $quiz->id, 'course_id' => $course_id, 'item_id'=>$item_id])}}">
                                @csrf
                                <div class="form-group">
                                    <input type="text" placeholder="Quiz Title" name="title" required class="form-control" value="{{ $quiz->title }}">
                                   

                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Duration in Minute" name="duration" type="number" value="{{ $quiz->duration  }}" required>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group text-left ">
                                        <label for="sections">{{trans('teacher_courses.Sections')}}
                                            <span class="text-danger"></span></label>
                                        <select class="custom-select mr-sm-2" name="section_id"  >
                                            <option selected disabled>{{trans('teacher_courses.Choose from the list')}}
                                                ...</option>
                                            @foreach($sections as $section)
                                            @if($section->course_id == $course_id)
                                            @if ($section->id == $item->section_id)
                                            <option selected value="{{ $section->id }}">{{ $section->name }}</option>
                                            @else
                                            <option value="{{ $section->id }}">{{ $section->name }}</option>
                                                @endif
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('sections')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="text-left">
                                    <button class="btn btn-success" type="submit">{{trans('teacher_courses.Edit')}}
                                    </button>
                                </div>
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

