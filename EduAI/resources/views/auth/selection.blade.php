<!DOCTYPE html>
<html lang="en" dir="rtl">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="keywords" content="HTML5 Template" />
    <meta name="description" content="Webmin - Bootstrap 4 & Angular 5 Admin Dashboard Template" />
    <meta name="author" content="potenzaglobalsolutions.com" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title> {{trans('Selection_page.EduAi')}} </title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="images/favicon.ico" />

    <!-- Font -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Poppins:200,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900">

    <!-- css -->
    <link href="{{ URL::asset('assets/css/rtl.css') }}" rel="stylesheet">
    <link rel="shortcut icon" href="{{ URL::asset('assets/images/fiv.png') }}" type="image/x-icon" />
    <style>
        #section-title {
            font-size: 2em;
            color: #198754;
            text-transform: uppercase;
            position: relative;
            animation: fadeIn 2s;
            
        }

        #about-title {
            font-size: 2em;
            color: #198754;
            text-transform: uppercase;
            position: relative;
            animation: fadeIn 2s;
            
        }

        #section-login {
            font-size: 2em;
            color: #198754;
            position: relative;
            animation: fadeIn 2s;
            
        }
        
        #section-title::after {
            content: "";
            width: 50px;
            position: absolute;
            left: 50%;
            bottom: -5px;
            transform: translateX(-50%);
        }
        
        #card-body {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            animation: fadeIn 2s;
        }
        
        #card-body p {
    color: #6c757d;
    line-height: 1.6;
    animation: fadeIn 2s;
    text-align: <?php echo App::getLocale() == 'ar' ? 'right' : 'left'; ?>;
} 

#card-text  {
    color: #6c757d;
    line-height: 1.6;
    animation: fadeIn 2s;
    text-align: <?php echo App::getLocale() == 'ar' ? 'right' : 'left'; ?>;
} 



        
        #card-body p:hover {
            color: #198754;
            transition: color 0.3s ease;
        }
        
        @keyframes fadeIn {
            from {opacity: 0;}
            to {opacity: 1;}
        }

        ::-webkit-scrollbar {
  width: 20px;
}

::-webkit-scrollbar-track {
  background-color: transparent;
}

::-webkit-scrollbar-thumb {
  background-color: #61a083;
  border-radius: 20px;
  border: 6px solid transparent;
  background-clip: content-box;
}

::-webkit-scrollbar-thumb:hover {
  background-color: #a8bbbf;
}
        </style>
        
</head>

<body>
    
       
    <div class="wrapper" >
        <section  class="height-120vh d-flex align-items-center page-section-ptb login" style="background-image: url('{{ asset('assets/images/bg2.png')}}');">
            
            <div class="container" >
             
                <div class="row justify-content-center">
                   
                    <div class="col-lg-8 col-md-8">
                        <div class="card border-0 rounded-lg">
                            <div class="card-body p-5" >
                                <h2 id="section-title" class="text-center mb-4">{{trans('Selection_page.About Us')}}</h2>
                                <div id="card-body" class="text-center">
                                    <p>{{trans('Selection_page.p1')}}</p>
                                    <p>{{trans('Selection_page.p2')}}</p>
                                    <p>{{trans('Selection_page.p3')}}</p>
                                    <p>{{trans('Selection_page.p4')}}</p>
                                    <p>{{trans('Selection_page.p5')}}</p>
                                </div>
                                
                                <hr>
                                <h3 class="text-center mb-4" id="section-login"  style="font-family: 'Cairo', sans-serif;">{{trans('Selection_page.Select the login method')}}  </h3>
                                <div class="row justify-content-center">
                                    <div class="col-lg-4 col-md-4 mb-4">
                                        <a  title="{{trans('Selection_page.Student')}}" href="{{route('login.show','student')}}">
                                            <img class="img-fluid" alt="طالب" src="{{URL::asset('assets/images/student.png')}}">
                                            <div class="text-center mt-2">{{trans('Selection_page.Student')}}</div>
                                        </a>
                                    </div>
                                    <div class="col-lg-4 col-md-4 mb-4">
                                        <a  title="{{trans('Selection_page.Instructor')}}" href="{{route('login.show','teacher')}}">
                                            <img class="img-fluid" alt="معلم" src="{{URL::asset('assets/images/teacher.png')}}">
                                            <div class="text-center mt-2">{{trans('Selection_page.Instructor')}}</div>
                                        </a>
                                    </div>
                                    <div class="col-lg-4 col-md-4 mb-4">
                                        <a  title="{{trans('Selection_page.Admin')}}" href="{{route('login.show','admin')}}">
                                            <img class="img-fluid" alt="ادمن" src="{{URL::asset('assets/images/admin.png')}}">
                                            <div class="text-center mt-2">{{trans('Selection_page.Admin')}} </div>
                                        </a>
                                    </div>
                                </div>
                                <hr>
                                <h2 class="section-title text-center mb-4" id="about-title">{{trans('Selection_page.Contact Us')}}</h2>
                                    <p id="card-text">{{trans('Selection_page.Contact text')}} <a href="mailto:eduai8194@gmail.com" style="color:#198754">{{trans('Selection_page.Click Here')}}</a> </p> 
                                  

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    
    <!-- jquery -->
    <script src="{{ URL::asset('assets/js/jquery-3.3.1.min.js') }}"></script>
    <!-- plugins-jquery -->
    <script src="{{ URL::asset('assets/js/plugins-jquery.js') }}"></script>
    <!-- plugin_path -->
    <script>
        var plugin_path = 'js/';

    </script>


    <!-- toastr -->
    @yield('js')
    <!-- custom -->
    <script src="{{ URL::asset('assets/js/custom.js') }}"></script>

</body>

</html>
