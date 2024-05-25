<div class="scrollbar side-menu-bg" style="overflow: scroll">
    <ul class="nav navbar-nav side-menu" id="sidebarnav">
        <!-- menu item Dashboard-->
        <li>
            <a href="{{ url('/teacher/dashboard') }}">
                <div class="pull-left"><i class="ti-home"></i><span
                        class="right-nav-text">{{trans('teacher_page.Dashboard')}}</span>
                </div>
                <div class="clearfix"></div>
            </a>
        </li>
        <!-- menu title -->
        <li class="mt-10 mb-10 text-muted pl-4 font-medium menu-title">{{trans('teacher_page.EduAi')}} </li>

        <!-- الملف الشخصي-->
        <li>
            <a href="{{route('profile.show')}}"><i class="fas fa-id-card-alt"></i><span
                    class="right-nav-text"> {{trans('teacher_page.profile')}} </span></a>
        </li>

          <!-- students-->
          <li>
            <a href="javascript:void(0);" data-toggle="collapse" data-target="#students-menu"><i class="fas fa-id-card-alt"></i>{{trans('teacher_page.Courses')}}<div class="pull-right"><i class="ti-plus"></i></div><div class="clearfix"></div></a>
            <ul id="students-menu" class="collapse">
                <li> <a href="{{route('chat.index')}}"> ChatGPT </a></li>
                <li>
                    <a href="javascript:void(0);" data-toggle="collapse" data-target="#Student_information"> {{trans('teacher_page.Courses_Information')}}<div class="pull-right"><i class="ti-plus"></i></div><div class="clearfix"></div></a>
                    <ul id="Student_information" class="collapse">
                        <li> <a href="{{route('lesson.index')}}">  {{trans('teacher_page.Course List')}}   </a></li>
                        <li> <a href="{{route('courses.index')}}"> {{trans('teacher_page.Add New Course')}} </a></li>
                       
                    </ul>
                </li>
            </ul>
        </li>


    </ul>
</div>
