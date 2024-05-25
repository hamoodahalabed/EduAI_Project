<div class="scrollbar side-menu-bg" style="overflow: scroll">
    <ul class="nav navbar-nav side-menu" id="sidebarnav">
        <!-- menu item Dashboard-->
        <li>
            <a href="{{ route('dashboard.Students') }}">
                <div class="pull-left"><i class="ti-home"></i><span
                        class="right-nav-text">{{trans('student_page.Dashboard')}}</span>
                </div>
                <div class="clearfix"></div>
            </a>
        </li>
        <!-- menu title -->
        <li class="mt-10 mb-10 text-muted pl-4 font-medium menu-title">{{trans('student_page.EduAi')}} </li>




        <!-- profile-->
        <li>
            <a href="{{route('profile-student.index')}}"><i class="fas fa-id-card-alt"></i><span
                    class="right-nav-text"> {{trans('student_page.profile')}}</span></a>
        </li>
       


        <li>
            <a href="javascript:void(0);" data-toggle="collapse" data-target="#students-menu"><i class="fas fa-user-graduate"></i>{{trans('student_page.Courses')}}<div class="pull-right"><i class="ti-plus"></i></div><div class="clearfix"></div></a>
            <ul id="students-menu" class="collapse">
                <li> <a href="{{route('Courses.index')}}"> {{trans('student_page.Courses List')}}   </a></li>
                <li> <a href="{{route('my-new-courses')}}">  {{trans('student_page.My Courses')}}  </a></li>
                <li> <a href="{{route('my-courses')}}"> {{trans('student_page.Progress Courses List')}}     </a></li>
                <li> <a href="{{route('my-completed-courses')}}">  {{trans('student_page.Finished Courses List')}}    </a></li>

            </ul>
    </ul>
</div>
