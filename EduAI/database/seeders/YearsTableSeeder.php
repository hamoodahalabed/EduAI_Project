<?php

namespace Database\Seeders;
use App\Models\Year;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class YearsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      
        DB::table('years')->delete();

        $years = [
            ['en'=> 'First Year', 'ar'=> 'السنة الاولى'],
            ['en'=> 'Second Year', 'ar'=> 'السنة الثانية'],
            ['en'=> 'Third Year', 'ar'=> 'السنة الثالثة'],
            ['en'=> 'Fourth Year', 'ar'=> 'السنة الرابعة'],

        ];
        foreach ($years as $year) {
            Year::create(['Name' => $year]);
        }
    }
}