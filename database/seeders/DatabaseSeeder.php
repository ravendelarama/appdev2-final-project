<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Attachment;
use App\Models\Post;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Post::factory()->create([
            'parent_id' => Post::factory(),
            'quote_id' => Post::factory()
        ]);

        $this->call([
            UserSeeder::class,
            FollowSeeder::class,
            PostSeeder::class,
            AttachmentSeeder::class,
            LikeSeeder::class,
            RepostSeeder::class,
            SavedPostSeeder::class,
        ]);
    }
}
