<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // إنشاء مجموعة من المستخدمين
        DB::table('users')->insert([
            ['name' => 'John Doe',  'email' => 'johndoe@example.com', 'password' => Hash::make('password123')],
            ['name' => 'Jane Smith', 'email' => 'janesmith@example.com', 'password' => Hash::make('password456')],
            // ... أضف المزيد من المستخدمين حسب الحاجة
        ]);
    }
}
