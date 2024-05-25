<!DOCTYPE html>
<html lang="en" dir="rtl">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="keywords" content="HTML5 Template" />
    <meta name="description" content="Webmin - Bootstrap 4 & Angular 5 Admin Dashboard Template" />
    <meta name="author" content="potenzaglobalsolutions.com" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title>{{ trans('login_page.EduAi') }} </title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="images/favicon.ico" />

    <!-- Font -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Poppins:200,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900">

    <!-- css -->
    <link href="{{ URL::asset('assets/css/rtl.css') }}" rel="stylesheet">
    <link rel="shortcut icon" href="{{ URL::asset('assets/images/fiv.png') }}" type="image/x-icon" />
</head>

<body>
@php
if (!isset($isError)) {
    $isError=0;
}
    $bool=$isError;
@endphp
    <div class="wrapper">
        <!-- Preloader -->
        <div id="pre-loader">
            <img src="{{ URL::asset('assets/images/pre-loader/loader-01.svg') }}" alt="">
        </div>
        <!-- Preloader -->

        <!-- Login Section -->
        <section class="height-100vh d-flex align-items-center page-section-ptb login"
            style="background-image: url('{{ asset('assets/images/bg2.png') }}');">
            <div class="container">
                <div class="row justify-content-center no-gutters vertical-align">
                    <div class="col-lg-4 col-md-6 login-fancy-bg bg"
                        >
                        <div class="login-fancy text-center">
                            <h2 class="text-white mb-4 " style="font-size: 40px;">{{ trans('login_page.Welcome') }}
                                <br>{{ trans('login_page.To') }} <br>!{{ trans('login_page.EduAi') }}
                            </h2>
                            <p class="mb-4 text-white" style="font-size: 14px;">{{ trans('login_page.content') }}</p>
                            <ul class="list-unstyled pos-bot pb-3">
                                <li class="list-inline-item mb-2"><a class="text-white mr-4 p-5"
                                        href="{{ route('term') }}">{{ trans('login_page.Terms of Use') }}</a></li>
                                <li class="list-inline-item mb-2"><a class="text-white"
                                        href="{{ route('privacy') }}">{{ trans('login_page.Privacy Policy') }}</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 bg-white">
                        <div class="login-fancy pb-40 clearfix">
                            @if ($type == 'student')
                                <h3 style="font-family: 'Cairo', sans-serif" class="mb-30">
                                    {{ trans('login_page.Student') }} </h3>
                            @elseif($type == 'teacher')
                                <h3 style="font-family: 'Cairo', sans-serif" class="mb-30">
                                    {{ trans('login_page.Instructor') }}</h3>
                            @else
                                <h3 style="font-family: 'Cairo', sans-serif" class="mb-30">
                                    {{ trans('login_page.Admin') }}</h3>
                            @endif

                            @if (\Session::has('message'))
                                <div class="alert alert-danger">
                                    <li>{!! \Session::get('message') !!}</li>
                                </div>
                            @endif

                            <form method="POST" action="{{ route('login') }}" style="display:inline;">
                                @csrf

                                <div class="section-field mb-20">
                                    <label class="mb-10" for="name">{{ trans('login_page.Email') }}</label>
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}"  autocomplete="email" autofocus
                                        onchange="document.getElementById('user_email').value = this.value;">
                                    <input type="hidden" value="{{ $type }}" name="type">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="section-field mb-20">
                                    <label class="mb-10" for="Password"> {{ trans('login_page.password') }} </label>
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                         autocomplete="current-password">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group mb-0">
                                   
                                
                                   
                                    <button class="button"><span>{{ trans('login_page.Login') }}</span><i class="fa fa-check"></i></button>
                                   
                                
                                
                               
                            </form>
                             <!-- Forgot Password -->
                             <form method="POST" action="{{ route('forgetPassword') }}" style="display:inline;">
                                @csrf
                                <input id="user_email" type="hidden" name="user_email" value="{{ old('email') }}">
                                <input type="hidden" name="user_type" value="{{ $type }}">
                                <button type="submit" class="btn btn-link float-right">
                                    {{ trans('login_page.Forgot Your Password') }}
                                </button>
                            </form>
                        </div>
                        @if ($type == 'student')
                        <div class="mt-3">
                            <p>{{ trans('login_page.Dont have an account?') }} <a class="text-success"
                                    href="{{ route('register') }}">{{ trans('login_page.Register here') }}</a></p>
                        </div>
                    @endif
                        @if (session()->has('msg'))
                        <br>
                        <div id="message" style="color:{{ $isError == 2 ? 'red' : 'green' }}">
                            {{ session()->get('msg') }}
                        </div>
                    @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Login Section -->
    </div>

    <!-- jquery -->
    <script src="{{ URL::asset('assets/js/jquery-3.3.1.min.js') }}"></script>
    <!-- plugins-jquery -->
    <script src="{{ URL::asset('assets/js/plugins-jquery.js') }}"></script>
    <!-- plugin_path -->
    <script>
        var plugin_path = 'js/';
    </script>

    <!-- chart -->
    <script src="{{ URL::asset('assets/js/chart-init.js') }}"></script>
    <!-- calendar -->
    <script src="{{ URL::asset('assets/js/calendar.init.js') }}"></script>
    <!-- charts sparkline -->
    <script src="{{ URL::asset('assets/js/sparkline.init.js') }}"></script>
    <!-- charts morris -->
    <script src="{{ URL::asset('assets/js/morris.init.js') }}"></script>
    <!-- datepicker -->
    <script src="{{ URL::asset('assets/js/datepicker.js') }}"></script>
    <!-- sweetalert2 -->
    <script src="{{ URL::asset('assets/js/sweetalert2.js') }}"></script>
    <!-- toastr -->
    @yield('js')
    <script src="{{ URL::asset('assets/js/toastr.js') }}"></script>
    <!-- validation -->
    <script src="{{ URL::asset('assets/js/validation.js') }}"></script>
    <!-- lobilist -->
    <script src="{{ URL::asset('assets/js/lobilist.js') }}"></script>
    <!-- custom -->
    <script src="{{ URL::asset('assets/js/custom.js') }}"></script>
    <!-- toastr -->
    <script>
        $(function() {
            var isSet = "{{ $bool }}";
            if (isSet != 0) {
                var msg = "{{ Session::get('Msg') }}";
                var isError = "{{ $isError }}";
                if (msg !== "") {
                    if (isError == 2) {
                        toastr.error(msg);
                    } else if (isError == 1) {
                        toastr.success(msg);
                    }
                }
            }
        });
    </script>
</body>

</html>
