<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SizesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('sizes_clothing')->insert([
            ['size_name' => 'S', 'category_id' => 1],
            ['size_name' => 'M', 'category_id' => 1],
            ['size_name' => 'L', 'category_id' => 1],
            ['size_name' => 'XL', 'category_id' => 1],
            ['size_name' => 'XXL', 'category_id' => 1],
        ]);
        DB::table('sizes_2')->insert([
            ['size_name' => 'S', 'category_id' => 2],
            ['size_name' => 'M', 'category_id' => 2],
            ['size_name' => 'L', 'category_id' => 2],
            ['size_name' => 'XL', 'category_id' => 2],
            ['size_name' => 'XXL', 'category_id' => 2],
        ]);
    }
}

