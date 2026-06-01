<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for($i=0; $i<100; $i++){
            Post::create([
                'title' => "Post $i",
                'body' => "Body of post $i",
                'user_id' => 1,
            ]);
        }
    }
}
