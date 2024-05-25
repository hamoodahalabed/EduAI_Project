<?php

namespace App\Repository;

interface TeacherRepositoryInterface{

    // get all Teachers
    public function getAllTeachers();


    // StoreTeachers
    public function StoreTeachers($request);

    // StoreTeachers
    public function editTeachers($id);

    // UpdateTeachers
    public function UpdateTeachers($request);

    // DeleteTeachers
    public function DeleteTeachers($request);

}