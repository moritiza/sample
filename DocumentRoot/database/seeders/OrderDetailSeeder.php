<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i < 3; $i++) {
            DB::table('order_details')->insert([
                'order_id' => $i,
                'product_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }
}
