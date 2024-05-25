<?php

namespace App\Repository;

interface StudentRepositoryInterface{


    //  Get_Student
    public function Get_Student();

    // Edit_Student
    public function Edit_Student($id);

    // Show_Student
    public function Show_Student($id);

    //Update_Student
    public function Update_Student($request);

    //Delete_Student
    public function Delete_Student($request);

    // Get Add Form Student
    public function Create_Student();

   
    //Store_Student
    public function Store_Student($request);

  

}