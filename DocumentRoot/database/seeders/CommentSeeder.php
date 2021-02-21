<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i < 21; $i++) {
            DB::table('comments')->insert([
                'user_id' => rand(1, 3),
                'product_id' => rand(1, 4),
                'approve' => rand(0, 1),
                'description' => Str::random(30),
                'created_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }
}
