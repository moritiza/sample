<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i < 51; $i++) {
            DB::table('votes')->insert([
                'user_id' => rand(1, 3),
                'product_id' => rand(1, 4),
                'approve' => rand(0, 1),
                'vote' => rand(1, 5),
                'created_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }
}
