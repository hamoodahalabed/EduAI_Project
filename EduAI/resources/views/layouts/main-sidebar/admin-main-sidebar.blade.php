<div class="scrollbar side-menu-bg" style="overflow: scroll">
    <ul class="nav navbar-nav side-menu" id="sidebarnav">
        <!-- menu item Dashboard-->
        <li>
            <a href="{{ url('/dashboard') }}">
                <div class="pull-left"><i class="ti-home"></i><span class="right-nav-text">{{trans('admin_page.Dashboard')}}</span>
                </div>
                <div class="clearfix"></div>
            </a>
        </li>
        <!-- menu title -->
        <li class="mt-10 mb-10 text-muted pl-4 font-medium menu-title">{{trans('admin_page.EduAi')}} </li>

 <!-- profile-->
 <li>
    <a href="{{route('profile-admin.index')}}"><i class="fas fa-id-card-alt"></i><span
            class="right-nav-text"> {{trans('admin_page.profile')}}</span></a>
</li>
        <!-- students-->
        <li>
            <a href="javascript:void(0);" data-toggle="collapse" data-target="#students-menu"><i class="fas fa-user-graduate"></i>{{trans('admin_page.Student')}}<div class="pull-right"><i class="ti-plus"></i></div><div class="clearfix"></div></a>
            <ul id="students-menu" class="collapse">
                <li>
                    <a href="javascript:void(0);" data-toggle="collapse" data-target="#Student_information">{{trans('admin_page.Student_information')}}<div class="pull-right"><i class="ti-plus"></i></div><div class="clearfix"></div></a>
                    <ul id="Student_information" class="collapse">
                        <li> <a href="{{route('Students.create')}}">{{trans('admin_page.add_student')}}</a></li>
                        <li> <a href="{{route('Students.index')}}">{{trans('admin_page.list_students')}}</a></li>
                    </ul>
                </li>
            </ul>
        </li>



        <!-- Teachers-->
        <li>
            <a href="javascript:void(0);" data-toggle="collapse" data-target="#Teachers-menu">
                <div class="pull-left"><i class="fas fa-chalkboard-teacher"></i></i><span
                        class="right-nav-text">{{trans('admin_page.Teachers')}}</span></div>
                <div class="pull-right"><i class="ti-plus"></i></div>
                <div class="clearfix"></div>
            </a>
            <ul id="Teachers-menu" class="collapse" data-parent="#sidebarnav">
                <li> <a href="{{route('Teachers.index')}}">{{trans('admin_page.List_Teachers')}}</a> </li>
            </ul>
        </li>
 <!-- course List-->
 <li>
    <a href="{{route('course-list')}}"><i class="fas fa-id-card-alt"></i><span
            class="right-nav-text">{{trans('admin_page.Course List')}}</span></a>
</li>

         <!-- course overview-->
         <li>
            <a href="{{route('course-overview')}}"><i class="fas fa-id-card-alt"></i><span
                    class="right-nav-text">{{trans('admin_page.Course Overview')}}</span></a>
        </li>
       
    </ul>
</div>
