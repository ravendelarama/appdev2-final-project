<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Attachment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Post::factory()->create([
        //     'parent_id' => Post::factory(),
        //     'quote_id' => Post::factory()
        // ]);

        // $this->call([
        //     UserSeeder::class,
        //     FollowSeeder::class,
        //     PostSeeder::class,
        //     AttachmentSeeder::class,
        //     LikeSeeder::class,
        //     RepostSeeder::class,
        //     SavedPostSeeder::class,
        // ]);

        $user = User::create([
            "username" => "_rxybxn",
            "name" => "RYBN",
            "email" => "rrraaveennn@gmail.com",
            "password" => Hash::make("password")
        ]);

        $post = Post::factory()->create([
            "user_id" => $user->id,
        ]);

        $attachments = Attachment::factory(5)->create();

        $post->attachments()->saveMany($attachments);
    }
}
