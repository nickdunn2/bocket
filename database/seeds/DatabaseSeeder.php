<?php

use App\Tag;
use App\User;
use App\Bookmark;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tag::truncate();
        User::truncate();
        Bookmark::truncate();
        DB::table('bookmark_tag')->truncate();

        $users = factory(App\User::class, 10)->create();
        $users->each(function($user) {
            foreach(range(1, rand(2,5)) as $int) {
                $bookmark = factory(App\Bookmark::class)->make();
                $user->bookmarks()->save($bookmark);
            }

            foreach(range(1, rand(2,5)) as $int) {
                $tag = factory(App\Tag::class)->make();
                $user->tags()->save($tag);
            }

            $tags = $user->tags;
            foreach($tags as $tag) {
                $bookmarks = $user->bookmarks;
                foreach(range(1, rand(2,5)) as $int) {
                    $bookmark = $bookmarks[rand(0, $bookmarks->count() - 1)];
                    if (!$bookmark->tags()->where('tag_id', $tag->id)->exists()) {
                        $bookmark->tags()->attach($tag);
                    }
                }
            }
        });

        /*
         * another way of doing it if you want to assign a random amount of bookmarks/tags to each user
         * $users->each(function($user) {
            for ($i = 0; $i < rand(1, 5); $i++) {
                factory(App\Bookmark::class)->create([
                    'user_id'   => $user->id
                ]);
                factory(App\Tag::class)->create([
                    'user_id'   => $user->id
                ]);
            }

        });
         */

    }
}
