<?php

use App\Models\Teacher;
use Database\Seeders\DepartmentTableSeeder;
use Database\Seeders\StudentsTableSeeder;
use Database\Seeders\TeacherTableSeeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\YearsTableSeeder;
use Illuminate\Database\Seeder;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(DepartmentTableSeeder::class);
        $this->call(YearsTableSeeder::class);
        $this->call(StudentsTableSeeder::class);
        $this->call(TeacherTableSeeder::class);
       

     
       
    }
}