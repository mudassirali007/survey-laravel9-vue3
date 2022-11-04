<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        \DB::table('users')->insert([
            'name' => \Str::random(10),
            'email' => 'admin@gmail.com',
            'password' => \Hash::make('password'),
            'is_admin' => 1,
        ]);

    }
}
