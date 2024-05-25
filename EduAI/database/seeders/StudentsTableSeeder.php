<?php

namespace Database\Seeders;
use App\Models\Gender;
use App\Models\My_Parent;
use App\Models\Nationalitie;
use App\Models\Student;
use App\Models\Type_Blood;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StudentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('students')->delete();
        $students = new Student();
        $students->name = ['ar' => 'محمد', 'en' => 'mohammd'];
        $students->email = 'mohammed@gmail.com';
        $students->password = Hash::make('12345678');
        $students->department_id = 1;
        $students->year_id= 1;
         $students->save();
    }
}