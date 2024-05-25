<?php

namespace Database\Seeders;

use App\Models\Teacher;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TeacherTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
            DB::table('teachers')->delete();
            $teachers = new Teacher();
            $teachers->Name = ['ar' => 'عدنان سامر', 'en' => 'Adnan Samer'];
            $teachers->email = 'adnan@gmail.com';
            $teachers->password = Hash::make('12345678');
            $teachers->Address = 'Amman';
            $teachers->Joining_Date= Carbon::createFromFormat('d-m-Y', '12-3-2020')->format('Y-m-d');
             $teachers->save();
    }
}