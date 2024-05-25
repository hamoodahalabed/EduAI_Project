@extends('layouts.app')
@section('page-header')

<!-- breadcrumb -->
<link rel="shortcut icon" href="{{ URL::asset('assets/images/fiv.png') }}" type="image/x-icon" />
@endsection
@section('css')
<style>
    body{
    
        background-image: url({{ asset('assets/images/bg2.png') }});
    }
</style>
@endsection
@section('content')
<div class="container" >
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card " style="margin-top: 10%">
                <div class="card-header bg-success text-white">  {{trans('register_page.Student Register')}}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name_en" class="col-md-4 col-form-label text-md-right">{{trans('register_page.Name')}}</label>
                            <div class="col-md-6">
                                <input id="name_en" type="text" class="form-control @error('name_en') is-invalid @enderror" name="name_en" value="{{ old('name_en') }}" autocomplete="name_en" autofocus>
                                @error('name_en')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name_ar" class="col-md-4 col-form-label text-md-right">{{trans('register_page.Arabic Name')}}</label>
                            <div class="col-md-6">
                                <input id="name_ar" type="text" class="form-control @error('name_ar') is-invalid @enderror" name="name_ar" value="{{ old('name_ar') }}" autocomplete="name_ar">
                                @error('name_ar')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{trans('register_page.E-Mail Address')}}</label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="departments" class="col-md-4 col-form-label text-md-right">{{trans('teacher_courses.Department')}}</label>
                            <div class="col-md-6">
                                <select class="custom-select mr-sm-2 @error('departments') is-invalid @enderror" name="departments">
                                    <option selected disabled>{{trans('teacher_courses.Choose from the list')}}...</option>
                                    @foreach($departments as $department)
                                        <option value="{{ $department->id }}">{{ $department->Name }}</option>
                                    @endforeach
                                </select>
                                @error('departments')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="years" class="col-md-4 col-form-label text-md-right">{{trans('teacher_courses.Years')}}</label>
                            <div class="col-md-6">
                                <select class="custom-select mr-sm-2 @error('years') is-invalid @enderror" name="years">
                                    <option selected disabled>{{trans('teacher_courses.Choose from the list')}}...</option>
                                    @foreach($years as $year)
                                        <option value="{{ $year->id }}">{{ $year->Name }}</option>
                                    @endforeach
                                </select>
                                @error('years')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{trans('register_page.Password')}}</label>
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{trans('register_page.Confirm Password')}}</label>
                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-success">
                                    {{trans('register_page.Register')}}
                                </button>
                                <a href="{{ route('login.show', 'student') }}" class="btn btn-link">
                                    {{trans('register_page.Have an account? Login')}}
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
