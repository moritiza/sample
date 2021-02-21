<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i < 4; $i++) {
            DB::table('users')->insert([
                'name' => Str::random(10),
                'email' => 'test' . $i . '@gmail.com',
                'password' => Hash::make('test1234'),
                'created_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }
}
