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
     * @return  void
     */
    public function run()
    {
        Tag::truncate();
        User::truncate();
        Bookmark::truncate();
        DB::table('bookmark_tag')->truncate();

        // Start with 10 users, then iterate through each one to populate the other tables
        $users = factory(App\User::class, 50)->create();
        $users->each(function($user) {

            // Create a variable number of bookmarks/tags and persist them to the DB.
            // saveMany() automatically associates them with the current user_id.
            $bookmarks = factory(App\Bookmark::class, rand(2, 5))->make();
            $user->bookmarks()->saveMany($bookmarks);
            $tags = factory(App\Tag::class, rand(2, 5))->make();
            $user->tags()->saveMany($tags);

            // Everything is populated now except the bookmark_tag pivot table.
            // For that we need another loop.
            $tags->each(function($tag) use ($bookmarks) {
                for ($i=0; $i<rand(1,3); $i++) {

                    // Select a random bookmark from the $bookmarks collection,
                    // then attach the tag only IF the tag has not already been attached
                    // to that bookmark.
                    $bookmark = $bookmarks[rand(0, $bookmarks->count() - 1)];
                    if (!$bookmark->tags()->where('tag_id', $tag->id)->exists()) {
                        $bookmark->tags()->attach($tag);
                    }
                }
            });
        });
    }
}
