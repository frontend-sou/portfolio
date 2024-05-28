<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('posts')->insert([
            'user_id' => 1,
            'title' => 'Example Post',
            'content' => 'This is an example post content.',
            'image_path' => 'example.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
