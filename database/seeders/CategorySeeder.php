<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            [
                'name' => 'Electronics',
                'slug' => 'electronics',
                'description' => 'Electronic items',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Clothing',
                'slug' => 'clothing',
                'description' => 'Clothing items',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Food',
                'slug' => 'food',
                'description' => 'Food items',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
