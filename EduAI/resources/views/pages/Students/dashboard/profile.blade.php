@extends('layouts.master')
@section('css')
    @toastr_css
    @section('title')
    {{trans('student_profile.profile')}}
    @stop
@endsection
@section('page-header')
    <!-- breadcrumb -->
    @section('PageTitle')
    {{trans('student_profile.profile')}}
    @stop
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->



    <div class="card-body">

        <section style="background-color: #eee;">
            <div class="row">
                <div class="col-lg-4">
                    <div class="card mb-4">
                        <div class="card-body text-center">
                            <img src="{{URL::asset('assets/images/student.png')}}"
                                 alt="avatar"
                                 class="rounded-circle img-fluid" style="width: 150px;">
                            <h5 style="font-family: Cairo" class="my-3">{{$information->name}}</h5>
                            <p class="text-muted mb-1">{{$information->email}}</p>
                            <p class="text-muted mb-4">{{trans('student_profile.student')}}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="card mb-4">
                        <div class="card-body">
                            <form action="{{route('profile-student.update',$information->id)}}" method="post">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">    {{trans('student_profile.student name arabic')}}
                                        </p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="text-muted mb-0">
                                            <input type="text" name="Name_ar"
                                                   value="{{ $information->getTranslation('name', 'ar') }}"
                                                   class="form-control">
                                        </p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">   {{trans('student_profile.student name english')}} </p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="text-muted mb-0">
                                            <input type="text" name="Name_en"
                                                   value="{{ $information->getTranslation('name', 'en') }}"
                                                   class="form-control">
                                        </p>
                                    </div>
                                </div>
                                <hr>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="department"> {{trans('student_profile.department')}}<span class="text-danger"></span></label>
                                            <select class="form-control" name="department_id">
                                                <option value="" disabled>{{ trans('Select department') }}</option>
                                                @foreach($departments as $department)
                                                    <option value="{{ $department->id }}" @if($information->department_id == $department->id) selected @endif>{{ $department->Name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="year"> {{trans('student_profile.year')}} <span class="text-danger"></span></label>
                                            <select class="form-control" name="year_id">
                                                <option value="" disabled>{{ trans('Select Year') }}</option>
                                                @foreach($years as $year)
                                                    <option value="{{ $year->id }}" @if($information->year_id == $year->id) selected @endif>{{ $year->Name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0"> {{trans('student_profile.password')}}</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="text-muted mb-0">
                                            <input type="password" id="password" class="form-control" name="password">
                                        </p><br><br>
                                        <input type="checkbox" class="form-check-input" onclick="myFunction()"
                                               id="exampleCheck1">
                                        <label class="form-check-label" for="exampleCheck1"> {{trans('student_profile.show password')}}</label>
                                    </div>
                                </div>
                                <hr>
                                <button type="submit" class="button"> {{trans('student_profile.Edit Data')}}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- row closed -->
@endsection
@section('js')
    @toastr_js
    @toastr_render
    <script>
        function myFunction() {
            var x = document.getElementById("password");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>
@endsection

