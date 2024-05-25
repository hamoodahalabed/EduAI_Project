@extends('layouts.master')
@section('css')
    @toastr_css

@section('title')
{{trans('admin_student.add_student')}}
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
@section('PageTitle')
{{trans('admin_student.add_student')}}
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

                <form method="post" action="{{ route('Students.store') }}" autocomplete="off"
                    enctype="multipart/form-data">
                    @csrf
                    <h6 style="font-family: 'Cairo'">{{trans('admin_student.personal_information')}}</h6>

                    <br>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{trans('admin_student.name_ar')}} <span
                                        class="text-danger"></span></label>
                                <input type="text" name="name_ar" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{trans('admin_student.name_en')}} <span
                                        class="text-danger"></span></label>
                                <input class="form-control" name="name_en" type="text">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{trans('admin_student.email')}} </label>
                                <input type="email" name="email" class="form-control">
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{trans('admin_student.password')}}</label>
                                <input type="password" name="password" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="department">{{trans('admin_student.department')}} <span
                                        class="text-danger"></span></label>
                                <select class="custom-select mr-sm-2" name="department_id">
                                    <option selected disabled>{{ trans('Parent_trans.Choose') }}...</option>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}">{{ $department->Name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div  class="col-md-3">
                            <div class="form-group">
                                <label for="year">{{trans('admin_student.year')}} <span
                                        class="text-danger"></span></label>
                                <select class="custom-select mr-sm-2" name="year_id">
                                    <option selected disabled>{{ trans('Parent_trans.Choose') }}...</option>
                                    @foreach ($years as $year)
                                        <option value="{{ $year->id }}">{{ $year->Name }}</option>
                                    @endforeach
                                </select>

                            </div>

                        </div>
                        <div style="margin-top: 2%;display: block;width: 100%;margin-right: 1.3%">
                            <button class="button" type="submit">{{trans('admin_student.submit')}}</button>
                        </div>

                    </div>

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
