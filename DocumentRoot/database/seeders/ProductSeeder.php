<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i < 5; $i++) {
            DB::table('products')->insert([
                'provider_id' => rand(1, 2),
                'title' => Str::random(20),
                'price' => 100 + $i,
                'created_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }
}
