<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();
        $users = new User();
        $users->name = ['ar' => 'مهند', 'en' => 'Mohanned'];
        $users->email = 'mohanned@gmail.com';
        $users->password = Hash::make('12345678');
        $users->save();

    }
}