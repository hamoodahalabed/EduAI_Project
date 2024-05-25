@extends('layouts.master')
@section('css')
    @toastr_css
@section('title')
{{trans('admin_student.Student_Edit')}}
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
@section('PageTitle')
{{trans('admin_student.Student_Edit')}}
@stop
<!-- breadcrumb -->
@endsection
@section('content')
<!-- row -->
<div class="row">
    <div class="col-md-12 mb-30">
        <div class="card card-statistics h-100">
            <div class="card-body">

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                    <form action="{{route('Students.update','test')}}" method="post" autocomplete="off">
                        @method('PUT')
                        @csrf
                        <h6 style="font-family: 'Cairo', sans-serif;">{{trans('admin_student.personal_information')}}</h6><br>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{trans('admin_student.name_ar')}} <span class="text-danger"></span></label>
                                    <input value="{{$Students->getTranslation('name','ar')}}" type="text" name="name_ar"  class="form-control">
                                    <input type="hidden" name="id" value="{{$Students->id}}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{trans('admin_student.name_en')}} <span class="text-danger"></span></label>
                                    <input value="{{$Students->getTranslation('name','en')}}" class="form-control" name="name_en" type="text" >
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{trans('admin_student.email')}}</label>
                                    <input type="email" value="{{ $Students->email }}" name="email" class="form-control" >
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{trans('admin_student.password')}} </label>
                                    <input value="{{null}}" type="password" name="password" class="form-control" >
                                    @error('password')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>



                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="department">{{ trans('admin_student.department') }} <span class="text-danger"></span></label>
                                    <select class="custom-select mr-sm-2" name="department_id">
                                        <option selected disabled>{{ trans('Select department') }}</option>
                                        @foreach($departments as $department)
                                            <option value="{{ $department->id }}" @if($Students->department_id == $department->id) selected @endif>{{ $department->Name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>




                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="year">{{trans('admin_student.year')}} <span class="text-danger"></span></label>
                                    <select class="custom-select mr-sm-2" name="year_id">
                                        <option selected disabled>{{ trans('Select Year') }}</option>
                                        @foreach($years as $year)
                                            <option value="{{ $year->id }}" @if($Students->year_id == $year->id) selected @endif>{{ $year->Name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>



                        </div>

                   <br>
                    <button class="btn btn-success btn-sm nextBtn btn-lg pull-right" type="submit">{{trans('admin_student.submit')}}</button>
                </form>

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
