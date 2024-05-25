<?php

namespace App\Repository;

use App\Http\Requests\StoreCoursesRequest;
use App\Models\Course;

interface CourseRepositoryInterface{

    // StoreTeachers
    public function StoreCoursesRequest(StoreCoursesRequest $request);

    // StoreTeachers
    public function editCourse($id);

    // UpdateTeachers
    public function UpdateCourses($request,$course);

    // DeleteTeachers
    public function DeleteCourse($request);


}