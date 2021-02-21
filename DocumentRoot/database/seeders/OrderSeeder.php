<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i < 3; $i++) {
            DB::table('orders')->insert([
                'user_id' => $i,
                'city' => Str::random(10),
                'created_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }
}
