<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('departments')->delete();

        $departments = [
            ['en'=> 'CIS', 'ar'=> 'انظمة المعلومات الحاسوبية'],
            ['en'=> 'CS', 'ar'=> 'علم الحاسوب'],
            ['en'=> 'AI', 'ar'=> 'الذكاء الاصطناعي'],
            ['en'=> 'CYS', 'ar'=> 'الامن السيبراني'],
            ['en'=> 'BIT', 'ar'=> 'انظمة معلومات الاعمال'],
            ['en'=> 'DS', 'ar'=> 'علم البيانات'],

        ];
        foreach ($departments as $department) {
            Department::create(['Name' => $department]);
        }
    }
}